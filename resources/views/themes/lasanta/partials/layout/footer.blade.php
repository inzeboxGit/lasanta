@php
$footerLocale = app()->getLocale();
// Navigation labels (copied from nav.blade.php for cohérence)
$footerNavLabels = [
    'fr' => [
        'home' => 'Accueil',
        'appartement' => 'Nos chambres',
        'auberge' => 'Restaurant',
        'piscine' => 'Piscine',
        'news' => 'Actualités',
        'contact' => 'Contact',
    ],
    'en' => [
        'home' => 'Home',
        'appartement' => 'Our Rooms',
        'auberge' => 'Restaurant',
        'piscine' => 'Pool',
        'news' => 'News',
        'contact' => 'Contact',
    ],
    'de' => [
        'home' => 'Startseite',
        'appartement' => 'Unsere Zimmer',
        'auberge' => 'Restaurant',
        'piscine' => 'Pool',
        'news' => 'Neuigkeiten',
        'contact' => 'Kontakt',
    ],
    'it' => [
        'home' => 'Home',
        'appartement' => 'Le nostre camere',
        'auberge' => 'Ristorante',
        'piscine' => 'Piscina',
        'news' => 'News',
        'contact' => 'Contatti',
    ],
];
$footerNav = $footerNavLabels[$footerLocale] ?? $footerNavLabels['en'];
@endphp
@php
$footerTranslations = [
    'fr' => [
        'contact_us' => 'Contact',
        'subscribe' => 'S’abonner',
        'subscribe_text' => 'Pour être informé de nos services, inscrivez-vous et nous vous enverrons une notification par email.',
    ],
    'en' => [
        'contact_us' => 'Contact us',
        'subscribe' => 'Subscribe',
        'subscribe_text' => 'Want to be notified about our services. Just sign up and we\'ll send you a notification by email.',
    ],
    'de' => [
        'contact_us' => 'Kontakt',
        'subscribe' => 'Abonnieren',
        'subscribe_text' => 'Möchten Sie über unsere Dienstleistungen informiert werden? Melden Sie sich einfach an und wir senden Ihnen eine Benachrichtigung per E-Mail.',
    ],
    'it' => [
        'contact_us' => 'Contattaci',
        'subscribe' => 'Iscriviti',
        'subscribe_text' => 'Vuoi essere informato sui nostri servizi? Iscriviti e ti invieremo una notifica via email.',
    ],
];
$footerLocale = app()->getLocale();
$ft = $footerTranslations[$footerLocale] ?? $footerTranslations['en'];
$instagramUrl = !empty($siteSetting->instagram_url ?? null) ? $siteSetting->instagram_url : '#';
$twitterUrl = !empty($siteSetting->twitter_url ?? null) ? $siteSetting->twitter_url : '#';
$facebookUrl = !empty($siteSetting->facebook_url ?? null) ? $siteSetting->facebook_url : '#';
$footerAddress = method_exists($siteSetting, 't')
    ? ($siteSetting->t('address') ?: ($siteSetting->address ?? ''))
    : ($siteSetting->address ?? '');
$footerPhone = $siteSetting->phone_primary ?? '';
$footerPhoneHref = $footerPhone !== '' ? preg_replace('/\s+/', '', (string) $footerPhone) : '';
$footerEmail = $siteSetting->email ?? '';
@endphp
<footer class="footer">
    <!-- top -->
    <div class="top" bis_skin_checked="1">
        <div class="container" bis_skin_checked="1">
            <div class="row" bis_skin_checked="1">
                <div class="col-md-4 mb-30" bis_skin_checked="1">
                    <div class="item" bis_skin_checked="1">
                        <div class="logo" bis_skin_checked="1"><img src="img/logo.png" alt=""></div>
                        @php
                            $aboutExcerpt = null;
                            try {
                                $about = \App\Models\AboutSectionSetting::first();
                                if ($about) {
                                    $aboutExcerpt = Str::limit(strip_tags($about->description ?? ''), 120);
                                }
                            } catch (Exception $e) {
                                $aboutExcerpt = null;
                            }
                        @endphp
                        <p>{{ $aboutExcerpt ?: '...' }}</p>
                        <div class="social-icons" bis_skin_checked="1">
                            <ul class="list-inline">
                                <li><a href="{{ $instagramUrl }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="{{ $twitterUrl }}" target="_blank" rel="noopener"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{{ $facebookUrl }}" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 offset-md-1 mb-30" bis_skin_checked="1">
                    <div class="item" bis_skin_checked="1">
                        <h3>{{ $ft['contact_us'] }}</h3>
                        <p>{{ $footerAddress !== '' ? $footerAddress : '...' }}</p>
                        <div class="phone" bis_skin_checked="1">
                            <a href="{{ $footerPhoneHref !== '' ? 'tel:' . $footerPhoneHref : '#' }}">{{ $footerPhone !== '' ? $footerPhone : '...' }}</a>
                        </div>
                        <div class="mail" bis_skin_checked="1">
                            <a href="{{ $footerEmail !== '' ? 'mailto:' . $footerEmail : '#' }}">{{ $footerEmail !== '' ? $footerEmail : '...' }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-30" bis_skin_checked="1">
                    <div class="item" bis_skin_checked="1">
                        <h3>{{ $ft['subscribe'] }}</h3>
                        <p>{{ $ft['subscribe_text'] }}</p>
                        <div class="newsletter" bis_skin_checked="1">
                            <form action="#">
                                <input type="email" placeholder="Email Address" required="">
                                <button type="submit"><i class="fa-light fa-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bottom -->
    <div class="bottom" bis_skin_checked="1">
        <div class="container" bis_skin_checked="1">
            <div class="row" bis_skin_checked="1">
                <div class="col-lg-8 col-md-12" bis_skin_checked="1">
                    <div class="links" bis_skin_checked="1">
                        <ul>
                            <li><a href="{{ url('/') }}">{{ $footerNav['home'] }}</a></li>
                            <li><a href="{{ route('appartements.index') }}">{{ $footerNav['appartement'] }}</a></li>
                            <li><a href="{{ route('restaurant.index') }}">{{ $footerNav['auberge'] }}</a></li>
                            <li><a href="{{ route('pool.index') }}">{{ $footerNav['piscine'] }}</a></li>
                            <li><a href="{{ route('news.index') }}">{{ $footerNav['news'] }}</a></li>
                            <li><a href="{{ url('/contacts') }}">{{ $footerNav['contact'] }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 text-end" bis_skin_checked="1">
                    <p>Copyright 2026 </p>
                </div>
            </div>
        </div>
    </div>
</footer>
