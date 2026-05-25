@php $homeServices = $homeServices ?? collect(); @endphp
@if($homeServices->isNotEmpty())
<section class="facilities2 bg-lightbrown">
    <div class="border-bottom">
        <div class="container">
            <ul class="tab-buttons justify-content-center" style="--services-tabs-count: {{ max($homeServices->count(), 1) }}; width: 100%; gap: 0;">
                @foreach($homeServices as $svc)
                <li
                    data-tab="#{{ $svc->tab_key }}"
                    class="tab-btn {{ $loop->first ? 'active-btn' : '' }}"
                    style="flex: 0 0 calc(100% / var(--services-tabs-count)); max-width: calc(100% / var(--services-tabs-count)); width: calc(100% / var(--services-tabs-count)); border-left: {{ $loop->first ? '0' : '1px solid rgba(203, 157, 85, 0.2)' }};"
                >
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
                $svcButtonLink  = !empty($svc->pdf_file)
                    ? asset('storage/' . ltrim($svc->pdf_file, '/'))
                    : ($svc->button_link ?? '');
            @endphp
            <div class="tab {{ $loop->first ? 'active-tab' : '' }}" id="{{ $svc->tab_key }}">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{ $svcImage }}" class="img-fluid" alt="{{ $svcTitle }}">
                    </div>
                    <div class="col-lg-5 offset-lg-1 col-md-12">
                        @if($svcSubtitle)
                        <div class="section-subtitle brown">{{ $svcSubtitle }}</div>
                        @endif
                        <div class="section-title">{{ $svcTitle }}</div>
                        @if($svcDescription)
                            @php
                                $lines = preg_split('/\r?\n/', $svcDescription);
                                $list = [];
                                $text = [];
                                foreach ($lines as $line) {
                                    if (preg_match('/^\s*(Petit Dejeuner|Repas|Diner)\s*:/iu', $line)) {
                                        $list[] = trim($line);
                                    } elseif (trim($line) !== '') {
                                        $text[] = trim($line);
                                    }
                                }
                            @endphp
                            @if($text)
                                <p class="mb-25">{!! implode('<br>', array_map('e', $text)) !!}</p>
                            @endif
                            @if($list)
                                <ul class="service-hours-list" style="list-style:none;padding:0;margin:0;">
                                    @foreach($list as $item)
                                        <li style="display:flex;align-items:flex-start;gap:8px;margin-bottom:8px;">
                                            <span style="color:#b08c5a;font-size:1.0em;line-height:-0.8;"><i class="fa-light fa-check"></i></span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                        @if($svcButtonLink && $svcButtonText)
                        <div class="mb-25"></div>
                        <a href="{{ $svcButtonLink }}" class="button-3">
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
