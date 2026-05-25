<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ContactPageController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.settings.index');
    }

    public function update(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.settings.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        // Accept French decimal format (comma) from admin inputs.
        $request->merge([
            'map_latitude' => $this->normalizeCoordinate($request->input('map_latitude')),
            'map_longitude' => $this->normalizeCoordinate($request->input('map_longitude')),
        ]);

        $setting = $this->resolveSetting();
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'availability_small' => ['nullable', 'string', 'max:255'],
            'availability_title' => ['nullable', 'string', 'max:255'],
            'availability_text' => ['nullable', 'string'],
            'info_booking_label' => ['nullable', 'string', 'max:255'],
            'select_room_label' => ['nullable', 'string', 'max:255'],
            'adults_label' => ['nullable', 'string', 'max:255'],
            'children_label' => ['nullable', 'string', 'max:255'],
            'book_now_label' => ['nullable', 'string', 'max:255'],
            'map_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'map_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'header_image' => ['nullable', 'image', 'max:5120'],
            'remove_header_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_header_image') && ! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
            Storage::disk('public')->delete($setting->header_image);
            $data['header_image'] = '';
        }

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $setting->update([
            'subtitle' => array_key_exists('subtitle', $data) ? $data['subtitle'] : $setting->subtitle,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'availability_small' => array_key_exists('availability_small', $data) ? $data['availability_small'] : $setting->availability_small,
            'availability_title' => array_key_exists('availability_title', $data) ? $data['availability_title'] : $setting->availability_title,
            'availability_text' => array_key_exists('availability_text', $data) ? $data['availability_text'] : $setting->availability_text,
            'info_booking_label' => array_key_exists('info_booking_label', $data) ? $data['info_booking_label'] : $setting->info_booking_label,
            'select_room_label' => array_key_exists('select_room_label', $data) ? $data['select_room_label'] : $setting->select_room_label,
            'adults_label' => array_key_exists('adults_label', $data) ? $data['adults_label'] : $setting->adults_label,
            'children_label' => array_key_exists('children_label', $data) ? $data['children_label'] : $setting->children_label,
            'book_now_label' => array_key_exists('book_now_label', $data) ? $data['book_now_label'] : $setting->book_now_label,
            'map_latitude' => array_key_exists('map_latitude', $data) ? $data['map_latitude'] : $setting->map_latitude,
            'map_longitude' => array_key_exists('map_longitude', $data) ? $data['map_longitude'] : $setting->map_longitude,
            'header_image' => array_key_exists('header_image', $data) ? $data['header_image'] : $setting->header_image,
        ]);

        $translatedFields = [
            'info_booking_label',
            'select_room_label',
            'adults_label',
            'children_label',
            'book_now_label',
        ];
        $translationPayload = $request->input('translations', []);
        $locales = array_keys(config('content_translations.locales', ['fr' => 'Français']));

        foreach ($translationPayload as $locale => $fields) {
            if ($locale === 'fr' || ! in_array($locale, $locales, true) || ! is_array($fields)) {
                continue;
            }

            foreach ($translatedFields as $field) {
                $setting->setTranslation($field, $locale, $fields[$field] ?? null);
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'En-tête de la page contact mise à jour.');
    }

    private function normalizeCoordinate(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $normalized = str_replace([',', ' '], ['.', ''], trim($value));

        return $normalized === '' ? null : $normalized;
    }

    private function resolveSetting(): object
    {
        $defaults = [
            'page' => 'contact',
            'subtitle' => '',
            'title' => '',
            'availability_small' => ' Hotel La Santa',
            'availability_title' => 'Disponibilité',
            'availability_text' => 'Consultez les disponibilités et contactez-nous pour finaliser votre réservation.',
            'info_booking_label' => 'Infos et réservations',
            'select_room_label' => 'Sélectionner un appartement',
            'adults_label' => 'Adultes',
            'children_label' => 'Enfants',
            'book_now_label' => 'Réserver maintenant',
            'map_latitude' => 42.6043096,
            'map_longitude' => 8.9295210,
            'header_image' => '',
        ];

        if (! Schema::hasTable('page_header_settings')) {
            return (object) $defaults;
        }

        return PageHeaderSetting::firstOrCreate(
            ['page' => 'contact'],
            $defaults
        );
    }
}
