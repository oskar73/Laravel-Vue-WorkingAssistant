<?php

namespace App\Models;

class Price extends BaseModel
{
    protected $table = 'prices';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getPriceText()
    {
        $text = '$'.formatNumber($this->price);
        if ($this->recurrent) {
            $text .= '/'.periodName($this->period, $this->period_unit).' (Recurrent) ';
        } else {
            $text .= ' (Onetime)';
        }

        return $text;
    }
}
