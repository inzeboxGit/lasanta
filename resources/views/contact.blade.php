@extends('layouts.app')

@section('content')
<main>
    @php
        $locale = app()->getLocale();
        $labels = [
            'fr' => [
                'hero_small' => 'Expérience hôtelière', 'hero_title' => 'Contact',
                'address' => 'Adresse', 'email' => 'Adresse email', 'phone' => 'Téléphone', 'hours' => 'Lundi à vendredi 9h - 19h',
                'touch' => 'Contactez-nous', 'name' => 'Prénom', 'lastname' => 'Nom', 'message' => 'Message', 'human' => 'Êtes-vous humain ? 3 + 1 =', 'submit' => 'Envoyer',
                'availability_small' => 'Residence Bella Vista', 'availability_title' => 'Disponibilité', 'availability_text' => 'Consultez les disponibilités et contactez-nous pour finaliser votre réservation.',
                'info_booking' => 'Infos et réservations', 'select_room' => 'Sélectionner un appartement', 'adults' => 'Adultes', 'children' => 'Enfants', 'book_now' => 'Réserver maintenant',
            ],
            'en' => [
                'hero_small' => 'Hotel Experience', 'hero_title' => 'Contact Us',
                'address' => 'Address', 'email' => 'Email address', 'phone' => 'Telephone', 'hours' => 'Monday to Friday 9am - 7pm',
                'touch' => 'Get in Touch', 'name' => 'Name', 'lastname' => 'Last name', 'message' => 'Message', 'human' => 'Are you human? 3 + 1 =', 'submit' => 'Submit',
                'availability_small' => 'Residence Bella Vista', 'availability_title' => 'Check Availability', 'availability_text' => 'Check availability and contact us to complete your booking.',
                'info_booking' => 'Info and bookings', 'select_room' => 'Select apartment', 'adults' => 'Adults', 'children' => 'Children', 'book_now' => 'Book now',
            ],
            'de' => [
                'hero_small' => 'Hotelerlebnis', 'hero_title' => 'Kontakt',
                'address' => 'Adresse', 'email' => 'E-Mail-Adresse', 'phone' => 'Telefon', 'hours' => 'Montag bis Freitag 9:00 - 19:00',
                'touch' => 'Kontaktieren Sie uns', 'name' => 'Vorname', 'lastname' => 'Nachname', 'message' => 'Nachricht', 'human' => 'Sind Sie ein Mensch? 3 + 1 =', 'submit' => 'Senden',
                'availability_small' => 'Residence Bella Vista', 'availability_title' => 'Verfügbarkeit', 'availability_text' => 'Prüfen Sie die Verfügbarkeit und kontaktieren Sie uns für Ihre Buchung.',
                'info_booking' => 'Info und Buchung', 'select_room' => 'Apartment auswählen', 'adults' => 'Erwachsene', 'children' => 'Kinder', 'book_now' => 'Jetzt buchen',
            ],
            'nl' => [
                'hero_small' => 'Hotelbeleving', 'hero_title' => 'Contact',
                'address' => 'Adres', 'email' => 'E-mailadres', 'phone' => 'Telefoon', 'hours' => 'Maandag tot vrijdag 9u - 19u',
                'touch' => 'Neem contact op', 'name' => 'Voornaam', 'lastname' => 'Achternaam', 'message' => 'Bericht', 'human' => 'Ben je een mens? 3 + 1 =', 'submit' => 'Verzenden',
                'availability_small' => 'Residence Bella Vista', 'availability_title' => 'Beschikbaarheid', 'availability_text' => 'Controleer beschikbaarheid en neem contact op om te boeken.',
                'info_booking' => 'Info en reserveringen', 'select_room' => 'Selecteer appartement', 'adults' => 'Volwassenen', 'children' => 'Kinderen', 'book_now' => 'Nu boeken',
            ],
        ];
        $ui = $labels[$locale] ?? $labels['en'];

        $primaryPhone = $siteSetting->phone_primary ?? '';
        $secondaryPhone = $siteSetting->phone_secondary ?? '';
        $primaryPhoneHref = preg_replace('/\s+/', '', (string) $primaryPhone);
        $secondaryPhoneHref = preg_replace('/\s+/', '', (string) $secondaryPhone);
        $heroSrc = media_url($contactPageSetting->header_image ?? null, 'img/hero_home_2.jpg');
    @endphp

    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ $heroSrc }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">{{ method_exists($contactPageSetting, 't') ? $contactPageSetting->t('subtitle') : ($contactPageSetting->subtitle ?? $ui['hero_small']) }}</small>
                <h1 class="slide-animated two">{{ method_exists($contactPageSetting, 't') ? $contactPageSetting->t('title') : ($contactPageSetting->title ?? $ui['hero_title']) }}</h1>
            </div>
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="container margin_120_95">
        <div class="row justify-content-between">
            <div class="col-xl-4 col-lg-5 order-lg-2">
                <div class="contact_info">
                    <ul class="clearfix">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <h4>{{ $ui['address'] }}</h4>
                            <div>{{ method_exists($siteSetting, 't') ? $siteSetting->t('address') : ($siteSetting->address ?? '') }}</div>
                        </li>
                        <li>
                            <i class="bi bi-envelope-paper"></i>
                            <h4>{{ $ui['email'] }}</h4>
                            @if(!empty($siteSetting->email))
                                <p><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></p>
                            @else
                                <p>-</p>
                            @endif
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <h4>{{ $ui['phone'] }}</h4>
                            <div>
                                @if(!empty($primaryPhone))
                                    <a href="tel:{{ $primaryPhoneHref }}">{{ $primaryPhone }}</a>
                                @endif
                                @if(!empty($secondaryPhone))
                                    <br><a href="tel:{{ $secondaryPhoneHref }}">{{ $secondaryPhone }}</a>
                                @endif
                                <br><small>{{ $ui['hours'] }}</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 order-lg-1">
                <h3 class="mb-3">{{ $ui['touch'] }}</h3>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div id="message-contact"></div>
                <form method="post" action="{{ route('contact.send') }}" id="contact_form_laravel" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="name_contact" name="name_contact" value="{{ old('name_contact') }}" placeholder="Name">
                                <label for="name_contact">{{ $ui['name'] }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="lastname_contact" name="lastname_contact" value="{{ old('lastname_contact') }}" placeholder="Last Name">
                                <label for="lastname_contact">{{ $ui['lastname'] }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="email" id="email_contact" name="email_contact" value="{{ old('email_contact') }}" placeholder="{{ $ui['email'] }}">
                                <label for="email_contact">{{ $ui['email'] }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="phone_contact" name="phone_contact" value="{{ old('phone_contact') }}" placeholder="{{ $ui['phone'] }}">
                                <label for="phone_contact">{{ $ui['phone'] }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="form-floating mb-4">
                        <textarea class="form-control" placeholder="{{ $ui['message'] }}" id="message_contact" name="message_contact">{{ old('message_contact') }}</textarea>
                        <label for="message_contact">{{ $ui['message'] }}</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="verify_contact" name="verify_contact" value="{{ old('verify_contact') }}" placeholder="{{ $ui['human'] }}">
                                <label for="verify_contact">{{ $ui['human'] }}</label>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3"><input type="submit" value="{{ $ui['submit'] }}" class="btn_1 outline" id="submit-contact"></p>
                </form>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!--/container -->

    <div class="map_contact">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.4364241114604!2d-73.96780638459853!3d40.774418641731515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c258a29d3847f5%3A0x564dfbba0141774a!2s5th%20Ave%2C%20New%20York%2C%20NY%2C%20Stati%20Uniti!5e0!3m2!1sit!2ses!4v1661414716655!5m2!1sit!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!--/map_contact -->

    <div class="container margin_120_95" id="booking_section">
        <div class="row justify-content-between">
            <div class="col-xl-4">
                <div data-cue="slideInUp">
                    <div class="title">
                        <small>{{ $ui['availability_small'] }}</small>
                        <h2>{{ $ui['availability_title'] }}</h2>
                    </div>
                    <p>{{ $ui['availability_text'] }}</p>
                    <p class="phone_element no_borders">
                        <a href="tel:{{ $primaryPhoneHref }}">
                            <i class="bi bi-telephone"></i>
                            <span><em>{{ $ui['info_booking'] }}</em>{{ $primaryPhone ?: '-' }}</span>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-xl-7">
                <div data-cue="slideInUp" data-delay="200">
                    <div class="booking_wrapper">
                        <div class="col-12">
                            <input type="hidden" id="date_booking" name="date_booking">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="custom_select">
                                    <select class="wide">
                                        <option>{{ $ui['select_room'] }}</option>
                                        <option>{{ $ui['select_room'] }}</option>
                                        <option>{{ $ui['select_room'] }}</option>
                                        <option>{{ $ui['select_room'] }}</option>
                                        <option>{{ $ui['select_room'] }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="adults_booking">
                                            <input type="text" name="adults_booking" id="adults_booking" value="" class="qty form-control" placeholder="{{ $ui['adults'] }}">
                                            <input type="button" value="-" class="qtyminus" name="adults_booking">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3 qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="childs_booking">
                                            <input type="text" name="childs_booking" id="childs_booking" value="" class="qty form-control" placeholder="{{ $ui['children'] }}">
                                            <input type="button" value="-" class="qtyminus" name="childs_booking">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / row -->
                    <p class="text-end mt-5"><a href="#0" class="btn_1 outline">{{ $ui['book_now'] }}</a></p>
                </div>
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

</main>
@endsection
