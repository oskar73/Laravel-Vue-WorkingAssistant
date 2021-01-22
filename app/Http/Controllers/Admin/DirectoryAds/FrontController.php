<?php

namespace App\Http\Controllers\Admin\DirectoryAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BaseModel;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontController extends AdminController
{
    public $front;

    public function __construct()
    {
        $this->front = Page::firstOrCreate([
            'type' => 'module',
            'url' => 'directoryAds',
        ]);
    }

    public function index()
    {
        $front = optional($this->front->data);
        $name = $this->front->name;

        return view(self::$viewDir.'directoryAds.front', compact('front', 'name'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), $this->front->updateRule($request, 'directoryAds'));
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

        $path = config('custom.storage_name.directoryAds');

        if ($nav_image = $request->nav_image) {
            $navimage_name = 'directoryAds_nav.'.$nav_image->getClientOriginalExtension();

            $data['nav_image'] = BaseModel::fileUpload($nav_image, $navimage_name, $path);
        }
        if ($meta_image = $request->meta_image) {
            $metaimage_name = 'directoryAds_meta.'.$meta_image->getClientOriginalExtension();

            $data['meta_image'] = BaseModel::fileUpload($meta_image, $metaimage_name, $path);
        }

        $front->data = $data;
        $front->save();

        $website = tenant();
        $new = $website->module_url;
        $new['directoryAds'] = $request->url;
        $website->module_url = $new;
        $website->save();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
