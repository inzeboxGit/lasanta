@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $headerImage = media_url($room->main_image ?? null, 'themes/lasanta/img/restaurant/3.jpg');
    $locale = app()->getLocale();
    $ui = [
        'fr' => [
            'banner_subtitle'       => 'Expérience hôtelière',
            'section_subtitle'      => 'Expérience premium',
            'checkin'               => 'Arrivée',
            'checkout'              => 'Départ',
            'special_instructions'  => 'Instructions spéciales à l\'arrivée',
            'children'              => 'Enfants et lits supplémentaires',
            'equipment'             => 'Équipements',
            'no_amenity'            => 'Aucune commodité renseignée.',
            'back'                  => 'Retour aux appartements',
            'suggestions'           => 'Suggestions',
            'similar'               => 'Appartements similaires',
            'gallery_subtitle'      => 'Photos de la chambre',
        ],
        'en' => [
            'banner_subtitle'       => 'Hotel Experience',
            'section_subtitle'      => 'Luxury Experience',
            'checkin'               => 'Check-in',
            'checkout'              => 'Check-out',
            'special_instructions'  => 'Special check-in instructions',
            'children'              => 'Children and extra beds',
            'equipment'             => 'Room Equipment',
            'no_amenity'            => 'No amenities listed.',
            'back'                  => 'Back to apartments',
            'suggestions'           => 'Suggestions',
            'similar'               => 'Similar apartments',
            'gallery_subtitle'      => 'Room Images',
        ],
        'de' => [
            'banner_subtitle'       => 'Hotelerlebnis',
            'section_subtitle'      => 'Luxuserlebnis',
            'checkin'               => 'Check-in',
            'checkout'              => 'Check-out',
            'special_instructions'  => 'Besondere Check-in-Hinweise',
            'children'              => 'Kinder und Zustellbetten',
            'equipment'             => 'Zimmerausstattung',
            'no_amenity'            => 'Keine Ausstattung angegeben.',
            'back'                  => 'Zurück zu den Apartments',
            'suggestions'           => 'Vorschläge',
            'similar'               => 'Ähnliche Apartments',
            'gallery_subtitle'      => 'Zimmerbilder',
        ],
        'it' => [
            'banner_subtitle'       => 'Esperienza alberghiera',
            'section_subtitle'      => 'Esperienza di lusso',
            'checkin'               => 'Check-in',
            'checkout'              => 'Check-out',
            'special_instructions'  => 'Istruzioni speciali per il check-in',
            'children'              => 'Bambini e letti aggiuntivi',
            'equipment'             => 'Dotazioni della camera',
            'no_amenity'            => 'Nessun servizio indicato.',
            'back'                  => 'Torna agli appartamenti',
            'suggestions'           => 'Suggerimenti',
            'similar'               => 'Appartamenti simili',
            'gallery_subtitle'      => 'Immagini della camera',
        ],
    ][$locale] ?? [
        'banner_subtitle'       => 'Expérience hôtelière',
        'section_subtitle'      => 'Expérience premium',
        'checkin'               => 'Arrivée',
        'checkout'              => 'Départ',
        'special_instructions'  => 'Instructions spéciales à l\'arrivée',
        'children'              => 'Enfants et lits supplémentaires',
        'equipment'             => 'Équipements',
        'no_amenity'            => 'Aucune commodité renseignée.',
        'back'                  => 'Retour aux appartements',
        'suggestions'           => 'Suggestions',
        'similar'               => 'Appartements similaires',            'gallery_subtitle'      => 'Photos de la chambre',    ];
@endphp
<section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $headerImage }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <div class="subtitle">{{ $ui['banner_subtitle'] }}</div>
                <div class="title">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
            </div>
        </div>
    </div>
</section>

<section class="page-details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 mb-30">
                <div class="row mb-30">
                    <div class="col-md-12">
                        <div class="section-subtitle">{{ $ui['section_subtitle'] }}</div>
                        <div class="section-title">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
                        @php
                            $roomDescription = method_exists($room, 't') ? $room->t('description') : ($room->description ?? '');
                        @endphp
                        @if(!empty($roomDescription))
                            <div class="room-description">{!! $roomDescription !!}</div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @if(!empty($room->checkin_info))
                    <div class="col-lg-6 col-md-12 mb-30">
                        <h5>{{ $ui['checkin'] }}</h5>
                        @php
                            $checkinLines = array_filter(array_map('trim', explode("\n", $room->checkin_info)));
                        @endphp
                        <ul class="list-unstyled page-list">
                            @foreach($checkinLines as $line)
                                <li>
                                    <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                    <div class="page-list-text"><p>{{ $line }}</p></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(!empty($room->checkout_info))
                    <div class="col-lg-6 col-md-12 mb-30">
                        <h5>{{ $ui['checkout'] }}</h5>
                        @php
                            $checkoutLines = array_filter(array_map('trim', explode("\n", $room->checkout_info)));
                        @endphp
                        <ul class="list-unstyled page-list mb-30">
                            @foreach($checkoutLines as $line)
                                <li>
                                    <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                    <div class="page-list-text"><p>{{ $line }}</p></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @if(!empty($room->special_instructions))
                <div class="row mb-30">
                    <div class="col-md-12">
                        <h5>{{ $ui['special_instructions'] }}</h5>
                        <p>{{ $room->special_instructions }}</p>
                    </div>
                </div>
                @endif
                @if(!empty($room->children_policy))
                <div class="row">
                    <div class="col-md-12">
                        <h5>{{ $ui['children'] }}</h5>
                        <p>{{ $room->children_policy }}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4 offset-lg-1 col-md-12">
                <div class="cont">
                    <h5>{{ $ui['equipment'] }}</h5>
                    <ul class="list">
                        @forelse($room->amenities as $amenity)
                            <li>
                                <span>
                                    @if($amenity->image_path)
                                        <img src="{{ asset($amenity->image_path) }}" alt=""
                                            style="width: 22px; height: 22px; object-fit: contain;">
                                    @elseif($amenity->icon)
                                        <i class="{{ $amenity->icon }}"></i>
                                    @endif
                                </span>
                                <span>{{ method_exists($amenity, 't') ? $amenity->t('title') : $amenity->title }}</span>
                            </li>
                        @empty
                            <li>{{ $ui['no_amenity'] }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

@if(!empty($room->gallery))
<section class="galleryscroll section-padding bg-darkgray">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle brown">{{ $ui['gallery_subtitle'] }}</div>
                <div class="section-title white">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme">
                    @foreach($room->gallery as $image)
                        <div class="item">
                            <a href="{{ media_url($image) }}" title="" class="gallery-masonry-item-img-link img-zoom">
                                <div class="img">
                                    <img src="{{ media_url($image) }}" class="img-fluid mx-auto d-block" alt="">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- FAQ -->
@include('themes.lasanta.partials.home.faqs', [
    'homeFaqs'          => $homeFaqs ?? collect(),
    'faqSectionSetting' => $faqSectionSetting ?? null,
])

<!-- Booking Footer -->
<!-- 
@if(($similarRooms ?? collect())->isNotEmpty())
<section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle">{{ $ui['suggestions'] }}</div>
                <div class="section-title">{{ $ui['similar'] }}</div>
            </div>
        </div>
        <div class="row">
            @foreach($similarRooms as $similar)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img"><img src="{{ media_url($similar->main_image ?? null, 'themes/lasanta/img/restaurant/5.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="cont">
                            <h4><a href="{{ route('rooms.show', $similar->slug) }}">{{ method_exists($similar, 't') ? $similar->t('title') : $similar->title }}</a></h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif -->
@endsection
