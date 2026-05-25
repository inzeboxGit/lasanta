@extends('themes.lasanta.layouts.app')

@section('content')
    @php
        $headerImage = media_url($localAmenitySectionSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
        $mainImage   = media_url($aboutSectionSetting->main_image ?? null, 'themes/lasanta/img/spa/1.jpg');

        $poolHoursTitle = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('small_title')
            : ($poolInfoSectionSetting->small_title ?? 'Horaires');
        $poolHoursText = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('lead')
            : ($poolInfoSectionSetting->lead ?? '');
        $poolHoursItems = collect(preg_split('/\n|\r\n|\r/', (string) $poolHoursText))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values();

        $poolRulesTitle = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('title')
            : ($poolInfoSectionSetting->title ?? 'Règles');
        $poolRulesText = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('description')
            : ($poolInfoSectionSetting->description ?? '');

        $poolServicesTitle = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('signature')
            : ($poolInfoSectionSetting->signature ?? 'Services inclus');
        $poolServicesText = method_exists($poolInfoSectionSetting, 't')
            ? $poolInfoSectionSetting->t('main_image')
            : ($poolInfoSectionSetting->main_image ?? '');
    @endphp

    {{-- Banner --}}
    <section class="banner-header full-height valign bg-img" data-overlay-dark="4" data-background="{{ $headerImage }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="subtitle">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? '') }}
                    </div>
                    <div class="title mb-0">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? 'Piscine') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About + Info block --}}
    <section class="page-details section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('small_title') : ($aboutSectionSetting->small_title ?? 'À propos de la piscine') }}
                    </div>
                    <div class="section-title">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'La Piscine') }}
                    </div>
                    <div class="row mb-30">
                        <div class="col-md-12">
                            <p>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead') : ($aboutSectionSetting->lead ?? '') }}</p>
                            <p>{!! method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('description') : ($aboutSectionSetting->description ?? '') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-md-12">
                    <h5>{{ $poolHoursTitle }}</h5>
                    @if($poolHoursItems->isNotEmpty())
                        <ul class="list-unstyled page-list">
                            @foreach($poolHoursItems as $poolHoursItem)
                                <li>
                                    <div class="page-list-icon"><span class="ti-time"></span></div>
                                    <div class="page-list-text"><p>{{ $poolHoursItem }}</p></div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-md-12">
                    <h5>{{ $poolRulesTitle }}</h5>
                    <p>{{ $poolRulesText }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $poolServicesTitle }}</h5>
                    <p>{{ $poolServicesText }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery --}}
    @php
        $galleryImages   = $poolGallerySetting->gallery ?? [];
        $gallerySubtitle = method_exists($poolGallerySetting ?? null, 't')
            ? $poolGallerySetting->t('small_title')
            : ($poolGallerySetting->small_title ?? 'Galerie Photos');
        $galleryTitle    = method_exists($poolGallerySetting ?? null, 't')
            ? $poolGallerySetting->t('title')
            : ($poolGallerySetting->title ?? 'Piscine Gallery');
    @endphp
    @if(!empty($galleryImages))
    <section class="galleryscroll section-padding bg-lightbrown">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-20">
                    <div class="section-subtitle">{{ $gallerySubtitle }}</div>
                    <div class="section-title">{{ $galleryTitle }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        @foreach($galleryImages as $galleryImage)
                        <div class="item">
                            <a href="{{ media_url($galleryImage) }}" title=""
                                class="gallery-masonry-item-img-link img-zoom">
                                <div class="img"><img src="{{ media_url($galleryImage) }}"
                                        class="img-fluid mx-auto d-block" alt="{{ $galleryTitle }}"></div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@endsection
