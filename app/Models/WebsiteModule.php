<?php

namespace App\Models;

class WebsiteModule extends StaticBaseModel
{
    protected $table = 'website_modules';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const SIMPLE_BLOG = 'simple_blog';

    const ADVANCED_BLOG = 'advanced_blog';

    const BLOG_ADS = 'blogAds';

    const EMAIL = 'email';

    const DIRECTORY = 'directory';

    const DIRECTORY_ADS = 'directoryAds';

    const SITE_ADS = 'siteAds';

    const ECOMMERCE = 'ecommerce';

    const PORTFOLIO = 'portfolio';

    const ADDITIONAL_PAGE = 'page';
}
