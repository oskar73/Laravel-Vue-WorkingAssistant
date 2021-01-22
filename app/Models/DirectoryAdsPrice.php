<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirectoryAdsPrice extends BaseModel
{
    use HasFactory;

    protected $table = 'directory_ads_prices';

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
