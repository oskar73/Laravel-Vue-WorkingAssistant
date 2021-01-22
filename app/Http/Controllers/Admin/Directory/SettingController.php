<?php

namespace App\Http\Controllers\Admin\Directory;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Validator;

class SettingController extends AdminController
{
    public function index()
    {
        $setting = optional(option('directory', null));

        return view(self::$viewDir.'directory.setting', compact('setting'));
    }

    public function rule($request)
    {
        $rule['allow_type'] = 'required|in:free,paid,not,both';
        if ($request->allow_type == 'both' || $request->allow_type == 'free') {
            if ($request->unlimit == null) {
                $rule['listing_number'] = 'required|numeric|min:1';
            }
        }
        $rule['listing_approve'] = 'required|in:1,0';

        return $rule;
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->rule($request)
            );
            if ($validation->fails()) {
                return $this->jsonError($validation->errors());
            }

            $setting['permission'] = $request->allow_type;

            if ($request->allow_type == 'both' || $request->allow_type == 'free') {
                $setting['listing_number'] = $request->unlimit ? -1 : $request->listing_number;

                $setting['thumbnail'] = $request->allow_thumbnail ? 1 : 0;
                $setting['social'] = $request->allow_social ? 1 : 0;
                $setting['featured'] = $request->allow_featured ? 1 : 0;
                $setting['image'] = $request->allow_image ? 1 : 0;
                $setting['links'] = $request->allow_links ? 1 : 0;
                $setting['videos'] = $request->allow_videos ? 1 : 0;
                $setting['tracking'] = $request->allow_tracking ? 1 : 0;
            } else {
                $setting['listing_number'] = 0;

                $setting['thumbnail'] = 0;
                $setting['social'] = 0;
                $setting['featured'] = 0;
                $setting['image'] = 0;
                $setting['links'] = 0;
                $setting['videos'] = 0;
                $setting['tracking'] = 0;
            }
            $setting['listing_approve'] = $request->listing_approve;

            option(['directory' => $setting]);

            return response()->json([
                'status' => 1,
                'data' => $setting,
            ]);
        } catch (\Exception $e) {
            return $this->jsonExceptionError($e);
        }
    }
}
