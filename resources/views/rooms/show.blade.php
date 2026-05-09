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
                ],
                'en' => [
                    'hero_small' => 'Hotel Experience',
                    'section_small' => 'Luxury Experience',
                    'gallery' => 'Full screen gallery',
                ],
                'de' => [
                    'hero_small' => 'Hotelerlebnis',
                    'section_small' => 'Luxuserlebnis',
                    'gallery' => 'Vollbild-Galerie',
                ],
                'it' => [
                    'hero_small' => 'Esperienza hoteliera',
                    'section_small' => 'Esperienza di lusso',
                    'gallery' => 'Galleria a schermo intero',
                ],
            ];
            $ui = $labels[$locale] ?? $labels['en'];
        @endphp

        <div class="hero full-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img kenburns"
                src="{{ $room->main_image ? asset('storage/' . $room->main_image) : asset('img/rooms/1.jpg') }}" alt="">
            <div class="wrapper opacity-mask d-flex align-items-center text-center animate_hero"
                data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <small class="slide-animated one">{{ $ui['hero_small'] }}</small>
                            <h1 class="slide-animated two">
                                {{ method_exists($room, 't') ? $room->t('title') : $room->title }}</h1>
                            @if(method_exists($room, 't') ? $room->t('subtitle') : $room->subtitle)
                                <p class="slide-animated three">
                                    {{ method_exists($room, 't') ? $room->t('subtitle') : $room->subtitle }}</p>
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

        <section class="page-details section-padding" id="first_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 mb-30">
                        <div class="row mb-30">
                            <div class="col-md-12">
                                <div class="section-subtitle">{{ $ui['section_small'] }}</div>
                                <div class="section-title">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
                                @php
                                    $roomDescription = method_exists($room, 't') ? $room->t('description') : $room->description;
                                @endphp
                                @if(!empty($roomDescription))
                                    <div class="room-description">{!! $roomDescription !!}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-30">
                                <h5>Check-in</h5>
                                <ul class="list-unstyled page-list">
                                    <li>
                                        <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                        <div class="page-list-text">
                                            <p>Check-in from 9:00 AM - anytime</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                        <div class="page-list-text">
                                            <p>Early check-in subject to availability</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-30">
                                <h5>Check-out</h5>
                                <ul class="list-unstyled page-list mb-30">
                                    <li>
                                        <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                        <div class="page-list-text">
                                            <p>Check-out before noon</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="page-list-icon"> <span class="ti-check"></span> </div>
                                        <div class="page-list-text">
                                            <p>Express check-out</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col-md-12">
                                <h5>Special check-in instructions</h5>
                                <p>Guests will receive an email 5 days before arrival with check-in instructions; front desk staff will greet guests on arrival For more details, please contact the property using the information on the booking confirmation.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Children and extra beds</h5>
                                <p>Children are welcome Kids stay free! Children stay free when using existing bedding; children may not be eligible for complimentary breakfast Rollaway/extra beds are available for $ 10 per day.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-1 col-md-12">
                        <div class="cont">
                            <h5>Room Equipment</h5>
                            <ul class="list">
                                @foreach($room->amenities as $amenity)
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
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                <a class="btn_1 outline" data-fslightbox="gallery_1" data-type="image"
                                    href="{{ asset('storage/' . $img) }}">{{ $ui['gallery'] }}</a>
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
