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
}
