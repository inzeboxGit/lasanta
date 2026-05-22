<!-- Rooms 1 -->
@php
    $sectionDescription = '';

    if (isset($appartmentPageSetting)) {
        $locale = app()->getLocale();

        if ($locale === 'fr') {
            $sectionDescription = trim((string) ($appartmentPageSetting->home_description ?? ''));
        } elseif (method_exists($appartmentPageSetting, 'translations')) {
            $sectionDescription = trim((string) ($appartmentPageSetting->translations()
                ->where('field', 'home_description')
                ->where('locale', $locale)
                ->value('value') ?? ''));
        }
    }
@endphp
<section class="rooms1 section-padding bg-darkgray">
    <div class="container">
        <div class="row mb-30">
            <div class="row mb-30 align-items-center" bis_skin_checked="1">
                <div class="col-md-5 text-left" bis_skin_checked="1">
                    <div class="section-subtitle brown" bis_skin_checked="1">{{ $apartmentsSubtitle }}</div>
                    <!-- <div class="section-title white mb-0" bis_skin_checked="1">Rooms &amp; Suites</div> -->
                    
                    @php
                        $safeTitle = e($apartmentsTitle);
                        $titleHtml = str_replace('&amp;', '<span class="brown">&</span>', $safeTitle);
                    @endphp
                <div class="section-title white mb-0">{!! $titleHtml !!}</div>
                </div>
                <div class="col-md-5" bis_skin_checked="1">
                    @if($sectionDescription !== '')
                        <p>{{ $sectionDescription }}</p>
                    @endif
                </div>
                <div class="col-md-2 d-flex justify-content-center justify-content-lg-end" bis_skin_checked="1">
                    <div class="my-owl-nav" bis_skin_checked="1"> <span class="my-prev-button">
                            <i class="fa-light fa-angle-left" aria-hidden="true"></i>
                        </span> <span class="my-next-button">
                            <i class="fa-light fa-angle-right" aria-hidden="true"></i>
                        </span> </div>
                </div>
            </div>
            <!-- <div class="col-12 text-center">
                <div class="section-subtitle brown">{{ $apartmentsSubtitle }}</div>
                @php
                    $safeTitle = e($apartmentsTitle);
                    $titleHtml = str_replace('&amp;', '<span class="brown">&</span>', $safeTitle);
                @endphp
                <div class="section-title white mb-0">{!! $titleHtml !!}</div>
            </div>
           
        </div> -->
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


<!-- 
<section class="rooms3 section-padding bg-darkgray">
        <div class="row" bis_skin_checked="1">
            <div class="col-md-12 mb-25 text-center" bis_skin_checked="1">
                <div class="section-subtitle" bis_skin_checked="1">{{ $apartmentsSubtitle }}</div>
                @php
                    $safeTitle = e($apartmentsTitle);
                    $titleHtml = str_replace('&amp;', '<span>&amp;</span>', $safeTitle);
                @endphp
                <div class="section-title white" bis_skin_checked="1">{!! $titleHtml !!}</div>
            </div>
        </div>
        <div class="row" bis_skin_checked="1">
            <div class="col-md-12" bis_skin_checked="1">
                <div class="owl-carousel owl-theme" bis_skin_checked="1">
                    @forelse(($homeRooms ?? collect()) as $room)
                        @php
                            $bedAmenity  = $room->amenities->first(fn($a) => preg_match('/\blits?\b/i', $a->title));
                            $bathAmenity = $room->amenities->first(fn($a) => preg_match('/salle\s*de\s*bain|bathroom/i', $a->title));
                        @endphp
                    <div class="item" bis_skin_checked="1">
                        <div class="img" bis_skin_checked="1"><img src="{{ media_url($room->main_image ?? null, 'themes/lasanta/img/restaurant/1.jpg') }}" class="img-fluid" alt="{{ method_exists($room, 't') ? $room->t('title') : $room->title }}"></div>
                        @if(!empty($room->discount)) <span class="discount"><i class="fa-light fa-badge-percent"></i> {{ $room->discount }}%</span>@endif
                        <div class="cont" bis_skin_checked="1">
                            <div class="title" bis_skin_checked="1"><a href="{{ route('rooms.show', $room->slug) }}">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</a></div>
                            <div class="details" bis_skin_checked="1"> @if($bedAmenity)<span><i class="fa-thin fa-bed-front"></i> {{ method_exists($bedAmenity, 't') ? $bedAmenity->t('title') : $bedAmenity->title }}</span>@endif @if($bathAmenity)<span><i class="fa-thin fa-bath"></i>{{ method_exists($bathAmenity, 't') ? $bathAmenity->t('title') : $bathAmenity->title }}</span>@endif @if(!empty($room->external_id))<span><i class="fa-thin fa-expand"></i> {{ $room->external_id }} m²</span>@endif </div>
                        </div>
                    </div>
                    @empty
                    <div class="item" bis_skin_checked="1">
                        <div class="cont" bis_skin_checked="1">
                            <div class="title" bis_skin_checked="1"><a href="#">Aucun appartement publié</a></div>
                            <div class="details" bis_skin_checked="1"></div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section> -->
