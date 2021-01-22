<?php

namespace App\Http\Controllers\Admin\PurchaseFollowup;

use App\Http\Controllers\Admin\AdminController;
use App\Models\PurchaseFollowupEmail;
use Illuminate\Http\Request;
use Validator;

class EmailController extends AdminController
{
    public function __construct(PurchaseFollowupEmail $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $emails = $this->model->select(['id', 'title', 'status', 'content', 'created_at'])->get();
            $activeEmails = $emails->where('status', 1);
            $inactiveEmails = $emails->where('status', 0);

            $all = view('components.admin.purchase_followup_email', [
                'emails' => $emails,
                'selector' => 'datatable-all',
            ])->render();
            $active = view('components.admin.purchase_followup_email', [
                'emails' => $activeEmails,
                'selector' => 'datatable-active',
            ])->render();
            $inactive = view('components.admin.purchase_followup_email', [
                'emails' => $inactiveEmails,
                'selector' => 'datatable-inactive',
            ])->render();

            $count['all'] = $emails->count();
            $count['active'] = $activeEmails->count();
            $count['inactive'] = $inactiveEmails->count();

            return response()->json([
                'status' => 1,
                'all' => $all,
                'active' => $active,
                'inactive' => $inactive,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'purchasefollowup.email');
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), $this->model->storeRule($request));
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $item = $this->model->storeEmail($request);

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
