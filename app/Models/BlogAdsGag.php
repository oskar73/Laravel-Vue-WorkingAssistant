<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BlogAdsGag extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'blog_ads_gags';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function spot()
    {
        return $this->belongsTo(BlogAdsSpot::class, 'spot_id')->withDefault();
    }
}
