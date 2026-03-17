<!-- chambres hotel -->
@php
    $locale = app()->getLocale();
    $labels = [
        'fr' => ['small' => 'Expérience hôtelière', 'title' => 'Chambres et suites', 'from' => 'À partir de', 'per_night' => '€/nuit', 'double' => 'Chambres Doubles', 'superior' => 'Chambres Supérieures', 'exclusive' => 'Chambres Exclusives', 'view_all' => 'Voir toutes les chambres'],
        'en' => ['small' => 'Hotel Experience', 'title' => 'Rooms and Suites', 'from' => 'From', 'per_night' => 'EUR/night', 'double' => 'Double Rooms', 'superior' => 'Superior Rooms', 'exclusive' => 'Exclusive Rooms', 'view_all' => 'View all rooms'],
        'de' => ['small' => 'Hotelerlebnis', 'title' => 'Zimmer und Suiten', 'from' => 'Ab', 'per_night' => 'EUR/Nacht', 'double' => 'Doppelzimmer', 'superior' => 'Superior-Zimmer', 'exclusive' => 'Exklusive Zimmer', 'view_all' => 'Alle Zimmer anzeigen'],
        'nl' => ['small' => 'Hotelbeleving', 'title' => 'Kamers en suites', 'from' => 'Vanaf', 'per_night' => 'EUR/nacht', 'double' => 'Tweepersoonskamers', 'superior' => 'Superior kamers', 'exclusive' => 'Exclusieve kamers', 'view_all' => 'Bekijk alle kamers'],
    ];
    $ui = $labels[$locale] ?? $labels['en'];
@endphp
<div class="title mb-3">
    <small data-cue="slideInUp">{{ $ui['small'] }}</small>
    <h2 data-cue="slideInUp" data-delay="200">{{ $ui['title'] }}</h2>
</div>

<div class="row justify-content-center add_bottom_90" data-cues="slideInUp" data-delay="300">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
        <a href="{{ route('appartements.index') }}" class="box_cat_rooms">
            <figure>
                <div class="background-image" data-background="url({{ asset('img/rooms/1.jpg') }})"></div>
                <div class="info">
                    <small>{{ $ui['from'] }} 66 {{ $ui['per_night'] }}</small>
                    <h3>{{ $ui['double'] }}</h3>
                </div>
            </figure>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <a href="{{ route('appartements.index') }}" class="box_cat_rooms">
            <figure>
                <div class="background-image" data-background="url({{ asset('img/rooms/2.jpg') }})"></div>
                <div class="info">
                    <small>{{ $ui['from'] }} 95 {{ $ui['per_night'] }}</small>
                    <h3>{{ $ui['superior'] }}</h3>
                </div>
            </figure>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <a href="{{ route('appartements.index') }}" class="box_cat_rooms">
            <figure>
                <div class="background-image" data-background="url({{ asset('img/rooms/3.jpg') }})"></div>
                <div class="info">
                    <small>{{ $ui['from'] }} 150 {{ $ui['per_night'] }}</small>
                    <h3>{{ $ui['exclusive'] }}</h3>
                </div>
            </figure>
        </a>
    </div>
    <p class="text-end"><a href="{{ route('appartements.index') }}" class="btn_1 outline mt-2">{{ $ui['view_all'] }}</a></p>
</div>
<!-- /row-->
