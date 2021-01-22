<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Admin\AdminController;
use App\Models\NotificationCategory;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Validator;

class TemplateController extends AdminController
{
    public function __construct(NotificationTemplate $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->model->getDatatable($request);
        }
        $categories = NotificationCategory::orderBy('name')->get(['id', 'name', 'slug']);

        return view(self::$viewDir.'notification.template', compact('categories'));
    }

    public function create()
    {
        $categories = NotificationCategory::orderBy('name')->get();

        return view(self::$viewDir.'notification.templateCreate', compact('categories'));
    }

    public function edit($id)
    {
        $template = $this->model->findorfail($id);
        $categories = NotificationCategory::orderBy('name')->get();

        return view(self::$viewDir.'notification.templateEdit', compact('categories', 'template'));
    }

    public function show($id)
    {
        $template = $this->model->findorfail($id);

        return view(self::$viewDir.'notification.templateShow', compact('template'));
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
            if ($request->template_id) {
                $item = $this->model->findorfail($request->template_id)
                    ->storeItem($request);
            } else {
                $item = $this->model->storeItem($request);
            }

            return response()->json([
                'status' => 1,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
