<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\AdminController;
use App\Models\NotificationTemplate;
use App\Models\UserForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class FormController extends AdminController
{
    public function __construct(UserForm $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'), request()->get('user'));
        }

        return view(self::$viewDir.'purchase.form');
    }

    public function detail($id)
    {
        $form = $this->model->findorfail($id);
        if ($form->read_at == null) {
            $form->read_at = Carbon::now()->toDateTimeString();
            $form->save();
        }

        return view(self::$viewDir.'purchase.formDetail', compact('form'));
    }

    public function edit($id)
    {
        $form = $this->model->findorfail($id);
        if ($form->read_at == null) {
            $form->read_at = Carbon::now()->toDateTimeString();
            $form->save();
        }

        return view(self::$viewDir.'purchase.formEdit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'status' => 'required|in:need to fill,filled,need revision,completed',
                'reason' => 'nullable|max:6000',
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $form = $this->model->findorfail($id);
            $result = $request->except('status', 'reason', '_token');
            $form->result = json_encode($result);
            $form->status = $request->status;
            $form->reason = $request->reason;
            $form->save();

            return response()->json([
                'status' => 1,
                'data' => $form,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function switchForm(Request $request)
    {
        try {
            $action = $request->action;

            $notification = new NotificationTemplate();
            $slug = '';
            $notify = 0;
            $forms = $this->model->whereIn('id', $request->ids)->get();

            if ($action === 'filled') {
                $forms->each->update(['status' => 'filled']);
            } elseif ($action === 'needtofill') {
                $forms->each->update(['status' => 'need to fill']);
            } elseif ($action === 'needrevision') {
                $forms->each->update(['status' => 'need revision', 'reason' => $request->reason]);

//                $slug= $notification::PURCHASE_FOLLOWUP_NEED_REVISION;
                $data['reason'] = $request->reason;
                $notify = 1;
            } elseif ($action === 'completed') {
                $forms->each->update(['status' => 'completed', 'reason' => null]);
//                $slug= $notification::PURCHASE_FOLLOWUP_COMPLETED;
                $notify = 1;
            } elseif ($action === 'read') {
                $forms->each->update(['read_at' => Carbon::now()->toDateTimeString()]);
            } elseif ($action === 'unread') {
                $forms->each->update(['read_at' => null]);
            } elseif ($action === 'delete') {
                $forms->each->delete();
            }
            if ($notify == 1) {
//                foreach($forms as $form)
//                {
//                    $data['url'] = route('user.purchase.form.detail', $form->id);
//                    $data['username'] = $form->user->name;
//                    $notification->sendNotification($data, $slug, $form->user);
//                }
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
