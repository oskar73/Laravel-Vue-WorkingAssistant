<?php

namespace App\Http\Controllers\User\Purchase;

use App\Http\Controllers\Controller;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new UserProduct();
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $items = $this->model->with('orderItem')
                ->where('user_id', user()->id)
                ->latest()
                ->get();
            $count['all'] = $items->count();
            $selector = 'datatable-all';
            $type = 'product';
            $all = view('components.user.pPackageTable', compact('items', 'selector', 'type'))->render();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'count' => $count,
            ]);
        }

        return view('user.purchase.product');
    }

    public function detail($id)
    {
        $item = $this->model->where('id', $id)
            ->where('user_id', user()->id)
            ->firstorfail();
        $detail = json_decode($item->item);
        $type = 'product';

        return view('user.purchase.productDetail', compact('item', 'detail', 'type'));
    }
}
