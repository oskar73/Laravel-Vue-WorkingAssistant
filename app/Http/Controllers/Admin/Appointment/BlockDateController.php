<?php

namespace App\Http\Controllers\Admin\Appointment;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AppointmentBlockDate;
use Illuminate\Http\Request;
use Validator;

class BlockDateController extends AdminController
{
    public function __construct(AppointmentBlockDate $model)
    {
        $this->model = $model;
    }

    public function index(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            return $this->model->getEvents($request, $type, $id);
        }

        return view(self::$viewDir.'appointment.blockDate');
    }

    public function store(Request $request, $type, $id = null)
    {
        $validation = Validator::make($request->all(), $this->model->storeRule($request), $this->model::CUSTOM_VALIDATION_MESSAGE);

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        if ($request->specific_time) {
            $error = $this->model->checkRule($request);
            if (count($error) != 0) {
                return response()->json([
                    'status' => 0,
                    'data' => $error,
                ]);
            }
        }

        $this->model->storeItem($request, $type, $id);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function edit(Request $request, $type, $id)
    {
        try {
            $date = $request->date;
            $event = $this->model->where('type', $type)
                ->where('product_id', $id)
                ->where('date', $date)
                ->firstorfail();

            return response()->json([
                'status' => 1,
                'data' => $event,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function delete(Request $request, $type, $id = null)
    {
        try {
            $this->model->whereId($request->id)
                ->where('type', $type)
                ->where('product_id', $id)
                ->firstorfail()
                ->delete();

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
