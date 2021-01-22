<?php

namespace App\Models;

use App\Traits\Formable;
use App\Traits\Meetable;
use App\Traits\PurchaseFollowUp;
use App\Traits\Ratable;
use App\Traits\RecurringPrice;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DirectoryPackage extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia, Ratable, RecurringPrice, PurchaseFollowUp, Meetable, Formable;
    use HasFactory;

    protected $table = 'directory_packages';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'property' => 'json',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function storeRule($request)
    {
        $rule['name'] = 'required|string|max:45';
        $rule['description'] = 'required|max:6000';
        $rule['order'] = 'required|in:1,0';

        $rule['images.*'] = 'nullable|image|mimes:jpg,png,jpeg,gif|max:10240';
        $rule['videos.*'] = 'nullable|mimes:mp4,mov,ogg,qt,flv,3gp,avi,wmv,mpeg,mpg|max:102400';
        if ($request->links) {
            $rule['links.*'] = 'required';
        }
        if ($request->unlimit == null) {
            $rule['listing_limit'] = 'required|integer|min:1';
        }

        return $rule;
    }

    public function storeItem($request)
    {
        return $this->saveItem($request)
            ->saveMedia($request);
    }

    public function saveItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->listing_limit = $request->unlimit ? -1 : $request->listing_limit;
        $item->description = $request->description;

        if ($request->links !== null) {
            $item->links = json_encode($request->links);
        } else {
            $item->links = null;
        }

        $item->featured = $request->featured ? 1 : 0;
        $item->status = $request->status ? 1 : 0;
        $item->new = $request->new ? 1 : 0;
        $item->order = $request->order;

        $property['thumbnail'] = $request->allow_thumbnail ? 1 : 0;
        $property['social'] = $request->allow_social ? 1 : 0;
        $property['featured'] = $request->allow_featured ? 1 : 0;
        $property['image'] = $request->allow_image ? 1 : 0;
        $property['links'] = $request->allow_links ? 1 : 0;
        $property['videos'] = $request->allow_videos ? 1 : 0;
        $property['tracking'] = $request->allow_tracking ? 1 : 0;

        $item->property = $property;

        $item->save();

        return $item;
    }

    public function saveMedia($request)
    {
        if ($request->thumbnail !== null) {
            $this->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('thumbnail');
        }
        foreach ($request->images ?? [] as $image) {
            $this->addMedia($image)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }
        foreach ($request->videos ?? [] as $video) {
            $this->addMedia($video)
                ->toMediaCollection('video');
        }

        return $this;
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

    public static function filterItem($request)
    {
        try {
            $items = DirectoryPackage::where('directory_packages.status', 1)
                ->select([
                    'directory_packages.id',
                    'directory_packages.name',
                    'directory_packages.slug',
                    'directory_packages.featured',
                    'directory_packages.new',
                    'directory_packages.description',
                    'directory_packages.listing_limit',
                ])
                ->with('media', 'standardPrice')
                ->orderBy('order')
                ->orderBy('featured', 'DESC')
                ->orderBy('new', 'DESC')
                ->orderBy('directory_packages.created_at', 'DESC')
                ->paginate(9);

            $view = view('components.front.directoryPackageItem', compact('items'))->render();

            $data['status'] = 1;
            $data['view'] = $view;

            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumbnail')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(40)
                    ->height(60)
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
