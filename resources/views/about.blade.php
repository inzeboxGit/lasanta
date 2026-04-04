@extends('layouts.app')

@section('content')
    @php
        $restaurantHeaderImage = $localAmenitySectionSetting->header_image ?? '';
        $restaurantHeaderImageSrc = media_url($restaurantHeaderImage, '');
        $aboutMainImage = $aboutSectionSetting->main_image ?? '';
        $aboutOverlayImage = $aboutSectionSetting->overlay_image ?? '';

        $aboutMainImageSrc = media_url($aboutMainImage, '');
        $aboutOverlayImageSrc = media_url($aboutOverlayImage, '');
    @endphp

    <main>
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" src="{{ $restaurantHeaderImageSrc }}"
                alt="{{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? '') }}">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
                data-opacity-mask="rgba(0, 0, 0, 0.45)">
                <div class="container">
                    <small class="slide-animated one">{{ method_exists($localAmenitySectionSetting, 't') ?
        $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? '')
                            }}</small>
                    <h1 class="slide-animated two">{{ method_exists($localAmenitySectionSetting, 't') ?
        $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? '') }}
                    </h1>
                    <p class="slide-animated three mb-0">{{ method_exists($localAmenitySectionSetting, 't') ?
        $localAmenitySectionSetting->t('hero_text') : ($localAmenitySectionSetting->hero_text ?? '') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg_white">
            <div class="container margin_120_0">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="parallax_wrapper about-main-media">
                            <img src="{{ $aboutMainImageSrc }}"
                                alt="{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? '') }}"
                                class="img-fluid rounded-img">
                            <div data-cue="slideInUp" class="img_over">
                                <span data-jarallax-element="-30">
                                    <img src="{{ $aboutOverlayImageSrc }}"
                                        alt="{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? '') }}"
                                        class="rounded-img">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 about-copy-column">
                        <div class="intro">
                            <div class="title mb-3">
                                <small>{{ method_exists($aboutSectionSetting, 't') ?
        $aboutSectionSetting->t('small_title')
        : ($aboutSectionSetting->small_title ?? '') }}</small>
                                <h2>{{ method_exists($aboutSectionSetting, 't') ?
        $aboutSectionSetting->t('title') :
        ($aboutSectionSetting->title ?? '') }}</h2>
                            </div>
                            <p class="lead">{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead') :
        ($aboutSectionSetting->lead ?? '') }}</p>
                            <p>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('description') :
        ($aboutSectionSetting->description ?? "") }}</p>
                            <p class="mb-0"><em>{{ method_exists($aboutSectionSetting, 't') ?
        $aboutSectionSetting->t('signature') : ($aboutSectionSetting->signature ?? '') }}</em>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.about.local-amenities', ['hideLocalAmenityHeading' => true])
    </main>
@endsection