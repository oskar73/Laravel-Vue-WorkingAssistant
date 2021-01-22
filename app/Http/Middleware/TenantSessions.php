<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class TenantSessions
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
//        if(!$request->session()->has('tenant_id')) {
//            $request->session()->put('tenant_id', app('tenant')->id);
//
//            return $next($request);
//        }
//
//        if($request->session()->get('tenant_id')!=app('tenant')->id)
//        {
//            abort(401);
//        }

        return $next($request);
    }
}
