<?php

namespace App\Models;

use App\Traits\Ratable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

class DirectoryListing extends BaseModel implements HasMedia
{
    use HasFactory;
    use Sluggable, InteractsWithMedia, Ratable;

    protected $table = 'directory_listings';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'property' => 'json',
    ];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($obj) {
            if ($obj->status == 'expired') {
//                $obj->expiredNotification();
            }
        });
    }

    public function storeRule($request)
    {
        $rule['category'] = 'required|integer|exists:directory_categories,id,web_id,'.tenant('id').',status,1';
        $rule['tags.*'] = 'nullable|exists:directory_tags,id,web_id,'.tenant('id').',status,1';
        $rule['title'] = 'required|string|max:255';
        $rule['url'] = 'required|string|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,10})([\/\w \.-]*)*\/?$/';
        $rule['description'] = 'required|max:10000';
        $rule['customer'] = 'required|integer|exists:users,id,web_id,'.tenant('id');
        $rule['order'] = 'required|in:1,0';
        $rule['status'] = 'required|in:approved,pending,paid';
        if ($request->unlimit == null) {
            $rule['expire_date'] = 'required|date|max:191|after:yesterday';
        }

        $rule['images'] = 'nullable|array|max:30';
        $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';

        $rule['links'] = 'nullable|array|max:10';
        $rule['links.*'] = 'nullable|string|max:255';

        $rule['videos'] = 'nullable|array|max:10';
        $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';

        return $rule;
    }

    public function storeUserRule($property)
    {
        $rule['category'] = 'required|integer|exists:directory_categories,id,web_id,'.tenant('id').',status,1';
        $rule['tags.*'] = 'nullable|exists:directory_tags,id,web_id,'.tenant('id').',status,1';
        $rule['title'] = 'required|string|max:255';
        $rule['url'] = 'required|string|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,10})([\/\w \.-]*)*\/?$/';
        $rule['description'] = 'required|max:10000';
        $rule['order'] = 'required|in:1,0';
        if ($property['links']) {
            $rule['images'] = 'nullable|array|max:30';
            $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($property['links']) {
            $rule['links'] = 'nullable|array|max:10';
            $rule['links.*'] = 'nullable|string|max:255';
        }
        if ($property['videos']) {
            $rule['videos'] = 'nullable|array|max:10';
            $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        }

        return $rule;
    }

    public function updateUserRule()
    {
        $rule['category'] = 'required|integer|exists:directory_categories,id,web_id,'.tenant('id').',status,1';
        $rule['tags.*'] = 'nullable|exists:directory_tags,id,web_id,'.tenant('id').',status,1';
        $rule['title'] = 'required|string|max:255';
        $rule['url'] = 'required|string|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,10})([\/\w \.-]*)*\/?$/';
        $rule['description'] = 'required|max:10000';
        $rule['order'] = 'required|in:1,0';
        if ($this->isProperty('image')) {
            $rule['images'] = 'nullable|array|max:30';
            $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        }
        if ($this->isProperty('links')) {
            $rule['links'] = 'nullable|array|max:10';
            $rule['links.*'] = 'nullable|string|max:255';
        }
        if ($this->isProperty('videos')) {
            $rule['videos'] = 'nullable|array|max:10';
            $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        }

        return $rule;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'category_id'], // unique slug for each website by combination of category_id #code
            ],
        ];
    }

    public function storeItem($request)
    {
        return $this->saveItem($request)
            ->saveMedia($request);
    }

    public function updateItem($request)
    {
        $item = $this->saveItem($request);

        $ids = $request->oldItems ?? [];
        if ($request->thumbnail !== null) {
            $collections = ['image', 'video', 'thumbnail'];
        } else {
            $collections = ['image', 'video'];
        }

        $item->media()
            ->whereNotIn('id', $ids)
            ->whereIn('collection_name', $collections)
            ->get()
            ->each
            ->delete();

        $item->saveMedia($request);

        return $item;
    }

    public function saveItem($request)
    {
        $item = $this;
        $item->title = $request->title;
        $item->category_id = $request->category;
        $item->description = $request->description;
        $item->user_id = $request->customer;
        if ($request->allow_links && $request->links !== null) {
            $item->links = json_encode($request->links);
        } else {
            $item->links = null;
        }
        $item->featured = $request->featured ? 1 : 0;
        $item->status = $request->status;
        $item->new = $request->new ? 1 : 0;
        $item->url = $request->url;

        $property['thumbnail'] = $request->allow_thumbnail ? 1 : 0;
        $property['social'] = $request->allow_social ? 1 : 0;
        $property['image'] = $request->allow_image ? 1 : 0;
        $property['links'] = $request->allow_links ? 1 : 0;
        $property['videos'] = $request->allow_videos ? 1 : 0;
        $property['tracking'] = $request->allow_tracking ? 1 : 0;

        if ($request->unlimit) {
            $item->expired_at = null;
        } else {
            $item->expired_at = $request->expire_date;
        }
        $item->property = $property;
        $item->order = $request->order;
        $item->save();

        $item->tags()->sync($request->tags);

        return $item;
    }

    public function storeUserItem($request, $property, $approve, $id)
    {
        return $this->saveUserItem($request, $property, $approve, $id)
            ->saveUserMedia($request, $property);
    }

    public function saveUserItem($request, $property, $approve, $id)
    {
        $item = $this;
        $item->title = $request->title;
        $item->category_id = $request->category;
        $item->purchase_id = $id == 0 ? null : $id;
        $item->description = $request->description;
        $item->user_id = user()->id;
        if ($property['links'] == 1 && $request->links !== null) {
            $item->links = json_encode($request->links);
        } else {
            $item->links = null;
        }
        if ($property['featured'] == 1 && $request->featured) {
            $item->featured = 1;
        } else {
            $item->featured = 0;
        }
        if ($approve == 1) {
            $item->status = 'active';
        } else {
            $item->status = 'pending';
        }
        $item->new = $request->new ? 1 : 0;
        $item->url = $request->url;
//
//        if($request->unlimit)
//        {
//            $item->expired_at=null;
//        }else {
//
//            $item->expired_at=$request->expire_date;
//        }
        $item->property = $property;
        $item->order = $request->order;
        $item->save();

        $item->tags()->sync($request->tags);

        return $item;
    }

    public function saveUserMedia($request, $property)
    {
        if ($property['thumbnail'] == 1 && $request->thumbnail !== null) {
            $this->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('thumbnail');
        }
        if ($property['image'] == 1) {
            foreach ($request->images ?? [] as $image) {
                $this->addMedia($image)
                    ->usingFileName(guid().'.jpg')
                    ->toMediaCollection('image');
            }
        }
        if ($property['videos'] == 1) {
            foreach ($request->videos ?? [] as $video) {
                $this->addMedia($video)
                    ->toMediaCollection('video');
            }
        }

        return $this;
    }

    public function updateUserItem($request, $approve)
    {
        $property = $this->property;

        $item = $this->saveUserItem($request, $property, $approve, $this->id);

        $ids = $request->oldItems ?? [];
        if ($request->thumbnail !== null) {
            $collections = ['image', 'video', 'thumbnail'];
        } else {
            $collections = ['image', 'video'];
        }

        $item->media()
            ->whereNotIn('id', $ids)
            ->whereIn('collection_name', $collections)
            ->get()
            ->each
            ->delete();

        $item->saveUserMedia($request, $property);

        return $item;
    }

    public function saveMedia($request)
    {
        if ($request->allow_thumbnail && $request->thumbnail !== null) {
            $this->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('thumbnail');
        }
        if ($request->allow_image) {
            foreach ($request->images ?? [] as $image) {
                $this->addMedia($image)
                    ->usingFileName(guid().'.jpg')
                    ->toMediaCollection('image');
            }
        }
        if ($request->allow_videos) {
            foreach ($request->videos ?? [] as $video) {
                $this->addMedia($video)
                    ->toMediaCollection('video');
            }
        }
    }

    public function isProperty($field)
    {
        return optional($this->property)[$field];
    }

    public function category()
    {
        return $this->belongsTo(DirectoryCategory::class, 'category_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany(DirectoryTag::class, 'directory_listing_tag', 'listing_id', 'tag_id');
    }

    public function scopeFrontVisible($query)
    {
        return $query->whereStatus('approved')
            ->where(function ($q) {
                $q->where('expired_at', null);
                $q->orWhere('expired_at', '>=', now()->toDateString());
            });
    }

    public function filterItem($request)
    {
        if ($request->tag != 0) {
            $tag = DirectoryTag::where('status', 1)->where('id', $request->tag)->firstorfail();

            $query = $tag->listings()->with('media', 'user');
        } else {
            $query = self::with('media', 'user');

            if ($request->keyword) {
                $keyword = $request->keyword;
                $query = $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'LIKE', "%$keyword%");
                    $q->orWhere('description', 'LIKE', "%$keyword%");
                });
            }
            if ($request->category != 0) {
                $query = $query->where('category_id', $request->category);
            }
        }

        return $query->frontVisible()
            ->select([
                'directory_listings.title',
                'directory_listings.id',
                'directory_listings.slug',
                'directory_listings.featured',
                'directory_listings.created_at',
                'directory_listings.description',
                'directory_listings.new',
                'directory_listings.property',
                'directory_listings.url',
                'directory_listings.status',
            ])
            ->orderBy('directory_listings.featured', 'DESC')
            ->orderBy('directory_listings.purchase_id')
            ->orderBy('directory_listings.created_at', 'DESC')
            ->paginate(10);
    }

    public function getDatatable($status, $user)
    {
        switch ($status) {
            case 'pending':
                $listings = $this::with('user', 'category')->where('status', 'pending');
                break;
            case 'all':
                $listings = $this::with('user', 'category');
                break;
            case 'approved':
                $listings = $this::with('user', 'category')->where('status', 'approved');
                break;
            case 'denied':
                $listings = $this::with('user', 'category')->where('status', 'denied');
                break;
            case 'expired':
                $listings = $this::with('user', 'category')->where('status', 'expired');
                break;
            case 'new':
                $listings = $this::with('user', 'category')->where('status', 'new');
                break;
        }
        if ($user != 'all') {
            $listings = $listings->where('user_id', $user);
        }

        return Datatables::of($listings)->addColumn('checkbox', function ($row) {
            return '<input type="checkbox" class="checkbox" data-id="'.$row->id.'">';
        })->addColumn('category', function ($row) {
            return $row->category->name;
        })->addColumn('user', function ($row) {
            $result = "<a href=''>".$row->user->name.'</a>';

            return $result;
        })->addColumn('purchased', function ($row) {
            if ($row->purchase_id) {
                return '<span class="c-badge c-badge-success">Package</span>';
            } else {
                return '<span class="c-badge c-badge-info">Free</span>';
            }
        })->editColumn('featured', function ($row) {
            if ($row->featured) {
                return '<span class="c-badge c-badge-success">Featured</span>';
            } else {
                return '';
            }
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success">Approved</span>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info" >Pending</span>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger" >Denied</span>';
            } elseif ($row->status == 'paid') {
                return '<span class="c-badge c-badge-info" >Newly Paid</span>';
            } elseif ($row->status == 'expired') {
                return '<span class="c-badge c-badge-warning" >Expired</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->editColumn('expired_at', function ($row) {
            if ($row->expired_at) {
                return $row->expired_at;
            } else {
                return 'Forever';
            }
        })->editColumn('property', function ($row) {
            $result = '<div class="text-right pr-5"><b>Thumbnail:</b> <img src="'.checkMark($row->isProperty('thumbnail')).'" alt="" class="width-20px">
                        <br>
                        <b>Social Share:</b> <img src="'.checkMark($row->isProperty('social')).'" alt="" class="width-20px">
                        <br>
                        <b>Tracking:</b> <img src="'.checkMark($row->isProperty('tracking')).'" alt="" class="width-20px">
                        <br>
                        <b>Image Gallery:</b> <img src="'.checkMark($row->isProperty('image')).'" alt="" class="width-20px">
                        <br>
                        <b>Video Links:</b> <img src="'.checkMark($row->isProperty('links')).'" alt="" class="width-20px">
                        <br>
                        <b>Video Upload:</b> <img src="'.checkMark($row->isProperty('videos')).'" alt="" class="width-20px">
                        <br></div>';

            return $result;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.directory.listing.show', $row->slug).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                       <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('admin.directory.listing.edit', $row->slug).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                       <i class="la la-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne" data-action="delete" title="Delete">
                            <i class="la la-remove"></i>
                    </a>';
        })->rawColumns(['checkbox', 'status', 'featured', 'purchased', 'property', 'user', 'property', 'action'])
            ->make(true);
    }

    public function getUserDatatable()
    {
        $listings = $this::with('user', 'category')->where('user_id', user()->id);

        return Datatables::of($listings)->addColumn('category', function ($row) {
            return $row->category->name;
        })->addColumn('purchased', function ($row) {
            if ($row->purchase_id) {
                return '<span class="c-badge c-badge-success">Package</span>';
            } else {
                return '<span class="c-badge c-badge-info">Free</span>';
            }
        })->editColumn('featured', function ($row) {
            if ($row->featured) {
                return '<span class="c-badge c-badge-success">Featured</span>';
            } else {
                return '';
            }
        })->editColumn('status', function ($row) {
            if ($row->status == 'approved') {
                return '<span class="c-badge c-badge-success">Approved</span>';
            } elseif ($row->status == 'pending') {
                return '<span class="c-badge c-badge-info" >Pending</span>';
            } elseif ($row->status == 'denied') {
                return '<span class="c-badge c-badge-danger" >Denied</span>';
            } elseif ($row->status == 'paid') {
                return '<span class="c-badge c-badge-info" >Newly Paid</span>';
            } elseif ($row->status == 'expired') {
                return '<span class="c-badge c-badge-warning" >Expired</span>';
            }
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->editColumn('expired_at', function ($row) {
            if ($row->expired_at) {
                return $row->expired_at;
            } else {
                return 'Forever';
            }
        })->editColumn('property', function ($row) {
            $result = '<div class="text-right pr-5"><b>Thumbnail:</b> <img src="'.checkMark($row->isProperty('thumbnail')).'" alt="" class="width-20px">
                        <br>
                        <b>Social Share:</b> <img src="'.checkMark($row->isProperty('social')).'" alt="" class="width-20px">
                        <br>
                        <b>Tracking:</b> <img src="'.checkMark($row->isProperty('tracking')).'" alt="" class="width-20px">
                        <br>
                        <b>Image Gallery:</b> <img src="'.checkMark($row->isProperty('image')).'" alt="" class="width-20px">
                        <br>
                        <b>Video Links:</b> <img src="'.checkMark($row->isProperty('links')).'" alt="" class="width-20px">
                        <br>
                        <b>Video Upload:</b> <img src="'.checkMark($row->isProperty('videos')).'" alt="" class="width-20px">
                        <br></div>';

            return $result;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('user.directory.show', $row->slug).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                       <i class="la la-eye"></i>
                    </a>
                    <a href="'.route('user.directory.edit', $row->slug).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Edit">
                       <i class="la la-edit"></i>
                    </a>';
        })->rawColumns(['status', 'featured', 'purchased', 'property',  'property', 'action'])
            ->make(true);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumbnail')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(40)
                    ->height(40)
                    ->sharpen(10)
                    ->nonQueued();
            });

        $this
            ->addMediaCollection('image')
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
