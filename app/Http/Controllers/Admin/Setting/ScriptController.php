<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class ScriptController extends AdminController
{
    public function index()
    {
        $script = optional(option('basic', null));

        return view(self::$viewDir.'setting.script', compact('script'));
    }

    public function store(Request $request)
    {
        $script = option('basic', null);

        $script['front_head'] = $request->frontside_head_code;
        $script['front_bottom'] = $request->frontside_bottom_code;
        $script['back_head'] = $request->backside_head_code;
        $script['back_bottom'] = $request->backside_bottom_code;

        option(['basic' => $script]);

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
