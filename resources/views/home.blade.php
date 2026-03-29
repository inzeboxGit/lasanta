@extends('layouts.app')

@section('content')
<main>
    @include('partials.home.hero')
    @include('partials.home.about')
    @include('partials.home.video')
    <div class="container margin_120_95">
        @include('partials.home.rooms')
        @include('partials.home.installations')
    </div>
    @include('partials.home.marquee')
    @include('partials.home.comodite-local')
    @include('partials.home.testimonials')
    @include('partials.home.news-events')
</main>
@endsection