<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */
    //    'dir' => ['/uploads/'],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [
        's3-pub-bizinasite',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix' => 'admin/storage/getData',
        'middleware' => ['web', 'auth', 'role:admin'], //Set to null to disable middleware filter
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => null,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => [],

    /*
    |--------------------------------------------------------------------------
    | Root Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with every root by default.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1#root-options
    |
    */
    'root_options' => [
        'defaults' => ['read' => true, 'write' => true, 'locked' => true],
        'uploadMaxSize' => '100M',
        'uploadAllow' => [
            'image/png',
            'image/jpg',
            'image/pjpeg',
            'image/jpeg',
            'image/gif',
            'image/bmp',
            'video/mp4',
            'video/mov',
            'video/ogg',
            'video/qt',
            'video/flv',
            'video/3gp',
            'video/avi',
            'video/wmv',
            'video/mpeg',
            'video/mpg',
            'image/x-windows-bmp',
            'application/msword',
            'application/excel',
            'application/vnd.ms-excel',
            'application/x-excel',
            'application/x-msexcel',
            'application/pdf',
            'application/mspowerpoint',
            'application/vnd.ms-powerpoint',
            'application/mspowerpoint',
            'application/powerpoint',
            'application/vnd.ms-powerpoint',
            'application/x-mspowerpoint',
            'application/x-compressed',
            'application/x-zip-compressed',
            'application/zip', 'multipart/x-zip',
        ],
        'uploadDeny' => [
            'all',
        ],
        'uploadOrder' => ['deny', 'allow'],
    ],

];
