@php
    $promoImage = $promoSetting->image ?? '';
    $promoImageSrc = empty($promoImage)
        ? theme_asset('img/home_2.jpg')
        : (str_starts_with($promoImage, 'img/')
            ? theme_asset($promoImage)
            : asset('storage/' . $promoImage));

    $locale = app()->getLocale();
    $buttonLabels = [
        'fr' => 'Voir l\'offre',
        'en' => 'View offer',
        'de' => 'Angebot ansehen',
        'it' => 'Vedi offerta',
    ];
    $defaultButtonLabel = $buttonLabels[$locale] ?? $buttonLabels['en'];
    $buttonLabel = method_exists($promoSetting, 't')
        ? ($promoSetting->t('button_text') ?: $defaultButtonLabel)
        : (($promoSetting->button_text ?? '') ?: $defaultButtonLabel);
    $buttonTarget = $promoSetting->button_target ?? '_self';

    $promoSubtitle = method_exists($promoSetting, 't')
        ? ($promoSetting->t('subtitle') ?: '')
        : ($promoSetting->subtitle ?? '');
    $promoTitle = method_exists($promoSetting, 't')
        ? ($promoSetting->t('title') ?: '')
        : ($promoSetting->title ?? '');
    $promoText = method_exists($promoSetting, 't')
        ? ($promoSetting->t('text') ?: '')
        : ($promoSetting->text ?? '');
@endphp

<style>
    .popup_wrapper--promo {
        position: fixed !important;
        inset: 0;
        display: block;
        opacity: 1;
        overflow: auto;
        padding: 24px;
        background:
            radial-gradient(circle at top left, rgba(255, 255, 255, 0.14), transparent 32%),
            radial-gradient(circle at bottom right, rgba(151, 134, 103, 0.2), transparent 40%),
            rgba(16, 18, 22, 0.76);
        backdrop-filter: blur(8px);
        z-index: 9999999;
    }

    .popup_wrapper--promo .popup_content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: min(980px, calc(100vw - 48px));
        min-height: 440px;
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 30px 120px rgba(0, 0, 0, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.35);
    }

    .popup_wrapper--promo .popup_close {
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 3;
        width: 42px;
        height: 42px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        color: #2f2f2f;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .popup_wrapper--promo .popup_close:hover {
        transform: scale(1.05);
        background: #fff;
        color: #978667;
    }

    .popup_wrapper--promo .popup_media {
        position: relative;
        min-height: 440px;
        height: 100%;
        background: #ddd;
        overflow: hidden;
    }

    .popup_wrapper--promo .popup_media::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(12, 12, 12, 0.03) 0%, rgba(12, 12, 12, 0.58) 100%);
        pointer-events: none;
    }

    .popup_wrapper--promo .popup_media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.01);
    }

    .popup_wrapper--promo .popup_badge {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255);
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 11px;
        font-weight: 700;
        backdrop-filter: blur(8px);
    }

    .popup_wrapper--promo .popup_content_area {
        position: relative;
        display: flex;
        align-items: stretch;
        min-height: 380px;
        padding: 32px 32px 12px 46px;
        /* background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(248, 245, 240, 0.98)); */
    }

    .popup_wrapper--promo .popup_layout {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 30px;
        width: 100%;
        min-height: 300px;
    }

    .popup_wrapper--promo .popup_intro {
        display: block;
    }

    .popup_wrapper--promo .popup_content_area::before {
        content: '';
        position: absolute;
        inset: 22px 22px auto 22px;
        height: 1px;
        background: linear-gradient(90deg, rgba(151, 134, 103, 0), rgba(151, 134, 103, 0.4), rgba(151, 134, 103, 0));
    }

    .popup_wrapper--promo .popup_kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        color: #978667;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 11px;
        font-weight: 800;
    }

    .popup_wrapper--promo .popup_kicker::before {
        content: '';
        width: 34px;
        height: 2px;
        background: #978667;
        border-radius: 999px;
    }

    .popup_wrapper--promo .popup_title {
        margin: 0 0 16px;
        font-family: 'Gilda Display', serif;
        font-size: clamp(2rem, 3.6vw, 3.55rem);
        line-height: 0.98;
        letter-spacing: -0.02em;
        color: #171717;
    }

    .popup_wrapper--promo .popup_subtitle {
        /* margin-bottom: 16px; */
        font-family: 'Urbanist', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-size: 12px;
        font-weight: 700;
        color: #8f8573;
    }

    .popup_wrapper--promo .popup_text {
        max-width: 36rem;
        margin-bottom: 28px;
        font-family: 'Urbanist', sans-serif;
        font-size: 1rem;
        line-height: 1.8;
        color: #5d5d5d;
    }

    .popup_wrapper--promo .promo-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .popup_wrapper--promo .btn_1.promo-cta {
        padding: 15px 28px;
        border-radius: 999px;
        background: linear-gradient(135deg, #978667 0%, #b79e72 100%);
        color: #fff;
        box-shadow: 0 14px 30px rgba(151, 134, 103, 0.28);
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    .popup_wrapper--promo .btn_1.promo-cta:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 38px rgba(151, 134, 103, 0.34);
    }

    .popup_wrapper--promo .promo-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .popup_wrapper--promo .promo-meta span {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(151, 134, 103, 0.08);
        color: #6a5b44;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    @media (max-width: 767px) {
        .popup_wrapper--promo {
            padding: 12px;
        }

        .popup_wrapper--promo .popup_content {
            width: calc(100vw - 24px);
            min-height: auto;
            border-radius: 22px;
        }

        .popup_wrapper--promo .popup_content_area {
            min-height: auto;
            padding: 34px 22px 28px;
        }

        .popup_wrapper--promo .popup_layout {
            min-height: auto;
            gap: 20px;
        }

        .popup_wrapper--promo .popup_text {
            font-size: 0.98rem;
            line-height: 1.75;
        }

        .popup_wrapper--promo .promo-actions {
            width: 100%;
        }

        .popup_wrapper--promo .btn_1.promo-cta {
            width: 100%;
        }
        /* 32px 32px 12px 46px */
    }
</style>

<div class="popup_wrapper popup_wrapper--promo" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="popup_content newsletter_c">
        <button type="button" class="popup_close" aria-label="Fermer la promotion">
            <i class="bi bi-x-lg" aria-hidden="true"></i> X
        </button>

        <div class="row g-0 h-100">
            <div class="col-md-5 d-none d-md-block">
                <div class="popup_media">
                    <span class="popup_badge">
                        @if(!empty($promoSubtitle))
                            <div class="popup_subtitle">{{ $promoSubtitle }}</div>
                        @endif
                    </span>
                    <img src="{{ $promoImageSrc }}" alt="{{ $promoTitle }}">
                </div>
            </div>

            <div class="col-md-7">
                <div class="popup_content_area">
                    <div class="wrapper w-100 popup_layout">
                        <!-- <div class="popup_kicker">Séjour exclusif</div> -->

                        <div class="popup_intro">
                        
                            <h3 class="popup_title">{{ $promoTitle }}</h3>

                            @if(!empty($promoText))
                                <p class="popup_text">{{ $promoText }}</p>
                            @endif
                        </div>

                        @if(!empty($promoSetting->button_link ?? null))
                            <div class="promo-actions">
                                <a href="{{ $promoSetting->button_link }}" class="button-3 mb-15" target="{{ $buttonTarget }}"
                                    @if($buttonTarget === '_blank') rel="noopener" @endif>
                                    {{ $buttonLabel }}
                                </a>
                            </div>
                        @endif

                        <!-- <div class="promo-meta">
                            <span>Exclusif sur la home</span>
                            <span>Design adapté au thème</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var popup = document.querySelector('.popup_wrapper--promo');
    if (!popup) return;

    popup.style.display = 'block';
    popup.style.opacity = '1';
    popup.setAttribute('aria-hidden', 'false');
});
</script>
@endpush