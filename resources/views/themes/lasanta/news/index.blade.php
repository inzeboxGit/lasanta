@extends('themes.lasanta.layouts.app')

@php
$bttext = ['fr' => 'Par', 'en' => 'By', 'de' => 'Von', 'it' => 'Da'];
$moreLabels = ['fr' => 'Voir plus', 'en' => 'See more', 'de' => 'Mehr sehen', 'it' => 'Vedi di piu'];
@endphp

@section('content')
@php
    $headerImage = media_url($newsPageSetting->header_image ?? null, 'themes/lasanta/img/banner/11.jpg');
@endphp
<section class="banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ $headerImage }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="subtitle">{{ method_exists($newsPageSetting, 't') ? $newsPageSetting->t('subtitle') : ($newsPageSetting->subtitle ?? 'Dernières nouvelles') }}</div>
                <div class="title">{{ method_exists($newsPageSetting, 't') ? $newsPageSetting->t('title') : ($newsPageSetting->title ?? 'Actualités') }}</div>
            </div>
        </div>
    </div>
</section>

<section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            @forelse($items as $item)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img">
                            <img src="{{ media_url($item->cover_image ?? null, 'themes/lasanta/img/blog/1.jpg') }}" class="img-fluid" alt="">
                            @if($item->category ?? null)
                                <div class="cat">{{ $item->category }}</div>
                            @endif
                        </div>
                        <div class="cont">
                            <h4><a href="{{ route('news.show', $item->slug) }}">{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</a></h4>
                            <p>{!! \Illuminate\Support\Str::limit(strip_tags(method_exists($item, 't') ? $item->t('excerpt') : ($item->excerpt ?? '')), 60) !!}</p>
                             <div class="col-lg-7 text-left">
                                <a href="{{ route('news.show', $item->slug) }}" style="padding:0px 8px !important;" class="button-3">{{ $moreLabels[app()->getLocale()] ?? $moreLabels['en'] }}</a>
                            </div>
                            <!-- <div class="author"> -->
                                <!-- <div>
                                    <h5>{{ $item->published_at?->format('d F Y') }}</h5>
                                    @if($item->author ?? null)
                                        <h5>{{ $bttext[app()->getLocale()] ?? 'Par' }} <a href="#" class="text-decoration-line-bottom">La Santa</a></h5>
                                    @endif
                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>  
                </div>
            @empty
                <div class="col-12 text-center">Aucune actualité.</div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-md-12 text-center mt-20">{{ $items->links() }}</div>
        </div>
    </div>
</section>
@endsection
