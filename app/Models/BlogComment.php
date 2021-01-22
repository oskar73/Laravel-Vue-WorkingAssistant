<?php

namespace App\Models;

use App\Models\Module\BlogPost;
use Yajra\DataTables\DataTables;

class BlogComment extends BaseModel
{
    protected $table = 'blog_comments';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($obj) {
            $obj->notifySubscribers();
        });
        static::updated(function ($obj) {
            $obj->notifySubscribers();
        });
    }

    public function notifySubscribers()
    {
        if ($this->status == 1) {
//            $emails = $this->post->subscribers->pluck("email")->toArray();
//            if($emails!=null)
//            {
//                $data['url'] = route('blog.detail', $this->post->slug?? 0) . "#comment_section";
//                $data['comment'] = $this->comment;
//                dispatch(new SendEmailToSubscribersJob($emails, $this->post, $data, NotificationTemplate::BLOG_COMMENT_TO_SUBSCRIBERS));
//            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id')->withDefault();
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->where('status', 1)->with('user.media', 'approvedComments', 'favorite_to_users');
    }

    public function favorite_to_users()
    {
        return $this->belongsToMany(User::class, 'blog_favorite_comment_user', 'comment_id', 'user_id')->withPivot('favorite');
    }

    public function getDatatable($status)
    {
        switch ($status) {
            case 'pending':
                $comments = $this::with('user', 'favorite_to_users', 'post')->where('status', 0)->latest();
                break;
            case 'all':
                $comments = $this::with('user', 'favorite_to_users', 'post')->latest();
                break;
            case 'approved':
                $comments = $this::with('user', 'favorite_to_users', 'post')->where('status', 1)->latest();
                break;
            case 'denied':
                $comments = $this::with('user', 'favorite_to_users', 'post')->where('status', -1)->latest();
                break;
        }

        return Datatables::of($comments)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('title', function ($row) {
            $result = "<a href='".route('admin.blog.post.show', $row->post->id)."' class='text-dark'>".$row->post->title.'</a>';

            return $result;
        })->addColumn('user', function ($row) {
            $result = "<a href='' class='text-dark'>".$row->user->name.'</a>';

            return $result;
        })->addColumn('liked_count', function ($row) {
            $result = "<a href='' class='text-dark'>".$row->favorite_to_users->where('pivot.favorite', 1)->count().'</a>';

            return $result;
        })->addColumn('disliked_count', function ($row) {
            $result = "<a href='' class='text-dark'>".$row->favorite_to_users->where('pivot.favorite', 0)->count().'</a>';

            return $result;
        })->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="c-badge c-badge-success hover-handle">Approved</span>
<a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="deny">Deny?</a>';
            } elseif ($row->status == 0) {
                return '<span class="c-badge c-badge-info hover-handle" >Pending</span>
<div class="down-handle origin-none d-none ">
    <a href="javascript:void(0);" class="h-cursor c-badge c-badge-success hover-box m-2 switchOne" data-action="approve">Approve?</a>
    <a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger hover-box m-2  switchOne" data-action="deny">Deny?</a>
</div>';
            } elseif ($row->status == -1) {
                return '<span class="c-badge c-badge-danger hover-handle" >Denied</span>
<a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="approve">Approve?</a>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.blog.comment.show', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('admin.blog.comment.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                            <i class="la la-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne" data-action="delete" title="Delete">
                            <i class="la la-remove"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'title', 'liked_count', 'comment', 'disliked_count', 'user', 'action'])->make(true);
    }
}
