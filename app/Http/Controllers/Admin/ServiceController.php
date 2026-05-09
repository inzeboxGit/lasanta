<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = collect();
        $editingService = null;

        if (Schema::hasTable('services')) {
            $services = Service::orderBy('sort_order')->orderBy('id')->get();

            $editingService = $request->filled('edit')
                ? Service::find($request->integer('edit'))
                : null;
        }

        return view('admin.services.index', compact('services', 'editingService'));
    }

    public function store(Request $request)
    {
        $data = $this->validateService($request);

        $service = new Service();
        $this->fillService($service, $data, $request);

        return redirect()->route('admin.services.index')->with('success', 'Service créé.');
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validateService($request, $service->id);
        $this->fillService($service, $data, $request);

        return redirect()->route('admin.services.index', ['edit' => $service->id])->with('success', 'Service mis à jour.');
    }

    public function destroy(Service $service)
    {
        if (!empty($service->image) && !str_starts_with($service->image, 'img/')) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service supprimé.');
    }

    private function validateService(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'tab_key'     => ['required', 'string', 'max:100', \Illuminate\Validation\Rule::unique('services', 'tab_key')->ignore($ignoreId)],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_published'=> ['nullable'],
            'image'       => ['nullable', 'image', 'max:5120'],
        ]);
    }

    private function fillService(Service $service, array $data, Request $request): void
    {
        if ($request->hasFile('image')) {
            if (!empty($service->image) && !str_starts_with($service->image, 'img/')) {
                Storage::disk('public')->delete($service->image);
            }

            $file = $request->file('image');
            $filename = 'services/' . Str::uuid() . '.jpg';
            $manager = new ImageManager(new Driver());
            $img = $manager->decode($file->getPathname());
            $img->cover(1000, 900);
            Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
            $data['image'] = $filename;
        }

        $service->fill([
            'tab_key'     => $data['tab_key'],
            'subtitle'    => $data['subtitle'] ?? '',
            'title'       => $data['title'],
            'description' => $data['description'] ?? '',
            'button_link' => $data['button_link'] ?? '',
            'button_text' => $data['button_text'] ?? '',
            'icon'        => $data['icon'] ?? '',
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_published'=> !empty($data['is_published']),
            'image'       => $data['image'] ?? ($service->image ?? ''),
        ]);

        $service->save();
    }
}
