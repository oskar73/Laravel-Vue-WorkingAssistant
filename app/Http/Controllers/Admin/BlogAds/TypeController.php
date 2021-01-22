<?php

namespace App\Http\Controllers\Admin\BlogAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogAdsType;
use Illuminate\Http\Request;
use Validator;

class TypeController extends AdminController
{
    public function __construct(BlogAdsType $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            // check if tenant blog ads type is created.
            $this->model->checkInit();

            $types = $this->model->get();

            $activeTypes = $types->where('status', 1);
            $inactiveTypes = $types->where('status', 0);

            $all = view('components.admin.blogAdsType', [
                'types' => $types,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.blogAdsType', [
                'types' => $activeTypes,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.blogAdsType', [
                'types' => $inactiveTypes,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $types->count();
            $count['active'] = $activeTypes->count();
            $count['inactive'] = $inactiveTypes->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'blogAds.type');
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->storeRule(),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }

            if ($request->type_id) {
                $type = $this->model->findorfail($request->type_id)
                    ->storeItem($request);
            } else {
                $type = $this->model->storeItem($request);
            }

            return response()->json(['status' => 1, 'data' => $type]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
