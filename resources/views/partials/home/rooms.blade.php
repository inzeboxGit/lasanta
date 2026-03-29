<!-- chambres hotel -->
@php
$locale = app()->getLocale();
$labels = [
'fr' => ['small' => 'Expérience hôtelière....', 'title' => 'Chambres et suites', 'from' => 'À partir de', 'per_night' =>
'€/nuit', 'double' => 'Chambres Doubles', 'superior' => 'Chambres Supérieures', 'exclusive' => 'Chambres Exclusives',
'view_all' => 'Voir toutes les chambres'],
'en' => ['small' => 'Hotel Experience', 'title' => 'Rooms and Suites', 'from' => 'From', 'per_night' => 'EUR/night',
'double' => 'Double Rooms', 'superior' => 'Superior Rooms', 'exclusive' => 'Exclusive Rooms', 'view_all' => 'View all
rooms'],
'de' => ['small' => 'Hotelerlebnis', 'title' => 'Zimmer und Suiten', 'from' => 'Ab', 'per_night' => 'EUR/Nacht',
'double' => 'Doppelzimmer', 'superior' => 'Superior-Zimmer', 'exclusive' => 'Exklusive Zimmer', 'view_all' => 'Alle
Zimmer anzeigen'],
'it' => ['small' => 'Esperienza hoteliera', 'title' => 'Camere e suite', 'from' => 'Da', 'per_night' => 'EUR/notte',
'double' => 'Camere doppie', 'superior' => 'Camere superiori', 'exclusive' => 'Camere esclusive', 'view_all' =>
'Vedi tutte le camere'],
];
$ui = $labels[$locale] ?? $labels['en'];
$homeRooms = $homeRooms ?? collect();
@endphp
<div class="title mb-3">
    <small data-cue="slideInUp">{{ $ui['small'] }}</small>
    <h2 data-cue="slideInUp" data-delay="200">{{ $ui['title'] }}</h2>
</div>

<div class="row justify-content-center add_bottom_90" data-cues="slideInUp" data-delay="300">
    @foreach($homeRooms as $room)
        @php
            $columnClass = $loop->first
                ? 'col-xl-6 col-lg-12 col-md-12 col-sm-12'
                : 'col-xl-3 col-lg-6 col-md-6 col-sm-6';
            $imageSrc = !empty($room->main_image)
                ? asset('storage/' . $room->main_image)
                : asset('img/rooms/' . min($loop->iteration, 3) . '.jpg');
            $roomTitle = method_exists($room, 't') ? $room->t('title') : $room->title;
            $roomPrice = $room->price_per_night
                ? $ui['from'] . ' ' . number_format($room->price_per_night, 0) . ' ' . $ui['per_night']
                : '';
        @endphp
        <div class="{{ $columnClass }}">
            <a href="{{ route('rooms.show', $room->slug) }}" class="box_cat_rooms">
                <figure>
                    <div class="background-image" data-background="url({{ $imageSrc }})"></div>
                    <div class="info">
                        <small>{{ $roomPrice }}</small>
                        <h3>{{ $roomTitle }}</h3>
                    </div>
                </figure>
            </a>
        </div>
    @endforeach
    <p class="text-end"><a href="{{ route('appartements.index') }}" class="btn_1 outline mt-2">{{ $ui['view_all'] }}</a>
    </p>
</div>
<!-- /row-->
