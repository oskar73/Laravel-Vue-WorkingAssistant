<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\EcommerceCustomer;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends AdminController
{
    public function __construct(EcommerceCustomer $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $products = $this->model
                ->orderBy('created_at', 'DESC')
                ->get();

            // $activeProducts = $products->where('status', 1);
            // $inactiveProducts = $products->where('status', 0);

            $all = view('components.admin.ecommerceCustomer', [
                'customers' => $products,
                'selector' => 'datatable-all',
            ])->render();
            // $active = view('components.admin.ecommerceProduct', [
            //     'products' => $activeProducts,
            //     'selector' => 'datatable-active',
            // ])->render();
            // $inactive = view('components.admin.ecommerceProduct', [
            //     'products' => $inactiveProducts,
            //     'selector' => 'datatable-inactive',
            // ])->render();

            $count['all'] = $products->count();
            // $count['active'] = $activeProducts->count();
            // $count['inactive'] = $inactiveProducts->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                // 'active' => $active,
                // 'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'ecommerce.customer');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }
}
