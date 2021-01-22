<?php

namespace App\Http\Controllers\Api;

class DirectoryApi
{

    public function getDirectoryCategories()
    {
        return response()->json([
            'success' => true,
            'categories' => tenant()->getDirectoryCategories(),
        ]);
    }

    public function getDirectoryListings()
    {
        return response()->json([
            'success' => true,
            'listings' => tenant()->getDirectoryListings(),
        ]);
    }
}
