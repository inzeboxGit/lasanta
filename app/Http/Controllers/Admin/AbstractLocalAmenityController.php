<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocalAmenity;
use App\Models\LocalAmenitySectionSetting;
use Illuminate\Http\Request;
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

    public function index()
    {
        $comodites = LocalAmenity::forDisplayContext($this->displayContext)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.comodites.index', $this->viewData([
            'comodites' => $comodites,
            'sectionSetting' => $this->resolveSectionSetting(),
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
            'subtitle' => $data['subtitle'] ?? $setting->subtitle,
            'title' => $data['title'] ?? $setting->title,
            'hero_text' => $this->supportsHeroText() ? ($data['hero_text'] ?? $setting->hero_text) : ($setting->hero_text ?? null),
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', $this->sectionSettingsSuccessMessage ?? "Paramètres {$this->itemLabelSingular} mis à jour.");
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
}
