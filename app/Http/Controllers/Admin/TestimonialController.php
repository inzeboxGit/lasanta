<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeaderSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->paginate(15);
        $testimonialSectionSetting = $this->resolveSectionSetting();

        return view('admin.testimonials.index', compact('testimonials', 'testimonialSectionSetting'));
    }

    public function updateSectionSettings(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.testimonials.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolveSectionSetting();
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'header_image' => ['nullable', 'image', 'max:5120'],
            'remove_header_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_header_image') && ! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
            Storage::disk('public')->delete($setting->header_image);
            $data['header_image'] = '';
        }

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $setting->update([
            'subtitle' => array_key_exists('subtitle', $data) ? $data['subtitle'] : $setting->subtitle,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'header_image' => array_key_exists('header_image', $data) ? $data['header_image'] : $setting->header_image,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Image de fond des témoignages mise à jour.');
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('testimonials', 'public');
        }

        unset($data['photo']);

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage créé.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.testimonials.edit', $id);
    }

    public function edit(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $this->validatedData($request);

        if ($request->boolean('remove_photo') && !empty($testimonial->photo_path) && !str_starts_with($testimonial->photo_path, 'img/')) {
            Storage::disk('public')->delete($testimonial->photo_path);
            $data['photo_path'] = null;
        }

        if ($request->hasFile('photo')) {
            if (!empty($testimonial->photo_path) && !str_starts_with($testimonial->photo_path, 'img/')) {
                Storage::disk('public')->delete($testimonial->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('testimonials', 'public');
        }

        unset($data['photo']);
        unset($data['remove_photo']);

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage mis à jour.');
    }

    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if (!empty($testimonial->photo_path) && !str_starts_with($testimonial->photo_path, 'img/')) {
            Storage::disk('public')->delete($testimonial->photo_path);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage supprimé.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'source' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'remove_photo' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function resolveSectionSetting(): object
    {
        $defaults = [
            'page' => 'testimonials',
            'header_image' => 'img/hero_home_1.jpg',
            'subtitle' => 'TÉMOIGNAGES',
            'title' => 'Ce que les clients disent',
            'hero_text' => '',
        ];

        if (! Schema::hasTable('page_header_settings')) {
            return (object) $defaults;
        }

        return PageHeaderSetting::firstOrCreate(
            ['page' => 'testimonials'],
            $defaults
        );
    }
}
