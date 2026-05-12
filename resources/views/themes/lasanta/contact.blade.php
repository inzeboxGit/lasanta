@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $heroImage = media_url($contactPageSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
    $primaryPhone = $siteSetting->phone_primary ?? '';
    $secondaryPhone = $siteSetting->phone_secondary ?? '';
    $address = method_exists($siteSetting, 't') ? $siteSetting->t('address') : ($siteSetting->address ?? '');
    $mapLatitude = str_replace(',', '.', (string) ($contactPageSetting->map_latitude ?? 42.6043096));
    $mapLongitude = str_replace(',', '.', (string) ($contactPageSetting->map_longitude ?? 8.9295210));
    $mapSrc = 'https://www.google.com/maps?q=' . $mapLatitude . ',' . $mapLongitude . '&z=15&output=embed';
    $contactHeading = [
        'fr' => 'Contactez-nous',
        'en' => 'Contact Us',
        'it' => 'Contattaci',
    ][$locale] ?? 'Contact Us';
    $contactUi = [
        'fr' => [
            'address' => 'Adresse',
            'phone' => 'Telephone',
            'first_name' => 'Prenom',
            'last_name' => 'Nom',
            'email' => 'Email',
            'message' => 'Message',
            'human_check' => 'Etes-vous humain ? 3 + 1 =',
            'send' => 'Envoyer',
        ],
        'en' => [
            'address' => 'Address',
            'phone' => 'Phone',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'message' => 'Message',
            'human_check' => 'Are you human? 3 + 1 =',
            'send' => 'Send',
        ],
        'it' => [
            'address' => 'Indirizzo',
            'phone' => 'Telefono',
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
            'email' => 'Email',
            'message' => 'Messaggio',
            'human_check' => 'Sei umano? 3 + 1 =',
            'send' => 'Invia',
        ],
    ];
    $ui = $contactUi[$locale] ?? $contactUi['en'];
@endphp
<section class="banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ $heroImage }}">
    <div class="container">
        <div class="row"><div class="col-md-12">
            <div class="subtitle">{{ method_exists($contactPageSetting, 't') ? $contactPageSetting->t('subtitle') : ($contactPageSetting->subtitle ?? '') }}</div>
            <div class="title">
                {{ method_exists($contactPageSetting, 't') ? $contactPageSetting->t('title') : ($contactPageSetting->title ?? 'Contact') }}
            </div>
        </div>
    </div>
    </div>
</section>

<section class="contact section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="row mb-30">
                    <div class="col-lg-6 col-md-12 mb-25">
                        <div class="item" style="transform-style: flat; perspective: none;">
                            <div class="front" style="transform: none; transition: none; backface-visibility: visible;"><div class="contents"><span class="fa-thin fa-location-dot"></span><h2 class="title">{{ $ui['address'] }}</h2><p class="text">{{ $address }}</p></div></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-25">
                        <div class="item" style="transform-style: flat; perspective: none;">
                            <div class="front" style="transform: none; transition: none; backface-visibility: visible;"><div class="contents"><span class="fa-thin fa-phone"></span><h2 class="title">{{ $ui['phone'] }}</h2><p class="text">{{ $primaryPhone }}</p></div></div>
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
                        <div class="head"><div class="row"><div class="col-md-12"><h5>{{ $contactHeading }}</h5></div></div></div>
                        <div class="cont">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 form-group"><input type="text" name="name_contact" value="{{ old('name_contact') }}" placeholder="{{ $ui['first_name'] }}" required></div>
                                <div class="col-lg-6 col-md-12 form-group"><input type="text" name="lastname_contact" value="{{ old('lastname_contact') }}" placeholder="{{ $ui['last_name'] }}" required></div>
                                <div class="col-lg-12 col-md-12 form-group"><input type="email" name="email_contact" value="{{ old('email_contact') }}" placeholder="{{ $ui['email'] }}" required></div>
                                <div class="col-lg-12 col-md-12 form-group"><input type="text" name="phone_contact" value="{{ old('phone_contact') }}" placeholder="{{ $ui['phone'] }}" required></div>
                                <div class="col-md-12 form-group"><textarea name="message_contact" cols="30" rows="4" placeholder="{{ $ui['message'] }}">{{ old('message_contact') }}</textarea></div>
                                <div class="col-md-12 form-group"><input type="text" name="verify_contact" value="{{ old('verify_contact') }}" placeholder="{{ $ui['human_check'] }}" required></div>
                                <div class="col-md-12"><button class="button-3" type="submit"><i class="fa-light fa-paper-plane"></i> {{ $ui['send'] }}</button></div>
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
