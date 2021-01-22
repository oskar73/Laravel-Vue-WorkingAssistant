<?php

namespace App\Http\Controllers\User\Purchase;

use App\Http\Controllers\User\UserController;
use App\Models\Order;

class OrderController extends UserController
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getUserDataTable();
        }

        return view(self::$viewDir.'purchase.order');
    }

    public function detail($id)
    {
        $order = $this->model->where('id', $id)
            ->where('user_id', user()->id)
            ->firstorfail();

        return view(self::$viewDir.'purchase.orderDetail', compact('order'));
    }
}
