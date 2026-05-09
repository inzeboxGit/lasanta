@php
    $translatedAddress = method_exists($siteSetting, 't') ? $siteSetting->t('address') : ($siteSetting->address ?? '');
    $siteName = method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Lasanta');
@endphp
<footer class="footer">
    <div class="top">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-30">
                    <div class="item">
                        <div class="logo"><img src="{{ theme_asset('img/logo.png') }}" alt="{{ $siteName }}"></div>
                        <p>{{ $siteName }}</p>
                        <div class="social-icons">
                            <ul class="list-inline">
                                @if(!empty($siteSetting->instagram_url))
                                    <li><a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
                                @endif
                                @if(!empty($siteSetting->twitter_url))
                                    <li><a href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener"><i class="fa-brands fa-twitter"></i></a></li>
                                @endif
                                @if(!empty($siteSetting->facebook_url))
                                    <li><a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 offset-md-1 mb-30">
                    <div class="item">
                        <h3>Contact</h3>
                        <p>{{ $translatedAddress }}</p>
                        @if(!empty($siteSetting->phone_primary))
                            <div class="phone"><a href="tel:{{ preg_replace('/\s+/', '', (string) $siteSetting->phone_primary) }}">{{ $siteSetting->phone_primary }}</a></div>
                        @endif
                        @if(!empty($siteSetting->email))
                            <div class="mail"><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 mb-30">
                    <div class="item">
                        <h3>Navigation</h3>
                        <div class="links">
                            <ul>
                                <li><a href="{{ url('/') }}">Accueil</a></li>
                                <li><a href="{{ route('appartements.index') }}">Appartements</a></li>
                                <li><a href="{{ route('restaurant.index') }}">Restaurant</a></li>
                                <li><a href="{{ route('news.index') }}">Actualités</a></li>
                                <li><a href="{{ url('/contacts') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="links">
                        <ul>
                            <li><a href="{{ route('termsOfUse.index') }}">Conditions</a></li>
                            <li><a href="{{ route('privacy.index') }}">Mentions légales</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 text-end">
                    <p>Copyright {{ now()->year }} by {{ $siteName }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
