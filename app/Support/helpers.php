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
                : asset(ltrim($fallback, '/'));
        }

        $path = ltrim($path, '/');

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (str_starts_with($path, 'img/') || str_starts_with($path, 'video/') || str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (public_storage_is_available()) {
            return Storage::disk('public')->url($path);
        }

        return url('media/' . $path);
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
