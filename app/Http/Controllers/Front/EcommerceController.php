<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Integration\Cart;
use App\Models\Module\EcommerceCategory;
use App\Models\Module\EcommerceProduct;
use Illuminate\Http\Request;
use Validator;

class EcommerceController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new EcommerceProduct();
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


        return view('frontend.ecommerce.index', [
            'website' => tenant(),
            'categories' => $categories,
            'modules' => tenant()->getBuilderModules()
        ]);
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

        return view('frontend.ecommerce.detail', [
            'item'  =>  $item,
            'price'  =>  $price,
            'mix'  =>  $mix,
            'modules' => tenant()->getBuilderModules()
        ]);
    }

    public function addtocart(Request $request, $slug)
    {
        $item = $this->model->where('slug', $slug)
            ->frontVisible()
            ->firstorfail();

        $validation = Validator::make($request->all(), $item->addToCartRule());
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }

        $size = $request->size == 0 ? null : $request->size;
        $color = $request->color == 0 ? null : $request->color;
        $custom = $request->custom == 0 ? null : $request->custom;

        $price = $item->prices()
            ->where('color_id', $color)
            ->where('size_id', $size)
            ->where('variant_id', $custom)
            ->first();

        if ($price == null) {
            $price = $item->standardPrice;
        }

        $old_cart = session('cart');
        $cart = new Cart($old_cart);

        $parameter = [];

        $parameter['color_id'] = $color;
        $parameter['size_id'] = $size;
        $parameter['custom_id'] = $custom;
        $parameter['color'] = null;
        $parameter['size'] = null;
        $parameter['custom'] = null;

        $parameter['period'] = $price->period;
        $parameter['period_unit'] = $price->period_unit;
        $parameter['price'] = $price;

        if ($item->color) {
            $parameter['color'] = $item->colors()->where('id', $request->color)->first()->name;
        }
        if ($item->size) {
            $parameter['size'] = $item->sizes()->where('id', $request->size)->first()->name;
        }
        if ($item->variant) {
            $parameter['custom_name'] = $item->variant_name;
            $parameter['custom'] = $item->variants()->where('id', $request->custom)->first()->name;
        }

        $cart->add(
            $item,
            route('ecommerce.detail', $item->slug),
            $request->quantity,
            $price->price,
            'ecommerce',
            $item->getFirstMediaUrl('thumbnail'),
            $price->recurrent,
            $item->title,
            $parameter
        );

        session()->put(['cart' => $cart]);

        return response()->json([
            'status' => 1,
            'data' => tenant()->getHeader(),
        ]);
    }
}
