<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Validator;

class SocialController extends AdminController
{
    public function index()
    {
        $social = option('social', null);

        return view(self::$viewDir.'setting.social', compact('social'));
    }

    public function rule($request)
    {
        $rule = [];
        if ($request->facebook) {
            $rule['facebook_client_id'] = 'required|max:191';
            $rule['facebook_client_secret'] = 'required|max:191';
        }
        if ($request->linkedin) {
            $rule['linkedin_client_id'] = 'required|max:191';
            $rule['linkedin_client_secret'] = 'required|max:191';
        }
        if ($request->twitter) {
            $rule['twitter_client_id'] = 'required|max:191';
            $rule['twitter_client_secret'] = 'required|max:191';
        }
        if ($request->google) {
            $rule['google_client_id'] = 'required|max:191';
            $rule['google_client_secret'] = 'required|max:191';
        }
        if ($request->instagram) {
            $rule['instagram_client_id'] = 'required|max:191';
            $rule['instagram_client_secret'] = 'required|max:191';
        }

        if ($request->github) {
            $rule['github_client_id'] = 'required|max:191';
            $rule['github_client_secret'] = 'required|max:191';
        }

        return $rule;
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), $this->rule($request));
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'data' => $validation->errors()]);
        }

        $social['facebook'] = $request->facebook ? 1 : 0;
        $social['facebook_client_id'] = $request->facebook_client_id;
        $social['facebook_client_secret'] = $request->facebook_client_secret;

        $social['github'] = $request->github ? 1 : 0;
        $social['github_client_id'] = $request->github_client_id;
        $social['github_client_secret'] = $request->github_client_secret;

        $social['instagram'] = $request->instagram ? 1 : 0;
        $social['instagram_client_id'] = $request->instagram_client_id;
        $social['instagram_client_secret'] = $request->instagram_client_secret;

        $social['twitter'] = $request->twitter ? 1 : 0;
        $social['twitter_client_id'] = $request->twitter_client_id;
        $social['twitter_client_secret'] = $request->twitter_client_secret;

        $social['linkedin'] = $request->linkedin ? 1 : 0;
        $social['linkedin_client_id'] = $request->linkedin_client_id;
        $social['linkedin_client_secret'] = $request->linkedin_client_secret;

        $social['google'] = $request->google ? 1 : 0;
        $social['google_client_id'] = $request->google_client_id;
        $social['google_client_secret'] = $request->google_client_secret;

        option(['social' => $social]);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
