@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $heroImage = media_url($news->hero_image ?? null, 'themes/lasanta/img/blog/1.jpg');
    $coverImage = media_url($news->cover_image ?? null, 'themes/lasanta/img/blog/p1.jpg');
@endphp
<section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $heroImage }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <div class="subtitle">{{ $news->published_at?->format('d M Y') }} @if($news->author) - {{ $news->author }} @endif</div>
                <div class="title">{{ method_exists($news, 't') ? $news->t('title') : $news->title }}</div>
            </div>
        </div>
    </div>
</section>

<section class="post section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 mb-60">
                @if(method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt)
                    <div class="section-subtitle">{{ method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt }}</div>
                @endif
                <div class="section-title">{{ method_exists($news, 't') ? $news->t('title') : $news->title }}</div>
                @if(method_exists($news, 't') ? $news->t('body') : $news->body)
                    <p class="mb-30">{!! nl2br(e(method_exists($news, 't') ? $news->t('body') : $news->body)) !!}</p>
                @endif
                <img src="{{ $coverImage }}" class="rounded-2 img-fluid" alt="">
            </div>
            <div class="col-lg-10 text-center">
                <a href="{{ route('news.index') }}" class="button-3">Retour aux actualités</a>
            </div>
        </div>
    </div>
</section>
@endsection
