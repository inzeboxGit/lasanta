@extends('layouts.app')

@section('content')
<main>
    @php
    $locale = app()->getLocale();
    $labels = [
    'fr' => [
    'hero_small' => '', 'hero_title' => '',
    'address' => 'Adresse', 'email' => 'Adresse email', 'phone' => 'Téléphone', 'hours' => 'Lundi à vendredi 9h - 19h',
    'touch' => 'Contactez-nous', 'name' => 'Prénom', 'lastname' => 'Nom', 'message' => 'Message', 'human' => 'Êtes-vous
    humain ? 3 + 1 =', 'submit' => 'Envoyer',
    'availability_small' => '', 'availability_title' => '', 'availability_text' => '',
    'info_booking' => 'Infos et réservations', 'select_room' => 'Sélectionner un appartement', 'adults' => 'Adultes',
    'children' => 'Enfants', 'book_now' => 'Réserver maintenant',
    ],
    'en' => [
    'hero_small' => '', 'hero_title' => '',
    'address' => 'Address', 'email' => 'Email address', 'phone' => 'Telephone', 'hours' => 'Monday to Friday 9am - 7pm',
    'touch' => 'Get in Touch', 'name' => 'Name', 'lastname' => 'Last name', 'message' => 'Message', 'human' => 'Are you
    human? 3 + 1 =', 'submit' => 'Submit',
    'availability_small' => '', 'availability_title' => '', 'availability_text' => '',
    'info_booking' => 'Info and bookings', 'select_room' => 'Select apartment', 'adults' => 'Adults', 'children' =>
    'Children', 'book_now' => 'Book now',
    ],
    'de' => [
    'hero_small' => '', 'hero_title' => '',
    'address' => 'Adresse', 'email' => 'E-Mail-Adresse', 'phone' => 'Telefon', 'hours' => 'Montag bis Freitag 9:00 -
    19:00',
    'touch' => 'Kontaktieren Sie uns', 'name' => 'Vorname', 'lastname' => 'Nachname', 'message' => 'Nachricht', 'human'
    => 'Sind Sie ein Mensch? 3 + 1 =', 'submit' => 'Senden',
    'availability_small' => '', 'availability_title' => '', 'availability_text' => '',
    'info_booking' => 'Info und Buchung', 'select_room' => 'Apartment auswählen', 'adults' => 'Erwachsene', 'children'
    => 'Kinder', 'book_now' => 'Jetzt buchen',
    ],
    'it' => [
    'hero_small' => '', 'hero_title' => '',
    'address' => 'Indirizzo', 'email' => 'Indirizzo email', 'phone' => 'Telefono', 'hours' => 'Lunedì a venerdì 9:00 -
    19:00',
    'touch' => 'Contattaci', 'name' => 'Nome', 'lastname' => 'Cognome', 'message' => 'Messaggio', 'human' => 'Sei umano?
    3 + 1 =', 'submit' => 'Invia',
    'availability_small' => '', 'availability_title' => '', 'availability_text' => '',
    'info_booking' => 'Informazioni e prenotazioni', 'select_room' => 'Seleziona appartamento', 'adults' => 'Adulti',
    'children' => 'Bambini', 'book_now' => 'Prenota ora',
    ],
    ];
    $ui = $labels[$locale] ?? $labels['en'];

    $primaryPhone = $siteSetting->phone_primary ?? '';
    $secondaryPhone = $siteSetting->phone_secondary ?? '';
    $primaryPhoneHref = preg_replace('/\s+/', '', (string) $primaryPhone);
    $secondaryPhoneHref = preg_replace('/\s+/', '', (string) $secondaryPhone);
    $heroSrc = media_url($contactPageSetting->header_image ?? null, '');
    $contactAddress = method_exists($siteSetting, 't')
    ? $siteSetting->t('address')
    : ($siteSetting->address ?? '');
    $contactAddress = $contactAddress ?: "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA, France";
    $availabilitySmall = method_exists($contactPageSetting, 't')
    ? $contactPageSetting->t('availability_small')
    : ($contactPageSetting->availability_small ?? $ui['availability_small']);
    $availabilityTitle = method_exists($contactPageSetting, 't')
    ? $contactPageSetting->t('availability_title')
    : ($contactPageSetting->availability_title ?? $ui['availability_title']);
    $availabilityText = method_exists($contactPageSetting, 't')
    ? $contactPageSetting->t('availability_text')
    : ($contactPageSetting->availability_text ?? $ui['availability_text']);
    $settingTranslation = function (string $field, string $default) use ($contactPageSetting, $locale) {
    if ($locale === 'fr') {
    return $contactPageSetting->{$field} ?? $default;
    }

    if (method_exists($contactPageSetting, 'translations') && $contactPageSetting->relationLoaded('translations')) {
    $translatedValue = $contactPageSetting->translations
    ->first(fn ($item) => $item->locale === $locale && $item->field === $field)?->value;

    if (!empty($translatedValue)) {
    return $translatedValue;
    }
    }

    return $default;
    };
    $calendarDefaults = [
    'fr' => ['night' => 'nuit', 'nights' => 'nuits'],
    'en' => ['night' => 'night', 'nights' => 'nights'],
    'de' => ['night' => 'Nacht', 'nights' => 'Nächte'],
    'it' => ['night' => 'notte', 'nights' => 'notti'],
    ];
    $infoBookingLabel = $settingTranslation('info_booking_label', $ui['info_booking']);
    $selectRoomLabel = $settingTranslation('select_room_label', $ui['select_room']);
    $adultsLabel = $settingTranslation('adults_label', $ui['adults']);
    $childrenLabel = $settingTranslation('children_label', $ui['children']);
    $bookNowLabel = $settingTranslation('book_now_label', $ui['book_now']);
    $calendarUi = $calendarDefaults[$locale] ?? $calendarDefaults['en'];
    $mapLatitude = $contactPageSetting->map_latitude ?? 42.6043096;
    $mapLongitude = $contactPageSetting->map_longitude ?? 8.9295210;
    $mapSrc = 'https://www.google.com/maps?q=' . $mapLatitude . ',' . $mapLongitude . '&z=15&output=embed';
    @endphp

    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ $heroSrc }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
            data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">{{ method_exists($contactPageSetting, 't') ?
                    $contactPageSetting->t('subtitle') : ($contactPageSetting->subtitle ?? $ui['hero_small']) }}</small>
                <h1 class="slide-animated two">{{ method_exists($contactPageSetting, 't') ?
                    $contactPageSetting->t('title') : ($contactPageSetting->title ?? $ui['hero_title']) }}</h1>
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
                            <div>{{ $contactAddress }}</div>
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
                                <!-- <br><small>{{ $ui['hours'] }}</small> -->
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
                                <input class="form-control" type="text" id="name_contact" name="name_contact"
                                    value="{{ old('name_contact') }}" placeholder="Name">
                                <label for="name_contact">{{ $ui['name'] }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="lastname_contact" name="lastname_contact"
                                    value="{{ old('lastname_contact') }}" placeholder="Last Name">
                                <label for="lastname_contact">{{ $ui['lastname'] }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="email" id="email_contact" name="email_contact"
                                    value="{{ old('email_contact') }}" placeholder="{{ $ui['email'] }}">
                                <label for="email_contact">{{ $ui['email'] }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="phone_contact" name="phone_contact"
                                    value="{{ old('phone_contact') }}" placeholder="{{ $ui['phone'] }}">
                                <label for="phone_contact">{{ $ui['phone'] }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="form-floating mb-4">
                        <textarea class="form-control" placeholder="{{ $ui['message'] }}" id="message_contact"
                            name="message_contact">{{ old('message_contact') }}</textarea>
                        <label for="message_contact">{{ $ui['message'] }}</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="verify_contact" name="verify_contact"
                                    value="{{ old('verify_contact') }}" placeholder="{{ $ui['human'] }}">
                                <label for="verify_contact">{{ $ui['human'] }}</label>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3"><input type="submit" value="{{ $ui['submit'] }}" class="btn_1 outline"
                            id="submit-contact"></p>
                </form>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!--/container -->

    <div class="map_contact">
        <iframe src="{{ $mapSrc }}" width="600"
            height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!--/map_contact -->

    <div class="container margin_120_95" id="booking_section">
        <div class="row justify-content-between">
            <div class="col-xl-4">
                <div data-cue="slideInUp">
                    <div class="title">
                        <small>{{ $availabilitySmall }}</small>
                        <h2>{{ $availabilityTitle }}</h2>
                    </div>
                    <p>{{ $availabilityText }}</p>
                    <p class="phone_element no_borders">
                        <a href="tel:{{ $primaryPhoneHref }}">
                            <i class="bi bi-telephone"></i>
                            <span><em>{{ $infoBookingLabel }}</em>{{ $primaryPhone ?: '-' }}</span>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-xl-7">
                <div data-cue="slideInUp" data-delay="200">
                    <div class="booking_wrapper">
                        <div class="col-12">
                            <input type="hidden" id="date_booking" name="date_booking"
                                data-night-label="{{ $calendarUi['night'] }}"
                                data-nights-label="{{ $calendarUi['nights'] }}">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="custom_select">
                                    <select class="wide">
                                        <option selected disabled>{{ $selectRoomLabel }}</option>
                                        @foreach(($rooms ?? collect()) as $room)
                                            <option>{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="adults_booking">
                                            <input type="text" name="adults_booking" id="adults_booking" value=""
                                                class="qty form-control" placeholder="{{ $adultsLabel }}">
                                            <input type="button" value="-" class="qtyminus" name="adults_booking">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3 qty-buttons mb-3 version_2">
                                            <input type="button" value="+" class="qtyplus" name="childs_booking">
                                            <input type="text" name="childs_booking" id="childs_booking" value=""
                                                class="qty form-control" placeholder="{{ $childrenLabel }}">
                                            <input type="button" value="-" class="qtyminus" name="childs_booking">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / row -->
                    <p class="text-end mt-5"><a href="#0" class="btn_1 outline">{{ $bookNowLabel }}</a></p>
                </div>
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

</main>
@endsection
