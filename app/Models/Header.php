<?php

namespace App\Models;

class Header extends StaticBaseModel
{
    protected $table = 'headers';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
