<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MaintenanceController extends Controller
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

        return view('admin.maintenance.index', compact('siteSetting'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('site_settings')) {
            return redirect()->route('admin.maintenance.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $supportsMaintenanceMessage = Schema::hasColumn('site_settings', 'maintenance_message');

        $data = $request->validate([
            'maintenance_enabled' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string'],
        ]);

        $setting = SiteSetting::firstOrCreate(
            ['setting_key' => 'general'],
            $this->databaseDefaults()
        );

        $payload = [
            'maintenance_enabled' => $request->boolean('maintenance_enabled'),
        ];

        if ($supportsMaintenanceMessage) {
            $payload['maintenance_message'] = $data['maintenance_message'] ?? null;
        }

        $setting->update($payload);

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance du site mise à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'site_name' => '',
            'address' => '',
            'email' => '',
            'phone_primary' => '',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
            'maintenance_enabled' => false,
            'maintenance_message' => '',
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
