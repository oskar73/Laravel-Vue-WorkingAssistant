<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Footer extends StaticBaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'footers';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
