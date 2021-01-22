<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Storage;

class EmailTemplate extends BaseModel implements HasMedia
{
    use HasFactory;
    use Sluggable, InteractsWithMedia;

    protected $table = 'email_templates';

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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($obj) {
//            dirDel(storage_path("app/public/uploads/" . $obj->id));
        });
    }

    public function category()
    {
        return $this->belongsTo(EmailCategory::class, 'category_id')->withDefault();
    }

    public function storeRule()
    {
        $rule['category'] = 'required|exists:email_categories,id,web_id,'.tenant('id').',status,1';
        $rule['name'] = 'required|max:45';
        $rule['description'] = 'required|max:600';

        return $rule;
    }

    public function storeItem($request)
    {
        $item = $this;
        $item->category_id = $request->category;
        $item->name = $request->name;
        $item->description = $request->description;
        if ($request->template_id) {
            $item->status = $request->status ? 1 : 0;
        } else {
            $item->status = 0;
        }
        $item->save();

        if ($request->thumbnail) {
            $this->clearMediaCollection('thumbnail')
                ->addMedia($request->thumbnail)
                ->usingFileName(guid().'.jpg')
                ->toMediaCollection('thumbnail');
        }

        return $item;
    }

    public function storeOnlineItem($request, $onlineTemplate)
    {
        $item = $this;
        $item->category_id = $request->category;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->status = $request->status ? 1 : 0;
        $item->body = $onlineTemplate->body;
        $item->save();

        $this->addMediaFromUrl('https://www.channelnews.com.au/wp-content/uploads/2018/02/google-amp-fast-speed-travel-ss-1920.jpg')
            ->usingFileName(guid().'.jpg')
            ->toMediaCollection('thumbnail');

        return $item;
    }

    public function updateBody($request)
    {
        $item = $this;
        if ($this->body == null) {
            $body = $request->body;
            if ($body != null && $request->fileNames != null) {
                foreach (json_decode($request->fileNames) as $name => $fileName) {
                    $route = Storage::url(config('custom.storage_name.tinymce').'/'.$this->id.'/'.$fileName);

                    $cases = [
                        "src=\"images/{$name}\"",
                        "src='images/{$name}'",
                        "src=\"./images/{$name}\"",
                        "src='./images/{$name}'",
                        "url(\"images/{$name}\")",
                        "url('images/{$name}')",
                        "url(\"./images/{$name}\")",
                        "url('./images/{$name}')",
                    ];
                    $output = [
                        "src=\"{$route}\"",
                        "src='{$route}'",
                        "src=\"{$route}\"",
                        "src='{$route}'",
                        "url(\"{$route}\")",
                        "url('{$route}')",
                        "url(\"{$route}\")",
                        "url('{$route}')",
                    ];

                    foreach ($cases as $key => $case) {
                        $body = str_replace($case, $output[$key], $body);
                    }
//                    $body =  str_replace("src=\"images/{$name}\"", "src='{$route}'", $body);
//                    $body =  str_replace("src=\"./images/{$name}\"", "src='{$route}'", $body);
//                    $body =  str_replace("url('images/{$name}')", "src='{$route}'", $body);
//                    $body =  str_replace("url('./images/{$name}')", "src='{$route}'", $body);
                }
            }
//            $body = remove_between('<!--', '-->',$body);
        } else {
            $body = $request->tem_body;

            $body = str_replace('<p>&nbsp;</p>', '', $body);
            $body = str_replace('<p></p>', '', $body);

//            $body = remove_between('<!--', '-->',$body);
        }
        $item->body = $body;
        $item->save();

        return $item;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(40)
            ->height(60)
            ->sharpen(10)
            ->nonQueued();
    }
}
