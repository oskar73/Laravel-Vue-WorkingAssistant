<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Order;

class OrderController extends AdminController
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDataTable();
        }

        return view(self::$viewDir.'purchase.order');
    }

    public function detail($id)
    {
        $order = $this->model->where('id', $id)
            ->firstorfail();

        return view(self::$viewDir.'purchase.orderDetail', compact('order'));
    }
}
