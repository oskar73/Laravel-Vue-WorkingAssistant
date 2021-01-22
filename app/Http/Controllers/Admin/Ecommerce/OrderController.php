<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Module\EcommerceOrder;
use Illuminate\Http\Request;
use Validator;

class OrderController extends AdminController
{
    public function __construct(EcommerceOrder $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $orders = $this->model
                ->with(['customer'])
                ->orderBy('created_at', 'DESC')
                ->get();

            $pendingOrders = $orders->where('status', 'pending');
            $confirmedOrders = $orders->where('status', 'confirmed');
            $completedOrders = $orders->where('status', 'completed');
            $canceledOrders = $orders->where('status', 'canceled');
            // $inactiveOrders = $orders->where('status', 0);

            $all = view('components.admin.ecommerceOrder', [
                'orders' => $orders,
                'selector' => 'datatable-all',
            ])->render();
            $pending = view('components.admin.ecommerceOrder', [
                'orders' => $pendingOrders,
                'selector' => 'datatable-pending',
            ])->render();
            $confirmed = view('components.admin.ecommerceOrder', [
                'orders' => $confirmedOrders,
                'selector' => 'datatable-pending',
            ])->render();
            $completed = view('components.admin.ecommerceOrder', [
                'orders' => $completedOrders,
                'selector' => 'datatable-pending',
            ])->render();
            $canceled = view('components.admin.ecommerceOrder', [
                'orders' => $canceledOrders,
                'selector' => 'datatable-pending',
            ])->render();

            $count['all'] = $orders->count();
            $count['pending'] = $pendingOrders->count();
            $count['confirmed'] = $confirmedOrders->count();
            $count['completed'] = $completedOrders->count();
            $count['canceled'] = $canceledOrders->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'pending' => $pending,
                'confirmed' => $confirmed,
                'completed' => $completed,
                'canceled' => $canceled,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'ecommerce.order');
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
