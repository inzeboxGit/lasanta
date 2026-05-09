@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $heroImage = media_url($contactPageSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
    $primaryPhone = $siteSetting->phone_primary ?? '';
    $secondaryPhone = $siteSetting->phone_secondary ?? '';
    $address = method_exists($siteSetting, 't') ? $siteSetting->t('address') : ($siteSetting->address ?? '');
    $mapLatitude = $contactPageSetting->map_latitude ?? 42.6043096;
    $mapLongitude = $contactPageSetting->map_longitude ?? 8.9295210;
    $mapSrc = 'https://www.google.com/maps?q=' . $mapLatitude . ',' . $mapLongitude . '&z=15&output=embed';
@endphp
<section class="banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ $heroImage }}">
    <div class="container">
        <div class="row"><div class="col-md-12"><div class="subtitle">Get in touch</div><div class="title">{{ method_exists($contactPageSetting, 't') ? $contactPageSetting->t('title') : ($contactPageSetting->title ?? 'Contact') }}</div></div></div>
    </div>
</section>

<section class="contact section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="row mb-30">
                    <div class="col-lg-6 col-md-12 mb-25">
                        <div class="item" style="transform-style: flat; perspective: none;">
                            <div class="front" style="transform: none; transition: none; backface-visibility: visible;"><div class="contents"><span class="fa-thin fa-location-dot"></span><h2 class="title">Adresse</h2><p class="text">{{ $address }}</p></div></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-25">
                        <div class="item" style="transform-style: flat; perspective: none;">
                            <div class="front" style="transform: none; transition: none; backface-visibility: visible;"><div class="contents"><span class="fa-thin fa-phone"></span><h2 class="title">Téléphone</h2><p class="text">{{ $primaryPhone }}</p></div></div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="col-md-12"><div class="map"><iframe src="{{ $mapSrc }}" width="100%" height="450" style="border:0; border-radius:5px" allowfullscreen loading="lazy"></iframe></div></div></div>
            </div>

            <div class="col-lg-4 offset-lg-1 col-md-12">
                <div class="form2-sidebar mt--240">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="post" action="{{ route('contact.send') }}" class="form2" autocomplete="off">
                        @csrf
                        <div class="head"><div class="row"><div class="col-md-12"><h5>Contactez-nous</h5></div></div></div>
                        <div class="cont">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 form-group"><input type="text" name="name_contact" value="{{ old('name_contact') }}" placeholder="Prénom" required></div>
                                <div class="col-lg-6 col-md-12 form-group"><input type="text" name="lastname_contact" value="{{ old('lastname_contact') }}" placeholder="Nom" required></div>
                                <div class="col-lg-12 col-md-12 form-group"><input type="email" name="email_contact" value="{{ old('email_contact') }}" placeholder="Email" required></div>
                                <div class="col-lg-12 col-md-12 form-group"><input type="text" name="phone_contact" value="{{ old('phone_contact') }}" placeholder="Téléphone" required></div>
                                <div class="col-md-12 form-group"><textarea name="message_contact" cols="30" rows="4" placeholder="Message">{{ old('message_contact') }}</textarea></div>
                                <div class="col-md-12 form-group"><input type="text" name="verify_contact" value="{{ old('verify_contact') }}" placeholder="Êtes-vous humain ? 3 + 1 =" required></div>
                                <div class="col-md-12"><button class="button-3" type="submit"><i class="fa-light fa-paper-plane"></i> Envoyer</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
@include('themes.lasanta.partials.home.faqs', [
    'homeFaqs'          => $homeFaqs ?? collect(),
    'faqSectionSetting' => $faqSectionSetting ?? null,
])
@endsection
