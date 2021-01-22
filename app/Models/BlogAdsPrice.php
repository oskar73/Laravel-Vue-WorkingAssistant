<?php

namespace App\Models;

class BlogAdsPrice extends BaseModel
{
    protected $table = 'blog_ads_prices';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getPeriodNameAttribute()
    {
        return numToDay($this->period);
    }

    public function getUnit()
    {
        if ($this->type == 'period') {
            return $this->period_name;
        } else {
            return $this->impression.' imps';
        }
    }
}
