<?php

namespace App\Traits;

use App\Models\Review;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Ratable
{
    public function reviews(): MorphMany
    {
        return $this->morphMany(
            Review::class,
            'reviews',
            'model_type',
            'model_id'
        );
    }

    public function approvedReviews(): MorphMany
    {
        return $this->morphMany(
            Review::class,
            'reviews',
            'model_type',
            'model_id'
        )->where('status', 1);
    }

    public function avgRating()
    {
        return $this->approvedReviews()->avg('rating');
    }

    public function sliders(): MorphMany
    {
        return $this->morphMany(
            Slider::class,
            'sliders',
            'model_type',
            'model_id'
        );
    }
}
