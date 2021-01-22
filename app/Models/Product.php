<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id')->withoutGlobalScopes();
    }

    public function unit()
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id')->withoutGlobalScopes();
    }

    public function additionalPrices()
    {
        return $this->hasMany(ProductAdditionalPrice::class)->withoutGlobalScopes();
    }

    public function images()
    {
        return $this->getMedia('image');
    }
}
