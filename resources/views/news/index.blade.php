@extends('layouts.app')

@section('content')
<main>
    @php
        $locale = app()->getLocale();
        $labels = [
            'fr' => ['small' => 'Expérience hôtelière', 'title' => 'Actualités et événements', 'event' => 'Événement', 'read_more' => 'Lire plus', 'empty' => 'Aucune actualité.'],
            'en' => ['small' => 'Hotel Experience', 'title' => 'News and Events', 'event' => 'Event', 'read_more' => 'Read more', 'empty' => 'No news.'],
            'de' => ['small' => 'Hotelerlebnis', 'title' => 'Neuigkeiten und Events', 'event' => 'Event', 'read_more' => 'Mehr lesen', 'empty' => 'Keine Neuigkeiten.'],
            'nl' => ['small' => 'Hotelbeleving', 'title' => 'Nieuws en evenementen', 'event' => 'Evenement', 'read_more' => 'Lees meer', 'empty' => 'Geen nieuws.'],
        ];
        $ui = $labels[$locale] ?? $labels['en'];
        $heroSrc = media_url($newsPageSetting->header_image ?? null, 'img/hero_home_2.jpg');
    @endphp

    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ $heroSrc }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">{{ method_exists($newsPageSetting, 't') ? $newsPageSetting->t('subtitle') : ($newsPageSetting->subtitle ?? $ui['small']) }}</small>
                <h1 class="slide-animated two">{{ method_exists($newsPageSetting, 't') ? $newsPageSetting->t('title') : ($newsPageSetting->title ?? $ui['title']) }}</h1>
                <p class="slide-animated three mb-0">{{ method_exists($newsPageSetting, 't') ? $newsPageSetting->t('hero_text') : ($newsPageSetting->hero_text ?? '') }}</p>
            </div>
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="container margin_120_95">
        <div class="isotope-wrapper">
            <div class="row justify-content-start">
                @forelse($items as $item)
                    <div class="item col-xl-4 col-lg-6">
                        <a href="{{ route('news.show', $item->slug) }}" class="box_contents" data-cue="slideInUp">
                            <figure>
                                <img src="{{ $item->cover_image ? asset('storage/' . $item->cover_image) : asset('img/blog-1.jpg') }}" alt="" class="img-fluid">
                                @if($item->published_at)
                                    <em>{{ $item->published_at->format('d M') }}</em>
                                @endif
                            </figure>
                            <div class="wrapper">
                                <small>{{ $ui['event'] }}<span></span></small>
                                <h2>{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</h2>
                                <em>{{ $ui['read_more'] }}</em>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">{{ $ui['empty'] }}</div>
                @endforelse
            </div>
            <!--/row -->
        </div>
        <!--/isotope-wrapper -->

        <div class="pagination__wrapper">
            {{ $items->links() }}
        </div>
        <!-- /pagination -->

    </div>
    <!--/container -->
</main>
@endsection
