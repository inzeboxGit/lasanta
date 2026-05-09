@php
    $testimonialsBackgroundSrc = media_url($testimonialSectionSetting->header_image ?? null, 'img/banner/02.jpg');
@endphp
<!-- TÉMOIGNAGES -->
<section class="testimonials">
    <div class="bg-img bg-fixed section-padding" data-overlay-dark="5" data-background="{{ $testimonialsBackgroundSrc }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <div class="owl-carousel owl-theme">
                        @forelse(($homeTestimonials ?? collect()) as $testimonial)
                            <div class="item">
                                <span>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                </span>
                                <h5>"{{ method_exists($testimonial, 't') ? $testimonial->t('content') : $testimonial->content }}"</h5>
                                <div class="info">
                                    <div class="cont">
                                        <h6>{{ method_exists($testimonial, 't') ? $testimonial->t('name') : $testimonial->name }}
                                            @if(!empty($testimonial->source))
                                                <i>|</i>
                                                <span>{{ $testimonial->source }}</span>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="item">
                                <span>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                    <i class="star-rating"></i>
                                </span>
                                <h5>"Aucun témoignage publié pour le moment."</h5>
                                <div class="info">
                                    <div class="cont">
                                        <h6>I Lasanta</h6>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

