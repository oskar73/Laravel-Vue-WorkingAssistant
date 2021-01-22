<?php

namespace App\Models;

class ProductMeeting extends BaseModel
{
    protected $table = 'product_meetings';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function categories()
    {
        return $this->belongsToMany(AppointmentCategory::class, 'product_meeting_category', 'meeting_id', 'category_id');
    }
}
