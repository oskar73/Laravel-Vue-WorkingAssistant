<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\AdminController;
use App\Models\UserBlogPackage;
use App\Models\UserDirectoryPackage;
use App\Models\UserEcommerceProduct;

class ProductController extends AdminController
{
    public function blog()
    {
        if (request()->wantsJson()) {
            $model = new UserBlogPackage();

            return $model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'purchase.blog');
    }

    public function blogDetail($id)
    {
        $item = UserBlogPackage::findorfail($id);
        $detail = json_decode($item->item);

        return view(self::$viewDir.'purchase.blogDetail', compact('item', 'detail'));
    }

    public function directory()
    {
        if (request()->wantsJson()) {
            $model = new UserDirectoryPackage();

            return $model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'purchase.directory');
    }

    public function directoryDetail($id)
    {
        $item = UserDirectoryPackage::findorfail($id);
        $detail = json_decode($item->item);

        return view(self::$viewDir.'purchase.directoryDetail', compact('item', 'detail'));
    }

    public function ecommerce()
    {
        if (request()->wantsJson()) {
            $model = new UserEcommerceProduct();

            return $model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'purchase.ecommerce');
    }

    public function ecommerceDetail($id)
    {
        $item = UserEcommerceProduct::findorfail($id);
        $detail = json_decode($item->item);

        return view(self::$viewDir.'purchase.ecommerceDetail', compact('item', 'detail'));
    }
}
