<?php

namespace App\Http\Controllers\User\Purchase;

use App\Http\Controllers\User\UserController;
use App\Models\NotificationTemplate;
use App\Models\UserForm;
use Illuminate\Http\Request;

class FormController extends UserController
{
    public function __construct(UserForm $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getUserDatatable();
        }

        return view(self::$viewDir.'purchase.form');
    }

    public function detail($id)
    {
        $form = $this->model->whereId($id)->where('user_id', user()->id)->firstorfail();

        return view(self::$viewDir.'purchase.formDetail', compact('form'));
    }

    public function edit($id)
    {
        $form = $this->model->whereId($id)->where('user_id', user()->id)->firstorfail();

        return view(self::$viewDir.'purchase.formEdit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        try {
            $form = $this->model->whereId($id)->where('user_id', user()->id)->firstorfail();
            $result = $request->except('_token');
            $form->result = json_encode($result);
            $form->read_at = null;
            $form->status = 'filled';
            $form->save();

//            $notification = new NotificationTemplate();
//            $data['url'] = route('admin.purchase.form.detail', $form->id);
//            $data['slug'] = $notification::PURCHASE_FOLLOWUP_APPROVAL;
//            $notification->sendNotificationToAdmin($data);

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
}
