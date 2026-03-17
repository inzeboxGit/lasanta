@extends('layouts.app')

@section('content')
<main>

    @php
        $locale = app()->getLocale();
        $labels = [
            'fr' => ['by' => 'par', 'next' => 'Actualité suivante'],
            'en' => ['by' => 'by', 'next' => 'Next news'],
            'de' => ['by' => 'von', 'next' => 'Nächste Neuigkeit'],
            'nl' => ['by' => 'door', 'next' => 'Volgend nieuws'],
        ];
        $ui = $labels[$locale] ?? $labels['en'];

        $heroSrc = null;
        if (!empty($news->hero_image)) {
            $heroSrc = str_starts_with($news->hero_image, 'http')
                ? $news->hero_image
                : asset(str_starts_with($news->hero_image, 'storage/') ? $news->hero_image : 'storage/' . $news->hero_image);
        } else {
            $heroSrc = asset('img/hero_blog.jpg');
        }
    @endphp
    <div class="hero medium-height jarallax" data-jarallax data-speed="0.2">
        <img class="jarallax-img" src="{{ $heroSrc }}" alt="">
        <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center animate_hero" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <small class="slide-animated one">
                    {{ $news->published_at?->format('d M Y') ?? '' }}
                    @if($news->author)
                        - {{ $ui['by'] }} {{ $news->author }}
                    @endif
                </small>
                <h1 class="slide-animated two">{{ method_exists($news, 't') ? $news->t('title') : $news->title }}</h1>
            </div>
        </div>
    </div>
    <!-- /Background Img Parallax -->

    <div class="container margin_120_95">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box_contents_in">
                    @if(method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt)
                        <h2 class="mb-4">{{ method_exists($news, 't') ? $news->t('excerpt') : $news->excerpt }}</h2>
                    @endif
                    @if(method_exists($news, 't') ? $news->t('body') : $news->body)
                        <p>{!! nl2br(e(method_exists($news, 't') ? $news->t('body') : $news->body)) !!}</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-10 my-4">
                @php
                    $coverSrc = null;
                    if (!empty($news->cover_image)) {
                        $coverSrc = str_starts_with($news->cover_image, 'http')
                            ? $news->cover_image
                            : asset(str_starts_with($news->cover_image, 'storage/') ? $news->cover_image : 'storage/' . $news->cover_image);
                    } else {
                        $coverSrc = asset('img/blog_in.jpg');
                    }
                @endphp
                <figure><img src="{{ $coverSrc }}" alt="" class="img-fluid"></figure>
            </div>
            <div class="col-lg-8">
                <div class="box_contents_in">
                    <small><span></span></small>
                    @if(method_exists($news, 't') ? $news->t('body') : $news->body)
                        <!-- <h2 class="mb-4">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</h2> -->
                        <p>{!! nl2br(e(method_exists($news, 't') ? $news->t('body') : $news->body)) !!}</p>
                    @endif
                </div>
                <p class="text-center mt-5"><a href="{{ url('/news') }}" class="btn_1 outline">{{ $ui['next'] }}</a></p>
            </div>
        </div>
        <!--/row -->
    </div>
    <!--/container -->

    <div class="bg_white">
        <!-- <div class="container margin_120_95">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id="comments">
                        <h3>Comments</h3>
                        <ul>
                            <li>
                                <div class="avatar">
                                    <a href="#"><img src="{{ asset('img/avatar1.jpg') }}" alt=""></a>
                                </div>
                                <div class="comment_right clearfix">
                                    <div class="comment_info">
                                        By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                    </div>
                                    <p>
                                        Nam cursus tellus quis magna porta adipiscing. Donec et eros leo, non pellentesque arcu.
                                    </p>
                                </div>
                                <ul class="replied-to">
                                    <li>
                                        <div class="avatar">
                                            <a href="#"><img src="{{ asset('img/avatar4.jpg') }}" alt=""></a>
                                        </div>
                                        <div class="comment_right clearfix">
                                            <div class="comment_info">
                                                By <a href="#">Anna Smith</a><span>|</span>25/10/2019<span>|</span><a href="#">Reply</a>
                                            </div>
                                            <p>
                                                Nam cursus tellus quis magna porta adipiscing. Donec et eros leo, non pellentesque arcu.
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <hr class="more_margin">
                    <h5 class="mb-3">Leave a comment</h5>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="text" name="name" id="name2" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <input type="text" name="email" id="email2" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="email" id="website3" class="form-control" placeholder="Website">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comments" id="comments2" rows="6" placeholder="Comment"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit2" class="btn_1 outline mb-3">Submit</button>
                    </div>
                </div>
            </div>
        </div> -->
        <!--/container -->
    </div>
    <!--/bg_white -->

</main>
@endsection
