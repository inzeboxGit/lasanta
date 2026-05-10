@php
$locale = app()->getLocale();
$labels = [
'fr' => [
'subtitle' => 'Résidence Hotel La Santa',
'title' => 'Commodités locales',
'desc' => 'Découvrez les restaurants, la nature et la culture autour de la résidence.',
'empty_title' => 'Commodités locales',
'empty_desc' => 'Aucune commodité locale publiée pour le moment.',
'fallback_alt' => 'Commodité locale',
],
'en' => [
'subtitle' => ' Hotel La Santa',
'title' => 'Local amenities',
'desc' => 'Discover restaurants, nature, and culture around the .',
'empty_title' => 'Local amenities',
'empty_desc' => 'No local amenity published at the moment.',
'fallback_alt' => 'Local amenity',
],
'de' => [
'subtitle' => ' Hotel La Santa',
'title' => 'Lokale Annehmlichkeiten',
'desc' => 'Entdecken Sie Restaurants, Natur und Kultur rund um die Residenz.',
'empty_title' => 'Lokale Annehmlichkeiten',
'empty_desc' => 'Derzeit keine lokalen Annehmlichkeiten veröffentlicht.',
'fallback_alt' => 'Lokale Annehmlichkeit',
],
'it' => [
'subtitle' => ' Hotel La Santa',
'title' => 'Servizi locali',
'desc' => 'Scopri ristoranti, natura e cultura nei dintorni della residenza.',
'empty_title' => 'Servizi locali',
'empty_desc' => 'Nessun servizio locale pubblicato al momento.',
'fallback_alt' => 'Servizio locale',
],
];
$ui = $labels[$locale] ?? $labels['en'];
$amenities = collect($localComodites ?? [])->take(3)->values();
$extraSubtitle = isset($restaurantExtraTextSectionSetting) && method_exists($restaurantExtraTextSectionSetting, 't')
? $restaurantExtraTextSectionSetting->t('small_title')
: ($restaurantExtraTextSectionSetting->small_title ?? '');
$extraTitle = isset($restaurantExtraTextSectionSetting) && method_exists($restaurantExtraTextSectionSetting, 't')
? $restaurantExtraTextSectionSetting->t('title')
: ($restaurantExtraTextSectionSetting->title ?? '');
$extraDescription = isset($restaurantExtraTextSectionSetting) && method_exists($restaurantExtraTextSectionSetting, 't')
? $restaurantExtraTextSectionSetting->t('description')
: ($restaurantExtraTextSectionSetting->description ?? '');
$fallbackImages = [
asset('img/local_amenities_1.jpg'),
asset('img/home_1.jpg'),
asset('img/local_amenities_3.jpg'),
];
@endphp

<div class="bg_white">
    <div class="container margin_120_0">
        <div>
            <div class="row justify-content-between">
                <div class="col-lg-5 fixed_title">
                    <div class="title">
                        @if(!empty($extraSubtitle))
                        <small>{{ $extraSubtitle }}</small>
                        @endif
                        @if(!empty($extraTitle))
                        <h3>{{ $extraTitle }}</h3>
                        @endif
                        @if(!empty($extraDescription))
                        <p>{{ $extraDescription }}</p>
                        @endif
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