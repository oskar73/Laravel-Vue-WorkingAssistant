<?php

namespace App\Models;

use App\Jobs\SendEmailJob;
use App\Mail\NotifyMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class Subscriber extends BaseModel
{
    use HasFactory;

    protected $table = 'subscribers';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function subscribe($request)
    {
        $email = $request->email;
        $subscriber = $this->where('email', $email)->first();
        if ($subscriber == null) {
            $subscriber = $this;
            $subscriber->status = 0;
            $subscriber->email = $email;
            $subscriber->token = \Str::random(64);
            $subscriber->save();
        }

        if ($subscriber->status == 0) {
            $subscriber->notifyEmail();

            return 0;
        } else {
            return 1;
        }
    }

    public function notifyEmail()
    {
        $data['subject'] = 'Confirm subscribe to newsletter.';
        $data['url'] = route('subscribe.confirm', $this->token);
        $data['text'] = '<p>Hello there! </p><p>Thank you for subscribing!</p><p>Please confirm your email for verification by clicking below link.</p><p>Thank you!</p>';
        $data['email'] = $this->email;

        $detail['email'] = $this->email;
        $detail['object'] = new NotifyMail($data);

        dispatch(new SendEmailJob($detail));
    }

    public function getDatatable($status)
    {
        switch ($status) {
            case 'all':
                $subscribers = $this::select(['email', 'status', 'id', 'created_at']);
                break;
            case 'active':
                $subscribers = $this::select(['email', 'status', 'id', 'created_at'])->where('status', 1);
                break;
            case 'inactive':
                $subscribers = $this::select(['email', 'status', 'id', 'created_at'])->where('status', 0);
                break;
        }

        return Datatables::of($subscribers)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="c-badge c-badge-success hover-handle">Verified</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Unverify?</a>';
            } else {
                return '<span class="c-badge c-badge-danger hover-handle" >Unverified</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Verify?</a>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                        <span>
                            <i class="la la-remove"></i>
                            <span>Delete</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'action'])->make(true);
    }

    public function categories()
    {
        return $this->belongsToMany(EmailCategory::class, 'unsubscribe_category', 'subscriber_id', 'category_id')->withTimestamps();
    }
}
