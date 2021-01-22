<?php

namespace App\Models;

use App\Events\BasicNotificationEvent;
use App\Jobs\SendEmailJob;
use App\Mail\BasicMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $table = 'notification_templates';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public const EMAIL_VERIFICATION = 'email_verification';

    public const FORGOT_PASSWORD = 'forgot_password';

    public const PROFILE_CHANGED = 'profile_changed';

    public const APPOINTMENT_APPROVAL = 'appointment_approval';

    public const APPOINTMENT_APPROVED = 'appointment_approved';

    public const APPOINTMENT_CANCELED = 'appointment_canceled';

    public const APPOINTMENT_RESCHEDULED = 'appointment_rescheduled';

    public const APPOINTMENT_CANCELED_BY_USER = 'appointment_canceled_by_user';

    public function getUpdatedBody($data = [])
    {
        $data['unsubscribe'] = \URL::signedRoute('unsubscribe');
        $data['home'] = route('home');
        $data['faq'] = '/faq';
        $data['contactus'] = '/contactus';
        $data['website_name'] = tenant('name');

        $body = $this->body;

        foreach ($data as $key => $item) {
            $body = str_replace('{'.$key.'}', $item, $body);
        }

        return $body;
    }

    public function sendEmail($data, $slug, $email)
    {
        $template = $this->where('slug', $slug)->first();
        if ($template != null) {
            $data2['body'] = $template->getUpdatedBody($data);
            $data2['website_name'] = tenant('name');
            $data2['subject'] = $template->subject;
            $data2['fromName'] = $template->fromName ?? tenant('name');

            $fromMail = $template->fromMail ?? 'info';
            $data2['fromMail'] = $fromMail.'@'.config('custom.bizinabox.mail_domain');

            $object['email'] = $email;
            $object['object'] = new BasicMail($data2);

            dispatch(new SendEmailJob($object));
        }
    }

    public function sendNotification($data, $slug, $user)
    {
        $template = $this->where('slug', $slug)->first();
        if ($template != null) {
            $data2['body'] = $template->getUpdatedBody($data);
            $data2['url'] = $data['url'] ?? '';
            $data2['website_name'] = tenant('name');
            $data2['subject'] = $template->subject;
            $data2['fromName'] = $template->fromName ?? tenant('name');

            $fromMail = $template->fromMail ?? 'info';
            $data2['fromMail'] = $fromMail.'@'.config('custom.bizinabox.mail_domain');

            event(new BasicNotificationEvent($user, $data2));
        }
    }

    public function sendNotificationToAdmin($data)
    {
        $admin = tenant()->owner();
        $data['username'] = $admin->name;
        if (! isset($data['user'])) {
            $data['user'] = user()->name ?? '';
        }

        $this->sendNotification($data, $data['slug'] ?? '', $admin);
    }

    public function storeRule($request)
    {
        $rule['name'] = 'required';
        if ($request->template_id) {
            $rule['slug'] = 'required|unique:notification_templates,slug,'.$request->template_id.',id';
        } else {
            $rule['slug'] = 'required|unique:notification_templates';
        }
        $rule['subject'] = 'nullable|max:191';
        $rule['fromMail'] = 'required|max:191';
        $rule['fromName'] = 'required|max:191';
        $rule['body'] = 'required';

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        if (! $request->template_id) {
            $item->category_id = $request->category;
        }
        $item->subject = $request->subject;
        $item->slug = $request->slug;
        $item->fromMail = $request->fromMail;
        $item->fromName = $request->fromName == '{website_name}' ? null : $request->fromName;
        $item->name = $request->name;
        $item->body = $request->body;
        $item->save();

        return $item;
    }

    public function category()
    {
        return $this->belongsTo(NotificationCategory::class, 'category_id')->withDefault();
    }

    public function getDatatable($request)
    {
        if ($request->category == 0) {
            $templates = $this::with('category');
        } else {
            $templates = $this::with('category')->where('category_id', $request->category);
        }

        return Datatables::of($templates)->addColumn('category', function ($row) {
            return $row->category->name;
        })->editColumn('fromName', function ($row) {
            return $row->fromName == null ? tenant('name') : $row->fromName;
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.notification.template.show', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-id="'.$row->id.'">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="'.route('admin.notification.template.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-id="'.$row->id.'">
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete"  data-id="'.$row->id.'">
                        <span>
                            <i class="la la-remove"></i>
                            <span>Delete</span>
                        </span>
                    </a>';
        })->rawColumns(['action'])->make(true);
    }
}
