<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Support\Facades\View;

class SiteSettingsMiddleware
{
    public function handle($request, Closure $next)
    {
        // $site_setting = SiteSetting::where('site_alias', env('SITE_ALIAS'))->first();

        // View::share('site_setting', $site_setting);

        return $next($request);
    }
}
