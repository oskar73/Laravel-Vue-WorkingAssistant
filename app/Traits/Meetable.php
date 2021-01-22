<?php

namespace App\Traits;

use App\Models\ProductMeeting;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Meetable
{
    public static $updateMeetingValidationCustomMessage = [

    ];

    public function getUpdateMeetingValidationMessage()
    {
        return self::$updateMeetingValidationCustomMessage;
    }

    public function updateMeetingRule($request)
    {
        $rule = [];
        if ($request->meeting) {
            $rule['appCats'] = 'required';
            $rule['appCats.*'] = 'required|exists:appointment_categories,id';
            $rule['meetingPeriod'] = 'required|in:30,60,90,120';
            $rule['meetingLimit'] = 'required|numeric|min:1';
        }

        return $rule;
    }

    public function updateMeeting($request)
    {
        $item = $this;
        $item->meeting = $request->meeting ? 1 : 0;
        $item->save();
        if ($request->meeting) {
            $productMeeting = ProductMeeting::firstOrCreate([
                'product_id' => $item->id,
                'product_type' => get_class($item),
            ]);
            $productMeeting->special = 1;
            $productMeeting->meeting_period = $request->meetingPeriod;
            $productMeeting->meeting_number = $request->meetingLimit;
            $productMeeting->save();

            $productMeeting->categories()->sync($request->appCats);
        } else {
            ProductMeeting::where('product_type', get_class($item))
                ->where('product_id', $item->id)
                ->delete();
        }

        return $item;
    }

    public function meetingSet(): MorphOne
    {
        return $this->morphOne(
            ProductMeeting::class,
            'product_meetings',
            'product_type',
            'product_id'
        )->withDefault();
    }
}
