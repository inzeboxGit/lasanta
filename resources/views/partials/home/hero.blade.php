<!-- Hero Section -->
@php
    $locale = app()->getLocale();
    $labels = [
        'fr' => ['small' => 'Expérience hôtelière', 'title' => 'Une expérience unique où séjourner', 'dates' => 'Arrivée / Départ', 'adults' => 'Adultes', 'children' => 'Enfants', 'search' => 'Rechercher'],
        'en' => ['small' => 'Hotel Experience', 'title' => 'A unique place to stay', 'dates' => 'Check in / Check out', 'adults' => 'Adults', 'children' => 'Children', 'search' => 'Search'],
        'de' => ['small' => 'Hotelerlebnis', 'title' => 'Ein einzigartiger Ort zum Übernachten', 'dates' => 'Check-in / Check-out', 'adults' => 'Erwachsene', 'children' => 'Kinder', 'search' => 'Suchen'],
        'nl' => ['small' => 'Hotelbeleving', 'title' => 'Een unieke plek om te verblijven', 'dates' => 'Inchecken / Uitchecken', 'adults' => 'Volwassenen', 'children' => 'Kinderen', 'search' => 'Zoeken'],
    ];
    $ui = $labels[$locale] ?? $labels['en'];
    $heroBackground = $heroSetting->background_image ?? 'img/hero_home_1.jpg';
    $heroBackgroundSrc = str_starts_with($heroBackground, 'img/')
        ? asset($heroBackground)
        : asset('storage/' . $heroBackground);
    $reserveLabels = [
        'fr' => 'RESERVER',
        'en' => 'BOOK NOW',
        'de' => 'JETZT BUCHEN',
        'nl' => 'BOEK NU',
    ];
    $reserveLabel = $reserveLabels[$locale] ?? $reserveLabels['en'];
@endphp
<div class="hero home-search full-height jarallax" data-jarallax data-speed="0.2">
    <img class="jarallax-img" src="{{ $heroBackgroundSrc }}" alt="{{ method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? $ui['title']) }}">
    <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
        <div class="container">
            <small class="slide-animated one">{{ strtoupper(method_exists($heroSetting, 't') ? $heroSetting->t('small_title') : ($heroSetting->small_title ?? $ui['small'])) }}</small>
            <h3 class="slide-animated two">{{ strtoupper(method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? $ui['title'])) }}</h3>
            @if($heroSetting->show_booking_form ?? true)
                <div class="row justify-content-center slide-animated three">
                    <div class="col-xl-10">
                        <div class="row g-0 booking_form">
                            <div class="col-lg-4 ">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="dates" id="dates" placeholder="{{ $ui['dates'] }}" readonly="readonly">
                                    <i class="bi bi-calendar2"></i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 pe-lg-0 pe-sm-1">
                                <div class="qty-buttons">
                                    <label>{{ $ui['adults'] }}</label>
                                    <input type="button" value="+" class="qtyplus" name="adults">
                                    <input type="text" name="adults" id="adults" value="" class="qty form-control">
                                    <input type="button" value="-" class="qtyminus" name="adults">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 ps-lg-0 ps-sm-1">
                                <div class="qty-buttons">
                                    <label>{{ $ui['children'] }}</label>
                                    <input type="button" value="+" class="qtyplus" name="childs">
                                    <input type="text" name="childs" id="childs" value="" class="qty form-control">
                                    <input type="button" value="-" class="qtyminus" name="childs">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <input type="submit" class="btn_search" value="{{ $ui['search'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($heroSetting->button_link ?? null))
                <div class="slide-animated three mt-4">
                    <a href="{{ $heroSetting->button_link }}" class="btn_1 outline" target="{{ $heroSetting->button_target ?? '_self' }}" @if(($heroSetting->button_target ?? '_self') === '_blank') rel="noopener" @endif>{{ $reserveLabel }}</a>
                </div>
            @endif
        </div>
        <div class="mouse_wp slide-animated four">
            <a href="#first_section" class="btn_scrollto">
                <div class="mouse"></div>
            </a>
        </div>
        <!-- /mouse_wp -->
    </div>
</div>
<!-- /jarallax video background -->
