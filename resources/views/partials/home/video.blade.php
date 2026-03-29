<!-- Image background -->
@php
    $homeVideoImageSrc = media_url($homeVideoSetting->header_image ?? null, 'img/video-background.png');
    $homeVideoHasTranslations = isset($homeVideoSetting) && method_exists($homeVideoSetting, 't');
    $homeVideoSubtitle = $homeVideoHasTranslations
        ? $homeVideoSetting->t('subtitle')
        : ($homeVideoSetting->subtitle ?? 'Expérience hôtelière');
    $homeVideoTitle = $homeVideoHasTranslations
        ? $homeVideoSetting->t('title')
        : ($homeVideoSetting->title ?? 'Profiter d un moment de détente');
@endphp
<div class="pinned-image pinned-image--medium">
    <div class="pinned-image__container" id="section_video">
        <img src="{{ $homeVideoImageSrc }}" alt="{{ $homeVideoTitle }}">
        <div class="pinned-image__container-overlay" style="background-color: rgba(120, 120, 120, 0.45);"></div>
    </div>
    <div class="pinned_over_content">
        <div class="title white">
            <small data-cue="slideInUp" data-delay="200">{{ $homeVideoSubtitle }}</small>
            <h2 data-cue="slideInUp" data-delay="300">{{ $homeVideoTitle }}</h2>
        </div>
    </div>
</div>

<!-- Version vidéo originale conservée -->
<!-- <div class="pinned-image pinned-image--medium">
        <div class="pinned-image__container" id="section_video">
            <video loop="loop" muted="muted" id="video_home">
                <source src="{{ asset('video/swimming_pool_2.mp4') }}" type="video/mp4">
                <source src="{{ asset('video/swimming_pool_2.webm') }}" type="video/webm">
                <source src="{{ asset('video/swimming_pool_2.ogv') }}" type="video/ogg">
            </video>
            <div class="pinned-image__container-overlay"></div>
        </div>
        <div class="pinned_over_content">
            <div class="title white">
                <small data-cue="slideInUp" data-delay="200">Expérience hôtelière</small>
                <h2 data-cue="slideInUp" data-delay="300">Profiter d un moment <br> de détente</h2>
            </div>
        </div>
    </div> -->
