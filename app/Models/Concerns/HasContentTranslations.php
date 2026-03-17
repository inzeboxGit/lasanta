<?php

namespace App\Models\Concerns;

use App\Models\ContentTranslation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasContentTranslations
{
    public function translations(): MorphMany
    {
        return $this->morphMany(ContentTranslation::class, 'translatable');
    }

    public function t(string $field, ?string $locale = null, string $fallbackLocale = 'fr'): ?string
    {
        $locale = $locale ?: app()->getLocale();

        if ($locale === 'fr') {
            return $this->{$field};
        }

        $value = $this->getTranslationValue($field, $locale);
        if ($value !== null && $value !== '') {
            return $value;
        }

        if ($fallbackLocale === 'fr') {
            return $this->{$field};
        }

        $fallback = $this->getTranslationValue($field, $fallbackLocale);
        if ($fallback !== null && $fallback !== '') {
            return $fallback;
        }

        return $this->{$field};
    }

    public function setTranslation(string $field, string $locale, ?string $value): void
    {
        if ($locale === 'fr') {
            $this->{$field} = $value;
            $this->save();
            return;
        }

        $value = is_string($value) ? trim($value) : $value;

        if ($value === null || $value === '') {
            $this->translations()
                ->where('locale', $locale)
                ->where('field', $field)
                ->delete();
            return;
        }

        $this->translations()->updateOrCreate(
            [
                'locale' => $locale,
                'field' => $field,
            ],
            [
                'value' => $value,
            ]
        );
    }

    private function getTranslationValue(string $field, string $locale): ?string
    {
        if ($this->relationLoaded('translations')) {
            $match = $this->translations->first(function ($item) use ($field, $locale) {
                return $item->field === $field && $item->locale === $locale;
            });

            return $match?->value;
        }

        return $this->translations()
            ->where('field', $field)
            ->where('locale', $locale)
            ->value('value');
    }
}
