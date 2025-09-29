<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;

class LayoutHelper
{
    public static function applClasses(): array
    {
        $defaults   = self::getDefaultConfig();
        $options    = self::getAllOptions();
        $data       = self::mergeWithCustomConfig($defaults);
        $data       = self::validateOptions($data, $defaults, $options);

        $theme      = self::resolveTheme();
        $layout     = self::buildLayoutClasses($data, $options, $theme);

        self::setDefaultLocale($layout);
        self::applyExtraClasses($layout);

        return $layout;
    }

    private static function getDefaultConfig(): array
    {
        return [
            'mainLayoutType'        => 'vertical',
            'theme'                 => 'light',
            'sidebarCollapsed'      => false,
            'navbarColor'           => '',
            'horizontalMenuType'    => 'floating',
            'verticalMenuNavbarType'=> 'floating',
            'footerType'            => 'static',
            'layoutWidth'           => 'boxed',
            'showMenu'              => true,
            'bodyClass'             => '',
            'pageClass'             => '',
            'pageHeader'            => true,
            'contentLayout'         => 'default',
            'blankPage'             => false,
            'defaultLanguage'       => 'ar',
            'direction'             => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];
    }

    private static function getAllOptions(): array
    {
        return [
            'mainLayoutType'        => ['vertical', 'horizontal'],
            'theme'                 => ['light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'],
            'sidebarCollapsed'      => [true, false],
            'showMenu'              => [true, false],
            'layoutWidth'           => ['full', 'boxed'],
            'navbarColor'           => ['bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'],
            'horizontalMenuType'    => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'],
            'horizontalMenuClass'   => ['static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'],
            'verticalMenuNavbarType'=> ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'],
            'navbarClass'           => ['floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'],
            'footerType'            => ['static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'],
            'pageHeader'            => [true, false],
            'contentLayout'         => ['default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'],
            'blankPage'             => [false, true],
            'sidebarPositionClass'  => [
                'content-left-sidebar' => 'sidebar-left',
                'content-right-sidebar' => 'sidebar-right',
                'content-detached-left-sidebar' => 'sidebar-detached sidebar-left',
                'content-detached-right-sidebar' => 'sidebar-detached sidebar-right',
                'default' => 'default-sidebar-position'
            ],
            'contentsidebarClass'   => [
                'content-left-sidebar' => 'content-right',
                'content-right-sidebar' => 'content-left',
                'content-detached-left-sidebar' => 'content-detached content-right',
                'content-detached-right-sidebar' => 'content-detached content-left',
                'default' => 'default-sidebar'
            ],
            'defaultLanguage'       => ['ar' => 'ar', 'en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'],
            'direction'             => ['ltr', 'rtl'],
        ];
    }

    private static function mergeWithCustomConfig(array $defaults): array
    {
        return array_merge($defaults, config('custom.custom', []));
    }

    private static function validateOptions(array $data, array $defaults, array $options): array
    {
        foreach ($options as $key => $validValues) {
            if (! array_key_exists($key, $defaults)) {
                continue;
            }

            if (gettype($defaults[$key]) !== gettype($data[$key])) {
                $data[$key] = $defaults[$key];
                continue;
            }

            if (is_string($data[$key]) && ! empty($data[$key])) {
                if (! array_key_exists($data[$key], $validValues)) {
                    $result = array_search($data[$key], $validValues, true);
                    if ($result === false) {
                        $data[$key] = $defaults[$key];
                    }
                }
            }
        }

        return $data;
    }

    private static function resolveTheme(): string
    {
        $employee = Auth::check()
            ? Employee::where('name', Auth::user()->name)->first()
            : null;

        return $employee && $employee->theme === 1 ? 'dark' : 'light';
    }

    private static function buildLayoutClasses(array $data, array $options, string $theme): array
    {
        return [
            'theme'                 => $theme,
            'layoutTheme'           => $options['theme'][$theme],
            'sidebarCollapsed'      => $data['sidebarCollapsed'],
            'showMenu'              => $data['showMenu'],
            'layoutWidth'           => $data['layoutWidth'],
            'verticalMenuNavbarType'=> $options['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass'           => $options['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor'           => $data['navbarColor'],
            'horizontalMenuType'    => $options['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass'   => $options['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType'            => $options['footerType'][$data['footerType']],
            'sidebarClass'          => '',
            'bodyClass'             => $data['bodyClass'],
            'pageClass'             => $data['pageClass'],
            'pageHeader'            => $data['pageHeader'],
            'blankPage'             => $data['blankPage'],
            'blankPageClass'        => '',
            'contentLayout'         => $data['contentLayout'],
            'sidebarPositionClass'  => $options['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass'   => $options['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType'        => $data['mainLayoutType'],
            'defaultLanguage'       => $options['defaultLanguage'][$data['defaultLanguage']],
            'direction'             => $data['direction'],
        ];
    }

    private static function setDefaultLocale(array $layout): void
    {
        if (! session()->has('locale')) {
            app()->setLocale($layout['defaultLanguage']);
        }
    }

    private static function applyExtraClasses(array &$layout): void
    {
        if ($layout['sidebarCollapsed'] === true || $layout['sidebarCollapsed'] === 'true') {
            $layout['sidebarClass'] = 'menu-collapsed';
        }

        if ($layout['blankPage'] === true || $layout['blankPage'] === 'true') {
            $layout['blankPageClass'] = 'blank-page';
        }
    }
}
