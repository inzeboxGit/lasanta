<!-- a propos de nous -->
<div class="pattern_2">
    <div class="container margin_120_95" id="first_section">
        <div class="row justify-content-between flex-lg-row-reverse align-items-center">
            <div class="col-lg-5">
                <div class="parallax_wrapper">
                    @php
                        $aboutMainImage = $aboutSectionSetting->main_image ?? 'img/home_2.jpg';
                        $aboutOverlayImage = $aboutSectionSetting->overlay_image ?? 'img/home_1.jpg';

                        $aboutMainImageSrc = str_starts_with($aboutMainImage, 'img/')
                            ? asset($aboutMainImage)
                            : asset('storage/' . ltrim($aboutMainImage, '/'));

                        $aboutOverlayImageSrc = str_starts_with($aboutOverlayImage, 'img/')
                            ? asset($aboutOverlayImage)
                            : asset('storage/' . ltrim($aboutOverlayImage, '/'));
                    @endphp
                    <img src="{{ $aboutMainImageSrc }}" alt="" class="img-fluid rounded-img">
                    <div data-cue="slideInUp" class="img_over"><span data-jarallax-element="-30"><img src="{{ $aboutOverlayImageSrc }}" alt="" class="rounded-img"></span></div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="intro">
                    <div class="title" style="padding-bottom: 16px;">
                        <small>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('small_title') : ($aboutSectionSetting->small_title ?? 'À PROPOS DE NOUS') }}</small>
                        <h2>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'La Résidence Bella Vista') }}</h2>
                        <span class="lead">{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead') : ($aboutSectionSetting->lead ?? 'Une conception du tourisme...') }}</span>
                    </div>

                    <p>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('description') : ($aboutSectionSetting->description ?? "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.") }}</p>
                    <p><em>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('signature') : ($aboutSectionSetting->signature ?? 'L’équipe du Bella Vista') }}</em></p>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>


    <!-- /pinned content -->
</div>
<!-- /Pattern  -->
