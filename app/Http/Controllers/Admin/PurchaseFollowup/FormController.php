<?php

namespace App\Http\Controllers\Admin\PurchaseFollowup;

use App\Http\Controllers\Admin\AdminController;
use App\Models\PurchaseFollowupForm;
use Illuminate\Http\Request;
use Validator;

class FormController extends AdminController
{
    public function __construct(PurchaseFollowupForm $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $forms = $this->model->select(['id', 'name', 'status', 'created_at'])->get();
            $activeForms = $forms->where('status', 1);
            $inactiveForms = $forms->where('status', 0);

            $all = view('components.admin.purchase_followup_form', [
                'forms' => $forms,
                'selector' => 'datatable-all',
            ])->render();

            $active = view('components.admin.purchase_followup_form', [
                'forms' => $forms,
                'selector' => 'datatable-active',
            ])->render();

            $inactive = view('components.admin.purchase_followup_form', [
                'forms' => $forms,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $forms->count();
            $count['active'] = $activeForms->count();
            $count['inactive'] = $inactiveForms->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'purchasefollowup.form');
    }

    public function create()
    {
        return view(self::$viewDir.'purchasefollowup.formCreate');
    }

    public function edit($id)
    {
        $form = $this->model->findorfail($id);

        return view(self::$viewDir.'purchasefollowup.formCreate', compact('form'));
    }

    public function show($id)
    {
        $form = $this->model->findorfail($id);

        return view(self::$viewDir.'purchasefollowup.formShow', compact('form'));
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'form_builder_json' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $form = $this->model->storeForm($request);

            return response()->json([
                'status' => 1,
                'data' => route('admin.purchasefollowup.form.show', $form->id),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
