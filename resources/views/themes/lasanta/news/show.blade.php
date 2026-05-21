@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $heroSource = $news->hero_image ?: ($news->cover_image ?: null);
    $heroImage = $heroSource ? media_url($heroSource, '') : '';
    $coverImage = !empty($news->cover_image) ? media_url($news->cover_image, '') : '';
    $heroHeightClass = $heroImage ? 'full-height' : 'middle-height';
@endphp
<section class="banner-header {{ $heroHeightClass }} valign {{ $heroImage ? 'bg-img' : '' }}" data-overlay-dark="5" @if($heroImage) data-background="{{ $heroImage }}" style="background-image: url('{{ $heroImage }}');" @else style="padding-top: 120px !important; padding-bottom: 120px !important;" @endif>
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
                <!-- @if(method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt)
                    <div class="section-subtitle">{{ method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt }}</div>
                @endif -->
                <div class="section-title">{{ method_exists($news, 't') ? $news->t('title') : $news->title }}</div>
                @if(method_exists($news, 't') ? $news->t('body') : $news->body)
                    <p class="mb-30">{!! nl2br(e(method_exists($news, 't') ? $news->t('body') : $news->body)) !!}</p>
                @endif
                @if($coverImage)
                    <img src="{{ $coverImage }}" class="rounded-2 img-fluid" alt="">
                @endif
            </div>
            <div class="col-lg-10 text-center">
                <a href="{{ route('news.index') }}" class="button-3">Retour aux actualités</a>
            </div>
        </div>
    </div>
</section>
@endsection
