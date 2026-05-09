<!-- utilisation -->

<!-- commenter Video Ambiance -->
@include('themes.lasanta.partials.home.video-ambiance', [
    'homeVideoSetting' => $homeVideoSetting ?? null,
])

@php
    $locale = app()->getLocale();
    $homeVideoHasTranslations = isset($homeVideoSetting) && method_exists($homeVideoSetting, 't');
    $homeVideoSubtitle = $homeVideoHasTranslations
        ? ($homeVideoSetting->t('subtitle', $locale) ?: ($homeVideoSetting->subtitle ?? ''))
        : ($homeVideoSetting->subtitle ?? '');
    $homeVideoTitle = $homeVideoHasTranslations
        ? ($homeVideoSetting->t('title', $locale) ?: ($homeVideoSetting->title ?? ""))
        : ($homeVideoSetting->title ?? "");
    $homeVideoImageSrc = media_url($homeVideoSetting->header_image ?? null, 'themes/lasanta/img/banner/01.jpg');
    $homeVideoPopupUrl = 'https://youtu.be/hG7Ok0HvDcU';
    $videoText = [
        'fr' => 'videos',
        'en' => 'videos',
        'de' => 'videos',
        'it' => 'videos',
    ][$locale] ?? 'videos';
@endphp

<section class="video-wrapper section-padding bg-img" data-overlay-dark="4" data-background="{{ $homeVideoImageSrc }}"
    style="background-image: url('{{ $homeVideoImageSrc }}');">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 text-center rotatex">
                <a href="{{ $homeVideoPopupUrl }}" data-lity="video" class="rotate-box vid" aria-label="Lire la vidéo">
                    <div class="rotate-circle rotate-text">
                        <svg class="textcircle" viewBox="0 0 500 500">
                            <defs>
                                <path id="textcircle" d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z"></path>
                            </defs>
                            <!-- <text>
                                <textPath xlink:href="#textcircle" textLength="900"> rixos luxury resort hotel </textPath>
                            </text> -->
                        </svg>
                    </div>
                    <span class="icon"><i class="fas fa-play"></i></span>
                </a>
                @if(!empty($homeVideoSubtitle))
                    <div class="section-subtitle mt-4" style="color: #fff;">{{ $homeVideoSubtitle }}</div>
                    <div class="section-title" style="color: #fff;">{{ $homeVideoTitle }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="video-text">{{ $videoText }}</div>
</section>