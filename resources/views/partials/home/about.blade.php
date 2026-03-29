<!-- a propos de nous -->
<div class="pattern_2">
    <div class="container margin_120_95" id="first_section">
        <div class="row justify-content-between flex-lg-row-reverse align-items-center">
            <div class="col-lg-5">
                <div class="parallax_wrapper">
                    @php
                    $aboutMainImage = $aboutSectionSetting->main_image ?? '';
                    $aboutOverlayImage = $aboutSectionSetting->overlay_image ?? '';

                    $aboutMainImageSrc = media_url($aboutMainImage, '');
                    $aboutOverlayImageSrc = media_url($aboutOverlayImage, '');
                    @endphp
                    <img src="{{ $aboutMainImageSrc }}" alt="" class="img-fluid rounded-img">
                    <div data-cue="slideInUp" class="img_over"><span data-jarallax-element="-30"><img
                                src="{{ $aboutOverlayImageSrc }}" alt="" class="rounded-img"></span></div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="intro">
                    <div class="title" style="padding-bottom: 16px;">
                        <small>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('small_title') :
                            ($aboutSectionSetting->small_title ?? '') }}</small>
                        <h2>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') :
                            ($aboutSectionSetting->title ?? '') }}</h2>
                        <span class="lead">{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('lead')
                            : ($aboutSectionSetting->lead ?? '') }}</span>
                    </div>

                    <div>{!! method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('description') :
                        ($aboutSectionSetting->description ?? "") !!}</div>
                    <p><em>{{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('signature') :
                            ($aboutSectionSetting->signature ?? '') }}</em></p>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>


    <!-- /pinned content -->
</div>
<!-- /Pattern  -->
