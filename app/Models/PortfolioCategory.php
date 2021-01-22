<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioCategory extends BaseModel implements HasMedia
{
    use Sluggable, InteractsWithMedia;

    protected $table = 'portfolio_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [
        'parent_id.integer' => 'Choose valid parent category.',
        'parent_id.different' => 'You can\'t choose itself as a parent category. Please choose different one as a parent category, or set it as a parent category.',
    ];

    public function storeRule($request)
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:1200';
        if ($request->category_id) {
            $rule['category_id'] = 'integer|exists:portfolio_categories,id,web_id,'.tenant('id');
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|different:category_id|exists:portfolio_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        } else {
            $rule['thumbnail'] = 'required';
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|exists:portfolio_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        }

        return $rule;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', 'parent_id', 'web_id'],
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
        return $this->hasMany(PortfolioCategory::class, 'parent_id');
    }

    public function approvedSubCategories()
    {
        return $this->hasMany(PortfolioCategory::class, 'parent_id')
            ->withCount('approvedItems')
            ->where('status', 1)
            ->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'parent_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany(Portfolio::class, 'category_id');
    }

    public function approvedItems()
    {
        return $this->hasMany(Portfolio::class, 'category_id')->status(1);
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
