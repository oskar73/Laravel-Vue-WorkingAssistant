<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Lacarte;
use App\Models\Module;
use App\Models\Package;
use App\Models\Plugin;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class CouponController extends AdminController
{
    public function __construct(Coupon $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        $users = User::whereStatus('active')
            ->select('id', 'name', 'email')
            ->get();

        return view(self::$viewDir.'coupon.index', compact('users'));
    }

    public function product(Request $request)
    {
        try {
            $products = [];
            switch ($request->type) {
                case 'package':
                    $products = Package::whereStatus(1)->wherePackage(1)->select('id', 'name')->get();
                    break;
                case 'readymade':
                    $products = Package::whereStatus(1)->wherePackage(0)->select('id', 'name')->get();
                    break;
                case 'plugin':
                    $products = Plugin::whereStatus(1)->select('id', 'name')->get();
                    break;
                case 'lacarte':
                    $products = Lacarte::whereStatus(1)->select('id', 'name')->get();
                    break;
                case 'module':
                    $products = Module::whereStatus(1)->select('id', 'name')->get();
                    break;
                case 'service':
                    $products = Service::whereStatus(1)->select('id', 'name')->get();
                    break;
            }
            $result = '<option value="0">All Products</option>';
            foreach ($products as $product) {
                $result .= "<option value='{$product->id}'>{$product->name}</option>";
            }

            return response()->json([
                'status' => 1,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule($request),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $coupon = $this->model->storeItem($request);

            return response()->json([
                'status' => 1,
                'data' => $coupon,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit(Request $request)
    {
        try {
            $coupon = $this->model->findorfail($request->id);

            return response()->json([
                'status' => 1,
                'data' => $coupon,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
