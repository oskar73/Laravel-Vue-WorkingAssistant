<?php

namespace App\Http\Controllers\Front;

use App\Enums\ModuleEnum;
use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Models\BlogComment;
use App\Models\BlogPackage;
use App\Models\BlogTag;
use App\Models\Module\BlogCategory;
use App\Models\Module\BlogPost;
use App\Models\Module\EcommerceCategory;
use App\Models\Module\EcommerceProduct;
use App\Models\AppointmentCategory;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Validator;

class BlogController extends Controller
{
    public $model;

    public $template;

    public function __construct()
    {
        $this->model = new BlogPost();
        $this->template = optional(option('blog'))['template'] ?: 'template1';
    }

    public function index()
    {
        $posts = $this->model->with('media')
            ->withCount('approvedComments', 'favoriters')
            ->frontVisible()
            ->get();

        $featured_posts = $posts->sortByDesc('featured')->sortByDesc('created_at')->take(6)->values();
        $recent_posts = $posts->sortByDesc('created_at')->take(4)->values();
        $popular_posts = $posts->sortByDesc('view_count')->take(5)->values();
        $most_discussed_posts = $posts->sortByDesc('approved_comments_count')->take(5)->values();

        $seo = $this->getSeo();

        return view("frontend.blog.{$this->template}.index", [
            'featured_posts' => $featured_posts,
            'recent_posts' => $recent_posts,
            'popular_posts' => $popular_posts,
            'most_discussed_posts' => $most_discussed_posts,
            'seo' => $seo,
            'modules' => tenant()->getBuilderModules(),
        ]);
    }

    public function ajaxPage(Request $request)
    {
        $posts = $this->model->with('media')
            ->withCount('approvedComments', 'favoriters')
            ->frontVisible()
            ->latest()
            ->paginate(10);

        return view("components.front.{$this->template}.ajaxPost", compact('posts'))->render();
    }

    public function ajaxCategory(Request $request, $id)
    {
        $category = BlogCategory::where('status', 1)->where('id', $id)->firstorfail();

        $posts = $this->model->with('media')
            ->withCount('approvedComments', 'favoriters')
            ->where('category_id', $category->id)
            ->frontVisible()
            ->latest()
            ->paginate(10);

        return view("components.front.{$this->template}.ajaxPost", compact('posts'))->render();
    }

    public function ajaxTag(Request $request, $id)
    {
        $tag = BlogTag::where('id', $id)
            ->whereStatus(1)
            ->firstorfail();

        $posts = $tag->visiblePosts()->with('media')
            ->withCount('approvedComments', 'favoriters')
            ->latest()
            ->paginate(10);

        return view("components.front.{$this->template}.ajaxPost", compact('posts'))->render();
    }

    public function ajaxAuthor(Request $request, $username)
    {
        $user = User::whereId($username)
            ->whereStatus('active')
            ->firstorfail();

        $posts = $user->visiblePosts()->with('media')
            ->withCount('approvedComments', 'favoriters')
            ->latest()
            ->paginate(10);

        return view("components.front.{$this->template}.ajaxPost", compact('posts'))->render();
    }

    public function ajaxComment(Request $request, $slug)
    {
        $post = $this->model->frontVisible()
            ->whereSlug($slug)
            ->firstorfail();

        $comments = BlogComment::with('approvedComments', 'user.media', 'favorite_to_users')
            ->whereNull('parent_id')
            ->where('post_id', $post->id)
            ->where('status', 1)
            ->paginate(10);

        return view("components.front.{$this->template}.blogComment", compact('comments'))->render();
    }

    public function detail($slug = null)
    {

        $post = $this->model->with('media', 'user', 'approvedTags:name,slug')
                ->withCount('favoriters')
                ->frontVisible()
                ->whereSlug($slug)
                ->first();

        if ($post) {
            $blogKey = 'blog_'.$post->id;
            if (! Session::has($blogKey)) {
                $post->increment('view_count');
            }
            $randomposts = $this->model->with('media')
                ->withCount('approvedComments', 'favoriters')
                ->frontVisible()
                ->inRandomOrder()
                ->take(2)
                ->get();
    
            $seo['meta_title'] = $post->title;
            $seo['meta_description'] = extractDesc($post->body);
            $seo['meta_keywords'] = extractKeyWords(strip_tags($post->body));
            $seo['meta_image'] = $post->getFirstMediaUrl('image');
    
            return view("frontend.blog.{$this->template}.detail", [
                'post' => $post,
                'randomposts' => $randomposts,
                'seo' => $seo,
                'modules' => tenant()->getBuilderModules(),
            ]);
        }

        if (empty(config('custom.route.blogDetail'))) {
            $website = tenant();

            if ($website) {
                $page = Page::where('url', $slug)
                    ->orWhere('url', '')
                    ->orWhere('url', '/')
                    ->where('status', 1)
                    ->firstorfail();

                $data = null;
                $seo = null;

                if ($page) {
                    $data = optional($page->data);
                    if ($data['seo']) {
                        $seo['meta_title'] = $data['seo']['title'];
                        $seo['meta_description'] = extractDesc($data['seo']['description']);
                        $seo['meta_keywords'] = $data['seo']['keywords'];
                        $seo['meta_image'] = $data['seo']['image'] ?? $page->getFirstMediaUrl('seo');
                    } else {
                        $seo['meta_title'] = $data['meta_title'];
                        $seo['meta_description'] = extractDesc($data['meta_description']);
                        $seo['meta_keywords'] = $data['meta_keywords'];
                        $seo['meta_image'] = $page->getFirstMediaUrl('seo');
                    }
                }

                $activeModules = tenant('p_modules');
                $modules = [
                    'activeModules' => $activeModules
                ];

                if (count($activeModules)) {
                    if (in_array(ModuleEnum::ECOMMERCE, $activeModules)) {
                        $productCategories = EcommerceCategory::status(1)->get();
                        $products = EcommerceProduct::status(1)
                            ->with('standardPrice')
                            ->orderBy('featured', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        $productPage = Page::where('type', 'module')->where('name', 'Product')->first();

                        $modules['ecommerce'] = [
                            'products' => $products ?? [],
                            'page' => $productPage ?? null,
                        ];
                    }

                    if (in_array(ModuleEnum::APPOINTMENT, $activeModules)) {
                        $appointmentCategories = AppointmentCategory::status(1)->get();

                        $modules['appointment'] = [
                            'categories' => $appointmentCategories ?? [],
                        ];
                    }
                }

                $data = [
                    'website' => $website,
                    'data' => $data,
                    'seo' => $seo,
                    'url' => $slug,
                    'modules' => $modules
                ];
    
                return view('frontend.v2', $data);
            }
        }
    }

    public function category($slug)
    {
        $category = BlogCategory::with('media')
            ->withCount('visiblePosts')
            ->whereSlug($slug)
            ->whereStatus(1)
            ->firstorfail();

        $seo['meta_title'] = $category->name;
        $seo['meta_description'] = extractDesc($category->description);
        $seo['meta_keywords'] = extractKeyWords($category->description);
        $seo['meta_image'] = $category->getFirstMediaUrl('image') ?? '';

        return view("frontend.blog.{$this->template}.category", [
            'category' => $category,
            'seo' => $seo,
            'modules' => tenant()->getBuilderModules(),
        ]);
    }

    public function tag($slug)
    {
        $tag = BlogTag::whereSlug($slug)
            ->withCount('visiblePosts')
            ->whereStatus(1)
            ->firstorfail();

        $seo['meta_title'] = $tag->name;
        $seo['meta_description'] = $tag->name;
        $seo['meta_keywords'] = $tag->name;

        return view("frontend.blog.{$this->template}.tag", [
            'tag' => $tag,
            'seo' => $seo,
            'modules' => tenant()->getBuilderModules(),
        ]);
    }

    public function allPosts(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request->category;
            $pageNum = $request->page;
            $perpage = 30;
            if ($slug == 'all') {
                $posts = $this->model->with('user:id,name')
                    ->withCount('approvedComments', 'favoriters')
                    ->frontVisible()
                    ->latest()
                    ->paginate($perpage);
            } else {
                $category = BlogCategory::whereStatus(1)
                    ->whereSlug($slug)
                    ->firstorfail();

                $posts = $this->model->with('user:id,name')
                    ->where('category_id', $category->id)
                    ->withCount('approvedComments', 'favoriters')
                    ->frontVisible()
                    ->latest()
                    ->paginate($perpage);
            }

            return view("components.front.{$this->template}.blogTable", compact('posts', 'pageNum', 'perpage'))->render();
        }

        $categories = BlogCategory::whereStatus(1)
            ->select('id', 'slug', 'name')
            ->orderBy('order')
            ->get();

        $seo = $this->getSeo();

        return view("frontend.blog.{$this->template}.allPosts", [
            'categories' => $categories,
            'seo' => $seo,
            'modules' => tenant()->getBuilderModules(),
        ]);
    }

    public function search(Request $request)
    {
        $perpage = 9;
        $keyword = $request->get('keyword');
        $posts = $this->model->withCount('approvedComments', 'favoriters')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%");
                $query->orWhere('body', 'LIKE', "%$keyword%");
            })
            ->frontVisible()
            ->latest()
            ->paginate($perpage);

        $data = view("components.front.{$this->template}.searchPost", compact('posts'))->render();

        return $this->jsonSuccess($data);
    }

    public function author($username)
    {
        $user = User::whereId($username)
            ->with('media')
            ->withCount('visiblePosts', 'approvedComments')
            ->whereStatus('active')
            ->firstorfail(['id', 'name']);

        return view("frontend.blog.{$this->template}.author", compact('user'));
    }

    public function getCommentForm(Request $request, $id)
    {
        return $this->jsonSuccess(view("components.front.{$this->template}.commentForm", ['post_id' => $id, 'comment_id' => $request->comment_id])->render());
    }

    public function postComment(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                [
                    'comment' => 'required|max:6000',
                    'comment_id' => 'nullable|exists:blog_comments,id,parent_id,NULL,status,1,post_id,'.$id.',web_id,'.tenant('id'),
                ]
            );
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $post = $this->model->frontVisible()
                ->whereId($id)
                ->firstorfail();

            $comment = new BlogComment();
            $comment->post_id = $post->id;
            $comment->user_id = user()->id;
            $comment->parent_id = $request->comment_id;
            $comment->comment = $request->comment;
            $comment->status = 1;
            $comment->save();

            return $this->jsonSuccess($comment);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function favoriteComment(Request $request)
    {
        $id = $request->get('id');
        $like = $request->get('like');

        $comment = BlogComment::with('favorite_to_users')
            ->whereId($id)
            ->whereStatus(1)
            ->firstorfail();

        if (\Auth::check() == false) {
            Session::put('url.intended', route('blog.detail', $comment->post->slug.'#post_comment_form'));

            return response()->json(['status' => 0, 'data' => 'login']);
        }

        $isFavorite = in_array($comment->id, user()->favorite_to_comments->where('pivot.favorite', 1)->pluck('id')->toArray());
        $isunFavorite = in_array($comment->id, user()->favorite_to_comments->where('pivot.favorite', 0)->pluck('id')->toArray());

        $favorite_count = $comment->favorite_to_users->where('pivot.favorite', 1)->count();
        $unfavorite_count = $comment->favorite_to_users->where('pivot.favorite', 0)->count();

        if ($like == 'like') {
            if ($isFavorite) {
                \DB::table('blog_favorite_comment_user')
                    ->where('comment_id', $comment->id)
                    ->where('user_id', user()->id)
                    ->where('favorite', 1)
                    ->delete();

                $favorite_count--;
                $data = 1;
            } else {
                \DB::table('blog_favorite_comment_user')->insert([
                    'comment_id' => $comment->id,
                    'user_id' => user()->id,
                    'favorite' => 1,
                ]);
                $favorite_count++;
                if ($isunFavorite) {
                    \DB::table('blog_favorite_comment_user')
                        ->where('comment_id', $comment->id)
                        ->where('user_id', user()->id)
                        ->where('favorite', 0)
                        ->delete();
                    $unfavorite_count--;
                }
                $data = 2;
            }
        } else {
            if ($isunFavorite) {
                \DB::table('blog_favorite_comment_user')
                    ->where('comment_id', $comment->id)
                    ->where('user_id', user()->id)
                    ->where('favorite', false)
                    ->delete();
                $unfavorite_count--;
                $data = 3;
            } else {
                \DB::table('blog_favorite_comment_user')->insert([
                    'comment_id' => $comment->id,
                    'user_id' => user()->id,
                    'favorite' => false,
                ]);
                $unfavorite_count++;
                if ($isFavorite) {
                    $favorite_count--;
                    \DB::table('blog_favorite_comment_user')
                        ->where('comment_id', $comment->id)
                        ->where('user_id', user()->id)
                        ->where('favorite', 1)
                        ->delete();
                }
                $data = 4;
            }
        }

        return response()->json([
            'status' => 1,
            'data' => $data,
            'like_count' => $favorite_count,
            'dislike_count' => $unfavorite_count,
        ]);
    }

    public function package(Request $request)
    {
        $setting = optional(option('blog', null));
        if ($setting['permission'] != 'paid' && $setting['permission'] != 'both') {
            abort(404);
        }

        if ($request->ajax()) {
            $result = BlogPackage::filterItem($request);

            return response()->json($result);
        }

        $seo = $this->getSeo();

        return view('frontend.blog.package', compact('seo'));
    }

    public function getSeo()
    {
        $data = optional(Page::firstOrCreate([
            'type' => 'module',
            'url' => 'blog',
        ])->data);

        $seo['meta_title'] = $data['meta_title'];
        $seo['meta_description'] = extractDesc($data['meta_description']);
        $seo['meta_keywords'] = $data['meta_keywords'];
        $seo['meta_image'] = $data['meta_image'];

        return $seo;
    }

    public function packageDetail($slug)
    {
        $setting = optional(option('blog', null));
        if ($setting['permission'] != 'paid' && $setting['permission'] != 'both') {
            abort(404);
        }

        $item = BlogPackage::where('slug', $slug)
            ->with('media', 'prices')
            ->status(1)
            ->firstorfail();

        $seo['meta_title'] = $item->title;
        $seo['meta_description'] = extractDesc($item->description);
        $seo['meta_keywords'] = extractKeyWords($item->description);
        $seo['meta_image'] = $item->getFirstMediaUrl('thumbnail');

        return view('frontend.blog.packageDetail', compact('item', 'seo'));
    }

    public function cartRule()
    {
        $rule['quantity'] = 'required|numeric|min:1';
        $rule['price'] = 'required';

        return $rule;
    }

    public function addtoCart(Request $request, $id)
    {
        try {
            $setting = optional(option('blog', null));
            if ($setting['permission'] != 'paid' && $setting['permission'] != 'both') {
                abort(404);
            }

            $validation = Validator::make($request->all(), $this->cartRule());
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $item = BlogPackage::whereId($id)
                ->whereStatus(1)
                ->firstorfail();

            if ($request->price == 0) {
                $price = $item->standardPrice;
            } else {
                $price = $item->prices()
                    ->whereStatus(1)
                    ->whereId($request->price)
                    ->firstorfail();
            }
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            $cart->add(
                $item,
                route('blog.package.detail', $item->slug),
                $request->quantity,
                $price->price,
                'blogPackage',
                $item->getFirstMediaUrl('thumbnail'),
                $price->recurrent,
                $item->name,
                $price
            );

            Session::put('cart', $cart);

            return $this->jsonSuccess(tenant()->getHeader());
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
