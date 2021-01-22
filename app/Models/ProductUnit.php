<?php

namespace App\Models;

class ProductUnit extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // public function categories()
    // {
    //     return $this->belongsToMany(AppointmentCategory::class, "product_meeting_category", "meeting_id", "category_id");
    // }

    public function storeRule()
    {
        $rule['name'] = 'required|unique:product_units';

        return $rule;
    }

    public function updateRule($unitId)
    {
        $rule['unit_id'] = 'required';
        $rule['name'] = 'required|unique:product_units,name,'.$unitId;

        return $rule;
    }

    public function storeUpdateItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->save();

        return $item;
    }
}
