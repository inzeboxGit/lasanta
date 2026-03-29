@php
    $testimonialsBackgroundSrc = media_url($testimonialSectionSetting->header_image ?? null, 'img/hero_home_1.jpg');
    $hasTestimonialSectionTranslations = isset($testimonialSectionSetting) && method_exists($testimonialSectionSetting, 't');
    $testimonialsSubtitle = $hasTestimonialSectionTranslations
        ? $testimonialSectionSetting->t('subtitle')
        : ($testimonialSectionSetting->subtitle ?? 'TÉMOIGNAGES');
    $testimonialsTitle = $hasTestimonialSectionTranslations
        ? $testimonialSectionSetting->t('title')
        : ($testimonialSectionSetting->title ?? 'Ce que les clients disent');
@endphp
<!-- TÉMOIGNAGES -->
<div class="parallax_section_1 jarallax" data-jarallax data-speed="0.2" id="testimonials">
    <img class="jarallax-img kenburns-2" src="{{ $testimonialsBackgroundSrc }}" alt="">
    <div class="wrapper opacity-mask d-flex align-items-center justify-content-center text-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title white">
                        <small class="mb-1">{{ $testimonialsSubtitle }}</small>
                        <h2>{{ $testimonialsTitle }}</h2>
                    </div>
                    <div class="carousel_testimonials owl-carousel owl-theme nav-dots-orizontal">
                        @forelse(($homeTestimonials ?? collect()) as $testimonial)
                            @php
                                $photoSrc = null;
                                if (!empty($testimonial->photo_path)) {
                                    $photoSrc = str_starts_with($testimonial->photo_path, 'img/')
                                        ? asset($testimonial->photo_path)
                                        : asset('storage/' . $testimonial->photo_path);
                                } else {
                                    $photoSrc = asset('img/testimonial_1.jpg');
                                }
                            @endphp
                            <div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="{{ $photoSrc }}" alt="{{ method_exists($testimonial, 't') ? $testimonial->t('name') : $testimonial->name }}" class="img-circle"></figure>
                                        <h4>
                                            {{ method_exists($testimonial, 't') ? $testimonial->t('name') : $testimonial->name }}
                                            <small>{{ $testimonial->published_at?->format('j M') ?? '' }}</small>
                                        </h4>
                                    </div>
                                    <div class="comment">
                                        "{{ method_exists($testimonial, 't') ? $testimonial->t('content') : $testimonial->content }}"
                                    </div>
                                </div>
                                <!-- End box_overlay -->
                            </div>
                        @empty
                            <div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="{{ asset('img/testimonial_1.jpg') }}" alt="" class="img-circle"></figure>
                                        <h4>Bella Vista<small></small></h4>
                                    </div>
                                    <div class="comment">
                                        "Aucun témoignage publié pour le moment."
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- End carousel_testimonials -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /parallax_section_1-->
