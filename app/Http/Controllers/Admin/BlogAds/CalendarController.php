<?php

namespace App\Http\Controllers\Admin\BlogAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogAdsEvent;
use App\Models\BlogAdsSpot;
use Illuminate\Http\Request;

class CalendarController extends AdminController
{
    public function index()
    {
        $spots = BlogAdsSpot::whereStatus(1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(self::$viewDir.'.blogAds.calendar', compact('spots'));
    }

    public function spot($id)
    {
        $spot = BlogAdsSpot::whereId($id)->firstorfail();
        $spots = BlogAdsSpot::whereStatus(1)
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

        return view(self::$viewDir.'.blogAds.calendar', compact('spots', 'spot'));
    }

    public function events(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $events = BlogAdsEvent::whereBetween('start_date', [$start, $end])
            ->orWhereBetween('end_date', [$start, $end])
            ->with('listing')
            ->get();

        $lists = [];
//        foreach($events as $event)
//        {
//            if($event->start_date!=null&&$event->end_date!=null)
//            {
//                $lists[] = [
//                    'id' => 'e' . $event->id,
//                    'start' => $event->start_date . " 00:00:00",
//                    'end' => $event->end_date . " 24:00:00",
//                    'color' => '#b3ffb3',
//                ];
//            }
//        }

        return $lists;
    }
}
