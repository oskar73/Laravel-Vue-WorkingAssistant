<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirectoryTag extends BaseModel
{
    use HasFactory;
    use Sluggable;

    protected $table = 'directory_tags';

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

    public function storeRule($request)
    {
        $rule['name'] = 'required|max:45';
        $rule['categories.*'] = 'nullable|exists:directory_categories,id,web_id,'.tenant('id').',status,1';
        if ($request->tag_id) {
            $rule['tag_id'] = 'integer';
        }

        return $rule;
    }

    public function storeItem($request)
    {
        if ($request->tag_id == null) {
            $tag = $this;
        } else {
            $tag = $this->findorfail($request->tag_id);
        }
        $tag->name = $request->name;
        $tag->status = $request->status ? 1 : 0;
        $tag->save();

        $tag->categories()->sync($request->categories);

        return $tag;
    }

    public function categories()
    {
        return $this->belongsToMany(DirectoryCategory::class, 'directory_category_tag', 'tag_id', 'category_id');
    }

    public function listings()
    {
        return $this->belongsToMany(DirectoryListing::class, 'directory_listing_tag', 'tag_id', 'listing_id');
    }

    public function visiblePosts()
    {
        return $this->belongsToMany(DirectoryListing::class, 'directory_listing_tag', 'tag_id', 'listing_id')
            ->frontVisible();
    }
}
