<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSetting;
use App\Models\PageHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class HomeHeroController extends Controller
{
    public function index()
    {
        $heroSetting = (object) $this->defaultSetting();
        $homeVideoSetting = $this->defaultVideoSettingObject();
        $locales = config('content_translations.locales', ['fr' => 'Français']);

        if (Schema::hasTable('home_hero_settings')) {
            $heroSetting = HomeHeroSetting::firstOrCreate(
                ['section' => 'home_hero'],
                $this->defaultSetting()
            );
            $heroSetting->loadMissing('translations');
        }

        if (Schema::hasTable('page_header_settings')) {
            $homeVideoSetting = PageHeaderSetting::firstOrCreate(
                ['page' => 'home_video'],
                $this->defaultVideoSetting()
            );
        }

        return view('admin.hero.index', compact('heroSetting', 'homeVideoSetting', 'locales'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('home_hero_settings')) {
            return redirect()->route('admin.hero.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = HomeHeroSetting::firstOrCreate(
            ['section' => 'home_hero'],
            $this->defaultSetting()
        );

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'dates_label' => ['nullable', 'string', 'max:255'],
            'adults_label' => ['nullable', 'string', 'max:255'],
            'children_label' => ['nullable', 'string', 'max:255'],
            'search_label' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'button_target' => ['nullable', 'in:_self,_blank'],
            'background_type' => ['required', 'in:video,image'],
            'background_video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime', 'max:51200'],
            'youtube_video_url' => ['nullable', 'url', 'max:2048'],
            'background_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['show_booking_form'] = $request->boolean('show_booking_form');

        if ($request->hasFile('background_image')) {
            if (!empty($setting->background_image) && !str_starts_with($setting->background_image, 'img/')) {
                Storage::disk('public')->delete($setting->background_image);
            }

            $data['background_image'] = $request->file('background_image')->store('hero', 'public');
        }

        if ($request->hasFile('background_video')) {
            if (!empty($setting->background_video) && !str_starts_with($setting->background_video, 'video/')) {
                Storage::disk('public')->delete($setting->background_video);
            }

            $data['background_video'] = $request->file('background_video')->store('hero/video', 'public');
        }

        $setting->update([
            'show_booking_form' => $data['show_booking_form'],
            'small_title' => $data['small_title'] ?? $setting->small_title,
            'title' => $data['title'] ?? $setting->title,
            'dates_label' => $data['dates_label'] ?? $setting->dates_label,
            'adults_label' => $data['adults_label'] ?? $setting->adults_label,
            'children_label' => $data['children_label'] ?? $setting->children_label,
            'search_label' => $data['search_label'] ?? $setting->search_label,
            'button_link' => $data['button_link'] ?? $setting->button_link,
            'button_target' => $data['button_target'] ?? $setting->button_target,
            'background_type' => $data['background_type'] ?? ($setting->background_type ?? 'video'),
            'background_video' => $data['background_video'] ?? ($setting->background_video ?? 'video/sunset.mp4'),
            'youtube_video_url' => array_key_exists('youtube_video_url', $data) ? $data['youtube_video_url'] : $setting->youtube_video_url,
            'background_image' => $data['background_image'] ?? $setting->background_image,
        ]);

        $translatedFields = ['dates_label', 'adults_label', 'children_label', 'search_label'];
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

        return redirect()->route('admin.hero.index')->with('success', 'Section Hero accueil mise à jour.');
    }

    public function updateVideoSection(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.hero.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = PageHeaderSetting::firstOrCreate(
            ['page' => 'home_video'],
            $this->defaultVideoSetting()
        );

        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'header_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('home-video', 'public');
        }

        $setting->update([
            'subtitle' => array_key_exists('subtitle', $data) ? $data['subtitle'] : $setting->subtitle,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'header_image' => $data['header_image'] ?? $setting->header_image,
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Section image accueil mise à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'section' => 'home_hero',
            'show_booking_form' => true,
            'small_title' => '',
            'title' => '',
            'dates_label' => 'Arrivée / Départ',
            'adults_label' => 'Adultes',
            'children_label' => 'Enfants',
            'search_label' => 'Rechercher',
            'button_link' => '',
            'button_target' => '_self',
            'background_type' => 'video',
            'background_video' => '',
            'youtube_video_url' => null,
            'background_image' => '',
        ];
    }

    private function defaultVideoSetting(): array
    {
        return [
            'page' => 'home_video',
            'header_image' => 'img/video-background.png',
            'subtitle' => 'Expérience hôtelière',
            'title' => 'Profiter d un moment de détente',
            'hero_text' => '',
        ];
    }

    private function defaultVideoSettingObject(): object
    {
        return (object) $this->defaultVideoSetting();
    }
}
