<?php

namespace App\Http\Controllers\Admin\Appointment;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AvailableWeekday;
use Illuminate\Http\Request;
use Validator;

class SettingController extends AdminController
{
    public function __construct(AvailableWeekday $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $data = $this->model->getData('appointment');
        $weekArray = $this->model::weekArray;

        return view(self::$viewDir.'appointment.setting', compact('data', 'weekArray'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request), $this->model::CUSTOM_VALIDATION_MESSAGE);
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $error = $this->model->checkRule($request);

            if (count($error) != 0) {
                return response()->json([
                    'status' => 0,
                    'data' => $error,
                ]);
            }

            $this->model->storeItem($request, 'appointment');

            return response()->json([
                'status' => 1,
                'data' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
