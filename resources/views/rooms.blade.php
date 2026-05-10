<!-- /appartements -->
@extends('layouts.app')

@section('content')
    <main>

        @php
            $locale = app()->getLocale();
            $labels = [
                'fr' => [
                    'hero_subtitle' => 'Expérience hôtelière',
                    'hero_title' => 'Nos chambres et suites',
                    'from' => 'À partir de',
                    'per_night' => '€/nuit',
                    'price_on_request' => 'Tarif sur demande',
                    'room_desc_fallback' => 'Découvrez cette chambre et profitez d\'un séjour confortable à la Résidence Hotel La Santa.',
                    'amenity_1' => 'Confort premium',
                    'amenity_2' => 'Wifi',
                    'amenity_3' => 'TV',
                    'book' => 'Réserver',
                    'read_more' => 'Lire plus',
                    'empty' => 'Aucune chambre publiée pour le moment.',
                ],
                'en' => [
                    'hero_subtitle' => 'Hotel Experience',
                    'hero_title' => 'Our Rooms & Suites',
                    'from' => 'From',
                    'per_night' => 'EUR/night',
                    'price_on_request' => 'Price on request',
                    'room_desc_fallback' => 'Discover this room and enjoy a comfortable stay at  Hotel La Santa.',
                    'amenity_1' => 'Premium comfort',
                    'amenity_2' => 'Wifi',
                    'amenity_3' => 'TV',
                    'book' => 'Book',
                    'read_more' => 'Read more',
                    'empty' => 'No published rooms at the moment.',
                ],
                'de' => [
                    'hero_subtitle' => 'Hotelerlebnis',
                    'hero_title' => 'Unsere Zimmer & Suiten',
                    'from' => 'Ab',
                    'per_night' => 'EUR/Nacht',
                    'price_on_request' => 'Preis auf Anfrage',
                    'room_desc_fallback' => 'Entdecken Sie dieses Zimmer und genießen Sie einen komfortablen Aufenthalt in der  Hotel La Santa.',
                    'amenity_1' => 'Premium-Komfort',
                    'amenity_2' => 'WLAN',
                    'amenity_3' => 'TV',
                    'book' => 'Buchen',
                    'read_more' => 'Mehr lesen',
                    'empty' => 'Derzeit keine veröffentlichten Zimmer.',
                ],
                'it' => [
                    'hero_subtitle' => 'Esperienza hoteliera',
                    'hero_title' => 'Le nostre camere e suite',
                    'from' => 'Da',
                    'per_night' => 'EUR/notte',
                    'price_on_request' => 'Prezzo su richiesta',
                    'room_desc_fallback' => 'Scopri questa camera e goditi un soggiorno confortevole al  Hotel La Santa.',
                    'amenity_1' => 'Comfort premium',
                    'amenity_2' => 'Wifi',
                    'amenity_3' => 'TV',
                    'book' => 'Prenota',
                    'read_more' => 'Scopri di più',
                    'empty' => 'Nessuna camera pubblicata al momento.',
                ],
            ];
            $ui = $labels[$locale] ?? $labels['en'];

            $heroSrc = null;
            if (!empty($appartmentPageSetting->header_image ?? null)) {
                $heroSrc = str_starts_with($appartmentPageSetting->header_image, 'img/')
                    ? asset($appartmentPageSetting->header_image)
                    : asset('storage/' . $appartmentPageSetting->header_image);
            } else {
                $heroSrc = asset('img/rooms/4.jpg');
            }
        @endphp
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.08">
            <img class="jarallax-img" src="{{ $heroSrc }}" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
                data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <small
                        class="slide-animated one">{{ method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('subtitle') : ($appartmentPageSetting->subtitle ?? $ui['hero_subtitle']) }}</small>
                    <h1 class="slide-animated two">
                        {{ method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('title') : ($appartmentPageSetting->title ?? $ui['hero_title']) }}
                    </h1>
                </div>
            </div>
        </div>
        <!-- /Background Img Parallax -->

        <div class="container margin_120_95 pb-0" id="first_section">
            @forelse(($rooms ?? collect()) as $room)
                @php
                    $isEven = $loop->iteration % 2 === 0;
                    $rowClass = $isEven ? 'row justify-content-end' : 'row justify-content-start';
                    $infoClass = $isEven ? 'box_item_info float-lg-end' : 'box_item_info';
                    $imageSrc = $room->main_image ? asset('storage/' . $room->main_image) : asset('img/rooms/1.jpg');
                    $roomDescription = method_exists($room, 't')
                        ? ($room->t('description') ?: $ui['room_desc_fallback'])
                        : ($room->description ?: $ui['room_desc_fallback']);
                    $roomExcerpt = \Illuminate\Support\Str::limit(trim(strip_tags($roomDescription)), 180);
                @endphp
                <div class="row_list_version_1">
                    <div class="pinned-image rounded_container pinned-image--medium apartment-list-image">
                        <div class="pinned-image__container">
                            <img class="apartment-list-image__asset" src="{{ $imageSrc }}"
                                alt="{{ method_exists($room, 't') ? $room->t('title') : $room->title }}">
                        </div>
                    </div>
                    <!-- /pinned-image -->
                    <div class="{{ $rowClass }}">
                        <div class="col-lg-8">
                            <div class="{{ $infoClass }}" data-jarallax-element="-30">
                                <small>
                                    {{ $room->price_per_night ? $ui['from'] . ' ' . number_format($room->price_per_night, 0) . ' ' . $ui['per_night'] : $ui['price_on_request'] }}
                                </small>
                                <h2>{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</h2>
                                <p
                                    style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $roomExcerpt }}
                                </p>
                                <div class="facilities clearfix">
                                    <ul>
                                        @forelse($room->amenities->take(3) as $amenity)
                                            <li>
                                                @if($amenity->icon)
                                                    <i class="{{ $amenity->icon }}"></i>
                                                @endif
                                                {{ method_exists($amenity, 't') ? $amenity->t('title') : $amenity->title }}
                                            </li>
                                        @empty
                                            <li><i class="customicon-double-bed"></i> {{ $ui['amenity_1'] }}</li>
                                            <li><i class="customicon-wifi"></i> {{ $ui['amenity_2'] }}</li>
                                            <li><i class="customicon-television"></i> {{ $ui['amenity_3'] }}</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="box_item_footer d-flex align-items-center justify-content-between">
                                    <a href="#booking_section" class="btn_4 learn-more">
                                        <span class="circle">
                                            <span class="icon arrow"></span>
                                        </span>
                                        <span class="button-text">{{ $ui['book'] }}</span>
                                    </a>
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="animated_link">
                                        <strong>{{ $ui['read_more'] }}</strong>
                                    </a>
                                </div>
                                <!-- /box_item_footer -->
                            </div>
                            <!-- /box_item_info -->
                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->
                </div>
                <!-- /row_list_version_1 -->
            @empty
                <div class="row">
                    <div class="col-12 text-center text-muted">{{ $ui['empty'] }}</div>
                </div>
            @endforelse
        </div>

        <!-- facilities -->
        @include('partials.home.installations')
        <!-- /bg_white -->


        <!-- /container -->

    </main>
@endsection
