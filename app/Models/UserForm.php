<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class UserForm extends BaseModel
{
    use HasFactory;

    protected $table = 'user_forms';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function createUserForm($model, $product, $user)
    {
        $form = $this;
        $form->user_id = $user->id;
        $form->model_id = $model->id;
        $form->model_type = get_class($model);
        $form->title = $product->getEmail->title ?? '';
        $form->description = $product->getEmail->content ?? '';
        $form->body = $product->getForm->content ?? '';
        $form->status = 'need to fill';
        $form->save();

        return $form;
    }

    public function getDatatable($status, $user)
    {
        switch ($status) {
            case 'all':
                $forms = $this::with('user', 'model');
                break;
            case 'unread':
                $forms = $this::with('user', 'model')->whereNull('read_at');
                break;
            case 'read':
                $forms = $this::with('user', 'model')->where('read_at', '!=', null);
                break;
        }
        if ($user != 'all') {
            $forms = $forms->my($user);
        }

        return Datatables::of($forms)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('user', function ($row) {
            return "<img src='".$row->user->avatar()."' title='".$row->user->name."' class='user-avatar-50'><br><a href='".route('admin.userManage.detail', $row->user->id)."'>{$row->user->name}</a><br>({$row->user->email})";
        })->editColumn('model_type', function ($row) {
            return $row->userModelToName($row->model_type);
        })->editColumn('model_name', function ($row) {
            return json_decode($row->model->item)->name ?? '';
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status === 'completed') {
                $result = "<span class='c-badge c-badge-success white-space-nowrap'>".$row->status.'</span>';
            } elseif ($row->status === 'filled') {
                $result = "<span class='c-badge c-badge-danger white-space-nowrap'>".$row->status.'</span>';
            } else {
                $result = "<span class='c-badge c-badge-info white-space-nowrap'>".$row->status.'</span>';
            }

            return $result;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.purchase.form.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="'.route('admin.purchase.form.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Edit</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne"  data-action="delete">
                        <span>
                            <span>Delete</span>
                        </span>
                    </a>
                    ';
        })->rawColumns(['checkbox', 'user', 'status', 'action'])->make(true);
    }

    public function getUserDatatable()
    {
        $forms = $this::with('model')->where('user_id', user()->id);

        return Datatables::of($forms)->editColumn('model_type', function ($row) {
            return $row->userModelToName($row->model_type);
        })->editColumn('model_name', function ($row) {
            return json_decode($row->model->item)->name ?? '';
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status === 'completed') {
                $result = "<span class='c-badge c-badge-success white-space-nowrap'>".$row->status.'</span>';
            } elseif ($row->status === 'filled') {
                $result = "<span class='c-badge c-badge-info white-space-nowrap'>".$row->status.'</span>';
            } else {
                $result = "<span class='c-badge c-badge-danger white-space-nowrap'>".$row->status.'</span>';
            }

            return $result;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('user.purchase.form.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="'.route('user.purchase.form.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon">
                        <span>
                            <span>Edit</span>
                        </span>
                    </a>
                    ';
        })->rawColumns(['checkbox', 'status', 'action'])->make(true);
    }
}
