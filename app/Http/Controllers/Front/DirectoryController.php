<?php

namespace App\Http\Controllers\Front;

use App\Enums\ModuleEnum;
use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Models\Module\BlogPost;
use App\Models\DirectoryCategory;
use App\Models\DirectoryListing;
use App\Models\DirectoryPackage;
use App\Models\DirectoryTag;
use App\Models\Module\EcommerceCategory;
use App\Models\Module\EcommerceProduct;
use App\Models\Page;
use Illuminate\Http\Request;
use Session;
use Validator;

class DirectoryController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new DirectoryListing();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $listings = $this->model->filterItem($request);

            $data = view('components.front.directoryListing', compact('listings'))->render();

            return response()->json([
                'status' => 1,
                'data' => $data,
            ]);
        }

        $categories = DirectoryCategory::where('parent_id', 0)
            ->with('media')
            ->withCount('approvedItems')
            ->status(1)
            ->orderBy('order')
            ->get(['id', 'name']);

        $seo = $this->getSeo();

        return view('frontend.directory.index', [
            'website' => tenant(),
            'categories' => $categories,
            'seo' => $seo,
            'modules' => tenant()->getBuilderModules()
        ]);
    }

    public function category($slug)
    {
        $category = DirectoryCategory::where('slug', $slug)
            ->where('parent_id', 0)
            ->where('status', 1)
            ->firstorfail();

        $seo['meta_title'] = $category->name;
        $seo['meta_description'] = extractDesc($category->description);
        $seo['meta_keywords'] = extractKeyWords($category->description);
        $seo['meta_image'] = $category->getFirstMediaUrl('image') ?? '';
        $modules = tenant()->getBuilderModules();
        
        return view('frontend.directory.category', compact('category', 'seo', 'modules'));
    }

    public function subCategory($cat_slug, $subCat_slug)
    {
        $parentCategory = DirectoryCategory::where('slug', $cat_slug)
            ->where('parent_id', 0)
            ->where('status', 1)
            ->firstorfail();

        $category = DirectoryCategory::where('parent_id', $parentCategory->id)
            ->where('slug', $subCat_slug)
            ->where('status', 1)
            ->firstorfail();

        $seo['meta_title'] = $category->name;
        $seo['meta_description'] = extractDesc($category->description);
        $seo['meta_keywords'] = extractKeyWords($category->description);
        $seo['meta_image'] = $category->getFirstMediaUrl('image') ?? '';
        $modules = tenant()->getBuilderModules();

        return view('frontend.directory.subCategory', compact('category', 'seo', 'modules'));
    }

    public function tag($slug)
    {
        $tag = DirectoryTag::where('slug', $slug)
            ->where('status', 1)
            ->firstorfail();

        $seo['meta_title'] = $tag->name;
        $seo['meta_description'] = $tag->name;
        $seo['meta_keywords'] = $tag->name;
        $modules = tenant()->getBuilderModules();

        return view('frontend.directory.tag', compact('tag', 'seo', 'modules'));
    }

    public function detail($slug)
    {
        $listing = $this->model->where('slug', $slug)
            ->frontVisible()
            ->firstorfail();

        $listing->increment('view_count');

        $seo['meta_title'] = $listing->title;
        $seo['meta_description'] = extractDesc($listing->description);
        $seo['meta_keywords'] = extractKeyWords(strip_tags($listing->description));
        $seo['meta_image'] = $listing->getFirstMediaUrl('thumbnail') ?? '';

        $modules = tenant()->getBuilderModules();

        return view('frontend.directory.detail', compact('listing', 'seo', 'modules'));
    }

    public function package(Request $request)
    {
        if ($request->ajax()) {
            $result = DirectoryPackage::filterItem($request);

            return response()->json($result);
        }

        $seo = $this->getSeo();
        $modules = tenant()->getBuilderModules();
    
        return view('frontend.directory.package', compact('seo', 'modules'));
    }

    public function packageDetail($slug)
    {
        $item = DirectoryPackage::where('slug', $slug)
            ->with('media', 'prices')
            ->status(1)
            ->firstorfail();

        $seo['meta_title'] = $item->title;
        $seo['meta_description'] = extractDesc($item->description);
        $seo['meta_keywords'] = extractKeyWords($item->description);
        $seo['meta_image'] = $item->getFirstMediaUrl('thumbnail');

        $modules = tenant()->getBuilderModules();

        return view('frontend.directory.packageDetail', compact('item', 'seo', 'modules'));
    }

    public function getSeo()
    {
        $data = optional(Page::firstOrCreate([
            'type' => 'module',
            'url' => 'directory',
        ])->data);

        $seo['meta_title'] = $data['meta_title'];
        $seo['meta_description'] = extractDesc($data['meta_description']);
        $seo['meta_keywords'] = $data['meta_keywords'];
        $seo['meta_image'] = $data['meta_image'];

        return $seo;
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
            $validation = Validator::make($request->all(), $this->cartRule());
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = DirectoryPackage::whereId($id)
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
                route('directory.package.detail', $item->slug),
                $request->quantity,
                $price->price,
                'directoryPackage',
                $item->getFirstMediaUrl('thumbnail'),
                $price->recurrent,
                $item->name,
                $price
            );

            Session::put('cart', $cart);

            return response()->json([
                'status' => 1,
                'data' => tenant()->getHeader(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
