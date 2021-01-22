<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class FooterController extends AdminController
{
    public function index()
    {
        $footer = tenant()->footer;

        return view(self::$viewDir.'content.footer', compact('footer'));
    }

    public function store(Request $request)
    {
        $footer = tenant()->footer;
        $footer->content = $request->sHTML;
        $footer->mainCss = $request->sMainCss;
        $footer->sectionCss = $request->sSectionCss;
        $footer->save();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }
}
