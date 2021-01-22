<?php

namespace App\Http\Controllers\Admin;

use Analytics;
use App\Integration\GoogleAnalytics;
use App\Jobs\QueueTestJob;
use App\Models\BlogAdsListing;
use App\Models\BlogComment;
use App\Models\DirectoryAdsListing;
use App\Models\DirectoryListing;
use App\Models\Module\BlogPost;
use App\Models\SiteAdsListing;
use App\Models\Subscriber;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Storage;

class DashboardController extends AdminController
{
    public $period = 29;

    public function test($type)
    {
        if ($type == 'queue') {
            $this->dispatch(new QueueTestJob());

            return 'success';
        }
    }

    public function index()
    {
        $data['notifications'] = auth()->user()->unreadNotifications;
        if (tenant()->hasAnyActiveModule(['simple_blog', 'advanced_blog'])) {
            if (tenant()->hasAnyActiveModule(['advanced_blog'])) {
                $data['pendingPosts'] = BlogPost::where('is_published', 1)->where('status', 'pending')->count();
            }

            $data['pendingComments'] = BlogComment::where('status', 0)->count();
        }
        if (tenant()->hasAnyActiveModule(['blogAds'])) {
            $data['pendingBlogAdsListings'] = BlogAdsListing::where('status', 'pending')->count();
        }

        if (tenant()->hasAnyActiveModule(['siteAds'])) {
            $data['pendingSiteAdsListings'] = SiteAdsListing::where('status', 'pending')->count();
        }

        if (tenant()->hasAnyActiveModule(['directoryAds'])) {
            $data['pendingDirectoryAdsListings'] = DirectoryAdsListing::where('status', 'pending')->count();
        }

        if (tenant()->hasAnyActiveModule(['directory'])) {
            $data['pendingDirectoryListings'] = DirectoryListing::where('status', 'pending')->count();
        }

        $data['openedTickets'] = Ticket::with('user')->where('parent_id', 0)
            ->where('status', '!=', 'closed')
            ->latest()
            ->get();

        $data['totalUsers'] = User::count();
        $data['verifiedUsers'] = User::whereNotNull('email_verified_at')->count();
        $data['todayUsers'] = User::where('created_at', '>', now()->toDateString())->count();
        $data['totalSubscribers'] = Subscriber::where('status', 1)->count();

        return view(self::$viewDir.'.dashboard', $data);
    }

    public function selectUser(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;

            $data = User::where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%$search%");
                $query->orWhere('users.email', 'LIKE', "%$search%");
            })
                ->selectRaw('CONCAT( name, " (", email, ")" ) as nameEmail, users.id')
                ->status('active')
                ->paginate(50);
        }

        return response()->json($data);
    }

    public function analytics()
    {
        try {
            $google_services = optional(option('google_services', []));

            Storage::disk('local-temp-pri-analytics')->put(
                 'service-account-credentials-'.tenant('id').'.json',
                $google_services['ga_file']);

            $path = 'app/analytics/service-account-credentials-'.tenant('id').'.json';

            config([
                'analytics.view_id' => $google_services['ga_view_id'],
                'analytics.service_account_credentials_json' => storage_path($path),
            ]);

            $data = null;
            $analyticsData_one = Analytics::fetchTotalVisitorsAndPageViews(Period::days($this->period));
            $dates = $analyticsData_one->pluck('date');

            $data['dates'] = $dates->map(function ($date) {
            return $date->format('d/m');
            });

            $data['visitors'] = $analyticsData_one->pluck('visitors');
            $data['pageViews'] = $analyticsData_one->pluck('pageViews');
            $data['browserjson'] = GoogleAnalytics::topbrowsers($this->period);

            $result = GoogleAnalytics::country($this->period);
            $data['country'] = $result->pluck('country');
            $data['country_sessions'] = $result->pluck('sessions');

            return response()->json([
                'status' => 1,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
