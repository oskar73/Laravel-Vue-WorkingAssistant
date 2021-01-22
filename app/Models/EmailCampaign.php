<?php

namespace App\Models;

use App\Jobs\SendEmailCampaignJob;
use App\Mail\CampaignMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class EmailCampaign extends BaseModel
{
    use HasFactory;

    protected $table = 'email_campaigns';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($obj) {
            if ($obj->status == 1 && $obj->time == null) {
                $obj->sendCampaign();
            }
        });
        static::updated(function ($obj) {
            if ($obj->status == 1 && $obj->time == null) {
                $obj->sendCampaign();
            }
        });
    }

    public function storeRule($request)
    {
        $rule['category'] = 'required|exists:email_categories,id,web_id,'.tenant('id').',status,1';
        $rule['subject'] = 'nullable|max:191';
        $rule['message_body'] = 'required';
        $rule['status'] = 'required|in:1,0';
        if ($request->notnow) {
            $rule['promised_time'] = 'required';
        }

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->category_id = $request->category;
        $item->subject = $request->subject;
        $item->body = $request->message_body;
        $item->time = $request->notnow ? $request->promised_time : null;
        $item->status = $request->status;
        $item->save();

        return $item;
    }

    public function sendCampaign()
    {
        $campaign = $this;
        $data['body'] = $campaign->body;
        $data['subject'] = $campaign->subject ?? '';
        $data['campaign_id'] = hashEncode($campaign->id);

        $detail['category'] = $campaign->category_id;
        $detail['object'] = new CampaignMail($data);

        $campaign->syncOriginal();
        $campaign->status = 'sent';
        $campaign->save();

        dispatch(new SendEmailCampaignJob($detail));
    }

    public function category()
    {
        return $this->belongsTo(EmailCategory::class, 'category_id')->withDefault();
    }

    public function getDatatable($status)
    {
        switch ($status) {
            case 'all':
                $campaigns = $this::with('category');
                break;
            case 'active':
                $campaigns = $this::with('category')->where('status', 1);
                break;
            case 'inactive':
                $campaigns = $this::with('category')->where('status', 0);
                break;
            case 'sent':
                $campaigns = $this::with('category')->where('status', 'sent');
                break;
        }

        return Datatables::of($campaigns)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('category', function ($row) {
            return $row->category->name;
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('time', function ($row) {
            $time = $row->time ?? 'Instant';
            if ($row->status == 1) {
                $result = $time."<br> <span class='c-badge c-badge-success sendNow h-cursor' data-id='{$row->id}'>Send Now</span>";
            } else {
                $result = $time;
            }

            return $result;
        })->editColumn('updated_at', function ($row) {
            return $row->updated_at->toDateTimeString();
        })->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="c-badge c-badge-success hover-handle">Active</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>';
            } elseif ($row->status == 'sent') {
                return '<span class="c-badge c-badge-danger" >Sent</span>';
            } elseif ($row->status == 0) {
                return '<span class="c-badge c-badge-warning hover-handle" >InActive</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>';
            }
        })->addColumn('action', function ($row) {
            $edit = $row->status == 'sent' ? 'Resend' : 'Edit';

            return '<a href="'.route('admin.email.campaign.show', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon viewBtn">
                        <span>
                            <i class="la la-eye"></i>
                            <span>View Email</span>
                        </span>
                    </a>
                    <a href="'.route('admin.email.campaign.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-id="'.$row->id.'">
                        <span>
                            <i class="la la-edit"></i>
                            <span>'.$edit.'</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                        <span>
                            <i class="la la-remove"></i>
                            <span>Delete</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'time', 'action'])->make(true);
    }
}
