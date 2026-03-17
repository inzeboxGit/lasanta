<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $aboutSetting = $this->defaultSetting();

        if (Schema::hasTable('about_section_settings')) {
            $aboutSetting = AboutSectionSetting::firstOrCreate(
                ['section' => 'home_about'],
                $this->defaultSetting()
            );
        }

        return view('admin.about.index', compact('aboutSetting'));
    }

    public function update(Request $request)
    {
        if (!Schema::hasTable('about_section_settings')) {
            return redirect()->route('admin.about.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = AboutSectionSetting::firstOrCreate(
            ['section' => 'home_about'],
            $this->defaultSetting()
        );

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'lead' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'signature' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'max:5120'],
            'overlay_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('main_image')) {
            if (!empty($setting->main_image) && !str_starts_with($setting->main_image, 'img/')) {
                Storage::disk('public')->delete($setting->main_image);
            }

            $data['main_image'] = $request->file('main_image')->store('about', 'public');
        }

        if ($request->hasFile('overlay_image')) {
            if (!empty($setting->overlay_image) && !str_starts_with($setting->overlay_image, 'img/')) {
                Storage::disk('public')->delete($setting->overlay_image);
            }

            $data['overlay_image'] = $request->file('overlay_image')->store('about', 'public');
        }

        $setting->update([
            'small_title' => $data['small_title'] ?? $setting->small_title,
            'title' => $data['title'] ?? $setting->title,
            'lead' => $data['lead'] ?? $setting->lead,
            'description' => $data['description'] ?? $setting->description,
            'signature' => $data['signature'] ?? $setting->signature,
            'main_image' => $data['main_image'] ?? $setting->main_image,
            'overlay_image' => $data['overlay_image'] ?? $setting->overlay_image,
        ]);

        return redirect()->route('admin.about.index')->with('success', 'Section À propos mise à jour.');
    }

    private function defaultSetting(): array
    {
        return [
            'small_title' => 'À PROPOS DE NOUS',
            'title' => 'La Résidence Bella Vista',
            'lead' => 'Une conception du tourisme...',
            'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
            'signature' => 'L’équipe du Bella Vista',
            'main_image' => 'img/home_2.jpg',
            'overlay_image' => 'img/home_1.jpg',
        ];
    }
}
