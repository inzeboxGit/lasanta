<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\AppartmentPageSetting;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        $appartmentPageSetting = (object) [
            'title' => 'Our Rooms & Suites',
            'subtitle' => 'Luxury Hotel Experience',
            'home_title' => 'Chambres et suites',
            'home_subtitle' => 'Expérience hôtelière',
            'header_image' => 'img/rooms/4.jpg',
        ];

        if (Schema::hasTable('appartment_page_settings')) {
            $defaults = [
                'title' => 'Our Rooms & Suites',
                'subtitle' => 'Luxury Hotel Experience',
                'header_image' => 'img/rooms/4.jpg',
            ];

            if (Schema::hasColumns('appartment_page_settings', ['home_title', 'home_subtitle'])) {
                $defaults['home_title'] = 'Chambres et suites';
                $defaults['home_subtitle'] = 'Expérience hôtelière';
            }

            $appartmentPageSetting = AppartmentPageSetting::firstOrCreate(
                ['page' => 'appartements'],
                $defaults
            );
        }

        return view('admin.rooms.index', compact('rooms', 'appartmentPageSetting'));
    }

    public function updatePageSettings(Request $request)
    {
        if (!Schema::hasTable('appartment_page_settings')) {
            return redirect()->route('admin.rooms.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = AppartmentPageSetting::firstOrCreate(
            ['page' => 'appartements'],
            [
                'title' => 'Our Rooms & Suites',
                'subtitle' => 'Luxury Hotel Experience',
                'header_image' => 'img/rooms/4.jpg',
            ]
        );

        $rules = [
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'header_image' => ['nullable', 'image', 'max:5120'],
        ];

        if (Schema::hasColumns('appartment_page_settings', ['home_title', 'home_subtitle'])) {
            $rules['home_title'] = ['nullable', 'string', 'max:255'];
            $rules['home_subtitle'] = ['nullable', 'string', 'max:255'];
        }

        $data = $request->validate($rules);

        if ($request->hasFile('header_image')) {
            if (!empty($setting->header_image) && !str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store('page-headers', 'public');
        }

        $payload = [
            'title' => $data['title'] ?? $setting->title,
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'header_image' => $data['header_image'] ?? $setting->header_image,
        ];

        if (Schema::hasColumns('appartment_page_settings', ['home_title', 'home_subtitle'])) {
            $payload['home_title'] = $data['home_title'] ?? $setting->home_title;
            $payload['home_subtitle'] = $data['home_subtitle'] ?? $setting->home_subtitle;
        }

        $setting->update($payload);

        return redirect()->route('admin.rooms.index')->with('success', 'En-tête de la page appartements mise à jour.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $amenities = Amenity::whereIn('scope', ['room', 'both'])
            ->orderBy('title')
            ->get();
        $selectedAmenities = [];

        return view('admin.rooms.create', compact('amenities', 'selectedAmenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'rooms/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->decode($file->getPathname());
            $img->cover(1550, 1080);
            Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
            $data['main_image'] = $filename;
        }

        // gallery_order contains existing images (empty on create), new uploads appended
        $gallery = $data['gallery_order'] ?? [];
        unset($data['gallery_order']);

        if ($request->hasFile('gallery')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('gallery') as $file) {
                $filename = 'rooms/' . Str::uuid() . '.jpg';
                $img = $manager->decode($file->getPathname());
                $img->cover(1550, 1080);
                Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
                $gallery[] = $filename;
            }
        }

        if (!empty($gallery)) {
            $data['gallery'] = $gallery;
        }

        $amenityIds = $data['amenities'] ?? [];
        unset($data['amenities']);

        $room = Room::create($data);
        $room->amenities()->sync($amenityIds);

        return redirect()->route('admin.rooms.edit', $room)->with('success', 'Chambre créée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.rooms.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $amenities = Amenity::whereIn('scope', ['room', 'both'])
            ->orderBy('title')
            ->get();
        $selectedAmenities = $room->amenities()->pluck('amenities.id')->all();
        $nextRoom = Room::where('id', '>', $room->id)->orderBy('id')->first();

        return view('admin.rooms.edit', compact('room', 'amenities', 'selectedAmenities', 'nextRoom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        $data = $this->validatedData($request, $room->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'rooms/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->decode($file->getPathname());
            $img->cover(1550, 1080);
            Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
            $data['main_image'] = $filename;
        }

        // gallery_order = ordered list of kept images (from hidden inputs)
        $keptGallery = $data['gallery_order'] ?? [];
        unset($data['gallery_order']);

        // Delete images that were removed by the user
        $oldGallery = $room->gallery ?? [];
        $removed = array_diff($oldGallery, $keptGallery);
        foreach ($removed as $path) {
            Storage::disk('public')->delete($path);
        }

        // Append newly uploaded images
        if ($request->hasFile('gallery')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('gallery') as $file) {
                $filename = 'rooms/' . Str::uuid() . '.jpg';
                $img = $manager->decode($file->getPathname());
                $img->cover(1550, 1080);
                Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
                $keptGallery[] = $filename;
            }
        }

        $data['gallery'] = !empty($keptGallery) ? array_values($keptGallery) : null;

        $amenityIds = $data['amenities'] ?? [];
        unset($data['amenities']);

        $room->update($data);
        $room->amenities()->sync($amenityIds);

        return redirect()->route('admin.rooms.edit', $room)->with('success', 'Chambre mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre supprimée.');
    }

    /**
     * Delete a single gallery image immediately via AJAX.
     */
    public function deleteGalleryImage(Request $request, Room $room)
    {
        $path = $request->input('path');
        $gallery = $room->gallery ?? [];

        if (($key = array_search($path, $gallery)) !== false) {
            unset($gallery[$key]);
            $room->update(['gallery' => array_values($gallery)]);
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image non trouvée.'], 404);
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $uniqueSlug = 'unique:rooms,slug';
        if ($ignoreId) {
            $uniqueSlug .= ',' . $ignoreId;
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'external_id' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $uniqueSlug],
            'price_per_night' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'checkin_info' => ['nullable', 'string'],
            'checkout_info' => ['nullable', 'string'],
            'special_instructions' => ['nullable', 'string'],
            'children_policy' => ['nullable', 'string'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => [
                'integer',
                Rule::exists('amenities', 'id')->where(fn ($query) => $query->whereIn('scope', ['room', 'both'])),
            ],
            'main_image' => ['nullable', 'image', 'max:10240'],
            'gallery.*' => ['nullable', 'image', 'max:5120'],
            'gallery_order' => ['nullable', 'array'],
            'gallery_order.*' => ['string'],
            'status' => ['required', 'in:draft,published'],
        ]);
    }
}
