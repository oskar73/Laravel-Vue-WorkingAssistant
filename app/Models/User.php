<?php

namespace App\Models;

use App\Models\Module\BlogPost;
use App\Traits\WebRowTrait;
use Auth;
use Carbon\Carbon;
use Config;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\Facades\DataTables;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable, WebRowTrait, HasRoles, InteractsWithMedia, Followable, Favoriter, Subscriber;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createRule()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,null,null,web_id,'.tenant('id')],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function profileUpdateRule($request, $id = null)
    {
        if ($id == null) {
            $id = user()->id;
        } else {
            $rule['roles.*'] = 'nullable|in:admin,employee,client';
            $rule['status'] = 'required|in:active,inactive';
        }
        $rule['name'] = 'required|max:45';
        $rule['email'] = 'required|email|unique:users,email,'.$id.',id,web_id,'.tenant('id');
        $rule['timezone'] = 'required';
        $rule['time_format'] = 'required';

        return $rule;
    }

    public function storeRule()
    {
        $rule['name'] = 'required|max:45';
        $rule['email'] = 'required|email|unique:users,email,NULL,NULL,web_id,'.tenant('id');
        $rule['roles.*'] = 'nullable|in:admin,employee,client';
        $rule['timezone'] = 'required';
        $rule['time_format'] = 'required';
        $rule['password'] = 'required|min:8|max:191';
        $rule['confirm_password'] = 'required|same:password';
        $rule['status'] = 'required|in:active,inactive';

        return $rule;
    }

    public function storeItem($request)
    {
        $user = $this;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_owner = 0;
        $user->timezone = $request->timezone;
        $user->timeformat = $request->time_format;
        $user->email_verified_at = $request->verified ? Carbon::now()->toDateTimeString() : null;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->save();
        if ($request->image) {
            $user->addMediaFromBase64($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('avatar');
        }
        if ($request->subscribe) {
            $user->addSubscriber();
        }

        return $user;
    }

    public function addSubscriber($status = 1)
    {
        $subscriber = \App\Models\Subscriber::where('email', $this->email)->first();
        if ($subscriber == null) {
            $subscriber = new \App\Models\Subscriber();
            $subscriber->token = \Str::random(64);
            $subscriber->email = $this->email;
        }
        $subscriber->status = 1;
        $subscriber->save();

        return $subscriber;
    }

    public function createUser($data)
    {
        return self::create([
            'web_id' => tenant('id'),
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => option('verification', 1) == 1 ? null : now(),
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateProfile($request, $admin = 0)
    {
        $user = $this;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->timezone = $request->timezone;
        $user->timeformat = $request->time_format;
        if ($admin == 1) {
            // $user->username = $request->username;
            $user->status = $request->status;
            if ($request->verified && $this->email_verified_at == null) {
                $user->email_verified_at = Carbon::now()->toDateTimeString();
            } elseif ($request->verified == null && $this->email_verified_at != null) {
                $user->email_verified_at = null;
            }
        }
        $user->save();
        if ($request->image) {
            $user->clearMediaCollection('avatar')
                ->addMediaFromBase64($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('avatar');
        }

        return $user;
    }

    public function getPurchaseUser($payeremail)
    {
        $new = 0;
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            if (session()->has('guestEmail')) {
                $email = session('guestEmail');
            } else {
                $email = $payeremail;
            }

            $user = self::where('email', $email)->first();

            if ($user == null) {
                $password = uniqid();
                $name = explode('@', $email)[0] ?? 'New User';

                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->is_owner = 0;
                $user->status = 'active';
                $user->password = bcrypt($password);
                $user->save();

                $user->raw_password = $password;
                $new = 1;
            }
        }

        $result['user'] = $user;
        $result['new'] = $new;

        return $result;
    }

    public function updatePsw($request)
    {
        $user = $this;
        $user->password = bcrypt($request->new_password);
        $user->save();

        return $user;
    }

    public function scopeMy($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopeWebRow($query)
    {
        return $query->where('web_id', tenant('id'));
    }

    public function sendEmailVerificationNotification()
    {
        $data['url'] = URL::temporarySignedRoute(
            'verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->id,
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
        $notification = new NotificationTemplate();
        $notification->sendEmail($data, $notification::EMAIL_VERIFICATION, $this->email);
    }

    public function sendPasswordResetNotification($token)
    {
        $data['username'] = $this->name;
        $data['url'] = route('password.reset', $token);

        $notification = new NotificationTemplate();
        $notification->sendEmail($data, $notification::FORGOT_PASSWORD, $this->email);
    }

    public function avatar()
    {
        $avatar = $this->getFirstMediaUrl('avatar');
        if ($avatar != '' || $avatar != null) {
            return $avatar;
        } else {
            return 'https://ui-avatars.com/api/?size=300&&name='.$this->name;
        }
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'user_id');
    }

    public function visiblePosts()
    {
        return $this->hasMany(BlogPost::class, 'user_id')->frontVisible()->withCount('favoriters');
    }

    public function directoryListings()
    {
        return $this->hasMany(DirectoryListing::class, 'user_id');
    }

    public function blogAdsListings()
    {
        return $this->hasMany(BlogAdsListing::class, 'user_id');
    }

    public function siteAdsListings()
    {
        return $this->hasMany(SiteAdsListing::class, 'user_id');
    }

    public function directoryAdsListings()
    {
        return $this->hasMany(DirectoryAdsListing::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'user_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class, 'user_id')->where('status', 1);
    }

    public function favorite_to_comments()
    {
        return $this->belongsToMany(BlogComment::class, 'blog_favorite_comment_user', 'user_id', 'comment_id')->withPivot('favorite');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getDatatable($status)
    {
        switch ($status) {
            case 'all':
                $users = $this::with('roles', 'media')->where('id', '!=', user()->id);
                break;
            case 'active':
                $users = $this::with('roles', 'media')->where('id', '!=', user()->id)->where('status', 'active');
                break;
            case 'inactive':
                $users = $this::with('roles', 'media')->where('id', '!=', user()->id)->where('status', 'inactive');
                break;
        }

        return Datatables::of($users)->addColumn('role', function ($row) {
            $result = '';
            if ($row->hasRole('admin')) {
                $result .= "<img src='https://ui-avatars.com/api/?size=30&&name=A' title='Admin' class='rounded-circle m-1'>";
            }
            if ($row->hasRole('client')) {
                $result .= "<img src='https://ui-avatars.com/api/?size=30&&name=C' title='Client' class='rounded-circle m-1'>";
            }
            if ($row->hasRole('employee')) {
                $result .= "<img src='https://ui-avatars.com/api/?size=30&&name=E' title='Employee' class='rounded-circle m-1'>";
            }

            return $result;
        })->editColumn('status', function ($row) {
            if ($row->status == 'active') {
                return '<span class="c-badge c-badge-success hover-handle">Active</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger d-none origin-none down-handle hover-box switchOne" data-action="inactive">Inactive?</a>';
            } else {
                return '<span class="c-badge c-badge-danger hover-handle" >Inactive</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="active">Active?</a>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('avatar', function ($row) {
            return "<img src='".$row->avatar()."' title='".$row->name."' class='user-avatar-50'>";
        })->editColumn('email', function ($row) {
            if ($row->email_verified_at == null) {
                return $row->email;
            } else {
                return $row->email." <i class=\"far fa-check-circle text-success\" title='Verified'></i>";
            }
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.userManage.detail', $row->id).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="'.route('admin.userManage.edit', $row->id).'" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon editBtn" data-action="edit">
                        <span>
                            <i class="la la-edit"></i>
                            <span>Edit</span>
                        </span>
                    </a>';
        })->rawColumns(['status', 'role', 'avatar', 'email', 'action'])->make(true);
    }

    public function getNotifications($status)
    {
        if ($status == 'unread') {
            $notifications = user()->unreadNotifications();
        } else {
            $notifications = user()->notifications();
        }

        return Datatables::of($notifications)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('subject', function ($row) {
            return $row->data['subject'];
        })->addColumn('link', function ($row) {
            return "<a href='".$row->data['url']."' class='btn btn-outline-success btn-sm'>Action</a>";
        })->editColumn('created_at', function ($row) {
            return $row->created_at->toDateTimeString();
        })->editColumn('read_at', function ($row) {
            return $row->read_at ? $row->read_at->toDateTimeString() : '';
        })->addColumn('action', function ($row) {
            return '<a href="'.route('notification.detail', ['id' => $row->id, 'role' => user()->hasRole('admin') ? 'admin' : 'account']).'" class="btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon" data-action="detail">
                        <span>
                            <i class="la la-eye"></i>
                            <span>Detail</span>
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm m-1	p-2 m-btn m-btn--icon switchOne" data-action="delete">
                        <span>
                            <i class="la la-remove"></i>
                            <span>Delete</span>
                        </span>
                    </a>';
        })->rawColumns(['checkbox', 'link', 'action'])->make(true);
    }
}
