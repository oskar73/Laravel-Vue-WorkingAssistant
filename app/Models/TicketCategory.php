<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketCategory extends BaseModel
{
    use HasFactory;
    use Sluggable;

    protected $table = 'ticket_categories';

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

    public function storeRule($request)
    {
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'max:6000';
        $rule['category_id'] = 'nullable|integer';

        return $rule;
    }

    public function storeItem($request)
    {
        if ($request->category_id == null) {
            $category = $this;
        } else {
            $category = $this->findorfail($request->category_id);
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ? 1 : 0;
        $category->save();

        return $category;
    }

    public function items()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }
}
