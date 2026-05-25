<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeaderSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $siteSetting = $this->defaultSetting();
        $contactPageSetting = (object) $this->defaultContactPageSetting();
        $locales = config('content_translations.locales', ['fr' => 'Français']);
        $supportsFooterBackgroundImage = Schema::hasTable('site_settings')
            && Schema::hasColumn('site_settings', 'footer_background_image');

        if (Schema::hasTable('site_settings')) {
            $siteSetting = SiteSetting::firstOrCreate(
                ['setting_key' => 'general'],
                $this->databaseDefaults()
            );
        }

        if (Schema::hasTable('page_header_settings')) {
            $contactPageSetting = PageHeaderSetting::firstOrCreate(
                ['page' => 'contact'],
                $this->defaultContactPageSetting()
            );

            if (method_exists($contactPageSetting, 'loadMissing')) {
                $contactPageSetting->loadMissing('translations');
            }
        }

        return view('admin.settings.index', compact('siteSetting', 'contactPageSetting', 'locales', 'supportsFooterBackgroundImage'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('site_settings')) {
            return redirect()->route('admin.settings.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $supportsFooterBackgroundImage = Schema::hasColumn('site_settings', 'footer_background_image');

        $rules = [
            'site_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'contact_recipient_email' => ['nullable', 'email', 'max:255'],
            'phone_primary' => ['nullable', 'string', 'max:255'],
            'phone_secondary' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'whatsapp_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
            'default_locale' => ['nullable', 'string', 'max:10'],
            'custom_head_scripts' => ['nullable', 'string'],
        ];

        if ($supportsFooterBackgroundImage) {
            $rules['footer_background_image'] = ['nullable', 'image', 'max:5120'];
            $rules['remove_footer_background_image'] = ['nullable', 'boolean'];
        }

        $data = $request->validate($rules);

        $locales = array_keys(config('content_translations.locales', ['fr' => 'Français']));
        $data['use_site_email_for_contact'] = $request->boolean('use_site_email_for_contact');

        if (! in_array($data['default_locale'] ?: config('app.locale', 'fr'), $locales, true)) {
            return back()->withErrors(['default_locale' => 'Langue par défaut invalide.'])->withInput();
        }

        $data['default_locale'] = $data['default_locale'] ?: config('app.locale', 'fr');

        if ($data['use_site_email_for_contact']) {
            $data['contact_recipient_email'] = null;
        }

        $setting = SiteSetting::firstOrCreate(
            ['setting_key' => 'general'],
            $this->databaseDefaults()
        );

        if ($supportsFooterBackgroundImage && $request->boolean('remove_footer_background_image') && ! empty($setting->footer_background_image) && ! str_starts_with($setting->footer_background_image, 'img/')) {
            Storage::disk('public')->delete($setting->footer_background_image);
            $data['footer_background_image'] = '';
        }

        if ($supportsFooterBackgroundImage && $request->hasFile('footer_background_image')) {
            if (! empty($setting->footer_background_image) && ! str_starts_with($setting->footer_background_image, 'img/')) {
                Storage::disk('public')->delete($setting->footer_background_image);
            }

            $data['footer_background_image'] = $request->file('footer_background_image')->store('site-settings', 'public');
        }

        unset($data['remove_footer_background_image']);

        $setting->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Paramètres mis à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'site_name' => '',
            'address' => '',
            'email' => '',
            'use_site_email_for_contact' => true,
            'contact_recipient_email' => null,
            'phone_primary' => '',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
            'default_locale' => config('app.locale', 'fr'),
            'front_theme' => 'default',
            'maintenance_enabled' => false,
            'maintenance_message' => '',
            'custom_head_scripts' => '',
            'footer_background_image' => '',
        ];
    }

    private function databaseDefaults(): array
    {
        $defaults = $this->defaultSetting();

        if (! Schema::hasColumn('site_settings', 'maintenance_message')) {
            unset($defaults['maintenance_message']);
        }

        if (! Schema::hasColumn('site_settings', 'use_site_email_for_contact')) {
            unset($defaults['use_site_email_for_contact']);
        }

        if (! Schema::hasColumn('site_settings', 'contact_recipient_email')) {
            unset($defaults['contact_recipient_email']);
        }

        if (! Schema::hasColumn('site_settings', 'default_locale')) {
            unset($defaults['default_locale']);
        }

        if (! Schema::hasColumn('site_settings', 'front_theme')) {
            unset($defaults['front_theme']);
        }

        if (! Schema::hasColumn('site_settings', 'custom_head_scripts')) {
            unset($defaults['custom_head_scripts']);
        }

        if (! Schema::hasColumn('site_settings', 'footer_background_image')) {
            unset($defaults['footer_background_image']);
        }

        return $defaults;
    }

    private function availableFrontThemes(): array
    {
        $themes = ['default' => 'Thème actuel'];
        $themesPath = resource_path('views/themes');

        if (! is_dir($themesPath)) {
            return $themes;
        }

        $entries = scandir($themesPath) ?: [];

        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            if (! preg_match('/^[a-z0-9_-]+$/i', $entry)) {
                continue;
            }

            if (! is_dir($themesPath . DIRECTORY_SEPARATOR . $entry)) {
                continue;
            }

            $key = strtolower($entry);

            if ($key === 'default') {
                continue;
            }

            $label = ucwords(str_replace(['-', '_'], ' ', $key));
            $themes[$key] = $label;
        }

        ksort($themes);

        if (isset($themes['default'])) {
            $defaultLabel = $themes['default'];
            unset($themes['default']);
            $themes = ['default' => $defaultLabel] + $themes;
        }

        return $themes;
    }

    private function defaultContactPageSetting(): array
    {
        return [
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
    }
}
