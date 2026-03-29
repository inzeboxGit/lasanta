<!-- Actualités et événements -->
@php
    $locale = app()->getLocale();
    $labels = [
        'fr' => ['small' => 'Expérience hôtelière', 'title' => 'Actualités et événements', 'event' => 'Événement', 'read_more' => 'Lire plus', 'empty' => 'Aucune actualité pour le moment.', 'view_all' => 'Voir toutes les actualités'],
        'en' => ['small' => 'Hotel Experience', 'title' => 'News and Events', 'event' => 'Event', 'read_more' => 'Read more', 'empty' => 'No news at the moment.', 'view_all' => 'View all news'],
        'de' => ['small' => 'Hotelerlebnis', 'title' => 'Neuigkeiten und Events', 'event' => 'Event', 'read_more' => 'Mehr lesen', 'empty' => 'Derzeit keine Neuigkeiten.', 'view_all' => 'Alle Neuigkeiten anzeigen'],
        'it' => ['small' => 'Esperienza hoteliera', 'title' => 'News ed eventi', 'event' => 'Evento', 'read_more' => 'Scopri di più', 'empty' => 'Al momento nessuna notizia.', 'view_all' => 'Vedi tutte le news'],
    ];
    $ui = $labels[$locale] ?? $labels['en'];
@endphp
<div class="bg_white">
    <div class="container margin_120_95">
        <div class="title mb-3">
            <small data-cue="slideInUp">{{ $ui['small'] }}</small>
            <h2 data-cue="slideInUp" data-delay="200">{{ $ui['title'] }}</h2>
        </div>
        <div class="row justify-content-center home">
            @php
                $fallbackImages = ['img/blog-1.jpg', 'img/blog-3.jpg', 'img/blog-2.jpg'];
            @endphp
            @forelse(($homeNews ?? collect()) as $item)
                @php
                    $fallback = $fallbackImages[$loop->index % count($fallbackImages)];
                    $coverSrc = $item->cover_image ? asset('storage/' . $item->cover_image) : asset($fallback);
                    $delay = 300 + ($loop->index * 100);
                @endphp
                <div class="item col-xl-4 col-lg-6">
                    <a href="{{ route('news.show', $item->slug) }}" class="box_contents" data-cue="slideInUp" data-delay="{{ $delay }}">
                        <figure style="aspect-ratio: 4 / 3; overflow: hidden;">
                            <img src="{{ $coverSrc }}" alt="{{ method_exists($item, 't') ? $item->t('title') : $item->title }}" class="img-fluid" style="width:100%; height:100%; object-fit:cover;">
                            @if($item->published_at)
                                <em>{{ $item->published_at->format('d M') }}</em>
                            @endif
                        </figure>
                        <div class="wrapper">
                            <small>{{ $ui['event'] }}<span></span></small>
                            <h2 style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</h2>
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ method_exists($item, 't') ? $item->t('excerpt') : $item->excerpt }}</p>
                            <em>{{ $ui['read_more'] }}</em>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted">{{ $ui['empty'] }}</div>
            @endforelse
        </div>
        <!--/row -->
        <p class="text-end"><a href="{{ route('news.index') }}" class="btn_1 outline mt-2" data-cue="slideInUp" data-delay="600">{{ $ui['view_all'] }}</a></p>
    </div>
    <!--/container -->
</div>
<!--/bg_white -->
