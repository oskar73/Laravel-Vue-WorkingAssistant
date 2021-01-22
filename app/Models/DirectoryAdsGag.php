<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DirectoryAdsGag extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'directory_ads_gags';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function spot()
    {
        return $this->belongsTo(DirectoryAdsSpot::class, 'spot_id')->withDefault();
    }
}
