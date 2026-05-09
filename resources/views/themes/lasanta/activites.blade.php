@extends('themes.lasanta.layouts.app')

@section('content')

    {{-- Banner --}}
    <section class="banner-header full-height valign bg-img" data-overlay-dark="4"
        data-background="{{ theme_asset('img/banner/11.jpg') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h5>Découvrez nos espaces</h5>
                    <h1>Nos Activités</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- Page Details --}}
    <section class="page-details section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">{{ method_exists($activitesAboutSetting, 't') ? $activitesAboutSetting->t('small_title') : ($activitesAboutSetting->small_title ?? 'Détente & Loisirs') }}</div>
                    <div class="section-title">{{ method_exists($activitesAboutSetting, 't') ? $activitesAboutSetting->t('title') : ($activitesAboutSetting->title ?? 'À propos de nos activités') }}</div>
                </div>
            </div>
            @if(!empty(method_exists($activitesAboutSetting, 't') ? $activitesAboutSetting->t('description') : ($activitesAboutSetting->description ?? null)))
            <div class="row mb-30">
                <div class="col-md-12">
                    @php $aboutDesc = method_exists($activitesAboutSetting, 't') ? $activitesAboutSetting->t('description') : ($activitesAboutSetting->description ?? ''); @endphp
                    @foreach(preg_split('/\n{2,}/', trim($aboutDesc)) as $paragraph)
                        @if(trim($paragraph))<p>{{ trim($paragraph) }}</p>@endif
                    @endforeach
                </div>
            </div>
            @endif
            @php
                $aboutImages = collect([
                    $activitesAboutSetting->main_image ?? null,
                    $activitesAboutSetting->overlay_image ?? null,
                    $activitesAboutSetting->third_image ?? null,
                ])->filter()->values();
            @endphp
            @if($aboutImages->isNotEmpty())
            <div class="row justify-content-center">
                @foreach($aboutImages as $img)
                <div class="col-lg-4 col-md-12 mb-15">
                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded-2" alt="Activités">
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- Gallery Scroll --}}
    @php
        $galleryImages = ($installations ?? collect())->filter(fn($i) => !empty($i->image_path))->values();
    @endphp
    <section class="galleryscroll section-padding bg-lightbrown">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-20">
                    <div class="section-subtitle">{{ method_exists($activitesGallerySetting, 't') ? $activitesGallerySetting->t('small_title') : ($activitesGallerySetting->small_title ?? 'Espace Loisirs') }}</div>
                    <div class="section-title">{{ method_exists($activitesGallerySetting, 't') ? $activitesGallerySetting->t('title') : ($activitesGallerySetting->title ?? 'Galerie des Activités') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        @if($galleryImages->isNotEmpty())
                            @foreach($galleryImages as $gItem)
                            <div class="item">
                                <a href="{{ asset('storage/' . $gItem->image_path) }}" title="" class="gallery-masonry-item-img-link img-zoom">
                                    <div class="img"><img src="{{ asset('storage/' . $gItem->image_path) }}" class="img-fluid mx-auto d-block" alt="{{ $gItem->title }}"></div>
                                </a>
                            </div>
                            @endforeach
                        @else
                            @foreach(['1','2','3','4','5'] as $n)
                            <div class="item">
                                <a href="{{ theme_asset('img/spa/' . $n . '.jpg') }}" title="" class="gallery-masonry-item-img-link img-zoom">
                                    <div class="img"><img src="{{ theme_asset('img/spa/' . $n . '.jpg') }}" class="img-fluid mx-auto d-block" alt=""></div>
                                </a>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-12 mb-25 text-center">
                    <div class="section-subtitle">F.A.Qs</div>
                    <div class="section-title">Informations pratiques</div>
                </div>
            </div>
            @php
                $faqItems = $installations ?? collect();
                $leftFaqs = $faqItems->values()->filter(fn($item, $key) => $key % 2 === 0)->values();
                $rightFaqs = $faqItems->values()->filter(fn($item, $key) => $key % 2 !== 0)->values();
            @endphp
            @if($faqItems->isNotEmpty())
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <ul class="accordion-box clearfix">
                        @foreach($leftFaqs as $faq)
                        <li class="accordion block">
                            <div class="acc-btn">{{ method_exists($faq, 't') ? $faq->t('title') : $faq->title }}</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">{{ method_exists($faq, 't') ? $faq->t('description') : ($faq->description ?? '') }}</div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6 col-md-12">
                    <ul class="accordion-box clearfix">
                        @foreach($rightFaqs as $faq)
                        <li class="accordion block">
                            <div class="acc-btn">{{ method_exists($faq, 't') ? $faq->t('title') : $faq->title }}</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">{{ method_exists($faq, 't') ? $faq->t('description') : ($faq->description ?? '') }}</div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <ul class="accordion-box clearfix">
                        <li class="accordion block">
                            <div class="acc-btn">Horaires des activités</div>
                            <div class="acc-content"><div class="content"><div class="text">Nos activités sont disponibles tous les jours de 8h à 20h selon les espaces. Renseignez-vous à la réception pour le planning.</div></div></div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Réservation requise ?</div>
                            <div class="acc-content"><div class="content"><div class="text">La plupart des activités sont accessibles sans réservation. Certaines excursions nécessitent une inscription préalable.</div></div></div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Activités pour les enfants</div>
                            <div class="acc-content"><div class="content"><div class="text">Des activités adaptées aux enfants sont proposées chaque jour. Les moins de 12 ans doivent être accompagnés d'un adulte.</div></div></div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-12">
                    <ul class="accordion-box clearfix">
                        <li class="accordion block">
                            <div class="acc-btn">Équipements inclus</div>
                            <div class="acc-content"><div class="content"><div class="text">L'accès à la piscine, aux espaces de détente et aux animations de base est inclus dans votre séjour.</div></div></div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Excursions aux alentours</div>
                            <div class="acc-content"><div class="content"><div class="text">Nous organisons des excursions dans les sites touristiques proches. Tarifs et programmes disponibles à la réception.</div></div></div>
                        </li>
                        <li class="accordion block">
                            <div class="acc-btn">Règles de sécurité</div>
                            <div class="acc-content"><div class="content"><div class="text">Merci de respecter les consignes affichées dans chaque espace. En cas d'urgence, signalez-vous au personnel.</div></div></div>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection
