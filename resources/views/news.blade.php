@extends('layouts.app')

@section('content')
<main>

    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ asset('img/hero_home_2.jpg') }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">Luxury Hotel Experience</small>
                <h1 class="slide-animated two">News and Events</h1>
            </div>
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="container margin_120_95">
        <div class="isotope-wrapper">
            <div class="row justify-content-center">
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-1.jpg') }}" alt="" class="img-fluid"><em>11 Dec</em></figure>
                        <div class="wrapper">
                            <small>Travel<span></span></small>
                            <h2>The vacation and travel Guide for experts in 2022</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-2.jpg') }}" alt="" class="img-fluid"><em>21 Dec</em></figure>
                        <div class="wrapper">
                            <small>Restaurant<span></span></small>
                            <h2>Best Local Restaurant in 2022</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-3.jpg') }}" alt="" class="img-fluid"><em>24 Dec</em></figure>
                        <div class="wrapper">
                            <small>Event<span></span></small>
                            <h2>Yayoi Kusama: Infinity Mirror Rooms at Tate Modern</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-4.jpg') }}" alt="" class="img-fluid"><em>08 Dec</em></figure>
                        <div class="wrapper">
                            <small>Event<span></span></small>
                            <h2>Bix Meeting 2023</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-5.jpg') }}" alt="" class="img-fluid"><em>11 Oct</em></figure>
                        <div class="wrapper">
                            <small>Guide<span></span></small>
                            <h2>Top 15 things to do and Discover story-worthy travel moments</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
                <div class="item col-xl-4 col-lg-6">
                    <a href="news-post.html" class="box_contents" data-cue="slideInUp">
                        <figure><img src="{{ asset('img/blog-6.jpg') }}" alt="" class="img-fluid"><em>20 Oct</em></figure>
                        <div class="wrapper">
                            <small>News<span></span></small>
                            <h2>Cycling tour October 2022</h2>
                            <em>Read more</em>
                        </div>
                    </a>
                </div>
            </div>
            <!--/row -->
        </div>
        <!--/isotope-wrapper -->

        <div class="pagination__wrapper">
            <ul class="pagination">
                <li><a href="#0" class="prev"><i class="bi bi-arrow-left-short"></i></a></li>
                <li>
                    <a href="#0" class="active">1</a>
                </li>
                <li>
                    <a href="#0">2</a>
                </li>
                <li>
                    <a href="#0">3</a>
                </li>
                <li>
                    <a href="#0">4</a>
                </li>
                <li><a href="#0" class="next"><i class="bi bi-arrow-right-short"></i></a></li>
            </ul>
        </div>
        <!-- /pagination -->

    </div>
    <!--/container -->
</main>
@endsection
