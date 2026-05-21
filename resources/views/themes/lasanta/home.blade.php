@extends('themes.lasanta.layouts.app')

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
    $heroButtonLabel = method_exists($heroSetting, 't')
        ? ($heroSetting->t('button_text', $locale) ?: ($heroSetting->button_text ?? ($heroButtonLabels[$locale] ?? $heroButtonLabels['en'])))
        : (($heroSetting->button_text ?? '') ?: ($heroButtonLabels[$locale] ?? $heroButtonLabels['en']));
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
    $aboutButtonText = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('button_text', $locale) ?: ($aboutSectionSetting->button_text ?? 'Découvrir Le Domaine'))
        : ($aboutSectionSetting->button_text ?? 'Découvrir Le Domaine');
    $aboutButtonLink = !empty($aboutSectionSetting->button_link ?? null)
        ? $aboutSectionSetting->button_link
        : route('restaurant.index');
    $aboutButtonTarget = $aboutSectionSetting->button_target ?? '_self';
    $apartmentsSubtitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('subtitle') ?: 'Expérience hôtelière')
        : ($appartmentPageSetting->subtitle ?? 'Expérience hôtelière');
    $apartmentsTitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('title') ?: 'Nos appartements')
        : ($appartmentPageSetting->title ?? 'Nos appartements');

    $uiDefaults = [
        'fr' => ['check_in_label' => 'Arrivée', 'check_out_label' => 'Départ', 'adults_label' => 'Adultes', 'adult_s' => 'Adulte', 'children_label' => 'Enfants', 'child_s' => 'Enfant', 'rooms_label' => 'Chambres', 'room_s' => 'Chambre', 'search_label' => 'Rechercher', 'dates_label' => 'Arrivée / Départ'],
        'en' => ['check_in_label' => 'Check in', 'check_out_label' => 'Check out', 'adults_label' => 'Adults', 'adult_s' => 'Adult', 'children_label' => 'Children', 'child_s' => 'Child', 'rooms_label' => 'Rooms', 'room_s' => 'Room', 'search_label' => 'Search', 'dates_label' => 'Check in / Check out'],
        'de' => ['check_in_label' => 'Anreise', 'check_out_label' => 'Abreise', 'adults_label' => 'Erwachsene', 'adult_s' => 'Erwachsener', 'children_label' => 'Kinder', 'child_s' => 'Kind', 'rooms_label' => 'Zimmer', 'room_s' => 'Zimmer', 'search_label' => 'Suchen', 'dates_label' => 'Anreise / Abreise'],
        'it' => ['check_in_label' => 'Arrivo', 'check_out_label' => 'Partenza', 'adults_label' => 'Adulti', 'adult_s' => 'Adulto', 'children_label' => 'Bambini', 'child_s' => 'Bambino', 'rooms_label' => 'Camere', 'room_s' => 'Camera', 'search_label' => 'Cerca', 'dates_label' => 'Arrivo / Partenza'],
    ];
    $ui = $uiDefaults[$locale] ?? $uiDefaults['en'];
    if (isset($heroSetting) && method_exists($heroSetting, 't')) {
        foreach (['dates_label', 'check_in_label', 'check_out_label', 'adults_label', 'children_label', 'rooms_label', 'search_label'] as $_f) {
            $v = $heroSetting->t($_f, $locale);
            if (!empty($v))
                $ui[$_f] = $v;
        }
    } elseif (isset($heroSetting)) {
        foreach (['dates_label', 'check_in_label', 'check_out_label', 'adults_label', 'children_label', 'rooms_label', 'search_label'] as $_f) {
            if (!empty($heroSetting->{$_f} ?? null))
                $ui[$_f] = $heroSetting->{$_f};
        }
    }
@endphp

@push('styles')
    <link rel="preload" as="image" href="{{ $heroImage }}" fetchpriority="high">
@endpush

@section('content')
    <section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $heroImage }}"
        style="background-image: url('{{ $heroImage }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 text-center">
                    <div class="subtitle">
                        {{ method_exists($heroSetting, 't') ? $heroSetting->t('small_title') : ($heroSetting->small_title ?? 'Expérience hôtelière') }}
                    </div>
                    <div class="title">
                        {{ method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? ' Lasanta') }}
                    </div>
                    <div class="mt-20"></div>
                     <!-- buttonHeader -->
                    <!-- <a href="{{ $heroButtonLink }}" class="button-3 mb-15" target="{{ $heroButtonTarget }}"
                        @if($heroButtonTarget === '_blank') rel="noopener" @endif>
                        {{ $heroButtonLabel }}
                    </a> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Search -->
    @if($heroSetting->show_booking_form ?? true)
        <div class="booking-wrapper">
            <div class="container">
                <div class="booking-inner clearfix">
                    <form id="hnet-booking-form" class="form1 clearfix">
                        <div class="col1 c1">
                            <div class="input1_wrapper border-l border-b border-t border-r br-5005">
                                <label>{{ $ui['check_in_label'] }}</label>
                                <div class="input1_inner">
                                    <input type="text" id="hnet-check-in" class="form-control input datepicker"
                                        placeholder="{{ $ui['check_in_label'] }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col1 c2">
                            <div class="input1_wrapper border-l border-b border-t border-r">
                                <label>{{ $ui['check_out_label'] }}</label>
                                <div class="input1_inner">
                                    <input type="text" id="hnet-check-out" class="form-control input datepicker"
                                        placeholder="{{ $ui['check_out_label'] }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col2 c3">
                            <div class="select1_wrapper border-l border-b border-t border-r">
                                <label>{{ $ui['adults_label'] }}</label>
                                <div class="select1_inner">
                                    <select id="hnet-adults" class="select2 select" style="width: 100%">
                                        <option value="1">1 {{ $ui['adult_s'] ?? $ui['adults_label'] }}</option>
                                        <option value="2" selected>2 {{ $ui['adults_label'] }}</option>
                                        <option value="3">3 {{ $ui['adults_label'] }}</option>
                                        <option value="4">4 {{ $ui['adults_label'] }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col2 c4">
                            <div class="select1_wrapper border-l border-b border-t  border-r">
                                <label>{{ $ui['children_label'] }}</label>
                                <div class="select1_inner">
                                    <select id="hnet-children" class="select2 select" style="width: 100%">
                                        <option value="0">0 {{ $ui['children_label'] }}</option>
                                        <option value="1">1 {{ $ui['child_s'] ?? $ui['children_label'] }}</option>
                                        <option value="2">2 {{ $ui['children_label'] }}</option>
                                        <option value="3">3 {{ $ui['children_label'] }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col2 c5">
                            <div class="select1_wrapper border-l border-b border-t  border-r">
                                <label>{{ $ui['rooms_label'] }}</label>
                                <div class="select1_inner">
                                    <select id="hnet-rooms" class="select2 select" style="width: 100%">
                                        <option value="1">1 {{ $ui['room_s'] ?? $ui['rooms_label'] }}</option>
                                        <option value="2">2 {{ $ui['rooms_label'] }}</option>
                                        <option value="3">3 {{ $ui['rooms_label'] }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col3 c6">
                            <button type="submit" class="btn-form1-submit">{{ $ui['search_label'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
<!-- 
php artisan migrate --path=database/migrations/2026_05_11_000002_alter_description_longtext_in_about_section_settings_table.php --force 
-->
    <!-- About -->
    <section class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 mb-15">
                    <div class="section-subtitle brown">{{ $aboutSmallTitle }}</div>
                    <div class="section-title black">{{ $aboutTitle }}</div>
                    <p class="mb-15 grey">{!! $aboutDescription !!}</p>
                    <!-- <a href="{{ $aboutButtonLink }}" class="button-3 mb-15" target="{{ $aboutButtonTarget }}" @if($aboutButtonTarget === '_blank') rel="noopener" @endif> -->
                        <!-- {{ $aboutButtonText }} -->
                    <!-- </a> -->
                     <div style="padding-left: 0!important;" class="phone" bis_skin_checked="1">
                        <a href="tel:{{ $aboutButtonText }}">
                            <i class="fa-light fa-phone"></i>{{ $aboutButtonText }}
                        </a>
                    </div>
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
                        <img src="{{ $aboutMain }}" class="rounded-2" alt="" width="1080" height="810" loading="lazy"
                            decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
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

    <!-- Activities & Excursions -->
        @include('themes.lasanta.partials.activities.pricing', [
            'localComodites' => $localComodites ?? collect(),
            'localAmenitySectionSetting' => $localAmenitySectionSetting ?? null,
            'installations' => $installations ?? collect(),
            'installationSectionSetting' => $installationSectionSetting ?? null,
        ])

        <!-- Témoignages -->
        @include('partials.home.testimonials', [
            'homeTestimonials' => $homeTestimonials ?? collect(),
            'testimonialSectionSetting' => $testimonialSectionSetting ?? null,
        ])

        @include('partials.home.news-events', [
            'homeNews' => $homeNews ?? collect(),
            'newsSectionSetting' => $newsSectionSetting ?? null,
        ])

        <!-- Booking Footer -->
        @include('themes.lasanta.partials.home.booking-footer', [
            'bookingFooterSetting' => $bookingFooterSetting ?? null,
            'heroSetting' => $heroSetting ?? null,
        ])
@endsection
