<!-- Installation principales -->
@php
    $locale = app()->getLocale();
    $emptyLabels = [
        'fr' => 'Aucune installation publiée pour le moment.',
        'en' => 'No installation published at the moment.',
        'de' => 'Derzeit keine Installation veröffentlicht.',
        'it' => 'Nessuna installazione pubblicata al momento.',
    ];
    $emptyText = $emptyLabels[$locale] ?? $emptyLabels['en'];
    $fallbackSubtitle = [
        'fr' => 'Résidence Hotel La Santa',
        'en' => ' Hotel La Santa',
        'de' => ' Hotel La Santa',
        'it' => ' Hotel La Santa',
    ];
    $fallbackTitle = [
        'fr' => 'Installations principales',
        'en' => 'Main facilities',
        'de' => 'Hauptausstattungen',
        'it' => 'Servizi principali',
    ];
@endphp
<div class="title text-center mb-5">
    <small data-cue="slideInUp">{{ method_exists($installationSectionSetting, 't') ? $installationSectionSetting->t('subtitle') : ($installationSectionSetting->subtitle ?? ($fallbackSubtitle[$locale] ?? $fallbackSubtitle['en'])) }}</small>
    <h2 data-cue="slideInUp" data-delay="100">{{ method_exists($installationSectionSetting, 't') ? $installationSectionSetting->t('title') : ($installationSectionSetting->title ?? ($fallbackTitle[$locale] ?? $fallbackTitle['en'])) }}</h2>
</div>
<div class="row mt-4 installation">
    @forelse(($installations ?? collect()) as $installation)
        <div class="col-xl-3 col-md-6">
            <div class="box_facilities {{ $loop->first ? 'no-border' : '' }}" data-cue="slideInUp">
                @if($installation->image_path)
                    <div class="mb-3">
                        <img src="{{ media_url($installation->image_path) }}" alt="{{ method_exists($installation, 't') ? $installation->t('title') : $installation->title }}" class="img-fluid rounded-img">
                    </div>
                @endif
                @if($installation->icon)
                    <i class="{{ $installation->icon }}"></i>
                @endif
                <h3>{{ method_exists($installation, 't') ? $installation->t('title') : $installation->title }}</h3>
                <p>{{ method_exists($installation, 't') ? $installation->t('description') : $installation->description }}</p>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">{{ $emptyText }}</div>
    @endforelse
</div>
<!-- /Row -->
