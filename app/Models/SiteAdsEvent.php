<?php

namespace App\Models;

class SiteAdsEvent extends BaseModel
{
    protected $table = 'site_ads_events';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $timestamps = false;

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function listing()
    {
        return $this->belongsTo(SiteAdsListing::class, 'listing_id')->withDefault();
    }
}
