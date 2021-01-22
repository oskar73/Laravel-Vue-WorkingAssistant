<?php

namespace App\Integration;

use Analytics;
use Spatie\Analytics\Period;

class GoogleAnalytics
{
    public static function country($period)
    {
        $country = Analytics::performQuery(Period::days($period), 'ga:sessions', ['dimensions' => 'ga:country', 'sort' => '-ga:sessions']);
        $result = collect($country['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'country' => $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        /* $data['country'] = $result->pluck('country'); */
        /* $data['country_sessions'] = $result->pluck('sessions'); */
        return $result;
    }

    public static function topbrowsers($period)
    {
        $analyticsData = Analytics::fetchTopBrowsers(Period::days($period));
        $array = $analyticsData->toArray();
        $result = [];
        foreach ($array as $k => $v) {
            $result['label'][] = $array[$k]['browser'];
            $result['value'][] = $array[$k]['sessions'];
            $result['color'][] = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        return json_encode($result);
    }
}
