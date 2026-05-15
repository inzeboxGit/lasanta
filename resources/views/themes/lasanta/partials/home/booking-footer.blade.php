@php
    $bfSetting  = $bookingFooterSetting ?? null;
    $bfImage    = $bfSetting->header_image ?? 'img/rooms/01.jpg';
    $bfSubtitle = method_exists($bfSetting ?? '', 't') ? ($bfSetting->t('subtitle') ?: ($bfSetting->subtitle ?? 'Hotel Experience')) : ($bfSetting->subtitle ?? 'Hotel Experience');
    $bfTitle    = method_exists($bfSetting ?? '', 't') ? ($bfSetting->t('title') ?: ($bfSetting->title ?? 'Booking Form')) : ($bfSetting->title ?? 'Booking Form');
    $bfBgUrl    = str_starts_with($bfImage, 'img/')
        ? asset('themes/lasanta/' . $bfImage)
        : (str_starts_with($bfImage, 'booking-footer/') ? asset('storage/' . $bfImage) : media_url($bfImage, 'img/rooms/01.jpg'));

    $locale = app()->getLocale();
    $bfDefaults = [
        'fr' => ['check_in' => 'Arrivée', 'check_out' => 'Départ', 'adults' => 'Adultes', 'children' => 'Enfants', 'rooms' => 'Chambres', 'search' => 'Vérifier'],
        'en' => ['check_in' => 'Check in', 'check_out' => 'Check out', 'adults' => 'Adults', 'children' => 'Children', 'rooms' => 'Rooms', 'search' => 'Check'],
        'de' => ['check_in' => 'Anreise', 'check_out' => 'Abreise', 'adults' => 'Erwachsene', 'children' => 'Kinder', 'rooms' => 'Zimmer', 'search' => 'Prüfen'],
        'it' => ['check_in' => 'Arrivo', 'check_out' => 'Partenza', 'adults' => 'Adulti', 'children' => 'Bambini', 'rooms' => 'Camere', 'search' => 'Verifica'],
    ];
    $bfLang = $bfDefaults[$locale] ?? $bfDefaults['en'];
    $bfHero = $heroSetting ?? null;
    if ($bfHero && method_exists($bfHero, 't')) {
        $v = $bfHero->t('check_in_label', $locale); if (!empty($v)) $bfLang['check_in'] = $v;
        $v = $bfHero->t('check_out_label', $locale); if (!empty($v)) $bfLang['check_out'] = $v;
        $v = $bfHero->t('adults_label', $locale);    if (!empty($v)) $bfLang['adults'] = $v;
        $v = $bfHero->t('children_label', $locale);  if (!empty($v)) $bfLang['children'] = $v;
        $v = $bfHero->t('search_label', $locale);    if (!empty($v)) $bfLang['search'] = $v;
    }
@endphp
<section class="section-padding bg-img bg-fixed" data-overlay-dark="5"
         data-background="{{ $bfBgUrl }}"
         style="background-image: url('{{ $bfBgUrl }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle text-brown">{{ $bfSubtitle }}</div>
                <div class="section-title white">{{ $bfTitle }}</div>
            </div>
        </div>
        <div class="booking-inner clearfix">
            <form id="hnet-booking-footer" class="form1 clearfix">
                <div class="col1 c1">
                    <div class="input1_wrapper border-l border-b border-t border-r">
                        <label>{{ $bfLang['check_in'] }}</label>
                        <div class="input1_inner">
                            <input type="text" id="hnet-footer-check-in" class="form-control input datepicker" placeholder="{{ $bfLang['check_in'] }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col1 c2">
                    <div class="input1_wrapper border-l border-b border-t border-r">
                        <label>{{ $bfLang['check_out'] }}</label>
                        <div class="input1_inner">
                            <input type="text" id="hnet-footer-check-out" class="form-control input datepicker" placeholder="{{ $bfLang['check_out'] }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col2 c3">
                    <div class="select1_wrapper border-l border-b border-t border-r">
                        <label>{{ $bfLang['adults'] }}</label>
                        <div class="select1_inner">
                            <select id="hnet-footer-adults" class="select2 select" style="width: 100%">
                                <option value="1">1 {{ $bfLang['adults'] }}</option>
                                <option value="2" selected>2 {{ $bfLang['adults'] }}</option>
                                <option value="3">3 {{ $bfLang['adults'] }}</option>
                                <option value="4">4 {{ $bfLang['adults'] }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col2 c4">
                    <div class="select1_wrapper border-l border-b border-t border-r">
                        <label>{{ $bfLang['children'] }}</label>
                        <div class="select1_inner">
                            <select id="hnet-footer-children" class="select2 select" style="width: 100%">
                                <option value="0" selected>{{ $bfLang['children'] }}</option>
                                <option value="1">1 {{ $bfLang['children'] }}</option>
                                <option value="2">2 {{ $bfLang['children'] }}</option>
                                <option value="3">3 {{ $bfLang['children'] }}</option>
                                <option value="4">4 {{ $bfLang['children'] }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col2 c5">
                    <div class="select1_wrapper border-l border-b border-t border-r">
                        <label>{{ $bfLang['rooms'] }}</label>
                        <div class="select1_inner">
                            <select id="hnet-footer-rooms" class="select2 select" style="width: 100%">
                                <option value="1">1 {{ $bfLang['rooms'] }}</option>
                                <option value="2">2 {{ $bfLang['rooms'] }}</option>
                                <option value="3">3 {{ $bfLang['rooms'] }}</option>
                                <option value="4">4 {{ $bfLang['rooms'] }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col3 c6">
                    <button type="submit" class="btn-form1-submit">{{ $bfLang['search'] }}</button>
                </div>
            </form>
        </div>
    </div>
</section>
