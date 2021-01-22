<?php

namespace App\Http\Controllers\Admin\DirectoryAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\DirectoryAdsPosition;
use Illuminate\Http\Request;
use Validator;

class PositionController extends AdminController
{
    public function __construct(DirectoryAdsPosition $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $this->model->checkInit();

            $positions = $this->model->get();

            $activePositions = $positions->where('status', 1);
            $inactivePositions = $positions->where('status', 0);

            $all = view('components.admin.directoryAdsPosition', [
                'positions' => $positions,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.directoryAdsPosition', [
                'positions' => $activePositions,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.directoryAdsPosition', [
                'positions' => $inactivePositions,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $positions->count();
            $count['active'] = $activePositions->count();
            $count['inactive'] = $inactivePositions->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'directoryAds.position');
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

            $position = $this->model->findorfail($request->position_id)
                ->storeItem($request);

            return response()->json(['status' => 1, 'data' => $position]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function switchPosition(Request $request)
    {
        try {
            $action = $request->action;

            if ($action === 'active') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 1]);
            } elseif ($action === 'inactive') {
                $this->model->whereIn('id', $request->ids)->update(['status' => 0]);
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
