@extends('layouts.app')

@section('content')
<main>
    @php
        $locale = app()->getLocale();
        $labels = [
            'fr' => [
                'hero_small' => 'Expérience hôtelière',
                'section_small' => 'Expérience premium',
                'gallery' => 'Galerie plein écran',
                'f1' => 'Lit King Size',
                'f2' => 'Coffre-fort',
                'f3' => 'Balcon',
                'f4' => 'TV 32 pouces',
                'f5' => 'Accès PMR',
                'f6' => 'Animaux acceptés',
                'f7' => 'Bouteille d\'accueil',
                'f8' => 'Wifi / Netflix',
                'f9' => 'Sèche-cheveux',
                'f10' => 'Climatisation',
                'f11' => 'Service de blanchisserie',
            ],
            'en' => [
                'hero_small' => 'Hotel Experience',
                'section_small' => 'Luxury Experience',
                'gallery' => 'Full screen gallery',
                'f1' => 'King Size Bed',
                'f2' => 'Safety Box',
                'f3' => 'Balcony',
                'f4' => '32 Inch TV',
                'f5' => 'Disabled Access',
                'f6' => 'Pet Allowed',
                'f7' => 'Welcome Bottle',
                'f8' => 'Wifi / Netflix access',
                'f9' => 'Hair Dryer',
                'f10' => 'Air Conditioning',
                'f11' => 'Laundry Service',
            ],
            'de' => [
                'hero_small' => 'Hotelerlebnis',
                'section_small' => 'Luxuserlebnis',
                'gallery' => 'Vollbild-Galerie',
                'f1' => 'Kingsize-Bett',
                'f2' => 'Safe',
                'f3' => 'Balkon',
                'f4' => '32-Zoll-TV',
                'f5' => 'Barrierefreier Zugang',
                'f6' => 'Haustiere erlaubt',
                'f7' => 'Willkommensflasche',
                'f8' => 'WLAN / Netflix-Zugang',
                'f9' => 'Haartrockner',
                'f10' => 'Klimaanlage',
                'f11' => 'Wäscheservice',
            ],
            'nl' => [
                'hero_small' => 'Hotelbeleving',
                'section_small' => 'Luxe beleving',
                'gallery' => 'Volledig scherm galerij',
                'f1' => 'Kingsize bed',
                'f2' => 'Kluis',
                'f3' => 'Balkon',
                'f4' => '32 inch tv',
                'f5' => 'Toegang voor mindervaliden',
                'f6' => 'Huisdieren toegestaan',
                'f7' => 'Welkomstfles',
                'f8' => 'Wifi / Netflix toegang',
                'f9' => 'Haardroger',
                'f10' => 'Airconditioning',
                'f11' => 'Wasservice',
            ],
        ];
        $ui = $labels[$locale] ?? $labels['en'];
    @endphp

    <div class="hero full-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img kenburns" src="{{ $room->main_image ? asset('storage/' . $room->main_image) : asset('img/rooms/1.jpg') }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <small class="slide-animated one">{{ $ui['hero_small'] }}</small>
                        <h1 class="slide-animated two">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</h1>
                        @if(method_exists($room, 't') ? $room->t('subtitle') : $room->subtitle)
                            <p class="slide-animated three">{{ method_exists($room, 't') ? $room->t('subtitle') : $room->subtitle }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mouse_wp slide-animated four">
                <a href="#first_section" class="btn_explore">
                    <div class="mouse"></div>
                </a>
            </div>
            <!-- / mouse -->
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="bg_white" id="first_section">
        <div class="container margin_120_95">
            <div class="row justify-content-between">
                <div class="col-lg-4">
                    <div class="title">
                        <small>{{ $ui['section_small'] }}</small>
                        <h2>{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</h2>
                    </div>
                    @if(method_exists($room, 't') ? $room->t('description') : $room->description)
                        <p>{{ method_exists($room, 't') ? $room->t('description') : $room->description }} </p>
                    @endif
                </div>
                <div class="col-lg-6">
                        <div class="room_facilities_list">
                            <ul data-cues="slideInLeft" data-disabled="true">
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-double_bed_2"></i> {{ $ui['f1'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 180ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-safety_box"></i> {{ $ui['f2'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-patio"></i>{{ $ui['f3'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 180ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-tv"></i> {{ $ui['f4'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-disable"></i> {{ $ui['f5'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 180ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-dog"></i> {{ $ui['f6'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-bottle"></i> {{ $ui['f7'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 180ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-wifi"></i> {{ $ui['f8'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-hairdryer"></i> {{ $ui['f9'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 180ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-condition"></i> {{ $ui['f10'] }}</li>
                                <li data-cue="slideInLeft" data-show="true" style="animation-name: slideInLeft; animation-duration: 600ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;"><i class="icon-hotel-loundry"></i>{{ $ui['f11'] }}</li>
                            </ul>
                        </div>
                    </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_white -->

    @if(!empty($room->gallery))
    <div class="bg_white add_bottom_120">
        <div class="container-fluid p-lg-0">
            <div data-cues="zoomIn">
                <div class="owl-carousel owl-theme carousel_item_centered kenburns rounded-img">
                    @foreach($room->gallery as $img)
                        <div class="item">
                            <img src="{{ asset('storage/' . $img) }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center mt-5">
                @foreach($room->gallery as $i => $img)
                    @if($i === 0)
                        <a class="btn_1 outline" data-fslightbox="gallery_1" data-type="image" href="{{ asset('storage/' . $img) }}">{{ $ui['gallery'] }}</a>
                    @else
                        <a data-fslightbox="gallery_1" data-type="image" href="{{ asset('storage/' . $img) }}"></a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- /bg_white -->

    @include('partials.rooms.similar-apparts')
</main>
@endsection
