<?php

namespace App\Models;

class ProductSubCategory extends BaseModel
{
    protected $connection = 'mysql2';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // public function categories()
    // {
    //     return $this->belongsToMany(AppointmentCategory::class, "product_meeting_category", "meeting_id", "category_id");
    // }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function storeRule()
    {
        $rule['product_category_id'] = 'required';
        $rule['name'] = 'required|unique:product_sub_categories';

        return $rule;
    }

    public function updateRule($subCategoryId)
    {
        $rule['sub_category_id'] = 'required';
        $rule['product_category_id'] = 'required';
        $rule['name'] = 'required|unique:product_sub_categories,name,'.$subCategoryId;

        return $rule;
    }

    public function storeUpdateItem($request)
    {
        $item = $this;
        $item->product_category_id = $request->product_category_id;
        $item->name = $request->name;
        $item->status = $request->has('status') ? 1 : 0;
        $item->save();

        return $item;
    }
}
