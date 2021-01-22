<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableHour extends BaseModel
{
    use HasFactory;

    protected $table = 'available_hours';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function weekday()
    {
        return $this->belongsTo(AvailableWeekday::class, 'weekday_id')->withDefault();
    }
}
