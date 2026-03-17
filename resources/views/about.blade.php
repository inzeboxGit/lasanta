@extends('layouts.app')

@section('content')
@php
$restaurantHeaderImage = $localAmenitySectionSetting->header_image ?? 'img/home_2.jpg';
$restaurantHeaderImageSrc = str_starts_with($restaurantHeaderImage, 'img/')
? asset($restaurantHeaderImage)
: asset('storage/' . ltrim($restaurantHeaderImage, '/'));
$aboutMainImage = $aboutSectionSetting->main_image ?? 'img/home_2.jpg';
$aboutOverlayImage = $aboutSectionSetting->overlay_image ?? 'img/home_1.jpg';

$aboutMainImageSrc = str_starts_with($aboutMainImage, 'img/')
? asset($aboutMainImage)
: asset('storage/' . ltrim($aboutMainImage, '/'));

$aboutOverlayImageSrc = str_starts_with($aboutOverlayImage, 'img/')
? asset($aboutOverlayImage)
: asset('storage/' . ltrim($aboutOverlayImage, '/'));
@endphp

<main>
    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ $restaurantHeaderImageSrc }}"
            alt="{{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? 'Restaurant') }}">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
            data-opacity-mask="rgba(0, 0, 0, 0.45)">
            <div class="container">
                <small class="slide-animated one">{{ method_exists($localAmenitySectionSetting, 't') ?
                    $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? 'RÉsidence
                    Bella vista')
                    }}</small>
                <h1 class="slide-animated two">{{ method_exists($localAmenitySectionSetting, 't') ?
                    $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? 'Restaurant') }}
                </h1>
                <p class="slide-animated three mb-0">{{ method_exists($aboutSectionSetting, 't') ?
                    $aboutSectionSetting->t('lead') : ($aboutSectionSetting->lead ?? 'Une conception du tourisme...') }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg_white">
        <div class="container margin_120_95">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="parallax_wrapper inverted about-main-media">
                        <img src="{{ $aboutMainImageSrc }}"
                            alt="{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'A propos') }}"
                            class="img-fluid rounded-img">
                        <div data-cue="slideInUp" class="img_over">
                            <span data-jarallax-element="-30">
                                <img src="{{ $aboutOverlayImageSrc }}"
                                    alt="{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'A propos') }}"
                                    class="rounded-img">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="intro">
                        <div class="title mb-3">
                            <small>{{ method_exists($localAmenitySectionSetting, 't') ?
                                $localAmenitySectionSetting->t('subtitle')
                                : ($localAmenitySectionSetting->subtitle ?? 'RÉsidence Bella vista') }}</small>
                            <h2>{{ method_exists($localAmenitySectionSetting, 't') ?
                                $localAmenitySectionSetting->t('title') :
                                ($localAmenitySectionSetting->title ?? 'Restaurant') }}</h2>
                        </div>
                        <p class="lead">{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead') :
                            ($aboutSectionSetting->lead ?? 'Une conception du tourisme...') }}</p>
                        <p>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('description') :
                            ($aboutSectionSetting->description ?? "Un établissement où se côtoient dans un subtil
                            mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées
                            dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre
                            de Maître Restaurateur.") }}</p>
                        <p class="mb-0"><em>{{ method_exists($aboutSectionSetting, 't') ?
                                $aboutSectionSetting->t('signature') : ($aboutSectionSetting->signature ?? 'L’équipe du
                                Bella Vista') }}</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.about.local-amenities')
</main>
@endsection