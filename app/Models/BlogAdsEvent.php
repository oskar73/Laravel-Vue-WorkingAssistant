<?php

namespace App\Models;

class BlogAdsEvent extends BaseModel
{
    protected $table = 'blog_ads_events';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $timestamps = false;

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function listing()
    {
        return $this->belongsTo(BlogAdsListing::class, 'listing_id')->withDefault();
    }
}
