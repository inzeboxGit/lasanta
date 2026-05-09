<?php

namespace App\Http\Controllers\Admin;

use App\Models\LocalAmenity;

class LocalAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_HOME;
    protected string $routePrefix = 'admin.comodites';
    protected string $pageTitle = 'Activites accueil';
    protected string $pageDescription = "Gerer les activites locales affichees sur la page d'accueil";
    protected string $itemLabelSingular = 'activite';
    protected string $itemLabelPlural = 'activites';
    protected ?string $emptyStateLabel = "Aucune activite d'accueil";

    protected ?array $sectionSettingConfig = [
        'panel_title'  => 'Titre de la section Activités',
        'section'      => 'home_activities',
        'subtitle'     => 'Nos activités',
        'title'        => 'Activités & Loisirs',
        'supports_hero_text' => false,
    ];
}
