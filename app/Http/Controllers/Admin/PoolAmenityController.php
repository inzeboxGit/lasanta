<?php

namespace App\Http\Controllers\Admin;

use App\Models\LocalAmenity;

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
        'subtitle' => 'RÉsidence Bella vista',
        'title' => 'Piscine',
        'hero_text' => 'Une parenthèse de détente à la Résidence Bella Vista.',
        'supports_hero_text' => true,
    ];
    protected ?array $aboutSectionConfig = [
        'section' => 'pool_about',
        'panel_title' => 'Section À propos Piscine',
        'small_title' => 'À PROPOS DE LA PISCINE',
        'title' => 'La Piscine Bella Vista',
        'lead' => 'Un espace de détente ouvert sur la résidence.',
        'description' => "Personnalisez ici le texte de présentation de la piscine, son ambiance et ses avantages pour les visiteurs.",
        'signature' => 'L’équipe de la Piscine',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
        'image_directory' => 'pool-about',
        'success_message' => 'Section À propos Piscine mise à jour.',
    ];

    protected ?array $extraTextSectionConfig = [
        'section' => 'pool_after_about',
        'panel_title' => 'Section après À propos Piscine',
        'subtitle' => '',
        'title' => '',
        'description' => '',
        'success_message' => 'Section après À propos Piscine mise à jour.',
    ];
}
