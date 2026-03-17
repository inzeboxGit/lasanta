@extends('layouts.app')

@section('content')
<main>
    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ asset('img/hero_home_2.jpg') }}" alt="Conditions d'utilisation">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">Informations légales</small>
                <h1 class="slide-animated two">Conditions d’utilisation</h1>
            </div>
        </div>
    </div>

    <div class="container margin_120_95">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="title mb-4">
                    <small>RÉsidence Bella vista</small>
                    <h2>Conditions générales d’utilisation</h2>
                </div>
                <p>Ce site est édité pour présenter les appartements, services et informations de la Résidence Bella Vista. En naviguant sur ce site, vous acceptez les présentes conditions d’utilisation.</p>
                <p>Les informations affichées (descriptions, photos, tarifs, disponibilités) sont fournies à titre indicatif et peuvent être modifiées sans préavis. Nous nous efforçons de maintenir ces informations à jour.</p>
                <p>La reproduction, la copie ou l’utilisation du contenu (textes, visuels, éléments graphiques) sans autorisation préalable est interdite.</p>
                <p>Pour toute demande relative à vos données, à une réservation ou à une information légale, vous pouvez nous contacter via la page Contact.</p>
                <p class="mb-0">Dernière mise à jour: {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</main>
@endsection
