@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        if (!in_array($locale, ['fr', 'en', 'de', 'it'], true)) {
            $locale = 'en';
        }

        $defaultHeroTitle = [
            'fr' => 'Mentions légales',
            'en' => 'Privacy Policy',
            'de' => 'Datenschutzerklärung',
            'it' => 'Informativa sulla privacy',
        ][$locale] ?? 'Privacy Policy';

        $defaultHeroSubtitle = [
            'fr' => 'Informations légales',
            'en' => 'Legal Information',
            'de' => 'Rechtliche Hinweise',
            'it' => 'Informazioni legali',
        ][$locale] ?? 'Legal Information';

        $heroTitle = isset($privacyPage) && method_exists($privacyPage, 't')
            ? ($privacyPage->t('header_title', $locale) ?: $defaultHeroTitle)
            : $defaultHeroTitle;
        $heroSubtitle = isset($privacyPage) && method_exists($privacyPage, 't')
            ? ($privacyPage->t('header_subtitle', $locale) ?: $defaultHeroSubtitle)
            : $defaultHeroSubtitle;

        $backgroundColor = $privacyPage->header_background_color ?? '#000000';
        if (preg_match('/^#([a-f0-9]{6})$/i', $backgroundColor, $matches)) {
            $hex = $matches[1];
            $backgroundColor = sprintf(
                'rgba(%d, %d, %d, 0.55)',
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2))
            );
        }
    @endphp

    <main>
        <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
            <img class="jarallax-img" src="{{ asset('img/hero_home_2.jpg') }}" alt="Privacy Policy">
            <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero"
                data-opacity-mask="{{ $backgroundColor }}">
                <div class="container">
                    <small class="slide-animated one">{{ $heroSubtitle }}</small>
                    <h1 class="slide-animated two">{{ $heroTitle }}</h1>
                </div>
            </div>
        </div>

        <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-10 legal-content">
                    {!! $privacyHtml !!}
                </div>
            </div>
        </div>
    </main>
@endsection
