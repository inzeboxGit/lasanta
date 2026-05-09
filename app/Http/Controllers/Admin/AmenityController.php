<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSectionSetting;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amenities = Amenity::whereIn('scope', ['room', 'both'])
            ->orderBy('title')
            ->paginate(15);

        $installations = Amenity::whereIn('scope', ['home', 'both'])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $activitesAboutSetting = (object) [
            'small_title' => 'Détente & Loisirs',
            'title' => 'À propos de nos activités',
            'description' => '',
            'main_image' => '',
            'overlay_image' => '',
            'third_image' => '',
        ];

        $activitesGallerySetting = (object) [
            'small_title' => 'Espace Loisirs',
            'title' => 'Galerie des Activités',
        ];

        if (Schema::hasTable('about_section_settings')) {
            $activitesAboutSetting = AboutSectionSetting::firstOrCreate(
                ['section' => 'activites_about'],
                [
                    'small_title' => 'Détente & Loisirs',
                    'title' => 'À propos de nos activités',
                ]
            );
            $activitesGallerySetting = AboutSectionSetting::firstOrCreate(
                ['section' => 'activites_gallery'],
                [
                    'small_title' => 'Espace Loisirs',
                    'title' => 'Galerie des Activités',
                ]
            );
        }

        return view('admin.amenities.index', compact('amenities', 'installations', 'activitesAboutSetting', 'activitesGallerySetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.amenities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        Amenity::create($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.amenities.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);

        return view('admin.amenities.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);
        $data = $this->validatedData($request, $amenity->id);
        $amenity->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $amenity = Amenity::whereIn('scope', ['room', 'both'])->findOrFail($id);
        $amenity->delete();

        return redirect()->route('admin.amenities.index')->with('success', 'Équipement supprimé.');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'scope' => ['required', 'in:room,both'],
        ]);
    }

    public function updateActivitesAbout(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route('admin.amenities.index')->with('success', 'Table indisponible.');
        }

        $data = $request->validate([
            'small_title'   => ['nullable', 'string', 'max:255'],
            'title'         => ['nullable', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'main_image'    => ['nullable', 'image', 'max:5120'],
            'overlay_image' => ['nullable', 'image', 'max:5120'],
            'third_image'   => ['nullable', 'image', 'max:5120'],
        ]);

        $setting = AboutSectionSetting::firstOrCreate(['section' => 'activites_about']);

        foreach (['main_image', 'overlay_image', 'third_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($setting->$field) {
                    Storage::disk('public')->delete($setting->$field);
                }
                $data[$field] = $request->file($field)->store('activites', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $setting->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Section contenu activités mise à jour.');
    }

    public function updateActivitesGallery(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route('admin.amenities.index')->with('success', 'Table indisponible.');
        }

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'title'       => ['nullable', 'string', 'max:255'],
        ]);

        $setting = AboutSectionSetting::firstOrCreate(
            ['section' => 'activites_gallery'],
            ['small_title' => 'Espace Loisirs', 'title' => 'Galerie des Activités']
        );
        $setting->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Section galerie activités mise à jour.');
    }
}
