<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModulePublishCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module)
    {
        $modules = is_array($module)
            ? $module
            : explode('|', $module);

        if (! tenant()->hasAnyPublishModule($modules)) {
            abort(404);
        }

        return $next($request);
    }
}
