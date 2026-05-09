@php $homeServices = $homeServices ?? collect(); @endphp
@if($homeServices->isNotEmpty())
<section class="facilities2 bg-lightbrown">
    <div class="border-bottom">
        <div class="container">
            <ul class="tab-buttons">
                @foreach($homeServices as $svc)
                <li data-tab="#{{ $svc->tab_key }}" class="tab-btn {{ $loop->first ? 'active-btn' : '' }}">
                    <span>{{ method_exists($svc, 't') ? ($svc->t('title') ?: $svc->title) : $svc->title }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="tabs-content">
            @foreach($homeServices as $svc)
            @php
                $_img = $svc->image ?? '';
                if (str_starts_with($_img, 'img/')) {
                    $svcImage = asset('themes/lasanta/' . $_img);
                } elseif (str_starts_with($_img, 'themes/')) {
                    $svcImage = asset($_img);
                } else {
                    $svcImage = media_url($_img ?: null, 'themes/lasanta/img/restaurant/1.jpg');
                }
                $svcTitle       = method_exists($svc, 't') ? ($svc->t('title') ?: $svc->title) : $svc->title;
                $svcSubtitle    = method_exists($svc, 't') ? ($svc->t('subtitle') ?: $svc->subtitle) : $svc->subtitle;
                $svcDescription = method_exists($svc, 't') ? ($svc->t('description') ?: $svc->description) : $svc->description;
                $svcButtonText  = method_exists($svc, 't') ? ($svc->t('button_text') ?: $svc->button_text) : $svc->button_text;
            @endphp
            <div class="tab {{ $loop->first ? 'active-tab' : '' }}" id="{{ $svc->tab_key }}">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ $svcImage }}" class="img-fluid" alt="{{ $svcTitle }}">
                    </div>
                    <div class="col-lg-5 offset-lg-1 col-md-12">
                        @if($svcSubtitle)
                        <div class="section-subtitle">{{ $svcSubtitle }}</div>
                        @endif
                        <div class="section-title">{{ $svcTitle }}</div>
                        @if($svcDescription)
                        <p class="mb-25">{{ $svcDescription }}</p>
                        @endif
                        @if($svc->button_link && $svcButtonText)
                        <a href="{{ $svc->button_link }}" class="button-3">
                            @if($svc->icon)<i class="{{ $svc->icon }}"></i> @endif{{ $svcButtonText }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
