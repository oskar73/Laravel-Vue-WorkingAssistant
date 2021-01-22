<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;

class PageApi
{
    public function getPage(Page $page) {
        $page->load('sections');

        return response()->json([
            'success' => true,
            'page' => $page,
        ]);
    }
}
