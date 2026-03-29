<!-- Hero Section -->
@php
$locale = app()->getLocale();
$labels = [
'fr' => ['small' => '', 'title' => '', 'dates' => 'Arrivée / Départ', 'adults' => 'Adultes', 'children' => 'Enfants',
'search' => 'Rechercher'],
'en' => ['small' => '', 'title' => '', 'dates' => 'Check in / Check out', 'adults' => 'Adults', 'children' =>
'Children', 'search' => 'Search'],
'de' => ['small' => '', 'title' => '', 'dates' => 'Check-in / Check-out', 'adults' => 'Erwachsene', 'children' =>
'Kinder', 'search' => 'Suchen'],
'it' => ['small' => '', 'title' => '', 'dates' => 'Check-in / Check-out', 'adults' => 'Adulti', 'children' =>
'Bambini', 'search' => 'Cerca'],
];
$ui = $labels[$locale] ?? $labels['en'];
$heroBackgroundType = $heroSetting->background_type ?? 'video';
$defaultHeroVideo = '';
$heroBackground = $heroSetting->background_image ?? '';
$heroBackgroundSrc = str_starts_with($heroBackground, 'img/')
? asset($heroBackground)
: asset('storage/' . $heroBackground);
$heroVideo = $heroSetting->background_video ?? '';
$heroVideoSrc = !empty($heroVideo) ? (str_starts_with($heroVideo, 'video/')
? asset($heroVideo)
: asset('storage/' . $heroVideo)) : '';
$heroYoutubeUrl = $heroSetting->youtube_video_url ?? null;
$heroYoutubeId = null;

if (!empty($heroYoutubeUrl) && preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([^&?/]+)~',
$heroYoutubeUrl, $matches)) {
$heroYoutubeId = $matches[1];
}

$heroYoutubeEmbedSrc = $heroYoutubeId
? 'https://www.youtube.com/embed/' . $heroYoutubeId . '?autoplay=1&mute=1&controls=0&loop=1&playlist=' . $heroYoutubeId
. '&playsinline=1&rel=0&modestbranding=1'
: null;
$reserveLabels = [
'fr' => 'RESERVER',
'en' => 'BOOK NOW',
'de' => 'JETZT BUCHEN',
'it' => 'PRENOTA ORA',
];
$reserveLabel = $reserveLabels[$locale] ?? $reserveLabels['en'];
@endphp
<div class="hero home-search full-height{{ $heroBackgroundType === 'image' ? ' jarallax' : ' hero-with-video' }}"
    @if($heroBackgroundType==='image' ) data-jarallax data-speed="0.2" @endif>
    @if($heroBackgroundType === 'video')
    @if($heroYoutubeEmbedSrc)
    <iframe class="hero-background-embed" src="{{ $heroYoutubeEmbedSrc }}" title="Hero background video"
        allow="autoplay; encrypted-media" referrerpolicy="strict-origin-when-cross-origin" tabindex="-1"></iframe>
    @else
    <video class="hero-background-video" autoplay loop muted playsinline poster="{{ $heroBackgroundSrc }}">
        <source src="{{ $heroVideoSrc }}">
    </video>
    @endif
    @else
    <img class="jarallax-img" src="{{ $heroBackgroundSrc }}"
        alt="{{ method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? $ui['title']) }}">
    @endif
    <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
        data-opacity-mask="rgba(0, 0, 0, 0)">
        <!-- 0.5 -->
        <div class="container">
            <small class="slide-animated one">{{ strtoupper(method_exists($heroSetting, 't') ?
                $heroSetting->t('small_title') : ($heroSetting->small_title ?? $ui['small'])) }}</small>
            <h3 class="slide-animated two">{{ strtoupper(method_exists($heroSetting, 't') ? $heroSetting->t('title') :
                ($heroSetting->title ?? $ui['title'])) }}</h3>
            @if($heroSetting->show_booking_form ?? true)
            <div class="row justify-content-center slide-animated three">
                <div class="col-xl-10">
                    <div class="row g-0 booking_form">
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <input class="form-control" type="text" name="dates" id="dates"
                                    placeholder="{{ $ui['dates'] }}" readonly="readonly">
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
