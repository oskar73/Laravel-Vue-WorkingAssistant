<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function jsonSuccess($data = [])
    {
        return response()->json([
            'status' => 1,
            'data' => $data,
        ]);
    }

    public function jsonError($data = [])
    {
        return response()->json([
            'status' => 0,
            'data' => $data,
        ]);
    }

    public function jsonExceptionError($e)
    {
        return response()->json([
            'status' => 0,
            'data' => [json_encode($e->getMessage())],
        ]);
    }

    public function jsonUnauthorized($data = [])
    {
        return response()->json([
            'status' => 0,
            'data'  =>  $data
        ], 401);
    }
}
