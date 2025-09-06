<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class SiteSettingsMiddleware
{
    public function handle($request, Closure $next)
    {
        // $site_setting = SiteSetting::where('site_alias', env('SITE_ALIAS'))->first();

        // View::share('site_setting', $site_setting);

        return $next($request);
    }
}
