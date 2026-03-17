<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\InstallationSectionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Amenity::whereIn('scope', ['home', 'both'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        $sectionSetting = (object) [
            'subtitle' => 'RÉsidence Bella vista',
            'title' => 'Installations principales',
        ];

        if (Schema::hasTable('installation_section_settings')) {
            $sectionSetting = InstallationSectionSetting::firstOrCreate(
                ['section' => 'home_installations'],
                [
                    'subtitle' => 'RÉsidence Bella vista',
                    'title' => 'Installations principales',
                ]
            );
        }

        return view('admin.installations.index', compact('installations', 'sectionSetting'));
    }

    public function updateSectionSettings(Request $request)
    {
        if (!Schema::hasTable('installation_section_settings')) {
            return redirect()->route('admin.installations.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = InstallationSectionSetting::firstOrCreate(
            ['section' => 'home_installations'],
            [
                'subtitle' => 'RÉsidence Bella vista',
                'title' => 'Installations principales',
            ]
        );

        $setting->update([
            'title' => $data['title'] ?? $setting->title,
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
        ]);

        return redirect()->route('admin.installations.index')->with('success', 'Titre et sous-titre des installations mis à jour.');
    }

    public function create()
    {
        return view('admin.installations.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('installations', 'public');
        }

        unset($data['image']);

        Amenity::create($data);

        return redirect()->route('admin.installations.index')->with('success', 'Installation créée.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.installations.edit', $id);
    }

    public function edit(string $id)
    {
        $installation = Amenity::whereIn('scope', ['home', 'both'])->findOrFail($id);

        return view('admin.installations.edit', compact('installation'));
    }

    public function update(Request $request, string $id)
    {
        $installation = Amenity::whereIn('scope', ['home', 'both'])->findOrFail($id);
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            if (!empty($installation->image_path)) {
                Storage::disk('public')->delete($installation->image_path);
            }
            $data['image_path'] = $request->file('image')->store('installations', 'public');
        }

        unset($data['image']);

        $installation->update($data);

        return redirect()->route('admin.installations.index')->with('success', 'Installation mise à jour.');
    }

    public function destroy(string $id)
    {
        $installation = Amenity::whereIn('scope', ['home', 'both'])->findOrFail($id);

        if (!empty($installation->image_path)) {
            Storage::disk('public')->delete($installation->image_path);
        }

        $installation->delete();

        return redirect()->route('admin.installations.index')->with('success', 'Installation supprimée.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'scope' => ['required', 'in:home,both'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
