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
            'header_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $setting->update([
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title' => $data['title'] ?? $setting->title,
            'header_image' => $data['header_image'] ?? $setting->header_image,
        ]);

        return redirect()->route('admin.contact.index')->with('success', 'En-tête de la page contact mise à jour.');
    }

    private function resolveSetting(): object
    {
        $defaults = [
            'page' => 'contact',
            'subtitle' => 'Expérience hôtelière',
            'title' => 'Contact',
            'header_image' => 'img/hero_home_2.jpg',
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
