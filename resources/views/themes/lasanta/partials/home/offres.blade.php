<!-- Offres Spéciales -->
<section class="rooms1 section-padding bg-darkgray">
    <div class="container">
        <div class="row mb-30 align-items-center">
            <div class="col-md-12 text-center">
                <div class="section-subtitle text-brown">{{ (isset($promoHeaderSetting) && method_exists($promoHeaderSetting, 't') ? $promoHeaderSetting->t('subtitle') : null) ?: ($promoHeaderSetting->subtitle ?? 'NOS OFFRES') }}</div>
                <div class="section-title white mb-0">{{ (isset($promoHeaderSetting) && method_exists($promoHeaderSetting, 't') ? $promoHeaderSetting->t('title') : null) ?: ($promoHeaderSetting->title ?? 'OFFRES SPÉCIALES') }}</div>
            </div>
        </div>
        <div class="row">
            @forelse(($homePromos ?? collect()) as $promo)
            <div class="col-md-6 mb-30">
                <div class="item mt-20" style="position: relative; border-radius: 10px; overflow: hidden; cursor: pointer;">
                    <div class="img" style="position: relative;">
                        <a href="{{ !empty($promo->button_link) ? $promo->button_link : '#' }}">
                            <img src="{{ media_url($promo->image ?? null, 'themes/lasanta/img/restaurant/1.jpg') }}"
                                 alt="{{ method_exists($promo, 't') ? $promo->t('title') : $promo->title }}"
                                 style="width: 100%; height: 430px; object-fit: cover; display: block; border-radius: 10px;">
                        </a>
                        @if(!empty($promo->button_text))
                        <span class="discount" style="position: absolute; top: 16px; left: 16px; background: #fff; color: #222; font-size: 13px; font-weight: 600; padding: 5px 12px; border-radius: 4px; z-index: 2;">
                            {{ $promo->button_text }}
                        </span>
                        @endif
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 20px 24px; background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 100%); border-radius: 0 0 10px 10px;">
                            <span style="color: #fff; font-size: 22px; font-family: inherit; font-weight: 400; letter-spacing: 0.5px;">
                                {{ method_exists($promo, 't') ? $promo->t('title') : $promo->title }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
