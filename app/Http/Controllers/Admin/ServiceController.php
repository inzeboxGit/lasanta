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

        if (!empty($service->pdf_file)) {
            Storage::disk('public')->delete($service->pdf_file);
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
            'pdf_file'    => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_pdf_file' => ['nullable', 'boolean'],
        ]);
    }

    private function fillService(Service $service, array $data, Request $request): void
    {
        if ($request->boolean('remove_image') && !empty($service->image) && !str_starts_with($service->image, 'img/')) {
            Storage::disk('public')->delete($service->image);
            $data['image'] = '';
        }

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

        if ($request->boolean('remove_pdf_file') && !empty($service->pdf_file)) {
            Storage::disk('public')->delete($service->pdf_file);
            $data['pdf_file'] = '';
            $data['button_link'] = '';
        }

        if ($request->hasFile('pdf_file')) {
            if (!empty($service->pdf_file)) {
                Storage::disk('public')->delete($service->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('services/pdf', 'public');
            $data['pdf_file'] = $pdfPath;
            // Use the media route strategy, same idea as images, to avoid OVH 403 on direct /storage links.
            $data['button_link'] = '/media/' . ltrim($pdfPath, '/');
        }

        $service->fill([
            'tab_key'     => $data['tab_key'],
            'subtitle'    => $data['subtitle'] ?? '',
            'title'       => $data['title'],
            'description' => $data['description'] ?? '',
            'button_link' => array_key_exists('button_link', $data) ? $data['button_link'] : ($service->button_link ?? ''),
            'button_text' => $data['button_text'] ?? '',
            'pdf_file'    => array_key_exists('pdf_file', $data) ? $data['pdf_file'] : ($service->pdf_file ?? ''),
            'icon'        => $data['icon'] ?? '',
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_published'=> !empty($data['is_published']),
            'image'       => array_key_exists('image', $data) ? $data['image'] : ($service->image ?? ''),
        ]);

        $service->save();
    }
}
