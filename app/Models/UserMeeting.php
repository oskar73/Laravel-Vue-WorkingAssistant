<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMeeting extends BaseModel
{
    use HasFactory;

    protected $table = 'user_meetings';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['available_number'];

    public function getAvailableNumberAttribute()
    {
        return $this->meeting_number - $this->current_number;
    }

    public function createUserMeeting($model, $product, $user)
    {
        $meetingSet = $product->meetingSet;

        $meeting = $this;
        $meeting->model_id = $model->id;
        $meeting->model_type = get_class($model);
        $meeting->user_id = $user->id;
        $meeting->product_id = $product->id;
        $meeting->product_type = get_class($product);
        $meeting->meeting_period = $meetingSet->meeting_period;
        $meeting->meeting_number = $meetingSet->meeting_number;
        $meeting->special = $meetingSet->special;
        $meeting->status = $model->status;
        $meeting->save();

        return $meeting;
    }

    public function product()
    {
        return $this->morphTo('product');
    }

    public function model()
    {
        return $this->morphTo('model');
    }

    public function getAvailablePeriod($date, $category)
    {
        $a_week = new AvailableWeekday();

        $c = new Carbon($date);
        $w = $c->dayOfWeek;
        $week = $a_week::weekMap[$w];

        $data = $a_week->getData('appointment', null);
        if ($data[$week] == null) {
            return [];
        }
        $a_hours1 = $data[$week]->hours;

        $data2 = $a_week->getData(get_class($category), $category->id);
        if ($data2[$week] == null) {
            return [];
        }
        $a_hours2 = $data2[$week]->hours;

        $data3 = $a_week->getData(get_class($this->product), $this->product->id);
        if ($data3[$week] == null) {
            return [];
        }
        $a_hours3 = $data3[$week]->hours;

        $b_hours1 = AppointmentBlockDate::where('type', 'appointment')->where('date', $date)->first();
        $b_hours2 = AppointmentBlockDate::where('type', 'appointmentCategory')->where('product_id', $category->id)->where('date', $date)->first();
        $b_hours3 = AppointmentList::where('date', $date)->get();

        if ($b_hours1 != null && $b_hours1->whole_date == 1) {
            return [];
        }
        if ($b_hours2 != null && $b_hours2->whole_date == 1) {
            return [];
        }

        $start = '00:00';
        $end = '00:30';
        $step = 30;

        $result = [];

        do {
            $v1 = 0;
            $v2 = 0;
            $v3 = 0;
            $b1 = 1;
            $b2 = 1;
            $b3 = 1;
            foreach ($a_hours1 as $a_h) {
                if (timePeriodCompare($start, $end, $a_h->start, $a_h->end) == 1) {
                    $v1 = 1;
                }
            }
            foreach ($a_hours2 as $a_h2) {
                if (timePeriodCompare($start, $end, $a_h2->start, $a_h2->end) == 1) {
                    $v2 = 1;
                }
            }
            foreach ($a_hours3 as $a_h3) {
                if (timePeriodCompare($start, $end, $a_h3->start, $a_h3->end) == 1) {
                    $v3 = 1;
                }
            }
            if ($b_hours1 != null) {
                foreach (json_decode($b_hours1->start) as $key1 => $s1) {
                    if (timePeriodCompare($start, $end, $s1, json_decode($b_hours1->end)[$key1]) == 1) {
                        $b1 = 0;
                    }
                }
            }
            if ($b_hours2 != null) {
                foreach (json_decode($b_hours2->start) as $key2 => $s2) {
                    if (timePeriodCompare($start, $end, $s2, json_decode($b_hours2->end)[$key2]) == 1) {
                        $b2 = 0;
                    }
                }
            }
            if ($b_hours3 != null) {
                foreach ($b_hours3 as $key2 => $s3) {
                    if (timePeriodCompare($start, $end, $s3->start_time, $s3->end_time) == 1) {
                        $b3 = 0;
                    }
                }
            }
            if ($v1 == 1 && $v2 == 1 && $v3 == 1 && $b1 == 1 && $b2 == 1 && $b3 == 1) {
                $data = [];
                $data['start'] = $start;
                $data['end'] = $end;
                array_push($result, $data);
            }

            $start = date('H:i', strtotime('+'.$step.' minutes', strtotime($start)));
            $mid_end = date('H:i', strtotime('+'.$step.' minutes', strtotime($end)));
            if ($mid_end == '00:00') {
                $end = '24:00';
            } else {
                $end = $mid_end;
            }
        } while ($start != '00:00');

        return $result;
    }
}
