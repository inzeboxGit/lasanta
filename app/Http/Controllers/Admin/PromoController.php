<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $promos = collect();
        $promoSetting = (object) $this->defaultSetting();
        $editingPromo = null;

        if (Schema::hasTable('promo_section_settings')) {
            $promos = PromoSectionSetting::query()
                ->latest('is_enabled')
                ->latest('updated_at')
                ->latest('id')
                ->get();

            $editingPromo = $request->filled('edit')
                ? PromoSectionSetting::find($request->integer('edit'))
                : null;

            if ($editingPromo) {
                $promoSetting = $editingPromo;
            }
        }

        return view('admin.promo.index', compact('promoSetting', 'promos', 'editingPromo'));
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('promo_section_settings')) {
            return redirect()->route('admin.promo.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $this->validatePromo($request);
        $setting = new PromoSectionSetting();
        $setting->section = 'home_promo';

        $this->fillPromo($setting, $data, $request);

        return redirect()->route('admin.promo.index')->with('success', 'Promo créée.');
    }

    public function update(Request $request, PromoSectionSetting $promo)
    {
        if (!Schema::hasTable('promo_section_settings')) {
            return redirect()->route('admin.promo.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $this->validatePromo($request);
        $this->fillPromo($promo, $data, $request);

        return redirect()->route('admin.promo.index', ['edit' => $promo->id])->with('success', 'Promo mise à jour.');
    }

    public function destroy(PromoSectionSetting $promo)
    {
        if (!Schema::hasTable('promo_section_settings')) {
            return redirect()->route('admin.promo.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        if (!empty($promo->image) && !str_starts_with($promo->image, 'img/')) {
            Storage::disk('public')->delete($promo->image);
        }

        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo supprimée.');
    }

    private function validatePromo(Request $request): array
    {
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['nullable', 'string'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        return $data;
    }

    private function fillPromo(PromoSectionSetting $setting, array $data, Request $request): void
    {
        $previousImage = $setting->image;

        if ($request->hasFile('image')) {
            if (!empty($previousImage) && !str_starts_with($previousImage, 'img/')) {
                Storage::disk('public')->delete($previousImage);
            }

            $data['image'] = $request->file('image')->store('promo', 'public');
        }

        DB::transaction(function () use ($setting, $data) {
            $setting->fill([
                'section' => $setting->section ?: 'home_promo',
                'is_enabled' => $data['is_enabled'],
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'subtitle' => $data['subtitle'] ?? '',
                'title' => $data['title'] ?? '',
                'text' => $data['text'] ?? '',
                'button_link' => $data['button_link'] ?? '',
                'button_text' => $data['button_text'] ?? '',
                'image' => $data['image'] ?? ($setting->image ?? ''),
            ]);
            $setting->save();

            if ($setting->is_enabled) {
                PromoSectionSetting::query()
                    ->whereKeyNot($setting->id)
                    ->where('is_enabled', true)
                    ->update(['is_enabled' => false]);
            }
        });
    }

    private function defaultSetting(): array
    {
        return [
            'section' => 'home_promo',
            'is_enabled' => false,
            'start_date' => null,
            'end_date' => null,
            'subtitle' => '',
            'title' => '',
            'text' => '',
            'button_link' => '',
            'button_text' => '',
            'image' => '',
        ];
    }
}
