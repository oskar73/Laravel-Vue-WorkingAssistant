<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Enums\ModuleEnum;
use App\Http\Controllers\Admin\AdminController;
use App\Models\BaseModel;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontController extends AdminController
{
    public function index()
    {
        $ecommercePage = tenant()->getEcommercePage();
        return view('admin.ecommerce.front', [
            'page' => $ecommercePage,
            'front' => $ecommercePage->data
        ]);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'url' => 'required|max:191',
            'nav_title' => 'nullable|max:191',
            'nav_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'meta_title' => 'nullable|max:191',
            'meta_keywords' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }


        $name = $request->name;
        $url = '/' . $request->url;

        $ecommercePage = tenant()->getEcommercePage();
        $data = $ecommercePage->data ?? [];
        $data['nav_status'] = $request->nav_status ? 1 : 0;
        $data['nav_title'] = $request->nav_title;
        $data['meta_title'] = $request->meta_title;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['meta_description'] = $request->meta_description;

        $path = config('custom.storage_name.ecommerce');

        if ($nav_image = $request->nav_image) {
            $navimage_name = 'ecommerce_nav.' . $nav_image->getClientOriginalExtension();

            $data['nav_image'] = BaseModel::fileUpload($nav_image, $navimage_name, $path);
        }
        if ($meta_image = $request->meta_image) {
            $metaimage_name = 'ecommerce_meta.' . $meta_image->getClientOriginalExtension();

            $data['meta_image'] = BaseModel::fileUpload($meta_image, $metaimage_name, $path);
        }

        Page::where('type', 'module')->where('module_name', ModuleEnum::ECOMMERCE)->update([
            'name' => $name,
            'url' => $url,
            'data' => $data,
        ]);

        $website = tenant();
        $new = $website->module_url;
        $new['ecommerce'] = '/' . $request->url;
        $website->module_url = $new;
        $website->save();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
