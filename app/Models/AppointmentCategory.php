<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentCategory extends BaseModel
{
    use HasFactory;
    use Sluggable;

    protected $table = 'appointment_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
            AvailableWeekday::where('type', \App\Models\AppointmentCategory::class)
                ->where('product_id', $obj->id)
                ->get()
                ->each
                ->delete();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function storeRule($request)
    {
        if ($request->category_id) {
            $rule['category_id'] = 'required|exists:appointment_categories,id';
        }
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'nullable|max:600';

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->status = $request->status ? 1 : 0;
        $item->save();

        return $item;
    }
}
