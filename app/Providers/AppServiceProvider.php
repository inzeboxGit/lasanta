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
            'email' => 'info@residencebellavista.fr',
            'phone_primary' => '04 95 00 00 00',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
            'maintenance_enabled' => false,
            'maintenance_message' => 'Le site est temporairement indisponible pour cause de mise a jour.' . PHP_EOL . 'Merci de revenir un peu plus tard.',
        ];

        try {
            if (Schema::hasTable('site_settings')) {
                $siteSetting = SiteSetting::firstOrCreate(
                    ['setting_key' => 'general'],
                    [
                        'site_name' => 'Residence Bella Vista',
                        'address' => "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA",
                        'email' => 'info@residencebellavista.fr',
                        'phone_primary' => '04 95 00 00 00',
                        'phone_secondary' => '',
                        'facebook_url' => '',
                        'instagram_url' => '',
                        'whatsapp_url' => '',
                        'twitter_url' => '',
                        'maintenance_enabled' => false,
                    ]
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
