<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $siteSetting = (object) [
            'site_name' => 'Residence Bella Vista',
            'address' => "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA",
            'email' => 'info@residence-bellavista.com',
            'use_site_email_for_contact' => true,
            'contact_recipient_email' => null,
            'phone_primary' => '04 95 00 00 00',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
            'default_locale' => config('app.locale', 'fr'),
            'maintenance_enabled' => false,
            'maintenance_message' => 'Le site est temporairement indisponible pour cause de mise a jour.' . PHP_EOL . 'Merci de revenir un peu plus tard.',
            'footer_background_image' => '',
        ];

        try {
            if (Schema::hasTable('site_settings')) {
                $defaults = [
                    'site_name' => 'Residence Bella Vista',
                    'address' => "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA",
                    'email' => 'info@residence-bellavista.com',
                    'use_site_email_for_contact' => true,
                    'contact_recipient_email' => null,
                    'phone_primary' => '04 95 00 00 00',
                    'phone_secondary' => '',
                    'facebook_url' => '',
                    'instagram_url' => '',
                    'whatsapp_url' => '',
                    'twitter_url' => '',
                    'default_locale' => config('app.locale', 'fr'),
                    'maintenance_enabled' => false,
                    'footer_background_image' => '',
                ];

                if (! Schema::hasColumn('site_settings', 'use_site_email_for_contact')) {
                    unset($defaults['use_site_email_for_contact']);
                }

                if (! Schema::hasColumn('site_settings', 'contact_recipient_email')) {
                    unset($defaults['contact_recipient_email']);
                }

                if (! Schema::hasColumn('site_settings', 'default_locale')) {
                    unset($defaults['default_locale']);
                }

                if (! Schema::hasColumn('site_settings', 'footer_background_image')) {
                    unset($defaults['footer_background_image']);
                }

                $siteSetting = SiteSetting::firstOrCreate(
                    ['setting_key' => 'general'],
                    $defaults
                );

                if (method_exists($siteSetting, 'loadMissing')) {
                    $siteSetting->loadMissing('translations');
                }
            }
        } catch (Throwable $e) {
            // Keep default in-memory settings if DB is unavailable.
        }

        view()->share('siteSetting', $siteSetting);
    }
}
