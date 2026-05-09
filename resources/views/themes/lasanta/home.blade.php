@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $heroImage = media_url($heroSetting->background_image ?? null, 'themes/lasanta/img/banner/11.jpg');
    $heroButtonLink = !empty($heroSetting->button_link ?? null) ? $heroSetting->button_link : route('appartements.index');
    $heroButtonTarget = $heroSetting->button_target ?? '_self';
    $heroButtonLabels = [
        'fr' => 'Découvrir Le Domaine',
        'en' => 'Discover The Estate',
        'de' => 'Entdecken Sie das Anwesen',
        'it' => 'Scopri la Tenuta',
    ];
    $heroButtonLabel = $heroButtonLabels[$locale] ?? $heroButtonLabels['en'];
    $aboutMain = media_url($aboutSectionSetting->main_image ?? null, 'themes/lasanta/img/spa/12.jpg');
    $aboutSmallTitle = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('small_title') ?: 'À PROPOS DE I LASANTA')
        : ($aboutSectionSetting->small_title ?? 'À PROPOS DE I LASANTA');
    $aboutTitle = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('title') ?: 'UN DOMAINE AU CŒUR DE LA NATURE')
        : ($aboutSectionSetting->title ?? 'UN DOMAINE AU CŒUR DE LA NATURE');
    $aboutLead = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('lead') ?: "")
        : ($aboutSectionSetting->lead ?? "");
    $aboutDescription = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('description') ?: "Entre les sentiers du maquis, la proximité de la plage de Saleccia et les moments de partage à l’auberge, chaque journée s’organise librement, au rythme de vos envies.")
        : ($aboutSectionSetting->description ?? "Entre les sentiers du maquis, la proximité de la plage de Saleccia et les moments de partage à l’auberge, chaque journée s’organise librement, au rythme de vos envies.");
    $apartmentsSubtitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('subtitle') ?: 'Expérience hôtelière')
        : ($appartmentPageSetting->subtitle ?? 'Expérience hôtelière');
    $apartmentsTitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('title') ?: 'Nos appartements')
        : ($appartmentPageSetting->title ?? 'Nos appartements');
@endphp
<section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $heroImage }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <div class="subtitle">{{ method_exists($heroSetting, 't') ? $heroSetting->t('small_title') : ($heroSetting->small_title ?? 'Expérience hôtelière') }}</div>
                <div class="title">{{ method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? 'Residence Lasanta') }}</div>
                <div class="mt-20"></div>
                <!-- <a href="about.html" class="button-3 mb-15">About Hotel</a> -->
                <a href="{{ $heroButtonLink }}" class="button-3 mb-15" target="{{ $heroButtonTarget }}"
                    @if($heroButtonTarget === '_blank') rel="noopener" @endif>
                    {{ $heroButtonLabel }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Booking Search -->
<div class="booking-wrapper">
    <div class="container">
        <div class="booking-inner clearfix">
            <form action="booking-system.html" class="form1 clearfix">
                <div class="col1 c1">
                    <div class="input1_wrapper border-l border-b border-t border-r br-5005">
                        <label>Check in</label>
                        <div class="input1_inner">
                            <input type="text" class="form-control input datepicker" placeholder="Check in">
                        </div>
                    </div>
                </div>
                <div class="col1 c2">
                    <div class="input1_wrapper border-l border-b border-t border-r">
                        <label>Check out</label>
                        <div class="input1_inner">
                            <input type="text" class="form-control input datepicker" placeholder="Check out">
                        </div>
                    </div>
                </div>
                <div class="col2 c3">
                    <div class="select1_wrapper border-l border-b border-t border-r">
                        <label>Adults</label>
                        <div class="select1_inner">
                            <select class="select2 select" style="width: 100%">
                                <option value="1">1 Adult</option>
                                <option value="2">2 Adults</option>
                                <option value="3">3 Adults</option>
                                <option value="4">4 Adults</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col2 c4">
                    <div class="select1_wrapper border-l border-b border-t  border-r">
                        <label>Children</label>
                        <div class="select1_inner">
                            <select class="select2 select" style="width: 100%">
                                <option value="1">Children</option>
                                <option value="1">1 Child</option>
                                <option value="2">2 Children</option>
                                <option value="3">3 Children</option>
                                <option value="4">4 Children</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col2 c5">
                    <div class="select1_wrapper border-l border-b border-t  border-r">
                        <label>Rooms</label>
                        <div class="select1_inner">
                            <select class="select2 select" style="width: 100%">
                                <option value="1">1 Room</option>
                                <option value="2">2 Rooms</option>
                                <option value="3">3 Rooms</option>
                                <option value="4">4 Rooms</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col3 c6">
                    <button type="submit" class="btn-form1-submit">Check Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- About -->
<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 mb-15">
                <div class="section-subtitle">{{ $aboutSmallTitle }}</div>
                <div class="section-title">{{ $aboutTitle }}</div>
                <p class="mb-15">{!! $aboutDescription !!}</p>
                <a href="{{ route('restaurant.index') }}" class="button-3 mb-15">Découvrir Le Domaine</a>
                <!-- @if(!empty($siteSetting->phone_primary ?? null))
                    <div class="phone">
                        <a href="tel:{{ preg_replace('/\s+/', '', (string) $siteSetting->phone_primary) }}">
                            <i class="fa-light fa-phone"></i>{{ $siteSetting->phone_primary }}
                        </a>
                    </div>
                @endif -->
            </div>
            <!-- offset-lg-1 mt-45-->
            <div class="col-lg-7 col-md-12 mb-20 ">
                <div style="aspect-ratio: 4 / 3; overflow: hidden; border-radius: 8px;">
                    <img src="{{ $aboutMain }}" class="rounded-2" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- chambres -->
 @include('themes.lasanta.partials.home.rooms', [
    'apartmentsSubtitle' => $apartmentsSubtitle,
    'apartmentsTitle' => $apartmentsTitle,
    'homeRooms' => $homeRooms ?? collect(),
])

<!-- Services -->
@include('themes.lasanta.partials.home.services', [
    'homeServices' => $homeServices ?? collect(),
])


<!-- Offres Spéciales -->
@include('themes.lasanta.partials.home.offres', [
    'homePromos' => $homePromos ?? collect(),
    'promoHeaderSetting' => $promoHeaderSetting ?? null,
])

<!-- Activities & Excursions -->
@include('themes.lasanta.partials.activities.pricing', [
    'localComodites' => $localComodites ?? collect(),
    'localAmenitySectionSetting' => $localAmenitySectionSetting ?? null,
    'installations' => $installations ?? collect(),
    'installationSectionSetting' => $installationSectionSetting ?? null,
])

<!-- Témoignages -->
@include('partials.home.testimonials', [
    'homeTestimonials'          => $homeTestimonials ?? collect(),
    'testimonialSectionSetting' => $testimonialSectionSetting ?? null,
])

@include('partials.home.news-events', [
    'homeNews'           => $homeNews ?? collect(),
    'newsSectionSetting' => $newsSectionSetting ?? null,
])

<!-- Booking Footer -->
@include('themes.lasanta.partials.home.booking-footer', [
    'bookingFooterSetting' => $bookingFooterSetting ?? null,
    'heroSetting'          => $heroSetting ?? null,
])
@endsection
