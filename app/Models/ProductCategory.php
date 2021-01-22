<?php

namespace App\Models;

class ProductCategory extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // public function categories()
    // {
    //     return $this->belongsToMany(AppointmentCategory::class, "product_meeting_category", "meeting_id", "category_id");
    // }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function subCategories()
    {
        return $this->hasMany(ProductSubCategory::class);
    }

    public function storeRule()
    {
        $rule['name'] = 'required|unique:product_categories';

        return $rule;
    }

    public function updateRule($categoryId)
    {
        $rule['category_id'] = 'required';
        $rule['name'] = 'required|unique:product_categories,name,'.$categoryId;

        return $rule;
    }

    public function storeUpdateItem($request)
    {
        $item = $this;
        $item->name = $request->name;
        $item->status = $request->has('status') ? 1 : 0;
        $item->save();

        return $item;
    }
}
