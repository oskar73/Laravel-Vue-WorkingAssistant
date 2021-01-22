<?php

namespace App\Http\Controllers\Admin\Appointment;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AppointmentCategory;
use App\Models\AvailableWeekday;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends AdminController
{
    public $weekday;

    public function __construct(AppointmentCategory $model)
    {
        $this->model = $model;
        $this->sortModel = $this->model;
        $this->weekday = new AvailableWeekday();
    }

    public function index()
    {
        if (request()->wantsJson()) {
            try {
                $categories = $this->model->orderBy('order')
                    ->get();
                $selector = 'all';
                $data = view('components.admin.appointmentCategory', compact('categories', 'selector'))->render();

                return response()->json([
                    'status' => 1,
                    'data' => $data,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 0,
                    'data' => [json_encode($e->getMessage())],
                ]);
            }
        }

        return view(self::$viewDir.'appointment.category');
    }

    public function create()
    {
        $weekArray = $this->weekday::weekArray;

        return view(self::$viewDir.'appointment.categoryCreate', compact('weekArray'));
    }

    public function store(Request $request)
    {
        try {
            $rule1 = $this->model->storeRule($request);
            $rule2 = $this->weekday->storeRule($request);

            $validation = Validator::make($request->all(), array_merge($rule1, $rule2), $this->model::CUSTOM_VALIDATION_MESSAGE);
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $error = $this->weekday->checkRule($request);

            if (count($error) != 0) {
                return response()->json([
                    'status' => 0,
                    'data' => $error,
                ]);
            }

            if ($request->category_id) {
                $item = $this->model->findorfail($request->category_id)
                    ->storeItem($request);
            } else {
                $item = $this->model->storeItem($request);
            }
            $this->weekday->storeItem($request, 'category', $item->id);

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

    public function edit($id)
    {
        $weekArray = $this->weekday::weekArray;
        $category = $this->model->findorfail($id);
        $data = $this->weekday->getData('category', $id);

        return view(self::$viewDir.'appointment.categoryEdit', compact('weekArray', 'data', 'category'));
    }
}
