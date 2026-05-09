@php
    $locale = app()->getLocale();
    $faqSubtitle = method_exists($faqSectionSetting ?? '', 't')
        ? ($faqSectionSetting->t('subtitle') ?: ($faqSectionSetting->subtitle ?? ''))
        : ($faqSectionSetting->subtitle ?? '');
    $faqTitle = method_exists($faqSectionSetting ?? '', 't')
        ? ($faqSectionSetting->t('title') ?: ($faqSectionSetting->title ?? ''))
        : ($faqSectionSetting->title ?? '');
    $faqDescription = method_exists($faqSectionSetting ?? '', 't')
        ? ($faqSectionSetting->t('description') ?: ($faqSectionSetting->description ?? ''))
        : ($faqSectionSetting->description ?? '');
    $faqButtonLabel = method_exists($faqSectionSetting ?? '', 't')
        ? ($faqSectionSetting->t('button_label') ?: ($faqSectionSetting->button_label ?? ''))
        : ($faqSectionSetting->button_label ?? '');
    $faqButtonLink = $faqSectionSetting->button_link ?? '#';
@endphp

@if(($homeFaqs ?? collect())->isNotEmpty())
<section class="faqs section-padding">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5 col-md-12 mb-30">
                @if($faqSubtitle)
                    <div class="section-subtitle">{{ $faqSubtitle }}</div>
                @endif
                @if($faqTitle)
                    <div class="section-title">{{ $faqTitle }}</div>
                @endif
                @if($faqDescription)
                    <p class="mb-25">{{ $faqDescription }}</p>
                @endif
                @if($faqButtonLabel)
                    <a href="{{ $faqButtonLink }}" class="button-3">{{ $faqButtonLabel }}</a>
                @endif
            </div>
            <div class="col-lg-6 offset-lg-1 col-md-12">
                <ul class="accordion-box clearfix">
                    @foreach($homeFaqs as $faq)
                        <li class="accordion block">
                            <div class="acc-btn">
                                {{ method_exists($faq, 't') ? ($faq->t('question') ?: $faq->question) : $faq->question }}
                            </div>
                            <div class="acc-content">
                                <div class="content">
                                    <p>{{ method_exists($faq, 't') ? ($faq->t('answer') ?: $faq->answer) : $faq->answer }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif
