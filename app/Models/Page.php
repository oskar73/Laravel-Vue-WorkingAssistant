<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations as Relations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends StaticBaseModel implements HasMedia
{
    use InteractsWithMedia;

//    protected $table = 'pages';

    protected $casts = [
        'data' => 'json',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sections(): Relations\HasMany
    {
        return $this->hasMany(PageSection::class, 'page_id');
    }

    public function pageStoreRule($id = null)
    {
        $rule['name'] = 'required|max:191';
        $rule['url'] = 'nullable|unique:pages,url,'.$id.',id,web_id,'.tenant('id');
        $rule['title'] = 'nullable|max:191';
        $rule['keywords'] = 'nullable|max:191';
        $rule['description'] = 'nullable|max:255';
        $rule['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';
        $rule['head_code'] = 'nullable|max:6000';
        $rule['bottom_code'] = 'nullable|max:6000';

        return $rule;
    }

    /*
    | Module name = blog|email|directory|directoryAds
     */
    public function updateRule($request, $moduleName): array
    {
        $rule = [];
        if ($request->nav_status) {
            $rule['name'] = 'required|max:191';
        } else {
            $rule['name'] = 'nullable|max:191';
        }

        if ($moduleName === 'blog') {
            $rule['template'] = 'required|in:template1,template2';
        }

        $rule['nav_title'] = 'nullable|max:191';
        $rule['nav_image'] = 'image|mimes:jpeg,png,jpg,gif|max:10240';
        $rule['meta_title'] = 'nullable|max:191';
        $rule['meta_keywords'] = 'nullable|max:255';
        $rule['meta_description'] = 'nullable|max:255';
        $rule['meta_image'] = 'image|mimes:jpeg,png,jpg,gif|max:10240';
        $rule['url'] = 'nullable|string|max:191';

        return $rule;
    }

    public function legalPageStoreRule($id = null)
    {
        $rule['name'] = 'required|max:191';
        $rule['url'] = 'nullable|unique:pages,url,'.$id.',id,web_id,'.tenant('id');
        $rule['head_code'] = 'nullable|max:6000';
        $rule['bottom_code'] = 'nullable|max:6000';
        $rule['content'] = 'nullable|max:60000';
        $rule['nav_title'] = 'nullable|max:191';
        $rule['nav_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';
        $rule['meta_title'] = 'nullable|max:191';
        $rule['meta_keywords'] = 'nullable|max:191';
        $rule['meta_description'] = 'nullable|max:255';
        $rule['meta_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';

        return $rule;
    }

    public function storeItem($request)
    {
        $page = $this;
        $page->parent_id = 0;
        $page->name = $request->name;
        $page->type = 'box';
        $page->url = $request->url;
        $page->status = 0;
        $page->css = $request->head_code;
        $page->script = $request->bottom_code;

        $data = $this->data;

        $data['nav_status'] = $request->nav_status ? 1 : 0;
        $data['nav_title'] = $request->nav_title;
        $data['meta_title'] = $request->meta_title;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['meta_description'] = $request->meta_description;

        $page->data = $data;
        $page->save();

        if ($request->image) {
            $page->addMedia($request->file('image'))
                ->usingFileName(guid().'.'.$request->image->getClientOriginalExtension())
                ->toMediaCollection('seo');
        }

        return $page;
    }

    public function updateItem($request)
    {
        $page = $this;
        $page->name = $request->name;
        $page->url = $request->url;
        $page->status = $request->status ? 1 : 0;
        $page->css = $request->head_code;
        $page->script = $request->bottom_code;

        $data['meta_title'] = $request->title;
        $data['meta_keywords'] = $request->keywords;
        $data['meta_description'] = $request->description;

        $page->data = $data;
        $page->save();

        if ($request->image) {
            $page->clearMediaCollection('seo')
                ->addMedia($request->file('image'))
                ->usingFileName(guid().'.'.$request->image->getClientOriginalExtension())
                ->toMediaCollection('seo');
        }

        return $page;
    }

    public function updateLegalItem($request)
    {
        $page = $this;
        $page->name = $request->name;
        $page->url = $request->url;
        $page->status = $request->status ? 1 : 0;
        $page->css = $request->head_code;
        $page->script = $request->bottom_code;
        $page->content = $request->content;

        $data = $this->data;

        $data['nav_status'] = $request->nav_status ? 1 : 0;
        $data['nav_title'] = $request->nav_title;
        $data['meta_title'] = $request->meta_title;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['meta_description'] = $request->meta_description;

        $path = config('custom.storage_name.page');

        if ($nav_image = $request->nav_image) {
            $navimage_name = "legal_page_nav_{$this->id}.".$nav_image->getClientOriginalExtension();

            $data['nav_image'] = BaseModel::fileUpload($nav_image, $navimage_name, $path);
        }

        $page->data = $data;
        $page->save();

        if ($request->meta_image) {
            $page->clearMediaCollection('seo')
                ->addMedia($request->file('meta_image'))
                ->usingFileName(guid().'.'.$request->meta_image->getClientOriginalExtension())
                ->toMediaCollection('seo');
        }

        return $page;
    }

    public function createLegalPages()
    {
        $web_id = tenant('id');
        $data = [
            [
                'name' => 'Payment Policy',
                'url' => 'payment-policy',
                'type' => 'legal',
                'web_id' => $web_id,
                'header' => 0,
                'footer' => 0,
            ],
            [
                'name' => 'Privacy Policy',
                'url' => 'privacy-policy',
                'type' => 'legal',
                'web_id' => $web_id,
                'header' => 0,
                'footer' => 0,
            ],
            [
                'name' => 'Terms and Conditions',
                'url' => 'terms-and-conditions',
                'type' => 'termsAndConditions',
                'web_id' => $web_id,
                'header' => 0,
                'footer' => 0,
            ],
            [
                'name' => 'Disclaimer',
                'url' => 'disclaimer',
                'type' => 'legal',
                'web_id' => $web_id,
                'header' => 0,
                'footer' => 0,
            ],
            [
                'name' => 'Cookie Content',
                'url' => 'cookie-content',
                'type' => 'legal',
                'web_id' => $web_id,
                'header' => 0,
                'footer' => 0,
            ],
        ];

        self::insert($data);

        option(['legal' => 1]);
    }

    public function website()
    {
        return $this->belongsTo(Website::class, 'web_id');
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id')->withDefault();
    }

    public function spots()
    {
        return $this->hasMany(SiteAdsSpot::class, 'page_id');
    }

    public function subPages()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function activeSubPages()
    {
        return $this->hasMany(Page::class, 'parent_id')
            ->with('activeSubPages')
            ->status(1)
            ->where('header', 1)
            ->orderBy('order');
    }

    public function dropDown($preview)
    {
        $menu = '';
        if ($this->activeSubPages->count()) {
            $menu .= "<ul class='sub-drop-down'>";
            foreach ($this->activeSubPages as $active) {
                $menu .= '<li class="sub-menu-item"><a class="sub-menu-link" href="'.$active->getUrl($preview).'">'.$active->name.'</a>'.$active->dropDown($preview).'</li>';
            }
            $menu .= '</ul>';
        }

        return $menu;
    }

    public function getUrl($preview = null)
    {
        if ($this->type == 'custom' && $this->url != null && $this->url != '#') {
            return '//'.$this->url;
        } elseif ($this->url == '#') {
            return $this->url;
        } elseif ($this->type == 'module') {
            return route($this->url.'.index');
        } else {
            return url('/').'/'.$this->url;
        }
    }

    public static function buildAdminHeader($headers, $parent_id = 0)
    {
        $result = null;
        foreach ($headers as $header) {
            if ($header->parent_id == $parent_id) {
                $edit = '<div class=\'menu_right\'>';
                if ($header->type == 'custom') {
                    $edit .= "<a href=\"javascript:;\" class=\"menu_edit \" data-menu='".$header->id."' title='Edit'><i class='la la-edit'></i></a><a href=\"javascript:;\" class=\"menu_delete \" data-id='".$header->id."' title='Delete'><i class='la la-remove'></i></a>";
                }
                $edit .= "<a href=\"javascript:;\" class=\"menu_switch\" data-menu='".$header->id."' title='Inactive'><i class='la la-arrow-right'></i></a></div>";

                $result .= "<li class=\"dd-item\" data-id=\"{$header->id}\">
                                    <div class=\"dd-handle\" >
                                        {$header->name}
                                    </div>
                                    ".$edit.'
                                '.self::buildAdminHeader($headers, $header->id).'</li>';
            }
        }

        return $result ? '<ol class="dd-list">'.$result.'</ol>' : null;
    }
}
