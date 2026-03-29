<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSectionSetting;
use App\Models\LocalAmenity;
use App\Models\LocalAmenitySectionSetting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

abstract class AbstractLocalAmenityController extends Controller
{
    protected string $displayContext = LocalAmenity::CONTEXT_HOME;
    protected string $routePrefix;
    protected string $pageTitle;
    protected string $pageDescription;
    protected string $itemLabelSingular;
    protected string $itemLabelPlural;
    protected string $linkPlaceholder = '/restaurant';
    protected string $sectionImageDirectory = 'restaurant';
    protected ?string $emptyStateLabel = null;
    protected ?string $sectionSettingsSuccessMessage = null;
    protected ?array $sectionSettingConfig = null;
    protected ?array $aboutSectionConfig = null;
    protected ?array $extraTextSectionConfig = null;

    public function index()
    {
        $comodites = LocalAmenity::forDisplayContext($this->displayContext)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.comodites.index', $this->viewData([
            'comodites' => $comodites,
            'sectionSetting' => $this->resolveSectionSetting(),
            'aboutSectionSetting' => $this->resolveAboutSectionSetting(),
            'extraTextSectionSetting' => $this->resolveExtraTextSectionSetting(),
        ]));
    }

    public function updateSectionSettings(Request $request)
    {
        abort_unless($this->hasSectionSettings(), 404);

        if (! Schema::hasTable('local_amenity_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'header_image' => ['nullable', 'image', 'max:5120'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'hero_text' => $this->supportsHeroText() ? ['nullable', 'string'] : ['nullable'],
        ]);

        $setting = $this->resolveSectionSetting();

        if ($request->hasFile('header_image')) {
            if (! empty($setting->header_image) && ! str_starts_with($setting->header_image, 'img/')) {
                Storage::disk('public')->delete($setting->header_image);
            }

            $data['header_image'] = $request->file('header_image')->store($this->sectionImageDirectory, 'public');
        }

        $setting->update([
            'header_image' => $data['header_image'] ?? $setting->header_image,
            'subtitle' => array_key_exists('subtitle', $data) ? $data['subtitle'] : $setting->subtitle,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'hero_text' => $this->supportsHeroText()
                ? (array_key_exists('hero_text', $data) ? $data['hero_text'] : $setting->hero_text)
                : ($setting->hero_text ?? null),
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', $this->sectionSettingsSuccessMessage ?? "Paramètres {$this->itemLabelSingular} mis à jour.");
    }

    public function updateAboutSectionSettings(Request $request)
    {
        abort_unless($this->hasAboutSectionSettings(), 404);

        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolveAboutSectionSetting();
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
            if (! empty($setting->main_image) && ! str_starts_with($setting->main_image, 'img/')) {
                Storage::disk('public')->delete($setting->main_image);
            }

            $data['main_image'] = $this->storeResizedImage($request->file('main_image'), $this->aboutSectionConfig['image_directory'] ?? 'about', 600, 730);
        }

        if ($request->hasFile('overlay_image')) {
            if (! empty($setting->overlay_image) && ! str_starts_with($setting->overlay_image, 'img/')) {
                Storage::disk('public')->delete($setting->overlay_image);
            }

            $data['overlay_image'] = $this->storeResizedImage($request->file('overlay_image'), $this->aboutSectionConfig['image_directory'] ?? 'about', 600, 830);
        }

        $setting->update([
            'small_title' => array_key_exists('small_title', $data) ? $data['small_title'] : $setting->small_title,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'lead' => array_key_exists('lead', $data) ? $data['lead'] : $setting->lead,
            'description' => array_key_exists('description', $data) ? $data['description'] : $setting->description,
            'signature' => array_key_exists('signature', $data) ? $data['signature'] : $setting->signature,
            'main_image' => $data['main_image'] ?? $setting->main_image,
            'overlay_image' => $data['overlay_image'] ?? $setting->overlay_image,
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', $this->aboutSectionConfig['success_message'] ?? "Section À propos {$this->itemLabelSingular} mise à jour.");
    }

    public function updateExtraTextSectionSettings(Request $request)
    {
        abort_unless($this->hasExtraTextSectionSettings(), 404);

        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolveExtraTextSectionSetting();
        $data = $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $setting->update([
            'small_title' => array_key_exists('subtitle', $data) ? $data['subtitle'] : $setting->small_title,
            'title' => array_key_exists('title', $data) ? $data['title'] : $setting->title,
            'description' => array_key_exists('description', $data) ? $data['description'] : $setting->description,
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', $this->extraTextSectionConfig['success_message'] ?? "Section texte {$this->itemLabelSingular} mise à jour.");
    }

    public function create()
    {
        return view('admin.comodites.create', $this->viewData());
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['display_context'] = $this->displayContext;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('local-amenities', 'public');
        }

        unset($data['image']);

        LocalAmenity::create($data);

        return redirect()->route($this->indexRouteName())
            ->with('success', "{$this->itemLabelSingular} créé.");
    }

    public function show(string $id)
    {
        return redirect()->route($this->editRouteName(), $id);
    }

    public function edit(string $id)
    {
        $comodite = $this->findItemOrFail($id);

        return view('admin.comodites.edit', $this->viewData([
            'comodite' => $comodite,
        ]));
    }

    public function update(Request $request, string $id)
    {
        $comodite = $this->findItemOrFail($id);
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            if (! empty($comodite->image_path) && ! str_starts_with($comodite->image_path, 'img/')) {
                Storage::disk('public')->delete($comodite->image_path);
            }

            $data['image_path'] = $request->file('image')->store('local-amenities', 'public');
        }

        unset($data['image']);

        $comodite->update($data);

        return redirect()->route($this->indexRouteName())
            ->with('success', "{$this->itemLabelSingular} mis à jour.");
    }

    public function destroy(string $id)
    {
        $comodite = $this->findItemOrFail($id);

        if (! empty($comodite->image_path) && ! str_starts_with($comodite->image_path, 'img/')) {
            Storage::disk('public')->delete($comodite->image_path);
        }

        $comodite->delete();

        return redirect()->route($this->indexRouteName())
            ->with('success', "{$this->itemLabelSingular} supprimé.");
    }

    protected function viewData(array $extra = []): array
    {
        return array_merge([
            'pageMeta' => [
                'title' => $this->pageTitle,
                'description' => $this->pageDescription,
                'item_label_singular' => $this->itemLabelSingular,
                'item_label_plural' => $this->itemLabelPlural,
                'empty_label' => $this->emptyStateLabel ?? "Aucun {$this->itemLabelSingular}",
                'link_placeholder' => $this->linkPlaceholder,
                'routes' => [
                    'index' => $this->indexRouteName(),
                    'create' => $this->createRouteName(),
                    'store' => $this->storeRouteName(),
                    'edit' => $this->editRouteName(),
                    'update' => $this->updateRouteName(),
                    'destroy' => $this->destroyRouteName(),
                    'section_settings' => $this->sectionSettingsRouteName(),
                ],
                'section_settings' => [
                    'enabled' => $this->hasSectionSettings(),
                    'title' => $this->sectionSettingConfig['panel_title'] ?? '',
                    'show_hero_text' => $this->supportsHeroText(),
                ],
                'about_section' => [
                    'enabled' => $this->hasAboutSectionSettings(),
                    'title' => $this->aboutSectionConfig['panel_title'] ?? '',
                    'route' => $this->aboutSectionSettingsRouteName(),
                ],
                'extra_text_section' => [
                    'enabled' => $this->hasExtraTextSectionSettings(),
                    'title' => $this->extraTextSectionConfig['panel_title'] ?? '',
                    'route' => $this->extraTextSectionSettingsRouteName(),
                ],
            ],
        ], $extra);
    }

    protected function resolveSectionSetting(): object
    {
        if (! $this->hasSectionSettings()) {
            return (object) [];
        }

        $defaults = $this->sectionSettingDefaults();

        if (Schema::hasTable('local_amenity_section_settings')) {
            return LocalAmenitySectionSetting::firstOrCreate(
                ['section' => $this->sectionSettingConfig['section']],
                $defaults
            );
        }

        return (object) $defaults;
    }

    protected function hasSectionSettings(): bool
    {
        return $this->sectionSettingConfig !== null;
    }

    protected function resolveAboutSectionSetting(): object
    {
        if (! $this->hasAboutSectionSettings()) {
            return (object) [];
        }

        $defaults = $this->aboutSectionDefaults();

        if (Schema::hasTable('about_section_settings')) {
            return AboutSectionSetting::firstOrCreate(
                ['section' => $this->aboutSectionConfig['section']],
                $defaults
            );
        }

        return (object) $defaults;
    }

    protected function hasAboutSectionSettings(): bool
    {
        return $this->aboutSectionConfig !== null;
    }

    protected function resolveExtraTextSectionSetting(): object
    {
        if (! $this->hasExtraTextSectionSettings()) {
            return (object) [];
        }

        $defaults = $this->extraTextSectionDefaults();

        if (Schema::hasTable('about_section_settings')) {
            return AboutSectionSetting::firstOrCreate(
                ['section' => $this->extraTextSectionConfig['section']],
                $defaults
            );
        }

        return (object) $defaults;
    }

    protected function hasExtraTextSectionSettings(): bool
    {
        return $this->extraTextSectionConfig !== null;
    }

    protected function aboutSectionDefaults(): array
    {
        return [
            'small_title' => $this->aboutSectionConfig['small_title'] ?? 'À PROPOS DE NOUS',
            'title' => $this->aboutSectionConfig['title'] ?? 'La Résidence Bella Vista',
            'lead' => $this->aboutSectionConfig['lead'] ?? 'Une conception du tourisme...',
            'description' => $this->aboutSectionConfig['description'] ?? "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
            'signature' => $this->aboutSectionConfig['signature'] ?? 'L’équipe du Bella Vista',
            'main_image' => $this->aboutSectionConfig['main_image'] ?? 'img/home_2.jpg',
            'overlay_image' => $this->aboutSectionConfig['overlay_image'] ?? 'img/home_1.jpg',
        ];
    }

    protected function extraTextSectionDefaults(): array
    {
        return [
            'small_title' => $this->extraTextSectionConfig['subtitle'] ?? '',
            'title' => $this->extraTextSectionConfig['title'] ?? '',
            'lead' => '',
            'description' => $this->extraTextSectionConfig['description'] ?? '',
            'signature' => '',
            'main_image' => '',
            'overlay_image' => '',
        ];
    }

    protected function sectionSettingDefaults(): array
    {
        return [
            'header_image' => $this->sectionSettingConfig['header_image'] ?? 'img/home_2.jpg',
            'subtitle' => $this->sectionSettingConfig['subtitle'] ?? 'Residence Bella Vista',
            'title' => $this->sectionSettingConfig['title'] ?? $this->pageTitle,
            'hero_text' => $this->sectionSettingConfig['hero_text'] ?? null,
        ];
    }

    protected function supportsHeroText(): bool
    {
        return (bool) ($this->sectionSettingConfig['supports_hero_text'] ?? false);
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
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

    protected function findItemOrFail(string $id): LocalAmenity
    {
        return LocalAmenity::forDisplayContext($this->displayContext)->findOrFail($id);
    }

    protected function indexRouteName(): string
    {
        return "{$this->routePrefix}.index";
    }

    protected function createRouteName(): string
    {
        return "{$this->routePrefix}.create";
    }

    protected function storeRouteName(): string
    {
        return "{$this->routePrefix}.store";
    }

    protected function editRouteName(): string
    {
        return "{$this->routePrefix}.edit";
    }

    protected function updateRouteName(): string
    {
        return "{$this->routePrefix}.update";
    }

    protected function destroyRouteName(): string
    {
        return "{$this->routePrefix}.destroy";
    }

    protected function sectionSettingsRouteName(): ?string
    {
        return $this->hasSectionSettings()
            ? "{$this->routePrefix}.section-settings.update"
            : null;
    }

    protected function aboutSectionSettingsRouteName(): ?string
    {
        return $this->hasAboutSectionSettings()
            ? "{$this->routePrefix}.about-section-settings.update"
            : null;
    }

    protected function extraTextSectionSettingsRouteName(): ?string
    {
        return $this->hasExtraTextSectionSettings()
            ? "{$this->routePrefix}.extra-text-section-settings.update"
            : null;
    }

    protected function storeResizedImage(UploadedFile $file, string $directory, int $width, int $height): string
    {
        $path = $file->store($directory, 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $this->cropImageToSize($absolutePath, $width, $height);

        return $path;
    }

    protected function cropImageToSize(string $path, int $targetWidth, int $targetHeight): void
    {
        if (! file_exists($path)) {
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
