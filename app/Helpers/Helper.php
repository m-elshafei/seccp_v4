<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Employee;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// use App\Helpers\Telegram;
class Helper
{
    

    public static function updatePageConfig(array $pageConfigs, string $namespace = 'custom'): void
    {
        if (empty($pageConfigs)) {
            return;
        }

        foreach ($pageConfigs as $config => $value) {
            self::setConfig($namespace, $config, $value);
        }
    }

    private static function setConfig(string $namespace, string $key, mixed $value): void
    {
        Config::set("custom.{$namespace}.{$key}", $value);
    }

    public static function checkCurrentRouteName(?string $routeName): bool
    {
        if ($routeName === null) {
            return false;
        }

        $currentRoute = Route::currentRouteName();

        return str_contains($currentRoute, "{$routeName}.")
            || str_contains($currentRoute, $routeName);
    }

    public static function dateFormat(string|\DateTimeInterface $value, string $format = 'Y-m-d'): ?string
    {
        try {
            return Carbon::parse($value)->format($format);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

            return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    public static function checkActiveRoute($menuRouteName, $comp_type = '')
    {
        if ($comp_type && $comp_type == 4) {//  4  ===> for report type
            // Debugbar::info($menuRouteName);
            // Debugbar::info(Route::current()->parameters());
            $routeReportName = '';
            $routeParamters = Route::current()->parameters();
            if ($routeParamters && isset($routeParamters['reportName']) && $routeParamters['reportName']) {
                $routeReportName = $routeParamters['reportName'];
            }

            return $routeReportName == $menuRouteName;
        } else {
            $menuRouteArr = [$menuRouteName.'.index', $menuRouteName.'.edit', $menuRouteName.'.show', $menuRouteName.'.create', $menuRouteName];

            return in_array(Route::currentRouteName(), $menuRouteArr);
        }
    }

    public static function redirectAfterSaving($id, $request, $routeName)
    {
        if (isset($request->redirectAction) && $request->redirectAction && $request->redirectAction == 'edit') {
            return redirect(route($routeName.'.edit', $id));
        }

        return redirect(route($routeName.'.index'));
    }

    public static function getConfigOptionsList($constName)
    {
        $listOptions = collect(config($constName))->map(function ($item, $key) {
            return $item['title'];
        })->prepend('لا يوجد', 0);

        return $listOptions;
    }

    public static function pdfImagePath($image_path)
    {
        if (env('APP_ENV') == 'production') {
            return url($image_path);
            //    return asset($image_path);
        }

        return public_path($image_path);
    }
}
