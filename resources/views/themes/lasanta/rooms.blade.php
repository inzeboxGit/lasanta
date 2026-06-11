@extends('themes.lasanta.layouts.app')

@php
    $headerImage = media_url($appartmentPageSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
@endphp

@push('styles')
    <link rel="preload" as="image" href="{{ $headerImage }}" fetchpriority="high">
@endpush

@section('content')
<section class="rooms banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ $headerImage }}" style="background-image: url('{{ $headerImage }}');">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="subtitle">{{ method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('subtitle') : ($appartmentPageSetting->subtitle ?? 'Expérience hôtelière') }}</div>
                @php
                    $rawTitle = method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('title') : ($appartmentPageSetting->title ?? 'Nos appartements');
                    $safeTitle = e($rawTitle);
                    $titleHtml = str_replace('&amp;', '<span class="brown">&</span>', $safeTitle);
                @endphp
                <div class="title">{!! $titleHtml !!}</div>
            </div>
        </div>
    </div>
</section>

<section class="rooms2 section-padding">
    <div class="container">

        @php $roomsList = ($rooms ?? collect()); @endphp

        @forelse($roomsList as $room)
        @php
            $roomTitle       = method_exists($room, 't') ? ($room->t('title') ?: $room->title) : $room->title;
            $roomDescription = method_exists($room, 't') ? ($room->t('description') ?: ($room->description ?? '')) : ($room->description ?? '');
            $gallery         = array_values(array_filter(array_merge(
                $room->main_image ? [$room->main_image] : [],
                is_array($room->gallery) ? $room->gallery : []
            )));
            $amenities       = ($room->amenities ?? collect())->take(4);
            $isEven          = $loop->index % 2 === 1; // 0-based: even index = odd row = carousel left
            $isLast          = $loop->last;
            $rowBr           = $isEven ? 'br-5005' : 'br-0550';
            $imgBr           = $isEven ? 'br-0550' : 'br-5005';
            $rowMb           = $isLast  ? '' : ' mb-90';
            $isPriorityRoom  = $loop->first;
        @endphp

        <div class="row g-0 justify-content-center align-items-center bg-lightbrown {{ $rowBr }}{{ $rowMb }}">

            @if(!$isEven)
            {{-- Odd rows: carousel LEFT --}}
            <div class="col-lg-7 col-md-12">
                <div class="owl-carousel owl-theme">
                    @forelse($gallery as $image)
                        <div class="img">
                            <img src="{{ media_url($image) }}" class="img-fluid {{ $imgBr }}" alt="{{ $roomTitle }}" width="1080" height="900" loading="{{ $isPriorityRoom ? 'eager' : 'lazy' }}" fetchpriority="{{ $isPriorityRoom ? 'high' : 'auto' }}" decoding="async">
                        </div>
                    @empty
                        <div class="img">
                            <img src="{{ asset('themes/lasanta/img/restaurant/2.jpg') }}" class="img-fluid {{ $imgBr }}" alt="{{ $roomTitle }}" width="1080" height="900" loading="{{ $isPriorityRoom ? 'eager' : 'lazy' }}" fetchpriority="{{ $isPriorityRoom ? 'high' : 'auto' }}" decoding="async">
                        </div>
                    @endforelse
                </div>
            </div>
            @endif

            {{-- Details column --}}
            <div class="{{ $isEven ? 'col-lg-5' : 'col-lg-5' }} col-md-12">
                <div class="item">
                    <h3 class="title">{{ $roomTitle }}</h3>
                    <p>{!! \Illuminate\Support\Str::words(strip_tags($roomDescription), 20, '…') !!}</p>

                    @if($amenities->isNotEmpty())
                    <div class="row room-features">
                        @foreach($amenities->chunk(2) as $chunk)
                        <div class="col-lg-6 col-md-12">
                            <ul>
                                @foreach($chunk as $amenity)
                                <li>
                                    <i class="{{ $amenity->icon ?? 'fa-thin fa-check' }}"></i>
                                    {{ method_exists($amenity, 't') ? ($amenity->t('title') ?: $amenity->title) : $amenity->title }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="line-dec"></div>
                    <div class="book">
                        <div>
                            @if($room->price_per_night)
                                <div class="price">{{ number_format($room->price_per_night, 0) }} € <span>/ nuit</span></div>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('rooms.show', $room->slug) }}" class="button-3">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>

            @if($isEven)
            {{-- Even rows: carousel RIGHT --}}
            <div class="col-lg-7 col-md-12">
                <div class="owl-carousel owl-theme">
                    @forelse($gallery as $image)
                        <div class="img">
                            <img src="{{ media_url($image) }}" class="img-fluid {{ $imgBr }}" alt="{{ $roomTitle }}" width="1080" height="900" loading="{{ $isPriorityRoom ? 'eager' : 'lazy' }}" fetchpriority="{{ $isPriorityRoom ? 'high' : 'auto' }}" decoding="async">
                        </div>
                    @empty
                        <div class="img">
                            <img src="{{ asset('themes/lasanta/img/restaurant/2.jpg') }}" class="img-fluid {{ $imgBr }}" alt="{{ $roomTitle }}" width="1080" height="900" loading="{{ $isPriorityRoom ? 'eager' : 'lazy' }}" fetchpriority="{{ $isPriorityRoom ? 'high' : 'auto' }}" decoding="async">
                        </div>
                    @endforelse
                </div>
            </div>
            @endif

        </div>{{-- /row --}}

        @empty
            <div class="row"><div class="col-12 text-center py-5">Aucun appartement publié.</div></div>
        @endforelse

    </div>
</section>

@include('themes.lasanta.partials.home.faqs', [
    'homeFaqs'          => $homeFaqs ?? collect(),
    'faqSectionSetting' => $faqSectionSetting ?? null,
])

@endsection
