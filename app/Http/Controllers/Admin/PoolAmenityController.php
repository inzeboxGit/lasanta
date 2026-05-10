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

class PoolAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_POOL;
    protected string $routePrefix = 'admin.pool';
    protected string $pageTitle = 'Piscine';
    protected string $pageDescription = 'Gerer la page Piscine et ses elements affiches sur le front';
    protected string $itemLabelSingular = 'élément piscine';
    protected string $itemLabelPlural = 'éléments piscine';
    protected string $linkPlaceholder = '/piscine';
    protected string $sectionImageDirectory = 'pool';
    protected ?string $emptyStateLabel = 'Aucun élément piscine';
    protected ?string $sectionSettingsSuccessMessage = 'Paramètres Piscine mis à jour.';
    protected ?array $sectionSettingConfig = [
        'section' => 'about_pool_amenities',
        'panel_title' => 'Paramètres de la page Piscine',
        'header_image' => 'img/home_2.jpg',
        'subtitle' => 'RÉsidence Hotel La Santa',
        'title' => 'Piscine',
        'hero_text' => 'Une parenthèse de détente à la Résidence Hotel La Santa.',
        'supports_hero_text' => true,
    ];
    //upload piscine about section config
    protected ?array $aboutSectionConfig = [
        'section' => 'pool_about',
        'panel_title' => 'Section À propos Piscine',
        'small_title' => 'À PROPOS DE LA PISCINE',
        'title' => 'La Piscine Hotel La Santa',
        'lead' => 'Un espace de détente ouvert sur la résidence.',
        'description' => "Personnalisez ici le texte de présentation de la piscine, son ambiance et ses avantages pour les visiteurs.",
        'signature' => 'L’équipe de la Piscine',
        'main_image' => 'img/home_2.jpg',
        'main_image_dimensions' => ['width' => 1920, 'height' => 1080],
        'overlay_image' => 'img/home_1.jpg',
        'image_directory' => 'pool-about',
        'success_message' => 'Section À propos Piscine mise à jour.',
    ];

    protected ?array $extraTextSectionConfig = null;

    protected ?array $secondaryExtraSectionConfig = null;

    // ── Gallery ─────────────────────────────────────────────────────────────

    public function updateGallerySectionSettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $request->validate([
            'subtitle' => ['nullable', 'string', 'max:255'],
            'title'    => ['nullable', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:5120'],
        ]);

        $setting = $this->resolvePoolGallerySectionSetting();
        $gallery = $setting->gallery ?? [];

        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('images') as $file) {
                $img = $manager->decode($file);
                $img->cover(1080, 900);
                $filename = 'pool-gallery/' . Str::random(40) . '.jpg';
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
            ->with('success', 'Galerie Piscine mise à jour.');
    }

    public function removeGalleryImage(Request $request)
    {
        $request->validate(['image' => ['required', 'string']]);

        $setting = $this->resolvePoolGallerySectionSetting();
        $gallery = $setting->gallery ?? [];
        $image   = $request->input('image');

        Storage::disk('public')->delete($image);
        $gallery = array_values(array_filter($gallery, fn ($img) => $img !== $image));
        $setting->update(['gallery' => $gallery]);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Image supprimée.');
    }

    protected function resolvePoolGallerySectionSetting(): object
    {
        $defaults = [
            'small_title' => 'Galerie Photos',
            'title'       => 'Piscine Gallery',
            'gallery'     => [],
        ];

        if (! Schema::hasTable('about_section_settings')) {
            return (object) $defaults;
        }

        return AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_gallery'],
            $defaults
        );
    }

    // ── Info block ───────────────────────────────────────────────────────────

    public function updatePoolInfoSectionSettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'lead'        => ['nullable', 'string'],
            'title'       => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'signature'   => ['nullable', 'string', 'max:255'],
            'main_image'  => ['nullable', 'string'],
        ]);

        $this->resolvePoolInfoSectionSetting()->update($data);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Informations pratiques Piscine mises à jour.');
    }

    protected function resolvePoolInfoSectionSetting(): object
    {
        $defaults = [
            'small_title' => 'Horaires',
            'title'       => 'Règles',
            'lead'        => "Ouverture : 8h00 – 20h00 (tous les jours)\nFermeture hivernale : octobre – avril",
            'description' => 'Respectez les règles d\'hygiène et de sécurité affichées au bord de la piscine.',
            'signature'   => 'Services inclus',
            'main_image'  => 'Accès piscine inclus dans le séjour. Transats et parasols disponibles.',
        ];

        if (! Schema::hasTable('about_section_settings')) {
            return (object) $defaults;
        }

        return AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_info_block'],
            $defaults
        );
    }

    // ── viewData ─────────────────────────────────────────────────────────────

    protected function viewData(array $extra = []): array
    {
        $data = parent::viewData(array_merge([
            'poolInfoSectionSetting'    => $this->resolvePoolInfoSectionSetting(),
            'poolGallerySectionSetting' => $this->resolvePoolGallerySectionSetting(),
        ], $extra));

        $data['pageMeta']['pool_info_section'] = [
            'enabled' => true,
            'title'   => 'Informations pratiques Piscine',
            'route'   => 'admin.pool.info-section.update',
        ];

        $data['pageMeta']['pool_gallery_section'] = [
            'enabled'      => true,
            'title'        => 'Galerie Piscine',
            'route'        => 'admin.pool.gallery-section.update',
            'remove_route' => 'admin.pool.gallery-image.remove',
        ];

        $data['pageMeta']['crud_labels'] = [
            'small_title'       => 'Intitulé court',
            'title'             => 'Catégorie',
            'sort_order'        => 'Ordre',
            'description'       => 'Description',
            'link_url'          => 'Lien (optionnel)',
            'image'             => 'Image (optionnelle)',
            'table_small_title' => 'Intitulé',
            'table_title'       => 'Catégorie',
            'table_sort_order'  => 'Ordre',
        ];

        return $data;
    }
}
