<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailCategory extends BaseModel
{
    use HasFactory;
    use Sluggable;

    protected $table = 'email_categories';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function storeRule()
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:6000';

        return $rule;
    }

    public function storeItem($request)
    {
        $category = $this;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ? 1 : 0;
        $category->save();

        return $category;
    }

    public function templates()
    {
        return $this->hasMany(EmailTemplate::class, 'category_id');
    }

    public function approvedTemplates()
    {
        return $this->hasMany(EmailTemplate::class, 'category_id')->where('status', 1);
    }
//    public function subscribers()
//    {
//        return $this->belongsToMany(Subscriber::class, 'unsubscribe_category', 'category_id', 'subscriber_id')
//            ->where("status", 1);
//    }
}
