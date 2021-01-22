<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableWeekday extends BaseModel
{
    use HasFactory;

    protected $table = 'available_weekdays';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public const weekArray = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    public const weekMap = [
        0 => 'sun',
        1 => 'mon',
        2 => 'tue',
        4 => 'thu',
        3 => 'wed',
        5 => 'fri',
        6 => 'sat',
    ];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function getData($type, $product_id = null)
    {
        $data = [];
        $avWeeks = $this->with('hours')
            ->whereType($type)
            ->whereProductId($product_id)
            ->get();
        foreach (self::weekArray as $weekday) {
            $data[$weekday] = null;
        }
        foreach ($avWeeks as $avWeek) {
            $data[$avWeek->weekday] = $avWeek;
        }

        return $data;
    }

    public function storeRule($request)
    {
        $rule = [];
        foreach (self::weekArray as $item) {
            if ($request->$item) {
                $rule['start_time_'.$item.'.*'] = 'required|date_format:G:i';
                $rule['end_time_'.$item.'.*'] = 'required|date_format:G:i';
            }
        }

        return $rule;
    }

    public function checkRule($request)
    {
        $error = [];
        foreach (self::weekArray as $item) {
            if ($request->$item) {
                $start_time = 'start_time_'.$item;
                $end_time = 'end_time_'.$item;
                if ($request->$start_time != null) {
                    foreach ($request->$start_time as $key => $start) {
                        if (strtotime($start) >= strtotime($request->$end_time[$key])) {
                            $error[] = ucfirst($item).' start time should be before than end time.';
                        }

                        foreach ($request->$start_time as $key1 => $check_start) {
                            if ($key != $key1 && ((strtotime($start) < strtotime($request->$end_time[$key1]) && (strtotime($start) > strtotime($check_start))) || (strtotime($request->$end_time[$key]) > strtotime($check_start) && strtotime($request->$end_time[$key]) < strtotime($request->$end_time[$key1])))) {
                                $error[] = ucfirst($item).' times have doubled period.';
                            }
                            if ($key != $key1 && (strtotime($start) == strtotime($check_start) || strtotime($request->$end_time[$key]) == strtotime($request->$end_time[$key1]))) {
                                $error[] = ucfirst($item).' times have doubled period.';
                            }
                        }
                    }
                }
            }
        }

        return $error;
    }

    public function storeItem($request, $type, $id = null)
    {
        foreach (self::weekArray as $item) {
            if ($request != null && $request->$item) {
                $weekday = self::firstOrCreate([
                    'type' => $type,
                    'product_id' => $id,
                    'weekday' => $item,
                ]);
                $start_time = 'start_time_'.$item;
                $end_time = 'end_time_'.$item;
                $weekday->$item = 1;
                AvailableHour::where('weekday_id', $weekday->id)->delete();
                if ($request->$start_time != null) {
                    foreach ($request->$start_time as $key => $start) {
                        $weekday->hours()->create([
                            'start' => $start,
                            'end' => ($request->$end_time)[$key],
                        ]);
                    }
                }
            } else {
                self::where('type', $type)
                    ->where('product_id', $id)
                    ->where('weekday', $item)
                    ->delete();
            }
        }

        return true;
    }

    public function isNowAvailable($type, $id)
    {
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = self::weekMap[$dayOfTheWeek];
        $c_time = date('G:i');
        $check1 = self::with('hours')
            ->whereType($type)
            ->whereProductId($id)
            ->whereWeekday($weekday)
            ->first();
        if ($check1 == null) {
            return false;
        }
        if ($check1->hours == null) {
            return true;
        }
        foreach ($check1->hours as $hour) {
            if (strtotime($c_time) > strtotime($hour->start) && strtotime($c_time) < strtotime($hour->end)) {
                return true;
            }
        }

        return false;
    }

    public function hours()
    {
        return $this->hasMany(AvailableHour::class, 'weekday_id');
    }
}
