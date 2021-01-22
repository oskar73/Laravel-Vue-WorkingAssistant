<?php

return [
    'default' => [
        'logo' => 'https://supervisoroncall.com/storage/uploads/b9a355a0-65a0-11ea-ab4e-77d30001510f-b9a35890-65a0-11ea-8516-0fc812c52c8c.png',
    ],
    'tenant_id' => 1,
    'bizinabox' => [
        'domain' => env('BIZINABOX_COM_DOMAIN', 'bizinabox.com'),
        'mail_domain' => env('BIZINABOX_COM_MAIL_DOMAIN'),
    ],
    'route' => [
        'blog' => 'blog',
        'blogDetail' => '',
        'blogAds' => 'blogAds',
        'siteAds' => 'siteAds',
        'portfolio' => 'portfolio',
        'directory' => 'directory',
        'directoryAds' => 'directoryAds',
        'review' => 'review',
        'ecommerce' => 'ecommerce',
        'product' => 'product',
        'details' => 'details'
    ],
    'storage_name' => [
        'media_library' => 'media',
        'tinymce' => 'editor',
        'video' => 'video',
        'blog' => 'blog',
        'directory' => 'directory',
        'directoryAds' => 'directory-ads',
        'blogAds' => 'blog-ads',
        'siteAds' => 'site-ads',
        'portfolio' => 'portfolio',
        'page' => 'page',
        'ecommerce' => 'ecommerce',
        'setting' => 'setting',
    ],
    'aws' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
    ],
    'variable' => [
        'blog_image_ratio_width' => 4,
        'blog_image_ratio_height' => 3,
        'package_image_ratio_width' => 3,
        'package_image_ratio_height' => 4,
    ]
];
