<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BaseModel;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontController extends AdminController
{
    public $front;

    public function __construct()
    {
        if (!empty(tenant())) {
            $this->front = Page::firstOrCreate([
                'web_id' => tenant()->id,
                'name' => 'Blog',
                'type' => 'module',
                'url' => 'blog',
            ]);
        }
    }

    public function index()
    {
        $front = optional($this->front->data);
        $name = $this->front->name;
        $template = optional(option('blog'))['template'] ?: 'template1';

        return view(self::$viewDir . 'blog.front', compact('front', 'name', 'template'));
    }

    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), $this->front->updateRule($request, 'blog'));
        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        $front = $this->front;
        $front->name = $request->name;

        $data = $front->data;
        $data['nav_status'] = $request->nav_status ? 1 : 0;
        $data['nav_title'] = $request->nav_title;
        $data['meta_title'] = $request->meta_title;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['meta_description'] = $request->meta_description;

        $path = config('custom.storage_name.blog');

        if ($nav_image = $request->nav_image) {
            $navimage_name = 'blog_nav.' . $nav_image->getClientOriginalExtension();

            $data['nav_image'] = BaseModel::fileUpload($nav_image, $navimage_name, $path);
        }
        if ($meta_image = $request->meta_image) {
            $metaimage_name = 'blog_meta.' . $meta_image->getClientOriginalExtension();

            $data['meta_image'] = BaseModel::fileUpload($meta_image, $metaimage_name, $path);
        }

        $front->data = $data;
        $front->save();

        $website = tenant();
        $new = $website->module_url;
        $new['blog'] = $request->url;
        $new['blogDetail'] = $request->detailUrl;
        $website->module_url = $new;
        $website->save();

        $blogOption = option('blog', []);
        $blogOption['template'] = $request->template;

        option(['blog' => $blogOption]);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
