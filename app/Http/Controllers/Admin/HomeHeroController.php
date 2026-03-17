<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class HomeHeroController extends Controller
{
    public function index()
    {
        $heroSetting = (object) $this->defaultSetting();

        if (Schema::hasTable('home_hero_settings')) {
            $heroSetting = HomeHeroSetting::firstOrCreate(
                ['section' => 'home_hero'],
                $this->defaultSetting()
            );
        }

        return view('admin.hero.index', compact('heroSetting'));
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
            'button_link' => ['nullable', 'string', 'max:2048'],
            'button_target' => ['nullable', 'in:_self,_blank'],
            'background_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['show_booking_form'] = $request->boolean('show_booking_form');

        if ($request->hasFile('background_image')) {
            if (!empty($setting->background_image) && !str_starts_with($setting->background_image, 'img/')) {
                Storage::disk('public')->delete($setting->background_image);
            }

            $data['background_image'] = $request->file('background_image')->store('hero', 'public');
        }

        $setting->update([
            'show_booking_form' => $data['show_booking_form'],
            'small_title' => $data['small_title'] ?? $setting->small_title,
            'title' => $data['title'] ?? $setting->title,
            'button_link' => $data['button_link'] ?? $setting->button_link,
            'button_target' => $data['button_target'] ?? $setting->button_target,
            'background_image' => $data['background_image'] ?? $setting->background_image,
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Section Hero accueil mise à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'section' => 'home_hero',
            'show_booking_form' => true,
            'small_title' => 'Expérience hôtelière',
            'title' => 'Une expérience unique où séjourner',
            'button_link' => '/appartements',
            'button_target' => '_self',
            'background_image' => 'img/hero_home_1.jpg',
        ];
    }
}
