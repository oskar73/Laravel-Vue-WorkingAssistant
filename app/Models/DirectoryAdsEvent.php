<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirectoryAdsEvent extends BaseModel
{
    use HasFactory;

    protected $table = 'directory_ads_events';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $timestamps = false;

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function listing()
    {
        return $this->belongsTo(DirectoryAdsListing::class, 'listing_id')->withDefault();
    }
}
