<!-- COMMODITÉS LOCALES -->
@php
    $locale = app()->getLocale();
    $labels = [
        'fr' => ['small' => 'Commodités locales', 'read_more' => 'Lire plus', 'empty' => 'Aucune commodité locale publiée.'],
        'en' => ['small' => 'Local amenities', 'read_more' => 'Read more', 'empty' => 'No local amenity published.'],
        'de' => ['small' => 'Lokale Annehmlichkeiten', 'read_more' => 'Mehr lesen', 'empty' => 'Keine lokalen Annehmlichkeiten veröffentlicht.'],
        'nl' => ['small' => 'Lokale voorzieningen', 'read_more' => 'Lees meer', 'empty' => 'Geen lokale voorziening gepubliceerd.'],
    ];
    $ui = $labels[$locale] ?? $labels['en'];
@endphp
<div class="bg_white">
    <div class="container margin_120_95">
        @forelse(($localComodites ?? collect()) as $comodite)
            @php
                $isEven = $loop->iteration % 2 === 0;
                $rowClass = $isEven ? 'row justify-content-between d-flex align-items-center' : 'row justify-content-between d-flex align-items-center add_bottom_90';
                $imageColClass = $isEven ? 'col-lg-6 order-lg-2' : 'col-lg-6';
                $contentColClass = $isEven ? 'col-lg-5 order-lg-1' : 'col-lg-5';

                $imageSrc = media_url($comodite->image_path);
            @endphp
            <div class="{{ $rowClass }}">
                <div class="{{ $imageColClass }}">
                    <div class="pinned-image rounded_container pinned-image--small mb-4">
                        <div class="pinned-image__container">
                            @if($imageSrc)
                                <img src="{{ $imageSrc }}" alt="{{ method_exists($comodite, 't') ? $comodite->t('title') : $comodite->title }}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="{{ $contentColClass }}">
                    <div class="title">
                        <small>{{ strtoupper($ui['small']) }}</small>
                        <h3>{{ method_exists($comodite, 't') ? $comodite->t('title') : $comodite->title }}</h3>
                        <p>{{ method_exists($comodite, 't') ? $comodite->t('description') : $comodite->description }}</p>
                        @if(!empty($comodite->link_url))
                            <p><a href="{{ $comodite->link_url }}" class="btn_1 mt-1 outline">{{ $ui['read_more'] }}</a></p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /row-->
        @empty
            <div class="row">
                <div class="col-12 text-center text-muted">{{ $ui['empty'] }}</div>
            </div>
        @endforelse
    </div>
    <!-- /container-->
</div>
<!-- /bg_white -->
