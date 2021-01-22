<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BizinaModule extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'modules';

    public function category()
    {
        return $this->belongsTo(BizinaModuleCategory::class, 'category_id')->withDefault();
    }
}
