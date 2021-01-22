<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends BaseModel
{
    use HasFactory;

    protected $table = 'colors';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'color' => 'json',
    ];

    public function storeRule($type)
    {
        $rule['name'] = 'required|max:45';
        if ($type == 'theme') {
            $rule['primary'] = 'required|max:45';
            $rule['theme_font'] = 'required|max:45';
            $rule['secondary'] = 'required|max:45';
            $rule['background'] = 'required|max:45';
            $rule['font'] = 'required|max:45';
            $rule['link'] = 'required|max:45';
            $rule['link_hover'] = 'required|max:45';
            $rule['active_icon'] = 'required|max:45';
        } else {
            $rule['nav_bg'] = 'required|max:45';
            $rule['nav_item'] = 'required|max:45';
            $rule['nav_hover_bg'] = 'required|max:45';
            $rule['nav_hover_item'] = 'required|max:45';
        }

        return $rule;
    }

    public function storeItem($request, $type)
    {
        if ($type == 'theme') {
            $data['primary'] = $request->primary;
            $data['theme_font'] = $request->theme_font;
            $data['secondary'] = $request->secondary;
            $data['background'] = $request->background;
            $data['font'] = $request->font;
            $data['link'] = $request->link;
            $data['link_hover'] = $request->link_hover;
            $data['active_icon'] = $request->active_icon;
        } else {
            $data['nav_bg'] = $request->nav_bg;
            $data['nav_item'] = $request->nav_item;
            $data['nav_hover_bg'] = $request->nav_hover_bg;
            $data['nav_hover_item'] = $request->nav_hover_item;
        }

        $color = $this;
        $color->name = $request->name;
        $color->type = $type;
        $color->color = $data;
        $color->save();

        return $color;
    }

    public function themeColor($parameter)
    {
        return optional($this->color)[$parameter];
    }
}
