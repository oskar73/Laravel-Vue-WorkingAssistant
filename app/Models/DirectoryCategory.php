<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DirectoryCategory extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia;
    use HasFactory;

    protected $table = 'directory_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [
        'parent_id.integer' => 'Choose valid parent category.',
        'parent_id.different' => 'You can\'t choose itself as a parent category. Please choose different one as a parent category, or set it as a parent category.',
    ];

    public function storeRule($request)
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:1200';
        $rule['tags.*'] = 'nullable|exists:directory_tags,id,web_id,'.tenant('id').',status,1';
        if ($request->category_id) {
            $rule['category_id'] = 'integer|exists:directory_categories,id,web_id,'.tenant('id');
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|different:category_id|exists:directory_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        } else {
            $rule['thumbnail'] = 'required';
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|exists:directory_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        }

        return $rule;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', 'web_id'], // unique slug for each website by combination of web_id #code
            ],
        ];
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->web_id = tenant('id');
        $item->name = $request->name;
        $item->description = $request->description;
        $item->status = $request->status ? 1 : 0;
        $item->parent_id = $request->parent_id ?? 0;
        $item->save();

        if ($request->thumbnail) {
            $item->clearMediaCollection('image')
                ->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }

        return $item;
    }

    public function subcategories()
    {
        return $this->hasMany(DirectoryCategory::class, 'parent_id');
    }

    public function approvedSubCategories()
    {
        return $this->hasMany(DirectoryCategory::class, 'parent_id')
            ->withCount('approvedItems')
            ->where('status', 1)
            ->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(DirectoryCategory::class, 'parent_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany(DirectoryListing::class, 'category_id');
    }

    public function approvedItems()
    {
        return $this->hasMany(DirectoryListing::class, 'category_id')->where('status', 'approved')->where(function ($query) {
            $query->where('expired_at', null);
            $query->orWhere('expired_at', '>=', now()->toDateSTring());
        });
    }

    public function tags()
    {
        return $this->belongsToMany(DirectoryTag::class, 'directory_category_tag', 'category_id', 'tag_id');
    }

    public function approvedTags()
    {
        return $this->belongsToMany(DirectoryTag::class, 'directory_category_tag', 'category_id', 'tag_id')->where('status', 1);
    }

    public function scopeIsParent($query)
    {
        return $query->where('parent_id', 0);
    }

    public function isParent()
    {
        if ($this->parent_id === 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(60)
            ->height(40)
            ->sharpen(10)
            ->nonQueued();
    }
}
