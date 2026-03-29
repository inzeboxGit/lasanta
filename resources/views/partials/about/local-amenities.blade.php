@php
$locale = app()->getLocale();
$labels = [
'fr' => [
'subtitle' => 'Résidence Bella Vista',
'title' => 'Commodités locales',
'desc' => 'Découvrez les restaurants, la nature et la culture autour de la résidence.',
'empty_title' => 'Commodités locales',
'empty_desc' => 'Aucune commodité locale publiée pour le moment.',
'fallback_alt' => 'Commodité locale',
],
'en' => [
'subtitle' => 'Residence Bella Vista',
'title' => 'Local amenities',
'desc' => 'Discover restaurants, nature, and culture around the residence.',
'empty_title' => 'Local amenities',
'empty_desc' => 'No local amenity published at the moment.',
'fallback_alt' => 'Local amenity',
],
'de' => [
'subtitle' => 'Residence Bella Vista',
'title' => 'Lokale Annehmlichkeiten',
'desc' => 'Entdecken Sie Restaurants, Natur und Kultur rund um die Residenz.',
'empty_title' => 'Lokale Annehmlichkeiten',
'empty_desc' => 'Derzeit keine lokalen Annehmlichkeiten veröffentlicht.',
'fallback_alt' => 'Lokale Annehmlichkeit',
],
'it' => [
'subtitle' => 'Residence Bella Vista',
'title' => 'Servizi locali',
'desc' => 'Scopri ristoranti, natura e cultura nei dintorni della residenza.',
'empty_title' => 'Servizi locali',
'empty_desc' => 'Nessun servizio locale pubblicato al momento.',
'fallback_alt' => 'Servizio locale',
],
];
$ui = $labels[$locale] ?? $labels['en'];
$amenities = collect($localComodites ?? [])->take(3)->values();
$fallbackImages = [
asset('img/local_amenities_1.jpg'),
asset('img/home_1.jpg'),
asset('img/local_amenities_3.jpg'),
];
@endphp

<div class="bg_white">
    <div class="container margin_120_95">
        <div>
            <div class="row justify-content-between">
                <div class="col-lg-5 fixed_title">
                    <div class="title">
                        <!-- <small>{{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? $ui['subtitle']) }}</small>
                        <h2>{{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? $ui['title']) }}</h2>
                        <p>{{ $amenities->first() && method_exists($amenities->first(), 't') ? $amenities->first()->t('description') : ($amenities->first()->description ?? $ui['desc']) }}</p> -->
                    </div>
                    <div class="list_ok">
                        <ul>
                            @forelse($amenities as $item)
                            <li data-cue="slideInUp" data-delay="{{ 200 + ($loop->index * 100) }}">
                                <h5>{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</h5>
                                <p>{{ method_exists($item, 't') ? $item->t('description') : $item->description }}</p>
                            </li>
                            @empty
                            <li>
                                <h5>{{ $ui['empty_title'] }}</h5>
                                <p>{{ $ui['empty_desc'] }}</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    @for($i = 0; $i < max(3, $amenities->count()); $i++)
                        @php
                        $amenity = $amenities->get($i);
                        $imageSrc = media_url($amenity?->image_path, $fallbackImages[$i] ?? 'img/home_1.jpg');
                        @endphp
                        <div data-cue="fadeIn" data-delay="500">
                            <figure><img src="{{ $imageSrc }}"
                                    alt="{{ ($amenity && method_exists($amenity, 't')) ? $amenity->t('title') : ($amenity->title ?? $ui['fallback_alt']) }}"
                                    class="img-fluid rounded-img"></figure>
                        </div>
                        @endfor
                </div>
            </div>
        </div>
    </div>
</div>