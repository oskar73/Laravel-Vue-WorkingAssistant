<?php

namespace App\Http\Middleware;

use App\Models\Website;
use Closure;
use Session;

class ApiHostname
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \URL::defaults([
            'domain' => $request->route()->parameter('domain'),
        ]);
        $domain = $request->route()->parameter('domain');

        $website = Website::where('domain', $domain)->where('status', 'active')->firstorfail();

        abort_if($website->status_by_owner == 'maintenance', 503);
        abort_if($website->status_by_owner == 'pending', 404);

        Session::put('webRow', $website);

//        if(!Session::has('webRow')){
//            $website = Website::where('domain', $domain)->where("status", "active")->firstorfail();
//
//            abort_if($website->status_by_owner=='maintenance', 503);
//            abort_if($website->status_by_owner=='pending', 404);
//
//            Session::put('webRow', $website);
//        }
        $request->route()->forgetParameter('domain');

        return $next($request);
    }
}
