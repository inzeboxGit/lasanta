<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutSectionSetting;
use App\Models\LocalAmenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class RestaurantAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_RESTAURANT;
    protected string $routePrefix = 'admin.restaurant';
    protected string $pageTitle = 'Restaurant';
    protected string $pageDescription = 'Gerer la page Restaurant et ses elements affiches sur le front';
    protected string $itemLabelSingular = 'item menu restaurant';
    protected string $itemLabelPlural = 'items menu restaurant';
    protected ?string $emptyStateLabel = 'Aucun item menu restaurant';
    protected ?string $sectionSettingsSuccessMessage = 'Paramètres Restaurant mis à jour.';
    protected ?array $sectionSettingConfig = [
        'section' => 'about_local_amenities',
        'panel_title' => 'Paramètres de la page Restaurant',
        'header_image' => 'img/home_2.jpg',
        'subtitle' => '',
        'title' => '',
        'hero_text' => '',
        'supports_hero_text' => true,
    ];
    protected ?array $aboutSectionConfig = [
        'section' => 'restaurant_about',
        'panel_title' => 'Section À propos Restaurant',
        'small_title' => '',
        'title' => '',
        'lead' => '',
        'description' => '',
        'signature' => '',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
        'image_directory' => 'restaurant-about',
        'success_message' => 'Section À propos Restaurant mise à jour.',
    ];
    protected ?array $extraTextSectionConfig = [
        'section' => 'restaurant_after_about',
        'panel_title' => 'Section après À propos Restaurant',
        'subtitle' => '',
        'title' => '',
        'description' => '',
        'success_message' => 'Section après À propos Restaurant mise à jour.',
    ];

    public function updateGallerySectionSettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $request->validate([
            'subtitle'   => ['nullable', 'string', 'max:255'],
            'title'      => ['nullable', 'string', 'max:255'],
            'images.*'   => ['nullable', 'image', 'max:5120'],
        ]);

        $setting = $this->resolveRestaurantGallerySectionSetting();
        $gallery = $setting->gallery ?? [];

        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('images') as $file) {
                $img = $manager->decode($file);
                $img->cover(1080, 900);
                $filename = 'restaurant-gallery/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $img->encode(new JpegEncoder(90)));
                $gallery[] = $filename;
            }
        }

        $setting->update([
            'small_title' => $request->input('subtitle', $setting->small_title),
            'title'       => $request->input('title', $setting->title),
            'gallery'     => $gallery,
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Galerie Restaurant mise à jour.');
    }

    public function removeGalleryImage(Request $request)
    {
        $request->validate(['image' => ['required', 'string']]);

        $setting = $this->resolveRestaurantGallerySectionSetting();
        $gallery = $setting->gallery ?? [];
        $image   = $request->input('image');

        Storage::disk('public')->delete($image);
        $gallery = array_values(array_filter($gallery, fn ($img) => $img !== $image));
        $setting->update(['gallery' => $gallery]);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Image supprimée.');
    }

    protected function resolveRestaurantGallerySectionSetting(): object
    {
        $defaults = [
            'small_title' => 'Image Gallery',
            'title'       => 'Restaurant Gallery',
            'gallery'     => [],
        ];

        if (! Schema::hasTable('about_section_settings')) {
            return (object) $defaults;
        }

        return AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_gallery'],
            $defaults
        );
    }

    public function updateRestaurantInfoSectionSettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'lead' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'signature' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'string'],
        ]);

        $this->resolveRestaurantInfoSectionSetting()->update($data);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Informations pratiques Restaurant mises à jour.');
    }

    protected function viewData(array $extra = []): array
    {
        $data = parent::viewData(array_merge([
            'restaurantInfoSectionSetting'    => $this->resolveRestaurantInfoSectionSetting(),
            'restaurantGallerySectionSetting' => $this->resolveRestaurantGallerySectionSetting(),
        ], $extra));

        $data['pageMeta']['restaurant_info_section'] = [
            'enabled' => true,
            'title' => 'Informations pratiques Restaurant',
            'route' => 'admin.restaurant.info-section.update',
        ];

        $data['pageMeta']['restaurant_gallery_section'] = [
            'enabled'      => true,
            'title'        => 'Galerie Restaurant',
            'route'        => 'admin.restaurant.gallery-section.update',
            'remove_route' => 'admin.restaurant.gallery-image.remove',
        ];

        $data['pageMeta']['crud_labels'] = [
            'small_title' => 'Nom du plat',
            'title' => 'Titre de l’onglet',
            'sort_order' => 'Prix',
            'description' => 'Description du plat',
            'link_url' => 'Lien (optionnel laisse vide)',
            'image' => 'Image (optionnelle optionnel laisse vide)',
            'table_small_title' => 'Plat',
            'table_title' => 'Onglet',
            'table_sort_order' => 'Prix',
        ];

        return $data;
    }

    protected function resolveRestaurantInfoSectionSetting(): object
    {
        $defaults = [
            'small_title' => 'Hours',
            'title' => 'Dress Code',
            'lead' => "Breakfast: 7.00 am - 11.00 am (daily)\nLunch: 12.00 noon - 2.00 pm (daily)\nDinner: open from 6.30 pm, last order at 10.00 pm (daily)",
            'description' => 'Smart casual (no shorts, hats, or sandals permitted).',
            'signature' => 'Terrace',
            'main_image' => 'Open for drinks only.',
            'overlay_image' => '',
            'third_image' => '',
        ];

        if (! Schema::hasTable('about_section_settings')) {
            return (object) $defaults;
        }

        return AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_info_block'],
            $defaults
        );
    }
}
