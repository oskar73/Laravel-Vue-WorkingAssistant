<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/content/page/upload/cover*',
        '/admin/content/page/upload/largeImage*',
        '/admin/content/page/upload/saveImage*',
        '/admin/content/page/upload/moduleImage*',
        '/admin/content/page/upload/moduleVideo*',
        '/ipn/stripe',
        '/ipn/paypal',
        'uploadImage*',
        'uploadImages*',
    ];

    public function handle($request, Closure $next)
    {
        if (! Auth::check() && $request->route()->named('logout')) {
            $this->except[] = route('logout');
        }

        return parent::handle($request, $next);
    }
}
