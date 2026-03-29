<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSectionSetting;
use Illuminate\Http\UploadedFile;
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

            $data['main_image'] = $this->storeResizedImage($request->file('main_image'), 'about');
        }

        if ($request->hasFile('overlay_image')) {
            if (!empty($setting->overlay_image) && !str_starts_with($setting->overlay_image, 'img/')) {
                Storage::disk('public')->delete($setting->overlay_image);
            }

            $data['overlay_image'] = $this->storeResizedImage($request->file('overlay_image'), 'about');
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
            'small_title' => '',
            'title' => '',
            'lead' => '',
            'description' => "",
            'signature' => '',
            'main_image' => '',
            'overlay_image' => '',
        ];
    }

    private function storeResizedImage(UploadedFile $file, string $directory): string
    {
        // upload 600, 750
        $path = $file->store($directory, 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $this->cropImageToSize($absolutePath, 600, 750);

        return $path;
    }

    private function cropImageToSize(string $path, int $targetWidth, int $targetHeight): void
    {
        if (!file_exists($path)) {
            return;
        }

        $imageInfo = @getimagesize($path);

        if ($imageInfo === false) {
            return;
        }

        [$originalWidth, $originalHeight] = $imageInfo;
        $mime = $imageInfo['mime'] ?? null;

        if ($originalWidth <= 0 || $originalHeight <= 0 || $mime === null) {
            return;
        }

        $source = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/gif' => @imagecreatefromgif($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };

        if ($source === false) {
            return;
        }

        $scale = max($targetWidth / $originalWidth, $targetHeight / $originalHeight);
        $resizedWidth = max(1, (int) round($originalWidth * $scale));
        $resizedHeight = max(1, (int) round($originalHeight * $scale));
        $destinationX = (int) floor(($targetWidth - $resizedWidth) / 2);
        $destinationY = (int) floor(($targetHeight - $resizedHeight) / 2);

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if (in_array($mime, ['image/png', 'image/gif', 'image/webp'], true)) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);
        }

        imagecopyresampled(
            $canvas,
            $source,
            $destinationX,
            $destinationY,
            0,
            0,
            $resizedWidth,
            $resizedHeight,
            $originalWidth,
            $originalHeight
        );

        match ($mime) {
            'image/jpeg', 'image/jpg' => imagejpeg($canvas, $path, 85),
            'image/png' => imagepng($canvas, $path, 6),
            'image/gif' => imagegif($canvas, $path),
            'image/webp' => function_exists('imagewebp') ? imagewebp($canvas, $path, 85) : false,
            default => false,
        };

        imagedestroy($source);
        imagedestroy($canvas);
    }
}
