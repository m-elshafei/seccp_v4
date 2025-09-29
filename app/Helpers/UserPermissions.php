<?php

// Code within app\Helpers\UserPermissions.php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserPermissions
{
    public static $systemName;

    public static function hasAccessTo(string $permissionName): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasRole('admin') || $user->can($permissionName);
    }


    public static function hasAccessToAction(string $actionName): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        $permission = self::getPermissionName($actionName);

        return self::isAdmin($user) || self::hasPermission($user, $permission);
    }

    private static function isAdmin($user): bool
    {
        return $user->hasRole('admin');
    }

    private static function hasPermission($user, string $permission): bool
    {
        return $user->can($permission);
    }
 

    /**
     * get permissionName string from route prefix & name
     *
     * @return @var permissionName
     */
    public static function getPermissionName($actionName = '')
    {
        if ($actionName) {
            $permissionName = self::getCurrentRouteName(true, true).'.'.$actionName;
        } else {
            $permissionName = self::getCurrentRouteName(true);
        }

        return $permissionName;
    }

    /**
     * get Current Route Name from the Route
     *
     * @param [bool] $permissiowithPrefixnName
     * @return @var routeName
     */

    public static function getCurrentRouteName(bool $withPrefix = false,
        bool $removeMethodName = false
    ): ?string {
        $prefix   = self::normalizePrefix(Route::current()->getPrefix());
        $route    = Route::current()->getName();

        if (! $route) {
            return null;
        }

        if ($removeMethodName) {
            $route = self::removeMethodFromRoute($route);
        }

        return $withPrefix && $prefix
            ? $prefix . '.' . $route
            : $route;
    }

    private static function normalizePrefix(?string $prefix): ?string
    {
        return $prefix ? str_replace('/', '', $prefix) : null;
    }

    private static function removeMethodFromRoute(string $routeName): string
    {
        return explode('.', $routeName)[0];
    }

    public static function getPrefixName()
    {
        return str_replace('/', '', Route::current()->getPrefix());
    }

    public static function getCurrentMethodName()
    {
        $routeName = Route::current()->getName();
        $arr = explode('.', $routeName);
        $methodName = $arr[1];

        return $methodName;
    }

    /**
     * get Route Name from the generated permisionName
     *
     * @param [string] $permissionName
     * @return @var routeName
     */
    private function getRouteName($permissionName)
    {
        $arr = explode('-', $permissionName);
        $routeName = $arr[0];

        return $routeName;
    }

    /**
     * Get the value of systemName
     */
    public function getSystemName()
    {
        return self::$systemName;
    }

    /**
     * Set the value of systemName
     *
     * @return self
     */
    public function setSystemName($systemName)
    {
        self::$systemName = $systemName;

        return $this;
    }
}
