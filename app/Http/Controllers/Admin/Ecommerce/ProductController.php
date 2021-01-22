<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\EcommerceCategory;
use App\Models\Module\EcommerceProduct;
use Illuminate\Http\Request;
use Validator;

class ProductController extends AdminController
{
    public function __construct(EcommerceProduct $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $products = $this->model->with('media')
                ->orderBy('featured', 'DESC')
                ->get();

            $activeProducts = $products->where('status', 1);
            $inactiveProducts = $products->where('status', 0);

            $all = view('components.admin.ecommerceProduct', [
                'products' => $products,
                'selector' => 'datatable-all',
            ])->render();
            $active = view('components.admin.ecommerceProduct', [
                'products' => $activeProducts,
                'selector' => 'datatable-active',
            ])->render();
            $inactive = view('components.admin.ecommerceProduct', [
                'products' => $inactiveProducts,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $products->count();
            $count['active'] = $activeProducts->count();
            $count['inactive'] = $inactiveProducts->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'ecommerce.product');
    }

    public function create()
    {
        $categories = EcommerceCategory::where('parent_id', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        return view(self::$viewDir.'ecommerce.productCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->storeItem($request);
            $route = route('admin.ecommerce.product.edit', $item->id).'#/price';

            return response()->json([
                'status' => 1,
                'data' => $route,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit($id)
    {
        $product = $this->model->with(['media', 'sizes', 'colors', 'variants'])
            ->where('id', $id)
            ->firstorfail();
        $categories = EcommerceCategory::where('parent_id', 0)
            ->with('approvedSubCategories')
            ->status(1)
            ->get(['id', 'name']);

        return view(self::$viewDir.'ecommerce.productEdit', compact('categories', 'product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $validation = Validator::make($request->all(), $this->model->storeRule($request));
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }

        $this->model->findorfail($id)
                    ->updateItem($request);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function getPrice($id)
    {
        $product = $this->model->findorfail($id);
        $price = $product->standardPrice;
        $prices = $product->prices->where('standard', 0)->toArray();
        $mix = [];
        foreach ($prices as $item) {
            $size_id = $item['size_id'] ?? 0;
            $color_id = $item['color_id'] ?? 0;
            $variant_id = $item['variant_id'] ?? 0;

            $mix[$size_id.$color_id.$variant_id] = $item;
        }
        $data = view('components.admin.ecommerceGetPrice', compact('product', 'price', 'mix'))->render();

        return response()->json([
            'status' => 1,
            'data' => $data,
        ]);
    }

    public function updatePrice(Request $request, $id)
    {
        $product = $this->model->findorfail($id);
        $price = $product->updateVariantPrice($request);

        return response()->json([
            'status' => 1,
            'data' => $price,
        ]);
    }

    public function delPrice($id)
    {
        $product = $this->model->findorfail($id);
        $product->prices->each->delete();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
