@php
    $promoImage = $promoSetting->image ?? '';
    $promoImageSrc = empty($promoImage)
        ? asset('img/home_2.jpg')
        : (str_starts_with($promoImage, 'img/')
            ? asset($promoImage)
            : asset('storage/' . $promoImage));

    $locale = app()->getLocale();
    $buttonLabels = [
        'fr' => 'Voir l\'offre',
        'en' => 'View offer',
        'de' => 'Angebot ansehen',
        'it' => 'Vedi offerta',
    ];
    $buttonLabel = $buttonLabels[$locale] ?? $buttonLabels['en'];
@endphp

<div class="popup_wrapper" aria-hidden="true">
    <div class="popup_content newsletter_c">
        <span class="popup_close"><i class="bi bi-x"></i></span>
        <div class="row g-0">
            <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center">
                <figure><img src="{{ $promoImageSrc }}"
                        alt="{{ method_exists($promoSetting, 't') ? $promoSetting->t('title') : ($promoSetting->title ?? '') }}">
                </figure>
            </div>
            <div class="col-md-7">
                <div class="content">
                    <div class="wrapper">
                        @if(!empty($promoSetting->subtitle ?? null))
                            <small
                                class="d-block mb-2">{{ method_exists($promoSetting, 't') ? $promoSetting->t('subtitle') : $promoSetting->subtitle }}</small>
                        @endif
                        <h3>{{ method_exists($promoSetting, 't') ? $promoSetting->t('title') : ($promoSetting->title ?? '') }}
                        </h3>
                        @if(!empty($promoSetting->text ?? null))
                            <p>{{ method_exists($promoSetting, 't') ? $promoSetting->t('text') : $promoSetting->text }}</p>
                        @endif
                        @if(!empty($promoSetting->button_link ?? null))
                            <a href="{{ $promoSetting->button_link }}" class="btn_1 mt-2 mb-4">{{ $buttonLabel }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>