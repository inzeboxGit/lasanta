@extends('themes.lasanta.layouts.app')

@section('content')
    @php
        $headerImage = media_url($localAmenitySectionSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
        $mainImage = media_url($aboutSectionSetting->main_image ?? null, 'themes/lasanta/img/restaurant/1.jpg');
        $restaurantHoursTitle = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('small_title')
            : ($restaurantInfoSectionSetting->small_title ?? 'Hours');
        $restaurantHoursText = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('lead')
            : ($restaurantInfoSectionSetting->lead ?? '');
        $restaurantHoursItems = collect(preg_split('/
|\r
|\n/', (string) $restaurantHoursText))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values();
        $restaurantDressCodeTitle = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('title')
            : ($restaurantInfoSectionSetting->title ?? 'Dress Code');
        $restaurantDressCodeText = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('description')
            : ($restaurantInfoSectionSetting->description ?? '');
        $restaurantTerraceTitle = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('signature')
            : ($restaurantInfoSectionSetting->signature ?? 'Terrace');
        $restaurantTerraceText = method_exists($restaurantInfoSectionSetting, 't')
            ? $restaurantInfoSectionSetting->t('main_image')
            : ($restaurantInfoSectionSetting->main_image ?? '');
    @endphp
    <section class="banner-header full-height valign bg-img" data-overlay-dark="4" data-background="{{ $headerImage }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="subtitle">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? '') }}
                    </div>
                    <div class="title mb-0">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? 'Restaurant') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-details section-padding">
        <div class="container">
            <div class="row">
                <!-- <div class="col-lg-6 mb-15">
                    <img src="{{ $mainImage }}" class="img-fluid rounded-2" alt="">
                </div> -->
                <div class="col-md-12">
                    <div class="section-subtitle">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('small_title') : ($aboutSectionSetting->small_title ?? 'Address of taste') }}
                    </div>
                    <div class="section-title">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'About Restaurant') }}
                    </div>

                    <div class="row mb-30">
                        <div class="col-md-12">
                            <p>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead') : ($aboutSectionSetting->lead ?? 'Led by Chef de Micheal Martin, The Restaurant is celebrated for its excellent cuisine and unique ambience. The gorgeous dining room features three open studio kitchens, allowing you to enjoy the sights and sounds of the culinary artistry on display.') }}
                            </p>
                            <p>
                                {!! method_exists($aboutSectionSetting, 't')
                                    ? $aboutSectionSetting->t('description')
                                    : ($aboutSectionSetting->description ?? "The menu showcases both Asian and European influences, with a tempting selection of classic favorites and creative dishes for you to sample. Cheese connoisseurs will be drawn to the The Wine and Cheese Cellar, housed in five-meter-high glass walls, where our knowledgeable staff can introduce you to some of New York's greatest culinary treasures.")
                                            !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-md-12">
                    <h5>{{ $restaurantHoursTitle }}</h5>
                    @if($restaurantHoursItems->isNotEmpty())
                        <ul class="list-unstyled page-list">
                            @foreach($restaurantHoursItems as $restaurantHoursItem)
                                <li>
                                    <div class="page-list-icon"><span class="ti-time"></span></div>
                                    <div class="page-list-text">
                                        <p>{{ $restaurantHoursItem }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-md-12">
                    <h5>{{ $restaurantDressCodeTitle }}</h5>
                    <p>{{ $restaurantDressCodeText }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $restaurantTerraceTitle }}</h5>
                    <p>{{ $restaurantTerraceText }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="menu" class="restaurant-menu menu section-padding bg-darkgray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-subtitle text-brown"><span>{{ $extraTextSectionSetting && method_exists($extraTextSectionSetting, 't') ? $extraTextSectionSetting->t('small_title') : ($extraTextSectionSetting->small_title ?? '') }}</span></div>
                    <div class="section-title text-white">{{ $extraTextSectionSetting && method_exists($extraTextSectionSetting, 't') ? $extraTextSectionSetting->t('title') : ($extraTextSectionSetting->title ?? '') }}</div>
                </div>
            </div>
            @php
                $menuGroups = $localComodites->groupBy('title');
                $tabKeys = $menuGroups->keys();
            @endphp
            @if($tabKeys->isNotEmpty())
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="tabs-icon col-md-10 offset-md-1 text-center">
                            <div class="owl-carousel owl-theme">
                                @foreach($tabKeys as $tabIndex => $tabName)
                                    <div id="tab-{{ $tabIndex + 1 }}" class="{{ $tabIndex === 0 ? 'active ' : '' }}item">
                                        <h6 class="text-white">{{ $tabName }}</h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="restaurant-menu-content col-md-12">
                            @foreach($tabKeys as $tabIndex => $tabName)
                                @php
                                    $tabItems = $menuGroups[$tabName];
                                    $leftItems = $tabItems->values()->filter(fn($item, $key) => $key % 2 === 0)->values();
                                    $rightItems = $tabItems->values()->filter(fn($item, $key) => $key % 2 !== 0)->values();
                                @endphp
                                <div id="tab-{{ $tabIndex + 1 }}-content" class="cont{{ $tabIndex === 0 ? ' active' : '' }}">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @foreach($leftItems as $item)
                                                <div class="menu-info">
                                                    <h5>{{ $item->small_title }}
                                                        @if($item->sort_order)
                                                            <span class="price">{{ $item->sort_order }}</span>
                                                        @endif
                                                    </h5>
                                                    @if($item->description)
                                                        <p>{{ $item->description }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-5 offset-md-2">
                                            @foreach($rightItems as $item)
                                                <div class="menu-info">
                                                    <h5>{{ $item->small_title }}
                                                        @if($item->sort_order)
                                                            <span class="price">{{ $item->sort_order }}</span>
                                                        @endif
                                                    </h5>
                                                    @if($item->description)
                                                        <p>{{ $item->description }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>


    @php
        $galleryImages   = $restaurantGallerySetting->gallery ?? [];
        $gallerySubtitle = method_exists($restaurantGallerySetting ?? null, 't')
            ? $restaurantGallerySetting->t('small_title')
            : ($restaurantGallerySetting->small_title ?? 'Image Gallery');
        $galleryTitle    = method_exists($restaurantGallerySetting ?? null, 't')
            ? $restaurantGallerySetting->t('title')
            : ($restaurantGallerySetting->title ?? 'Restaurant Gallery');
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
                            <a href="{{ asset('storage/' . $galleryImage) }}" title=""
                                class="gallery-masonry-item-img-link img-zoom">
                                <div class="img"><img src="{{ asset('storage/' . $galleryImage) }}"
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