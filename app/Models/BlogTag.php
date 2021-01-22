<?php

namespace App\Models;

use App\Models\Module\BlogCategory;
use App\Models\Module\BlogPost;
use Cviebrock\EloquentSluggable\Sluggable;

class BlogTag extends BaseModel
{
    use Sluggable;

    protected $table = 'blog_tags';

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
        $rule['categories.*'] = 'nullable|exists:blog_categories,id,web_id,'.tenant('id').',status,1';
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
        return $this->belongsToMany(BlogCategory::class, 'blog_category_tag', 'tag_id', 'category_id');
    }

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag', 'tag_id', 'post_id');
    }

    public function visiblePosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag', 'tag_id', 'post_id')
            ->frontVisible();
    }
}
