@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $defaultTitle = ['fr' => 'Conditions d\'utilisation', 'en' => 'Terms of Use', 'de' => 'AGB', 'it' => 'Condizioni d\'uso'][$locale] ?? 'Terms of Use';
    $title = isset($termsPage) && method_exists($termsPage, 't') ? ($termsPage->t('header_title', $locale) ?: $defaultTitle) : $defaultTitle;
    $subtitle = isset($termsPage) && method_exists($termsPage, 't')
        ? ($termsPage->t('header_subtitle', $locale) ?: ($termsPage->header_subtitle ?? 'Informations légales'))
        : ($termsPage->header_subtitle ?? 'Informations légales');
    $headerBgColor = $termsPage->header_background_color ?? null;
@endphp
@if($headerBgColor)
<section class="banner-header" style="background-color: {{ $headerBgColor }};">
@else
<section class="banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ theme_asset('img/banner/11.jpg') }}">
@endif
    <div class="container"><div class="row"><div class="col-md-12 text-center"><div class="subtitle">{{ $subtitle }}</div><div class="title">{{ $title }}</div></div></div></div>
</section>
<section class="page-details section-padding">
    <div class="container">
        <div class="row justify-content-center"><div class="col-lg-10 legal-content">{!! $termsHtml !!}</div></div>
    </div>
</section>
@endsection
