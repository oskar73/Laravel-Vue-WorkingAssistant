<?php

namespace App\Models\Module;

use App\Models\BaseModel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EcommerceCategory extends BaseModel implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;

    protected $table = 'ecommerce_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['web_id', 'name'],
                'unique' => false
            ],
        ];
    }

    const CUSTOM_VALIDATION_MESSAGE = [
        'parent_id.integer' => 'Choose valid parent category.',
        'parent_id.different' => 'You can\'t choose itself as a parent category. Please choose different one as a parent category, or set it as a parent category.',
    ];

    public function storeRule($request)
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:1200';
        if ($request->category_id) {
            $rule['category_id'] = 'integer|exists:ecommerce_categories,id,web_id,'.tenant('id');
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|different:category_id|exists:ecommerce_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        } else {
            $rule['thumbnail'] = 'required';
            if ($request->parent_id != 0) {
                $rule['parent_id'] = 'required|exists:ecommerce_categories,id,web_id,'.tenant('id').',parent_id,0';
            }
        }

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
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
        return $this->hasMany(EcommerceCategory::class, 'parent_id');
    }

    public function approvedSubCategories()
    {
        return $this->hasMany(EcommerceCategory::class, 'parent_id')
            ->withCount('approvedItems')
            ->where('status', 1)
            ->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(EcommerceCategory::class, 'parent_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany(EcommerceProduct::class, 'category_id');
    }

    public function approvedItems()
    {
        return $this->hasMany(EcommerceProduct::class, 'category_id')->frontVisible();
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
