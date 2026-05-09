@php
    $footerBackgroundSrc = media_url($siteSetting->footer_background_image ?? null, 'img/rooms/3.jpg');
@endphp
<footer class="revealed">
    <div class="footer_bg">
        <div class="gradient_over"></div>
        <div class="background-image" data-background="url({{ $footerBackgroundSrc }})"></div>
    </div>
    <div class="container">
        <div class="row move_content">
            <div class="col-lg-4 col-md-12">
                @php
                    $locale = app()->getLocale();
                    $labels = [
                        'fr' => [
                            'contact' => 'Contact',
                            'explore' => 'Explorer',
                            'home' => 'Accueil',
                            'apartments' => 'Appartements',
                            'restaurant' => 'Restaurant',
                            'pool' => 'Piscine',
                            'news' => 'Actualités',
                            'contact_link' => 'Contacts',
                            'terms' => 'Conditions d’utilisations',
                            'privacy' => 'Mentions légales',
                        ],
                        'en' => [
                            'contact' => 'Contact',
                            'explore' => 'Explore',
                            'home' => 'Home',
                            'apartments' => 'Apartments',
                            'restaurant' => 'Restaurant',
                            'pool' => 'Pool',
                            'news' => 'News',
                            'contact_link' => 'Contact',
                            'terms' => 'Terms of Use',
                            'privacy' => 'Privacy Policy',
                        ],
                        'de' => [
                            'contact' => 'Kontakt',
                            'explore' => 'Navigation',
                            'home' => 'Startseite',
                            'apartments' => 'Apartments',
                            'restaurant' => 'Restaurant',
                            'pool' => 'Pool',
                            'news' => 'Neuigkeiten',
                            'contact_link' => 'Kontakt',
                            'terms' => 'Nutzungsbedingungen',
                            'privacy' => 'Datenschutzerklärung',
                        ],
                        'it' => [
                            'contact' => 'Contact',
                            'explore' => 'Esplora',
                            'home' => 'Home',
                            'apartments' => 'Appartamenti',
                            'restaurant' => 'Ristorante',
                            'pool' => 'Piscina',
                            'news' => 'News',
                            'contact_link' => 'Contatti',
                            'terms' => 'condizioni d\'uso',
                            'privacy' => 'Avviso legale',
                        ],
                    ];
                    $extra = [
                        'fr' => [
                            'newsletter' => 'Newsletter',
                            'newsletter_placeholder' => 'Votre email',
                            'newsletter_text' => 'Recevez les dernières offres et promotions sans spam. Vous pouvez annuler à tout
                                                                                                                                        moment.',
                            'copy' => 'Copyright ' . date('Y'),
                        ],
                        'en' => [
                            'newsletter' => 'Newsletter',
                            'newsletter_placeholder' => 'Your email',
                            'newsletter_text' => 'Get the latest offers and promotions without spam. You can unsubscribe anytime.',
                            'copy' => 'Copyright ' . date('Y'),
                        ],
                        'de' => [
                            'newsletter' => 'Newsletter',
                            'newsletter_placeholder' => 'Ihre E-Mail',
                            'newsletter_text' => 'Erhalten Sie die neuesten Angebote ohne Spam. Abmeldung jederzeit möglich.',
                            'copy' => 'Copyright ' . date('Y'),
                        ],
                        'it' => [
                            'newsletter' => 'Newsletter',
                            'newsletter_placeholder' => 'La tua email',
                            'newsletter_text' => 'Ricevi le nostre ultime offerte e promozioni senza spam. Puoi annullare l’iscrizione in qualsiasi momento.',
                            'copy' => 'Copyright ' . date('Y'),
                        ],
                    ];
                    $t = $labels[$locale] ?? $labels['en'];
                    $x = $extra[$locale] ?? $extra['en'];
                    $primaryPhoneHref = preg_replace('/\s+/', '', (string) ($siteSetting->phone_primary ?? ''));
                    $secondaryPhoneHref = preg_replace('/\s+/', '', (string) ($siteSetting->phone_secondary ?? ''));
                    $translatedAddress = method_exists($siteSetting, 't') ? $siteSetting->t('address') :
                        ($siteSetting->address ?? '');
                @endphp
                <h5>{{ $t['contact'] }}</h5>
                <ul>
                    <li>{{ $translatedAddress }}<br><br></li>
                    @if(!empty($siteSetting->email))
                        <li><strong><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></strong></li>
                    @endif
                    @if(!empty($siteSetting->phone_primary))
                        <li><strong><a href="tel:{{ $primaryPhoneHref }}">{{ $siteSetting->phone_primary }}</a></strong>
                        </li>
                    @endif
                    @if(!empty($siteSetting->phone_secondary))
                        <li><strong><a href="tel:{{ $secondaryPhoneHref }}">{{ $siteSetting->phone_secondary }}</a></strong>
                        </li>
                    @endif
                </ul>
                <div class="social">
                    <ul>
                        @if(!empty($siteSetting->instagram_url))
                            <li><a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener"><i
                                        class="bi bi-instagram"></i></a></li>
                        @endif
                        @if(!empty($siteSetting->whatsapp_url))
                            <li><a href="{{ $siteSetting->whatsapp_url }}" target="_blank" rel="noopener"><i
                                        class="bi bi-whatsapp"></i></a></li>
                        @endif
                        @if(!empty($siteSetting->facebook_url))
                            <li><a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener"><i
                                        class="bi bi-facebook"></i></a></li>
                        @endif
                        @if(!empty($siteSetting->twitter_url))
                            <li><a href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener"><i
                                        class="bi bi-twitter-x"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 ms-lg-auto">
                <h5>{{ $t['explore'] }}</h5>
                <div class="footer_links">
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $t['home'] }}</a></li>
                        <li><a href="{{ url('/appartements') }}">{{ $t['apartments'] }}</a></li>
                        <li><a href="{{ route('restaurant.index') }}">{{ $t['restaurant'] }}</a></li>
                        <li><a href="{{ route('pool.index') }}">{{ $t['pool'] }}</a></li>
                        <li><a href="{{ url('/news') }}">{{ $t['news'] }}</a></li>
                        <li><a href="{{ url('/contacts') }}">{{ $t['contact_link'] }}</a></li>
                        <li><a href="{{ route('termsOfUse.index') }}">{{ $t['terms'] }}</a></li>
                        <li><a href="{{ route('privacy.index') }}">{{ $t['privacy'] }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div id="newsletter">
                    <h5>{{ $x['newsletter'] }}</h5>
                    <div id="message-newsletter"></div>
                    <form method="post" action="{{ asset('phpmailer/newsletter_template_email.php') }}"
                        name="newsletter_form" id="newsletter_form">
                        <div class="form-group">
                            <input type="email" name="email_newsletter" id="email_newsletter" class="form-control"
                                placeholder="{{ $x['newsletter_placeholder'] }}">
                            <button type="submit" id="submit-newsletter"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                    <p>{{ $x['newsletter_text'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="copy">
        <div class="container">
            © {{ $x['copy'] }}
        </div>
    </div>
</footer>
