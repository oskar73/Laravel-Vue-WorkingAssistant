<?php

namespace App\Models;

class ProductSize extends BaseModel
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
        $rule['size_code'] = 'required';
        $rule['slug'] = 'required|unique:product_sizes';

        return $rule;
    }

    public function updateRule($sizeId)
    {
        $rule['size_id'] = 'required';
        $rule['name'] = 'required';
        $rule['size_code'] = 'required';
        $rule['slug'] = 'required|unique:product_sizes,slug,'.$sizeId;

        return $rule;
    }

    public function storeUpdateItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->size_code = $request->size_code;
        $item->slug = $request->slug;
        $item->save();

        return $item;
    }
}
