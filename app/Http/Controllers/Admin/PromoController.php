<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index()
    {
        $promoSetting = (object) $this->defaultSetting();

        if (Schema::hasTable('promo_section_settings')) {
            $promoSetting = PromoSectionSetting::firstOrCreate(
                ['section' => 'home_promo'],
                $this->defaultSetting()
            );
        }

        return view('admin.promo.index', compact('promoSetting'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('promo_section_settings')) {
            return redirect()->route('admin.promo.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = PromoSectionSetting::firstOrCreate(
            ['section' => 'home_promo'],
            $this->defaultSetting()
        );

        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['nullable', 'string'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        if ($request->hasFile('image')) {
            if (!empty($setting->image) && !str_starts_with($setting->image, 'img/')) {
                Storage::disk('public')->delete($setting->image);
            }

            $data['image'] = $request->file('image')->store('promo', 'public');
        }

        $setting->update([
            'is_enabled' => $data['is_enabled'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title' => $data['title'] ?? $setting->title,
            'text' => $data['text'] ?? $setting->text,
            'button_link' => $data['button_link'] ?? $setting->button_link,
            'image' => $data['image'] ?? $setting->image,
        ]);

        return redirect()->route('admin.promo.index')->with('success', 'Section promo mise à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'section' => 'home_promo',
            'is_enabled' => true,
            'start_date' => null,
            'end_date' => null,
            'subtitle' => '',
            'title' => '',
            'text' => '',
            'button_link' => '',
            'image' => '',
        ];
    }
}
