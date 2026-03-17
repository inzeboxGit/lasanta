<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SiteSettingController extends Controller
{
    public function index()
    {
        $siteSetting = $this->defaultSetting();

        if (Schema::hasTable('site_settings')) {
            $siteSetting = SiteSetting::firstOrCreate(
                ['setting_key' => 'general'],
                $this->databaseDefaults()
            );
        }

        return view('admin.settings.index', compact('siteSetting'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('site_settings')) {
            return redirect()->route('admin.settings.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_primary' => ['nullable', 'string', 'max:255'],
            'phone_secondary' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'whatsapp_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = SiteSetting::firstOrCreate(
            ['setting_key' => 'general'],
            $this->databaseDefaults()
        );

        $setting->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Paramètres mis à jour.');
    }

    private function defaultSetting(): array
    {
        return [
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
    }

    private function databaseDefaults(): array
    {
        $defaults = $this->defaultSetting();

        if (! Schema::hasColumn('site_settings', 'maintenance_message')) {
            unset($defaults['maintenance_message']);
        }

        return $defaults;
    }
}
