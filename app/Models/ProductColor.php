<?php

namespace App\Models;

class ProductColor extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // public function categories()
    // {
    //     return $this->belongsToMany(AppointmentCategory::class, "product_meeting_category", "meeting_id", "category_id");
    // }

    public function storeRule()
    {
        $rule['name'] = 'required';
        $rule['color_code'] = 'required';
        $rule['slug'] = 'required|unique:product_colors';

        return $rule;
    }

    public function updateRule($colorId)
    {
        $rule['color_id'] = 'required';
        $rule['name'] = 'required';
        $rule['color_code'] = 'required';
        $rule['slug'] = 'required|unique:product_colors,slug,'.$colorId;

        return $rule;
    }

    public function storeUpdateItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->color_code = $request->color_code;
        $item->slug = $request->slug;
        $item->save();

        return $item;
    }
}
