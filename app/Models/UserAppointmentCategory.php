<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class UserAppointmentCategory extends BaseModel
{
    use Sluggable;

    protected $table = 'user_appointment_categories';

    protected $guarded = ['id', 'created_at', 'updated_at', 'web_id'];

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

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
            AvailableWeekday::where('type', \App\Models\UserAppointmentCategory::class)
                ->where('product_id', $obj->id)
                ->get()
                ->each
                ->delete();
        });
    }

    public function storeRule($request)
    {
        if ($request->category_id) {
            $rule['category_id'] = 'required|exists:user_appointment_categories,id';
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
        $item->user_id = user()->id;
        $item->save();

        return $item;
    }
}
