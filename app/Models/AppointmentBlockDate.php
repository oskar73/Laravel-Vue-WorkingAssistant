<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentBlockDate extends BaseModel
{
    use HasFactory;

    protected $table = 'appointment_block_dates';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    const CUSTOM_VALIDATION_MESSAGE = [

    ];

    public function storeRule($request)
    {
        $rule['from_date'] = 'required|date|after_or_equal:'.Carbon::now()->toDateString();
        $rule['to_date'] = 'required|date|after_or_equal:from_date';
        if ($request->specific_time) {
            $rule['start_time.*'] = 'required|date_format:G:i';
            $rule['end_time.*'] = 'required|date_format:G:i';
        }

        return $rule;
    }

    public function checkRule($request)
    {
        $error = [];
        foreach ($request->start_time as $key => $start) {
            if (strtotime($start) >= strtotime($request->end_time[$key])) {
                $error[0] = 'Start time should be before than end time.';
            }
            foreach ($request->start_time as $key1 => $check_start) {
                if ($key != $key1 && ((strtotime($start) < strtotime($request->end_time[$key1]) && (strtotime($start) > strtotime($check_start))) || (strtotime($request->end_time[$key]) > strtotime($check_start) && strtotime($request->end_time[$key]) < strtotime($request->end_time[$key1])))) {
                    $error[1] = 'Times have doubled period.';
                }

                if ($key != $key1 && (strtotime($start) == strtotime($check_start) || strtotime($request->end_time[$key]) == strtotime($request->end_time[$key1]))) {
                    $error[1] = 'Times have doubled period.';
                }
            }
        }

        return $error;
    }

    public function getEvents($request, $type, $product_id)
    {
        $start = $request->start;
        $end = $request->end;

        $dates = $this->where('type', $type)
            ->where('product_id', $product_id)
            ->whereBetween('date', [$start, $end])
            ->get();
        $events = [];
        if ($dates != null) {
            foreach ($dates as $date) {
                foreach (json_decode($date->start) as $key => $start) {
                    $event = [];
                    $event['title'] = $start.' - '.json_decode($date->end)[$key];
                    $event['start'] = $date->date.' '.timeGlobal($start);
                    $event['end'] = $date->date.' '.timeGlobal(json_decode($date->end)[$key]);
                    $event['reason'] = $date->reason;
                    $event['whole_date'] = $date->whole_date;
                    $event['color'] = '#f4516c';
                    $event['id'] = $date->id;
                    $event['date'] = $date->date;
                    $event['start_time'] = $start;
                    $event['end_time'] = json_decode($date->end)[$key];
                    $event['allDay'] = false;
                    array_push($events, $event);
                }
            }
        }

        return $events;
    }

    public function storeItem($request, $type, $product_id)
    {
        if ($request->specific_time) {
            $start_time = json_encode($request->start_time);
            $end_time = json_encode($request->end_time);
            $whole_date = 0;
        } else {
            $start_time = json_encode(['00:00']);
            $end_time = json_encode(['24:00']);
            $whole_date = 1;
        }
        $reason = $request->reason;
        $start_date = $request->from_date;

        do {
            $blockHour = AppointmentBlockDate::where('type', $type)
                ->where('product_id', $product_id)
                ->where('date', $start_date)
                ->first();
            if ($blockHour == null) {
                $blockHour = new AppointmentBlockDate();
                $blockHour->type = $type;
                $blockHour->product_id = $product_id;
                $blockHour->date = $start_date;
            }
            $blockHour->reason = $reason;
            $blockHour->whole_date = $whole_date;
            $blockHour->start = $start_time;
            $blockHour->end = $end_time;
            $blockHour->web_id = tenant('id');
            $blockHour->save();

            $start_date = nextDate($start_date);
        } while ($start_date < nextDate($request->to_date));

        return true;
    }
}
