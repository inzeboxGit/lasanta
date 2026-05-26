<!-- Actualités -->
@php
    $moreLabels = ['fr' => 'Voir plus', 'en' => 'See more', 'de' => 'Mehr sehen', 'it' => 'Vedi di piu'];
@endphp
<section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row mb-15">
            <div class="col-md-12 text-center">
                <div class="section-subtitle brown">{{ (isset($newsSectionSetting) && method_exists($newsSectionSetting, 't') ? $newsSectionSetting->t('subtitle') : null) ?: ($newsSectionSetting->subtitle) }}</div>
                <div class="section-title black">{{ (isset($newsSectionSetting) && method_exists($newsSectionSetting, 't') ? $newsSectionSetting->t('title') : null) ?: ($newsSectionSetting->title) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme">
                    @forelse(($homeNews ?? collect()) as $item)
                        @php
                            $coverSrc = media_url($item->cover_image ?? null, 'themes/lasanta/img/blog/1.jpg');
                        @endphp
                        <div class="item mt-10">
                            <div class="img">
                                <img src="{{ $coverSrc }}" class="img-fluid" alt="{{ method_exists($item, 't') ? $item->t('title') : $item->title }}">
                                <!-- @if($item->published_at)
                                    <div class="cat">{{ $item->published_at->format('d M Y') }}</div>
                                @endif -->
                            </div>
                            <div class="cont">
                                <h4><a href="{{ route('news.show', $item->slug) }}">{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</a></h4>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags(method_exists($item, 't') ? $item->t('excerpt') : ($item->excerpt ?? '')), 100) }}</p>
                                <div class="col-lg-7 text-left">
                                    <a href="{{ route('news.show', $item->slug) }}" style="padding:0px 8px !important;" class="button-3">{{ $moreLabels[app()->getLocale()] ?? $moreLabels['en'] }}</a>
                                </div>
                                <!-- <div class="author">
                                    <div>
                                        <h5>{{ $item->published_at?->format('d F Y') ?? '' }}</h5>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    @empty
                        <div class="item mt-10">
                            <div class="cont">
                                <p>Aucune actualité pour le moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
