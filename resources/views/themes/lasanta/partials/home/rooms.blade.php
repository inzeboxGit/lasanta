<!-- <section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle">{{ $apartmentsSubtitle }}</div>
                <div class="section-title">{{ $apartmentsTitle }}</div>
            </div>
        </div>
        <div class="row">
            @forelse(($homeRooms ?? collect()) as $room)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img">
                            <img src="{{ media_url($room->main_image ?? null, 'themes/lasanta/img/restaurant/1.jpg') }}" class="img-fluid" alt="">
                            <div class="cat">Appartement</div>
                        </div>
                        <div class="cont">
                            <h4><a href="{{ route('rooms.show', $room->slug) }}">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</a></h4>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(method_exists($room, 't') ? $room->t('description') : ($room->description ?? '')), 120) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">Aucun appartement publié.</div>
            @endforelse
        </div>
    </div>
</section> -->

<!-- Rooms 1 -->
<section class="rooms1 section-padding bg-darkgray">
    <div class="container">
        <div class="row mb-30 align-items-center">
            <div class="col-md-5 text-left">
                <div class="section-subtitle">{{ $apartmentsSubtitle }}</div>
                <div class="section-title white mb-0">{{ $apartmentsTitle }}</div>
            </div>
            <!-- <div class="col-md-5">
                <p>The experience elementum sesue the aucan vestibulum usto sapien rutrum volutan donec fermen lorem ipsum quisque sodales miss in the varius drana miss.</p>
            </div> -->
            <!-- <div class="col-md-2 d-flex justify-content-center justify-content-lg-end">
                <div class="my-owl-nav"> <span class="my-prev-button">
                        <i class="fa-light fa-angle-left" aria-hidden="true"></i>
                    </span> <span class="my-next-button">
                        <i class="fa-light fa-angle-right" aria-hidden="true"></i>
                    </span> </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme">
                    @forelse(($homeRooms ?? collect()) as $room)
                    <div class="item mt-20">
                        <div class="img">
                            <img src="{{ media_url($room->main_image ?? null, 'themes/lasanta/img/restaurant/1.jpg') }}" alt="">
                            @if(!empty($room->discount))
                            <span class="discount"><i class="fa-light fa-badge-percent"></i> {{ $room->discount }}%</span>
                            @endif
                        </div>
                        <div class="wrap">
                            <div class="cont">
                                <!-- <div class="price">
                                    @if(!empty($room->price_per_night))
                                        {{ number_format($room->price_per_night, 0, ',', ' ') }} € <span>/ nuit</span>
                                    @else
                                        Sur devis <span>/ nuit</span>
                                    @endif
                                </div> -->
                                <h3><a href="{{ route('rooms.show', $room->slug) }}">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</a></h3>
                                <div class="details">
                                    @php
                                        $bedAmenity  = $room->amenities->first(fn($a) => preg_match('/\blits?\b/i', $a->title));
                                        $bathAmenity = $room->amenities->first(fn($a) => preg_match('/salle\s*de\s*bain|bathroom/i', $a->title));
                                    @endphp
                                    @if($bedAmenity)
                                    <span>
                                        <i class="fa-thin fa-bed-front"></i>
                                        {{ method_exists($bedAmenity, 't') ? $bedAmenity->t('title') : $bedAmenity->title }}
                                    </span>
                                    @endif
                                    @if(!empty($room->external_id))
                                    <span>
                                        <i class="fa-thin fa-expand"></i>
                                        {{ $room->external_id }} m²
                                    </span>
                                    @endif
                                    @if($bathAmenity)
                                    <span>
                                        <i class="fa-thin fa-bath"></i>
                                        {{ method_exists($bathAmenity, 't') ? $bathAmenity->t('title') : $bathAmenity->title }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="arrow"> <a href="{{ route('rooms.show', $room->slug) }}"><span class="fa-regular fa-arrow-right"></span></a> </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>