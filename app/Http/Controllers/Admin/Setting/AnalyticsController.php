<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Validator;

class AnalyticsController extends AdminController
{
    public function index()
    {
        $google_services = optional(option('google_services', []));

        return view(self::$viewDir.'setting.analytics', compact('google_services'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'view_id' => 'required|max:191',
            'config_file' => 'nullable|mimes:json|max:10',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }

        $google_services = option('google_services', []);

        $google_services['ga_view_id'] = $request->view_id;

        if ($request->config_file) {
            $google_services['ga_file'] = file_get_contents($request->config_file->getRealPath());
        }
        option(['google_services' => $google_services]);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
