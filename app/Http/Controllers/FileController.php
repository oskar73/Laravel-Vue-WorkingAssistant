<?php

namespace App\Http\Controllers;

use Storage;

class FileController extends Controller
{
    public function get($disk, $path)
    {
        $headers = [
            'Content-Type: application/image',
        ];
        if (Storage::disk($disk)->exists($path)) {
            $file = Storage::disk($disk)->path($path);
//            return (new \Illuminate\Http\Response($file))->header('Content-Type', 'application/image');
            return response()->file($file, $headers);
        }
        abort(404);
    }

    public function sitemap()
    {
        if (Storage::disk('s3-pub-bizinasite')->exists('sitemap.xml')) {
            $xml = Storage::disk('s3-pub-bizinasite')->get('sitemap.xml');

            return response($xml, 200)->header('Content-Type', 'application/xml');
        }
        abort(404);
    }
}
