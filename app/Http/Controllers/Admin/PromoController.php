<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeaderSetting;
use App\Models\PromoSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $promos = collect();
        $promoSetting = (object) $this->defaultSetting();
        $editingPromo = null;
        $promoHeaderSetting = (object) ['subtitle' => 'NOS OFFRES', 'title' => 'OFFRES SPÉCIALES', 'header_image' => ''];

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

        if (Schema::hasTable('page_header_settings')) {
            $promoHeaderSetting = PageHeaderSetting::firstOrCreate(
                ['page' => 'home_promo_section'],
                ['subtitle' => 'NOS OFFRES', 'title' => 'OFFRES SPÉCIALES', 'header_image' => '', 'hero_text' => '']
            );
        }

        return view('admin.promo.index', compact('promoSetting', 'promos', 'editingPromo', 'promoHeaderSetting'));
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

    public function updateSection(Request $request)
    {
        if (!Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.promo.index')->with('success', 'Table indisponible.');
        }

        $data = $request->validate([
            'subtitle'     => ['nullable', 'string', 'max:255'],
            'title'        => ['nullable', 'string', 'max:255'],
            'header_image' => ['nullable', 'image', 'max:5120'],
            'remove_header_image' => ['nullable', 'boolean'],
        ]);

        $setting = PageHeaderSetting::firstOrCreate(
            ['page' => 'home_promo_section'],
            ['subtitle' => 'NOS OFFRES', 'title' => 'OFFRES SPÉCIALES', 'header_image' => '', 'hero_text' => '']
        );

        if ($request->boolean('remove_header_image') && !empty($setting->header_image) && !str_starts_with($setting->header_image, 'img/')) {
            Storage::disk('public')->delete($setting->header_image);
            $data['header_image'] = '';
        }

        if ($request->hasFile('header_image')) {
            if (!empty($setting->header_image) && !str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }
            $manager = new ImageManager(new Driver());
            $img = $manager->decode($request->file('header_image'));
            $img->cover(1920, 600);
            $filename = 'promo-section/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
            $data['header_image'] = $filename;
        }

        $setting->update([
            'subtitle'     => $data['subtitle'] ?? $setting->subtitle,
            'title'        => $data['title'] ?? $setting->title,
            'header_image' => array_key_exists('header_image', $data) ? $data['header_image'] : $setting->header_image,
        ]);

        return redirect()->route('admin.promo.index')->with('success', 'En-tête de section Offres mis à jour.');
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
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        return $data;
    }

    private function fillPromo(PromoSectionSetting $setting, array $data, Request $request): void
    {
        $previousImage = $setting->image;

        if ($request->boolean('remove_image') && !empty($previousImage) && !str_starts_with($previousImage, 'img/')) {
            Storage::disk('public')->delete($previousImage);
            $data['image'] = '';
            $previousImage = '';
        }

        if ($request->hasFile('image')) {
            if (!empty($previousImage) && !str_starts_with($previousImage, 'img/')) {
                Storage::disk('public')->delete($previousImage);
            }

            $file = $request->file('image');
            $filename = 'promo/' . Str::uuid() . '.jpg';
            $manager = new ImageManager(new Driver());
            $img = $manager->decode($file->getPathname());
            $img->cover(1550, 1080);
            Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
            $data['image'] = $filename;
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
                'image' => array_key_exists('image', $data) ? $data['image'] : ($setting->image ?? ''),
            ]);
            $setting->save();

            if ($setting->is_enabled) {
                PromoSectionSetting::query()
                    ->where('section', $setting->section)
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
