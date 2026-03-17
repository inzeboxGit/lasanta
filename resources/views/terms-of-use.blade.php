@extends('layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    if (!in_array($locale, ['fr', 'en', 'de'], true)) {
        $locale = 'en';
    }

    $heroTitle = [
        'fr' => 'Conditions d’utilisations',
        'en' => 'Terms of Use',
        'de' => 'AGB',
    ][$locale] ?? 'Terms of Use';

    $path = resource_path("content/legal/terms_{$locale}.html");
    $termsHtml = file_exists($path)
        ? file_get_contents($path)
        : file_get_contents(resource_path('content/legal/terms_en.html'));
@endphp

<main>
    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ asset('img/hero_home_2.jpg') }}" alt="Terms of Use">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">Informations légales</small>
                <h1 class="slide-animated two">{{ $heroTitle }}</h1>
            </div>
        </div>
    </div>

    <div class="container margin_120_95">
        <div class="row justify-content-center">
            <div class="col-lg-10 legal-content">
                {!! $termsHtml !!}
            </div>
        </div>
    </div>
</main>
@endsection
