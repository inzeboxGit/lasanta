@php
    $locale = app()->getLocale();
    $items = collect($installations ?? [])->values();

    $emptyLabels = [
        'fr' => 'Aucune installation publiée pour le moment.',
        'en' => 'No installation published at the moment.',
        'de' => 'Derzeit keine Installation veröffentlicht.',
        'it' => 'Nessuna installazione pubblicata al momento.',
    ];
    $emptyText = $emptyLabels[$locale] ?? $emptyLabels['en'];

    $fallbackSubtitle = [
        'fr' => 'iLasanta',
        'en' => 'iLasanta',
        'de' => 'iLasanta',
        'it' => 'iLasanta',
    ];
    $fallbackTitle = [
        'fr' => 'Installations principales',
        'en' => 'Main facilities',
        'de' => 'Hauptausstattungen',
        'it' => 'Servizi principali',
    ];

    $fallbackDescription = [
        'fr' => 'Découvrez les services et installations disponibles pour rendre votre séjour plus agréable.',
        'en' => 'Discover the services and amenities available to make your stay more enjoyable.',
        'de' => 'Entdecken Sie die Services und Ausstattungen, die Ihren Aufenthalt angenehmer machen.',
        'it' => 'Scopri i servizi e le dotazioni disponibili per rendere il tuo soggiorno piu piacevole.',
    ];

    $buttonLabels = [
        'fr' => 'Tous les appartements',
        'en' => 'All Apartments',
        'de' => 'Alle Apartments',
        'it' => 'Tutti gli appartamenti',
    ];

    $subtitle = (is_object($installationSectionSetting ?? null) && method_exists($installationSectionSetting, 't'))
        ? ($installationSectionSetting->t('subtitle') ?: ($fallbackSubtitle[$locale] ?? $fallbackSubtitle['en']))
        : (($installationSectionSetting->subtitle ?? null) ?: ($fallbackSubtitle[$locale] ?? $fallbackSubtitle['en']));

    $title = (is_object($installationSectionSetting ?? null) && method_exists($installationSectionSetting, 't'))
        ? ($installationSectionSetting->t('title') ?: ($fallbackTitle[$locale] ?? $fallbackTitle['en']))
        : (($installationSectionSetting->title ?? null) ?: ($fallbackTitle[$locale] ?? $fallbackTitle['en']));

    $description = (is_object($installationSectionSetting ?? null) && method_exists($installationSectionSetting, 't'))
        ? ($installationSectionSetting->t('description') ?: ($installationSectionSetting->description ?? null) ?: ($fallbackDescription[$locale] ?? $fallbackDescription['en']))
        : (($installationSectionSetting->description ?? null) ?: ($fallbackDescription[$locale] ?? $fallbackDescription['en']));
    $buttonLabel = $buttonLabels[$locale] ?? $buttonLabels['en'];
@endphp

<section class="amenities section-padding bg-lightbrown">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-12 mb-30">
                <div class="section-subtitle brown">{{ $subtitle }}</div>
                <div class="section-title black">{{ $title }}</div>
                <p class="mb-25">{{ $description }}</p>
                <a href="{{ route('appartements.index') }}" class="button-3">{{ $buttonLabel }}</a>
            </div>

            <div class="col-lg-8 col-md-12">
                <div class="row">
                    @forelse($items as $installation)
                        @php
                            $installationTitle = method_exists($installation, 't')
                                ? ($installation->t('title') ?: $installation->title)
                                : $installation->title;
                            $installationDescription = method_exists($installation, 't')
                                ? ($installation->t('description') ?: $installation->description)
                                : $installation->description;
                            $installationIconRaw = trim((string) ($installation->icon ?? ''));
                            $hasImageIcon = (bool) preg_match('/\.(png|jpe?g|gif|webp|svg)(\?.*)?$/i', $installationIconRaw);
                            $installationIconClass = $installationIconRaw !== '' ? $installationIconRaw : 'fa-thin fa-circle-check';
                            $installationIconSrc = null;

                            if ($hasImageIcon) {
                                $cleanIconPath = ltrim($installationIconRaw, '/');
                                if (str_starts_with($cleanIconPath, 'themes/lasanta/img/')) {
                                    $installationIconSrc = asset($cleanIconPath);
                                } elseif (str_starts_with($cleanIconPath, 'img/')) {
                                    $installationIconSrc = asset('themes/lasanta/' . $cleanIconPath);
                                } else {
                                    $installationIconSrc = asset('themes/lasanta/img/' . $cleanIconPath);
                                }
                            }
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="item hover-box mb-25">
                                <div class="cont up">
                                    <div class="icon">
                                        @if($installationIconSrc)
                                            <img src="{{ $installationIconSrc }}" alt="{{ $installationTitle }}" style="width: 46px; height: 46px; object-fit: contain; margin: 0 auto 15px; display: block;">
                                        @else
                                            <i class="{{ $installationIconClass }}"></i>
                                        @endif
                                    </div>
                                    <div class="text">
                                        <h5>{{ $installationTitle }}</h5>
                                        <p class="text-visible">{{ $installationDescription }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">{{ $emptyText }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>