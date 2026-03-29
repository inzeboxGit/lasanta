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
                                @foreach($room->amenities as $amenity)
                                    <li data-cue="slideInLeft">
                                        @if($amenity->image_path)
                                            <img src="{{ asset($amenity->image_path) }}" alt="" style="width: 25px; height: 25px; margin-right: 10px; object-fit: contain;">
                                        @elseif($amenity->icon)
                                            <i class="{{ $amenity->icon }}"></i>
                                        @endif
                                        {{ method_exists($amenity, 't') ? $amenity->t('title') : $amenity->title }}
                                    </li>
                                @endforeach
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
