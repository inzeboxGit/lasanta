@extends('themes.lasanta.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $defaultTitle = ['fr' => 'Mentions légales', 'en' => 'Privacy Policy', 'de' => 'Datenschutzerklärung', 'it' => 'Informativa privacy'][$locale] ?? 'Privacy Policy';
    $title = isset($privacyPage) && method_exists($privacyPage, 't') ? ($privacyPage->t('header_title', $locale) ?: $defaultTitle) : $defaultTitle;
    $subtitle = isset($privacyPage) && method_exists($privacyPage, 't')
        ? ($privacyPage->t('header_subtitle', $locale) ?: ($privacyPage->header_subtitle ?? 'Informations légales'))
        : ($privacyPage->header_subtitle ?? 'Informations légales');
    $headerBgColor = $privacyPage->header_background_color ?? null;
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
        <div class="row justify-content-center"><div class="col-lg-10 legal-content">{!! $privacyHtml !!}</div></div>
    </div>
</section>
@endsection
