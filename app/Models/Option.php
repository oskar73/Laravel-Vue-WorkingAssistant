<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;

    public $tenant_id;

    protected $table = 'options';

    protected $casts = [
        'value' => 'json',
    ];

    protected $fillable = [
        'web_id',
        'key',
        'value',
    ];

    public function __construct()
    {
        $this->tenant_id = tenant('id');
    }

    public function exists($key)
    {
        return self::where('key', $key)->where('web_id', $this->tenant_id)->exists();
    }

    public function get($key, $default = null)
    {
        if ($option = self::where('key', $key)->where('web_id', $this->tenant_id)->first()) {
            return $option->value;
        }

        return $default;
    }

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            self::updateOrCreate(
                ['key' => $key, 'web_id' => $this->tenant_id],
                ['value' => $value, 'web_id' => $this->tenant_id, 'key' => $key]
            );
        }
    }

    public function remove($key)
    {
        return (bool) self::where('key', $key)->where('web_id', $this->tenant_id)->delete();
    }
}
