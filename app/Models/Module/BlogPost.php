<?php

namespace App\Models\Module;

use App\Jobs\SendEmailToSubscribersJob;
use App\Models\BaseModel;
use App\Models\BlogComment;
use App\Models\BlogTag;
use App\Models\User;
use App\Models\UserBlogPackage;
use Carbon\Carbon;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

use VanOns\Laraberg\Traits\RendersContent;

class BlogPost extends BaseModel implements HasMedia
{
    use InteractsWithMedia, Favoriteable, Subscribable, RendersContent;

    protected $table = 'blog_posts';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['image', 'thumbnail'];

    protected $contentColumn = 'body';

    const CUSTOM_VALIDATION_MESSAGE = [];

    public function getImageAttribute(): string
    {
        return $this->getFirstMediaUrl('image');
    }

    public function getThumbnailAttribute(): string
    {
        return $this->getFirstMediaUrl('image', 'thumb');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            // Only generate a slug if it's not provided
            if (empty($blog->slug)) {
                $blog->slug = $blog->generateSlug($blog->title);
            } else {
                // Ensure the provided slug is unique
                $originalSlug = $blog->slug;
                $counter = 1;
                while (BlogPost::where('slug', $blog->slug)->exists()) {
                    $blog->slug = "{$originalSlug}-" . $counter++;
                }
            }
        });

        static::created(function ($obj) {
            $obj->notifySubscribers();
        });
        static::updated(function ($obj) {
            $obj->notifySubscribers();
        });
    }

    /**
     * Generate a unique slug based on a given title.
     *
     * @param string $title
     * @return string
     */
    protected function generateSlug($title)
    {
        $slug = \Str::slug($title);
        $count = BlogPost::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function notifySubscribers()
    {
        if ($this->status == 'approved' && $this->is_published == 1 && $this->visible_date <= now()->toDateString()) {
//            $this->notifyToAuthorSubscribers();
//            $this->notifyToCategorySubscribers();
//            $this->notifyToPostSubscribers();
        }
    }

    public function notifyToAuthorSubscribers()
    {
        $emails = $this->user->followers->pluck('email')->toArray();
        if ($emails != null) {
            $data['url'] = route('blog.detail', $this->slug ?? 0);
            dispatch(new SendEmailToSubscribersJob($emails, $this, $data, NotificationTemplate::BLOG_NOTIFY_TO_AUTHOR_SUBSCRIBERS));
        }
    }

    public function notifyToCategorySubscribers()
    {
        $emails = $this->category->subscribers->pluck('email')->toArray();
        if ($emails != null) {
            $data['url'] = route('blog.detail', $this->slug ?? 0);
            dispatch(new SendEmailToSubscribersJob($emails, $this, $data, NotificationTemplate::BLOG_COMMENT_TO_SUBSCRIBERS));
        }
    }

    public function notifyToPostSubscribers()
    {
        $emails = $this->subscribers->pluck('email')->toArray();
        if ($emails != null) {
            $data['url'] = route('blog.detail', $this->slug ?? 0);
            dispatch(new SendEmailToSubscribersJob($emails, $this, $data, NotificationTemplate::BLOG_NOTIFY_TO_POST_SUBSCRIBERS));
        }
    }

    public function storeRule($request)
    {
        $rule['title'] = 'required|max:191';
        $rule['category'] = 'required|exists:blog_categories,id,web_id,'.tenant('id').',status,1';
        $rule['tags'] = 'required';
        $rule['tags.*'] = 'exists:blog_tags,id,web_id,'.tenant('id').',status,1';
        $rule['publish'] = 'required|in:0,1';

        if ($request->origin_image) {
            $rule['origin_image'] = 'required|image|mimes:jpg,png,jpeg,gif|max:10240';
        } else {
            $rule['image'] = 'required';
        }

        if ($request->images) {
            $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($request->videos) {
            $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        }
        if ($request->links) {
            $rule['links.*'] = 'required|max:191';
        }
        $rule['order'] = 'required|in:1,0';

        return $rule;
    }

    public function userUpdateRule($request)
    {
        $rule['title'] = 'required|max:191';
        $rule['category'] = 'required|integer';
        $rule['tags'] = 'required';
        $rule['tags.*'] = 'integer';
        $rule['publish'] = 'required|in:0,1';

        if ($request->images) {
            $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($request->videos) {
            $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        }
        if ($request->links) {
            $rule['links.*'] = 'required|max:191';
        }
        $rule['order'] = 'required|in:1,0';

        return $rule;
    }

    public function updateRule($request)
    {
        $rule['title'] = 'required|max:191';
        $rule['category'] = 'required|exists:blog_categories,id,web_id,'.tenant('id').',status,1';
        $rule['tags'] = 'required';
        $rule['tags.*'] = 'exists:blog_tags,id,web_id,'.tenant('id').',status,1';
        $rule['denied_reason'] = 'max:600';
        $rule['publish'] = 'required|in:0,1';
        $rule['featured'] = 'required|in:0,1';
        $rule['status'] = 'required|in:approved,pending,denied';

        if ($request->origin_image) {
            $rule['origin_image'] = 'image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($request->images) {
            $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($request->videos) {
            $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        }
        if ($request->links) {
            $rule['links.*'] = 'required|max:191';
        }
        if ($request->links) {
            $rule['links.*'] = 'required';
        }
        $rule['order'] = 'required|in:1,0';

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->user_id = user()->id;
        $item->category_id = $request->category;
        $item->title = $request->title;
        $item->body = $request->description;
        $item->status = 'approved';
        $item->is_published = $request->publish;
        $item->visible_date = Carbon::now()->toDateString();
        $item->save();

        $item->tags()->sync($request->tags);

        if ($request->origin_image) {
            $item->addMedia($request->origin_image)
                ->usingFileName(guid().'.'.$request->origin_image->getClientOriginalExtension())
                ->toMediaCollection('image');
        } elseif ($request->image) {
            $item->addMediaFromBase64($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }
        foreach ($request->images ?? [] as $image) {
            $item->addMedia($image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('images');
        }
        foreach ($request->videos ?? [] as $video) {
            $item->addMedia($video)
                ->toMediaCollection('video');
        }

        return $item;
    }

    public function updateItem($request)
    {
        $this->category_id = $request->category;
        $this->title = $request->title;
        $this->body = $request->description;
        $this->visible_date = $request->visible_date;
        $this->is_published = $request->publish;
        if ($request->status == 'approved') {
            $this->denied_reason = null;
        } else {
            $this->denied_reason = $request->denied_reason;
        }
        $this->status = $request->status;
        $this->featured = $request->featured;
        $this->save();

        $this->tags()->sync($request->tags);

        $ids = $request->oldItems ?? [];
        if ($request->origin_image || $request->image !== null) {
            $collections = ['images', 'video', 'image'];
        } else {
            $collections = ['images', 'video'];
        }

        $this->media()
            ->whereNotIn('id', $ids)
            ->whereIn('collection_name', $collections)
            ->get()
            ->each
            ->delete();

        if ($request->origin_image) {
            $this->addMedia($request->origin_image)
                ->usingFileName(guid().'.'.$request->origin_image->getClientOriginalExtension())
                ->toMediaCollection('image');
        } elseif ($request->image) {
            $this->addMediaFromBase64($request->image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }
        foreach ($request->images ?? [] as $image) {
            $this->addMedia($image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('images');
        }
        foreach ($request->videos ?? [] as $video) {
            $this->addMedia($video)
                ->toMediaCollection('video');
        }

        return $this;
    }

    public function package()
    {
        return $this->belongsTo(UserBlogPackage::class, 'purchase_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    public function approvedTags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id')->withTimestamps()->where('status', 1);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class, 'post_id')->whereNull('parent_id')->with('user', 'approvedComments');
    }

    public function scopeVisible($query)
    {
        $today = Carbon::now()->toDateString();

        return $query->where('is_free', 0)->orWhere('visible_date', '<=', $today);
    }

    public function scopeFrontVisible($query)
    {
        return $query->whereStatus('approved')
            ->visible()
            ->whereIsPublished(1);
    }

    public function getVisibleDate($user_id, $setting)
    {
        if ($setting != null) {
            $free_post = $setting['post_number'] ?? 0;
            $period = $setting['period'];
            $period_unit = $setting['period_unit'];

            $start_date = get_before($period, $period_unit);
            $visible_date = Carbon::now()->toDateString();

            do {
                $counts = $this->where('user_id', $user_id)
                    ->where('is_free', 1)
                    ->where('visible_date', '>=', $start_date)
                    ->where('visible_date', '<=', $visible_date)
                    ->count();

                $date = new Carbon($start_date);
                $start_date = $date->addDay()->toDateString();
                $date2 = new Carbon($visible_date);
                $visible_date = $date2->addDay()->toDateString();
            } while ($counts >= $free_post);
            $date = new Carbon($visible_date);

            return $date->subDay()->toDateString();
        } else {
            return Carbon::now()->toDateString();
        }
    }

    public function getDatatable($status, $user)
    {
        switch ($status) {
            case 'pending':
                $posts = $this::with('user', 'category')
                    ->withCount('favoriters', 'comments', 'subscribers')
                    ->where('status', 'pending')
                    ->latest();
                break;
            case 'all':
                $posts = $this::with('user', 'category')
                    ->withCount('favoriters', 'comments', 'subscribers');
                break;
            case 'approved':
                $posts = $this::with('user', 'category')
                    ->withCount('favoriters', 'comments', 'subscribers')
                    ->where('status', 'approved');
                break;
            case 'draft':
                $posts = $this::with('user', 'category')
                    ->withCount('favoriters', 'comments', 'subscribers')
                    ->where('is_published', 0);
                break;
            case 'denied':
                $posts = $this::with('user', 'category')
                    ->withCount('favoriters', 'comments', 'subscribers')
                    ->where('status', 'denied');
                break;
        }
        if ($user != 'all') {
            $posts = $posts->where('user_id', $user);
        }

        return Datatables::of($posts)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('user', function ($row) {
            $result = "<a href=''>".$row->user->name.'</a>';

            return $result;
        })->addColumn('favoriters', function ($row) {
            return $row->favoriters_count;
        })->addColumn('comments', function ($row) {
            return $row->comments_count;
        })->addColumn('subscribers', function ($row) {
            return $row->subscribers_count;
        })->addColumn('category', function ($row) {
            return $row->category->name;
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success hover-handle">Approved</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="deny">Deny?</a>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info hover-handle" >Pending</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="approve">Approve?</a>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger hover-handle" >Denied</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success origin-none d-none down-handle hover-box switchOne" data-action="approve">Approve?</a>';
            }
        })->editColumn('is_published', function ($row) {
            if ($row->is_published == 1) {
                return '<span class="c-badge c-badge-success hover-handle">Published</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-info d-none origin-none down-handle hover-box switchOne" data-action="draft">Draft?</a>';
            } else {
                return '<span class="c-badge c-badge-info hover-handle" >Draft</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-success d-none origin-none down-handle hover-box switchOne" data-action="publish">Publish?</a>';
            }
        })->editColumn('is_free', function ($row) {
            if ($row->is_free == 1) {
                return '<span class="c-badge c-badge-info">Free</span>';
            } else {
                return '<span class="c-badge c-badge-success" >Paid</span>';
            }
        })->editColumn('featured', function ($row) {
            if ($row->featured == 1) {
                return '<span class="c-badge c-badge-success hover-handle">Featured</span><a href="javascript:void(0);" class="h-cursor c-badge c-badge-danger origin-none d-none down-handle hover-box switchOne" data-action="unfeatured">Cancel?</a>';
            } else {
                return '<a href="javascript:void(0);" class="c-badge c-badge-success hover-vis hover-box switchOne" data-action="featured">Featured?</a>';
            }
        })->editColumn('visible_date', function ($row) {
            return $row->visible_date;
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.blog.post.show', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('admin.blog.post.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                            <i class="la la-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne" data-action="delete" title="Delete">
                            <i class="la la-remove"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'is_published', 'user', 'featured', 'is_free', 'action'])
            ->make(true);
    }

    public function getUserDataTable()
    {
        $posts = $this::with('user', 'category')
            ->withCount('favoriters', 'comments', 'subscribers')
            ->where('useR_id', user()->id);

        return Datatables::of($posts)->addColumn('favoriters', function ($row) {
            return $row->favoriters_count;
        })->addColumn('comments', function ($row) {
            return $row->comments_count;
        })->addColumn('subscribers', function ($row) {
            return $row->subscribers_count;
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success">Approved</span>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info" >Pending</span>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger" >Denied</span>';
            }
        })->editColumn('is_published', function ($row) {
            if ($row->is_published == 1) {
                return '<span class="c-badge c-badge-success">Published</span>';
            } else {
                return '<span class="c-badge c-badge-info" >Draft</span>';
            }
        })->editColumn('is_free', function ($row) {
            if ($row->is_free == 1) {
                return '<span class="c-badge c-badge-info">Free</span>';
            } else {
                return '<span class="c-badge c-badge-success" >Paid</span>';
            }
        })->editColumn('title', function ($row) {
            if ($row->featured == 1) {
                $result = $row->title.' <span class="c-badge c-badge-success">Featured</span>';
            } else {
                $result = $row->title;
            }

            return $result;
        })->editColumn('visible_date', function ($row) {
            return $row->visible_date;
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('user.blog.detail', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('user.blog.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                            <i class="la la-edit"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'is_published', 'title', 'is_free', 'action'])
            ->make(true);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(60)
                    ->height(40)
                    ->sharpen(10)
                    ->nonQueued();
            });

        $this
            ->addMediaCollection('images')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(40)
                    ->height(40)
                    ->sharpen(10)
                    ->nonQueued();
            });
    }
}
