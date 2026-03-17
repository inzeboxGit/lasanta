<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocalAmenity;
use App\Models\LocalAmenitySectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class LocalAmenityController extends Controller
{
    public function index()
    {
        $comodites = LocalAmenity::orderBy('sort_order')->orderBy('id')->paginate(15);
        $sectionSetting = (object) [
            'header_image' => 'img/home_2.jpg',
            'subtitle' => 'RÉsidence Bella vista',
            'title' => 'Restaurant',
        ];

        if (Schema::hasTable('local_amenity_section_settings')) {
            $sectionSetting = LocalAmenitySectionSetting::firstOrCreate(
                ['section' => 'about_local_amenities'],
                [
                    'header_image' => 'img/home_2.jpg',
                    'subtitle' => 'RÉsidence Bella vista',
                    'title' => 'Restaurant',
                ]
            );
        }

        return view('admin.comodites.index', compact('comodites', 'sectionSetting'));
    }

    public function updateSectionSettings(Request $request)
    {
        if (!Schema::hasTable('local_amenity_section_settings')) {
            return redirect()->route('admin.comodites.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'header_image' => ['nullable', 'image', 'max:5120'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = LocalAmenitySectionSetting::firstOrCreate(
            ['section' => 'about_local_amenities'],
            [
                'header_image' => 'img/home_2.jpg',
                'subtitle' => 'RÉsidence Bella vista',
                'title' => 'Restaurant',
            ]
        );

        if ($request->hasFile('header_image')) {
            if (!empty($setting->header_image) && !str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('restaurant', 'public');
        }

        $setting->update([
            'header_image' => $data['header_image'] ?? $setting->header_image,
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title' => $data['title'] ?? $setting->title,
        ]);

        return redirect()->route('admin.comodites.index')->with('success', 'Paramètres Restaurant mis à jour.');
    }

    public function create()
    {
        return view('admin.comodites.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('local-amenities', 'public');
        }

        unset($data['image']);

        LocalAmenity::create($data);

        return redirect()->route('admin.comodites.index')->with('success', 'Élément restaurant créé.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.comodites.edit', $id);
    }

    public function edit(string $id)
    {
        $comodite = LocalAmenity::findOrFail($id);

        return view('admin.comodites.edit', compact('comodite'));
    }

    public function update(Request $request, string $id)
    {
        $comodite = LocalAmenity::findOrFail($id);
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            if (!empty($comodite->image_path) && !str_starts_with($comodite->image_path, 'img/')) {
                Storage::disk('public')->delete($comodite->image_path);
            }
            $data['image_path'] = $request->file('image')->store('local-amenities', 'public');
        }

        unset($data['image']);

        $comodite->update($data);

        return redirect()->route('admin.comodites.index')->with('success', 'Élément restaurant mis à jour.');
    }

    public function destroy(string $id)
    {
        $comodite = LocalAmenity::findOrFail($id);

        if (!empty($comodite->image_path) && !str_starts_with($comodite->image_path, 'img/')) {
            Storage::disk('public')->delete($comodite->image_path);
        }

        $comodite->delete();

        return redirect()->route('admin.comodites.index')->with('success', 'Élément restaurant supprimé.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
