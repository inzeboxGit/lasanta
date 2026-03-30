<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use HasFactory, HasContentTranslations;

    public const PAGE_PRIVACY = 'privacy';
    public const PAGE_TERMS = 'terms';

    protected $fillable = [
        'page',
        'header_title',
        'header_subtitle',
        'header_background_color',
        'body',
    ];

    public static function labels(): array
    {
        return [
            self::PAGE_PRIVACY => 'Confidentialité',
            self::PAGE_TERMS => 'Conditions',
        ];
    }

    public static function fileNameFor(string $page, string $locale): string
    {
        return match ($page) {
            self::PAGE_PRIVACY => "privacy_{$locale}.html",
            self::PAGE_TERMS => "terms_{$locale}.html",
            default => throw new \InvalidArgumentException("Unsupported legal page [{$page}]"),
        };
    }

    public static function defaultBody(string $page, string $locale = 'fr'): string
    {
        $path = resource_path('content/legal/' . static::fileNameFor($page, $locale));

        if (file_exists($path)) {
            return (string) file_get_contents($path);
        }

        if ($locale !== 'en') {
            return static::defaultBody($page, 'en');
        }

        return '';
    }
}
