<?php

namespace App\Http\Controllers\Admin;

class StorageController extends AdminController
{
    public function index()
    {
        return view(self::$viewDir.'storage.index');
    }

    public function getFrame()
    {
        return view(self::$viewDir.'storage.getFrame');
    }

    public function loadSize()
    {
        $data['count'] = tenant()->getStorageCount();
        $current = tenant()->getStorageSize();
        $data['current'] = formatSizeUnits($current);
        if (tenant('storage_limit') == -1) {
            $data['total'] = 'Unlimited';
            $data['percent'] = '0.1';
        } else {
            $data['total'] = tenant('storage_limit').' GB';

            $limit_bytes = tenant('storage_limit') * 1024 * 1024 * 1024;

            $data['percent'] = formatNumber($current / $limit_bytes * 100);
        }

        return view('components.admin.fileTree', compact('data'))->render();
    }
}
