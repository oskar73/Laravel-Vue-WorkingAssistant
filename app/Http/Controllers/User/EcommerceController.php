<?php

namespace App\Http\Controllers\User;

use App\Models\UserEcommerceProduct;
use App\Models\Module\EcommerceOrder;

class EcommerceController extends UserController
{
    public function __construct(UserEcommerceProduct $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getUserDataTable();
        }

        return view(self::$viewDir.'ecommerce.index');
    }

    public function detail($id)
    {
        $item = $this->model->my()
            ->whereId($id)
            ->firstorfail();

        return view(self::$viewDir.'ecommerce.detail', compact('item'));
    }
}
