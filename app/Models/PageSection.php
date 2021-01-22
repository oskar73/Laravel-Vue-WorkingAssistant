<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(SectionCategory::class, 'category_id');
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
