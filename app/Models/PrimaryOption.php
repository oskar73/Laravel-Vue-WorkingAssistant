<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryOption extends Model
{
    public $timestamps = false;

    public $tenant_id;

    protected $connection = 'mysql2';

    protected $table = 'options';

    protected $casts = [
        'value' => 'json',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    public function exists($key)
    {
        return self::where('key', $key)->exists();
    }

    public function get($key, $default = null)
    {
        if ($option = self::where('key', $key)->first()) {
            return $option->value;
        }

        return $default;
    }
}
