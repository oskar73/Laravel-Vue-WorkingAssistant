<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Validator;

class SettingController extends AdminController
{
    public function index()
    {
        $setting = optional(option('blog', null));

        return view(self::$viewDir.'blog.setting', compact('setting'));
    }

    public function rule($request)
    {
        $rule['guest_blog'] = 'required|in:free,paid,not,both';
        if ($request->guest_blog == 'both' || $request->guest_blog == 'free') {
            $rule['post_number'] = 'required|numeric|min:1';
            $rule['period'] = 'required|numeric|min:1';
            $rule['period_unit'] = 'required|in:day,week,month,year';
        }
        $rule['post_approve'] = 'required|in:1,0';
        $rule['comment_approve'] = 'required|in:1,0';

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
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $setting['permission'] = $request->guest_blog;

            if ($request->guest_blog == 'both' || $request->guest_blog == 'free') {
                $setting['post_number'] = $request->post_number;
                $setting['period'] = $request->period;
                $setting['period_unit'] = $request->period_unit;
            } else {
                $setting['post_number'] = 0;
                $setting['period'] = null;
                $setting['period_unit'] = null;
            }
            $setting['post_approve'] = $request->post_approve;
            $setting['comment_approve'] = $request->comment_approve;

            option(['blog' => $setting]);

            return response()->json([
                'status' => 1,
                'data' => $setting,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
