<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            if (blank($fallback)) {
                return null;
            }

            return filter_var($fallback, FILTER_VALIDATE_URL)
                ? $fallback
                : '/' . ltrim($fallback, '/');
        }

        $path = ltrim($path, '/');

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (str_starts_with($path, 'img/') || str_starts_with($path, 'video/') || str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        if (public_storage_is_available()) {
            return '/storage/' . $path;
        }

        return '/media/' . $path;
    }
}

if (! function_exists('public_storage_is_available')) {
    function public_storage_is_available(): bool
    {
        $publicStoragePath = public_path('storage');

        if (is_link($publicStoragePath)) {
            return file_exists($publicStoragePath);
        }

        return is_dir($publicStoragePath);
    }
}

if (! function_exists('current_front_theme')) {
    function current_front_theme(): string
    {
        $defaultTheme = 'default';
        $siteSetting = null;

        if (app()->bound('view')) {
            $siteSetting = app('view')->shared('siteSetting');
        }

        $theme = is_object($siteSetting) ? ($siteSetting->front_theme ?? null) : null;
        $theme = is_string($theme) ? strtolower(trim($theme)) : '';

        if ($theme === '' || ! preg_match('/^[a-z0-9_-]+$/', $theme)) {
            return $defaultTheme;
        }

        return $theme;
    }
}

if (! function_exists('themed_view_name')) {
    function themed_view_name(string $view): string
    {
        $theme = current_front_theme();

        if ($theme !== 'default') {
            $themedView = 'themes.' . $theme . '.' . ltrim($view, '.');

            if (view()->exists($themedView)) {
                return $themedView;
            }
        }

        return $view;
    }
}

if (! function_exists('themed_view')) {
    function themed_view(string $view, array $data = [], array $mergeData = [])
    {
        return view(themed_view_name($view), $data, $mergeData);
    }
}

if (! function_exists('theme_asset')) {
    function theme_asset(string $path): string
    {
        $normalizedPath = ltrim($path, '/');
        $theme = current_front_theme();

        if ($theme !== 'default') {
            $themedPath = 'themes/' . $theme . '/' . $normalizedPath;

            if (is_file(public_path($themedPath))) {
                return asset($themedPath);
            }
        }

        return asset($normalizedPath);
    }
}
