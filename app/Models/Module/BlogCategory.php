<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use App\Models\BlogTag;
use Cviebrock\EloquentSluggable\Sluggable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogCategory extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia, Subscribable;

    protected $table = 'blog_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

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
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:6000';
        $rule['tags.*'] = 'nullable|exists:blog_tags,id,web_id,'.tenant('id').',status,1';
        if ($request->category_id) {
            $rule['category_id'] = 'integer';
        } else {
            $rule['thumbnail'] = 'required';
        }

        return $rule;
    }

    public function storeItem($request)
    {
        if ($request->category_id == null) {
            $category = $this;
        } else {
            $category = $this->findorfail($request->category_id);
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ? 1 : 0;
        $category->save();

        if ($request->thumbnail) {
            $category->clearMediaCollection('image');
            $category->addMediaFromBase64($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('image');
        }
        $category->tags()->sync($request->tags);

        return $category;
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_category_tag', 'category_id', 'tag_id');
    }

    public function approvedTags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_category_tag', 'category_id', 'tag_id')->where('status', 1);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function visiblePosts()
    {
        return $this->hasMany(BlogPost::class, 'category_id')
            ->frontVisible();
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
