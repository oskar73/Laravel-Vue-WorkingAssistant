<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use App\Jobs\SiteMapGenerateJob;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Validator;

class SeoController extends AdminController
{
    public function index()
    {
        $seo = optional(option('basic', null));

        return view(self::$viewDir . 'setting.seo', compact('seo'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'nullable|max:191',
            'keywords' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }

        $seo = option('basic', null);

        $seo['seo_title'] = $request->title;
        $seo['seo_keywords'] = $request->keywords;
        $seo['seo_description'] = $request->description;

        if ($file = $request->image) {
            $image_name = 'meta_image.' . $file->getClientOriginalExtension();

            $path = config('custom.storage_name.setting');

            $seo['seo_image'] = BaseModel::fileUpload($file, $image_name, $path);
        }
        option(['basic' => $seo]);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function generateSitemap()
    {
        $this->dispatch(new SiteMapGenerateJob(tenant()->id));

        return back()->with('success', "It\'s generating in the background now. It won\'t take more than 5 minute. Please come back in a few and confirm updated time.");
    }

    public function downloadSitemap()
    {
        $path = tenant('id') . '/sitemap.xml';
        if (\Storage::disk('s3-pub-bizinasite')->exists($path)) {
            $file = \Storage::disk('s3-pub-bizinasite')->get($path);

            $headers = [
                'Content-Type' => 'text/xml',
                'Content-Description' => 'Sitemap Download',
                'Content-Disposition' => 'attachment; filename=sitemap.xml',
                'filename' => 'sitemap.xml',
            ];

            return response($file, 200, $headers);
        } else {
            return back()->with('error', 'Sorry, sitemap file doesn\'t exist. Please generate it.');
        }
    }
}
