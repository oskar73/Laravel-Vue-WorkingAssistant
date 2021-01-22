<?php

namespace App\Http\Controllers\Api;

class PortfolioApi
{
    public function getPortfolioItems()
    {
        return response()->json([
            'success' => true,
            'items' => tenant()->getPortfolioItems(),
        ]);
    }
}