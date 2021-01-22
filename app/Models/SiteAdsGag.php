<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteAdsGag extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'site_ads_gags';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function spot()
    {
        return $this->belongsTo(SiteAdsSpot::class, 'spot_id')->withDefault();
    }
}
