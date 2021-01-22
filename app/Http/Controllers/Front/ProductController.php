<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Models\Module\EcommerceCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->model->filterItem($request);

            return response()->json($result);
        }

        $categories = EcommerceCategory::with('approvedSubCategories')
            ->isParent()
            ->status(1)
            ->orderBy('order')
            ->get(['id', 'slug', 'name', 'parent_id']);

        return view('frontend.ecommerce.index', compact('categories'));
    }

    public function detail($slug)
    {
        $item = $this->model->where('slug', $slug)
            ->with(['media'])
            ->frontVisible()
            ->firstorfail();

        $price = $item->standardPrice;

        $prices = $item->prices()->where('standard', 0)->get(['id', 'color_id', 'size_id', 'variant_id', 'price', 'slashed_price'])->toArray();
        $mix = [];
        foreach ($prices as $p) {
            $size_id = $p['size_id'] ?? 0;
            $color_id = $p['color_id'] ?? 0;
            $variant_id = $p['variant_id'] ?? 0;

            $mix[$size_id.$color_id.$variant_id] = $p;
        }
        if ($price->price == null) {
            return back()->with('error', 'Sorry, the price of this product is not set yet.');
        }

        return view('frontend.ecommerce.detail', compact('item', 'price', 'mix'));
    }

    public function addtocart(Request $request, $id)
    {
        $product = $this->model->with('category:id,name', 'unit:id,name', 'additionalPrices')
                        ->withoutGlobalScopes()
                        ->findOrFail($id);

        $old_cart = session('cart');
        $cart = new Cart($old_cart);

        $parameter = [];

        if (! empty($category = $product->category)) {
            $parameter['category_id'] = $category->id;
            $parameter['category_name'] = $category->name;
        }
        if (! empty($unit = $product->unit)) {
            $parameter['unit_id'] = $unit->id;
            $parameter['unit_name'] = $unit->name;
        }
        if (! $product->additionalPrices->isEmpty()) {
            $additionalPrices = $product->additionalPrices()->with('additionals')->get();
            $sizes = [];
            $colors = [];

            foreach ($additionalPrices as $additionalPrice) {
                if (str_contains($additionalPrice->additionals->getMorphClass(), 'ProductSize')) {
                    $sizes[] = [
                        'name' => $additionalPrice->additionals->name,
                        'price' => $additionalPrice->price,
                    ];
                } elseif (str_contains($additionalPrice->additionals->getMorphClass(), 'ProductColor')) {
                    $colors[] = [
                        'name' => $additionalPrice->additionals->name,
                        'price' => $additionalPrice->price,
                    ];
                }
            }

            $parameter['sizes'] = $sizes;
            $parameter['colors'] = $colors;
        }

        $cart->add(
            $product,
            route('product.detail', $product->id),
            $request->quantity,
            $product->price,
            'product',
            $request->image,
            0,
            $product->name,
            $parameter
        );

        session()->put(['cart' => $cart]);

        return response()->json([
            'status' => 1,
            'data' => tenant()->getHeader(),
        ]);
    }
}
