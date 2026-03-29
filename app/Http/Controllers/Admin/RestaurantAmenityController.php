<?php

namespace App\Http\Controllers\Admin;

use App\Models\LocalAmenity;

class RestaurantAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_RESTAURANT;
    protected string $routePrefix = 'admin.restaurant';
    protected string $pageTitle = 'Restaurant';
    protected string $pageDescription = 'Gerer la page Restaurant et ses elements affiches sur le front';
    protected string $itemLabelSingular = 'élément restaurant';
    protected string $itemLabelPlural = 'éléments restaurant';
    protected ?string $emptyStateLabel = 'Aucun élément restaurant';
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
}
