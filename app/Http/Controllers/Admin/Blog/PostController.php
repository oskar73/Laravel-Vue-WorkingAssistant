<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogTag;
use App\Models\Module\BlogCategory;
use App\Models\Module\BlogPost;
use App\Jobs\ImportBlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PostController extends AdminController
{
    public function __construct(BlogPost $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'), request()->get('user'));
        }

        return view(self::$viewDir.'blog.post');
    }

    public function create()
    {
        $categories = BlogCategory::with('approvedTags')
            ->whereStatus(1)
            ->orderBy('order')
            ->get(['id', 'name']);

        $tags = BlogTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.blog.createPost', compact('categories', 'tags'));
    }
    public function importPageView(Request $request) {
        $host = $request->host;
        $page = $request->page;
        $search = $request->search;
        $username = $request->username;
        $password = $request->password;
        if (!$username || !$password) {
            return $this->jsonSuccess([
                'success'   =>  false,
            ]);
        }

        try {
            // credential check
            $response = Http::withoutVerifying()->withBasicAuth($username, $password)->get('https://' . $host . '/wp-json/wp/v2/users/me');
            if ($response->failed()) {
                return $this->jsonUnauthorized([
                    'error' => 'Unauthorized. Please check your credentials.',
                ]);
            }

            $wpUrl = 'https://' . $host . '/wp-json/wp/v2/posts?page=' . $page . '&per_page=100&orderby=title&order=asc';
            if ($search) {
                $wpUrl .= '&search=' . $search;
            }
            $response = Http::withoutVerifying()->withBasicAuth($username, $password)->get($wpUrl);

            if ($response->failed()) {
                return $this->jsonUnauthorized([
                    'error' => 'Unauthorized. Please check your credentials.',
                ]);
            } else {
                $posts = $response->json();
    
                $view = view('components.admin.blogImport', [
                    'posts' =>  $posts,
                    'page'  =>  $page
                ])->render();
        
                return $this->jsonSuccess([
                    'success'   =>  true,
                    'view'  =>  $view,
                    'hasMore'   =>  count($posts) == 100
                ]);
            }
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
    public function importView() {
        return view(self::$viewDir . "blog.importPost");
    }
    public function import(Request $request) {
        try {
            dispatch(new ImportBlogPost($request, user()->id));

            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $item = $this->model->storeItem($request);

            return $this->jsonSuccess($item);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }

    public function show($id)
    {
        $post = $this->model->with('media', 'user', 'tags', 'category')->findorfail($id);

        return view(self::$viewDir.'blog.showPost', compact('post'));
    }

    public function edit($id)
    {
        $post = $this->model->findorfail($id);
        $categories = BlogCategory::with('approvedTags')
            ->select('id', 'name')
            ->whereStatus(1)
            ->orderBy('order')
            ->get();

        $tags = BlogTag::whereStatus(1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(self::$viewDir.'blog.editPost', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->updateRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $item = $this->model->findorfail($id)->updateItem($request);

            return response()->json([
                'status' => 1,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function switchPost(Request $request)
    {
        try {
            $action = $request->action;
//            $notification = new NotificationTemplate();
            $slug = '';
            $notify = 0;

            $posts = $this->model->with('user')
                ->whereIn('id', $request->ids)
                ->get();

            if ($action === 'approve') {
                $posts->each->update(['status' => 'approved', 'denied_reason' => $request->denied_reason]);
//                $slug= $notification::BLOG_POST_APPROVED;
                $notify = 1;
            } elseif ($action === 'deny') {
                $posts->each->update(['status' => 'denied', 'denied_reason' => $request->denied_reason]);
                $data['reason'] = $request->denied_reason;
//                $slug= $notification::BLOG_POST_DENIED;
                $notify = 1;
            } elseif ($action === 'featured') {
                $posts->each->update(['featured' => 1]);
            } elseif ($action === 'unfeatured') {
                $posts->each->update(['featured' => 0]);
            } elseif ($action === 'publish') {
                $posts->each->update(['is_published' => 1]);
            } elseif ($action === 'draft') {
                $posts->each->update(['is_published' => 0]);
            } elseif ($action === 'delete') {
                $posts->each->delete();
            }

//            if($notify==1)
//            {
//                foreach($posts as $post)
//                {
//                    $data['url'] = route('user.blog.detail', $post->id);
//                    $data['username'] = $post->user->name;
//                    $notification->sendNotification($data, $slug, $post->user);
//                }
//            }
            return response()->json([
                'status' => 1,
                'data' => $action,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
