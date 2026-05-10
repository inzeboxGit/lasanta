@php
    $locale = app()->getLocale();
    $labels = [
        'fr' => ['small' => 'Résidence Hotel La Santa', 'title' => 'Appartements similaires', 'from' => 'À partir de', 'per_night' => '€/nuit', 'on_request' => 'Tarif sur demande', 'empty' => 'Aucun appartement similaire pour le moment.'],
        'en' => ['small' => ' Hotel La Santa', 'title' => 'Similar apartments', 'from' => 'From', 'per_night' => 'EUR/night', 'on_request' => 'Price on request', 'empty' => 'No similar apartment at the moment.'],
        'de' => ['small' => ' Hotel La Santa', 'title' => 'Ähnliche Apartments', 'from' => 'Ab', 'per_night' => 'EUR/Nacht', 'on_request' => 'Preis auf Anfrage', 'empty' => 'Derzeit keine ähnlichen Apartments.'],
        'it' => ['small' => ' Hotel La Santa', 'title' => 'Appartamenti simili', 'from' => 'Da', 'per_night' => 'EUR/notte', 'on_request' => 'Prezzo su richiesta', 'empty' => 'Al momento nessun appartamento simile.'],
    ];
    $ui = $labels[$locale] ?? $labels['en'];
@endphp
<div class="container margin_120_95" id="similar_apparts_section">
    <div class="title mb-3">
        <small data-cue="slideInUp">{{ $ui['small'] }}</small>
        <h2 data-cue="slideInUp" data-delay="200">{{ $ui['title'] }}</h2>
    </div>

    @php
        $items = collect($similarRooms ?? [])->take(3)->values();
    @endphp

    @if($items->isNotEmpty())
        <div class="row add_bottom_90" data-cues="slideInUp" data-delay="300">
            @foreach($items as $similarRoom)
                @php
                    $img = !empty($similarRoom->main_image)
                        ? asset('storage/' . $similarRoom->main_image)
                        : asset('img/rooms/1.jpg');
                    $priceLabel = $similarRoom->price_per_night
                        ? $ui['from'] . ' ' . number_format($similarRoom->price_per_night, 0) . ' ' . $ui['per_night']
                        : $ui['on_request'];
                    $colClass = 'col-lg-4 col-md-6';
                @endphp
                <div class="{{ $colClass }} mb-4">
                    <a href="{{ route('rooms.show', $similarRoom->slug) }}" class="box_cat_rooms" style="height:auto;aspect-ratio:3/4;min-height:unset;">
                        <figure>
                            <div class="background-image" data-background="url({{ $img }})"></div>
                            <div class="info">
                                <small>{{ $priceLabel }}</small>
                                <h3>{{ method_exists($similarRoom, 't') ? $similarRoom->t('title') : $similarRoom->title }}</h3>
                            </div>
                        </figure>
                    </a>
                </div>
            @endforeach
            <!-- <p class="text-end"><a href="{{ route('appartements.index') }}" class="btn_1 outline mt-2">Voir tous les appartements</a></p> -->
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center text-muted">{{ $ui['empty'] }}</div>
        </div>
    @endif
</div>
