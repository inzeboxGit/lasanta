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
        $contactPageSetting = $this->resolveSetting();

        return view('admin.contact.index', compact('contactPageSetting'));
    }

    public function update(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.contact.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolveSetting();
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'availability_small' => ['nullable', 'string', 'max:255'],
            'availability_title' => ['nullable', 'string', 'max:255'],
            'availability_text' => ['nullable', 'string'],
            'map_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'map_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'header_image' => ['nullable', 'image', 'max:5120'],
        ]);

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
            'map_latitude' => array_key_exists('map_latitude', $data) ? $data['map_latitude'] : $setting->map_latitude,
            'map_longitude' => array_key_exists('map_longitude', $data) ? $data['map_longitude'] : $setting->map_longitude,
            'header_image' => $data['header_image'] ?? $setting->header_image,
        ]);

        return redirect()->route('admin.contact.index')->with('success', 'En-tête de la page contact mise à jour.');
    }

    private function resolveSetting(): object
    {
        $defaults = [
            'page' => 'contact',
            'subtitle' => '',
            'title' => '',
            'availability_small' => 'Residence Bella Vista',
            'availability_title' => 'Disponibilité',
            'availability_text' => 'Consultez les disponibilités et contactez-nous pour finaliser votre réservation.',
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
