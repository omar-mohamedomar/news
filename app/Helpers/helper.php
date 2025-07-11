<?php

use App\Models\Language;
use App\Models\Setting;
use PhpParser\Node\Expr\Cast\String_;

/** format news tags */

function formatTags(array $tags): String
{
    return implode(',', $tags);
}

/** Get selected language from session */
function getLanguage(): string
{
    if (session()->has('language')) {
        return session('language');
    } else {
        try {
            $language = Language::where('default', 1)->first();
            setLanguage($language->lang);

            return $language->lang;
        } catch (\Throwable $th) {
            setLanguage('en');

            return 'en';  // $language->lang عدلنا هنا مكان دي
        }
    }
}

/** Set language code in session */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}

/** Truncate text */
function truncate(string $text, $limit = 50): String
{
    return \Str::limit($text, $limit, '...');
}

function convertToKFormat(int $number): string
{
    if ($number < 1000) {
        return $number;
    } elseif ($number < 1000000) {
        return round($number / 1000, 1) . 'K';  //5.K
    } else {
        return round($number / 1000000, 1) . 'M';
    }
}

/** Make Sidebar Active */
if (! function_exists('setSidebarActive')) {
    function setSidebarActive(array $routes): ?string
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return '';
    }
}

/** get Setting */
function getSetting($key)
{
    $data = Setting::where('key', $key)->first();
    return $data->value;
}


/** Check Permission */
function canAccess(array|string $permissions): bool
{
    $user = auth()->guard('admin')->user();

    if ($user->hasRole('Super Admin')) {
        return true;
    }

    return is_array($permissions)
        ? $user->hasAnyPermission($permissions)
        : $user->hasPermissionTo($permissions);
}


/** Check Permission */
// function canAccess(array $permissions): bool {
//     $user = auth()->guard('admin')->user();
//     return $user->hasRole('Super Admin') || $user->hasAnyPermission($permissions);
// }

/** Check Permission */
// function canAccess(array $permissions) {
//     $permission = auth()->guard('admin')->user()->hasAnyPermission($permissions);
//     $superAdmin = auth()->guard('admin')->user()->hasRole('Super Admin');

//     if ($permission || $superAdmin) {
//         return true;
//     } else {
//         return false;
//     }
// }


/** get admin role */
function getRole() {
    $role = auth()->guard('admin')->user()->getRoleNames();
    return $role->first();
}

/** check user permission */
function checkPermission(string $permission) {
    return auth()->guard('admin')->user()->hasPermissionTo($permission);
}
