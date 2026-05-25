@extends('admin.layout')

@section('title', $pageMeta['title'])

@section('content')
    <style>
        .rich-editor {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background: #fff;
        }

        .rich-editor__toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .rich-editor__toolbar button {
            border: 1px solid #d0d7de;
            background: #fff;
            border-radius: 0.375rem;
            padding: 0.35rem 0.65rem;
            font-size: 0.875rem;
            line-height: 1;
        }

        .rich-editor__content {
            min-height: 220px;
            padding: 1rem;
            outline: none;
        }

        .rich-editor__content:empty:before {
            content: attr(data-placeholder);
            color: #6c757d;
        }
    </style>
    @php
        $crudLabels = $pageMeta['crud_labels'] ?? [];
    @endphp
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $pageMeta['title'] }}</h1>
            <!-- <div class="text-muted">{{ $pageMeta['description'] }} 
                <a href="#table" class="text-decoration-underline">Voir le menu restaurant</a>
            </div> -->

        </div>
        <a href="{{ route($pageMeta['routes']['create']) }}" class="btn btn-primary">Ajouter</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pageMeta['section_settings']['enabled'])
        <div class="admin-card p-4 mb-4" id="header-section">
            <h2 class="h5 mb-3">{{ $pageMeta['section_settings']['title'] }}</h2>
            <form action="{{ route($pageMeta['routes']['section_settings']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $headerSrc = media_url($sectionSetting->header_image ?? null);
                @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Sous-titre</label>
                        <input type="text" name="subtitle" class="form-control"
                            value="{{ old('subtitle', $sectionSetting->subtitle ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $sectionSetting->title ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Image header</label>
                        <input type="file" name="header_image" id="restaurant_header_image" class="form-control"
                            accept="image/*">
                        <div class="mt-2">
                            <img id="restaurant_header_preview" src="{{ $headerSrc ?? '' }}" alt="" class="rounded"
                                style="max-height:120px;{{ empty($headerSrc) ? 'display:none;' : '' }}">
                        </div>
                    </div>
                    <!-- @if($pageMeta['section_settings']['show_hero_text'])
                        <div class="col-12">
                            <label class="form-label">.</label>
                            <textarea name="hero_text" class="form-control"
                                rows="3">{{ old('hero_text', $sectionSetting->hero_text ?? '') }}</textarea>
                        </div>
                    @endif -->
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($pageMeta['about_section']['enabled'])
        <div class="admin-card p-4 mb-4" id="about-section">
            <h2 class="h5 mb-3">{{ $pageMeta['about_section']['title'] }}</h2>
            <form action="{{ route($pageMeta['about_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $aboutMainSrc = media_url($aboutSectionSetting->main_image ?? null, 'img/home_2.jpg');
                    $aboutOverlaySrc = media_url($aboutSectionSetting->overlay_image ?? null, 'img/home_1.jpg');
                @endphp
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Petit titre</label>
                        <input type="text" name="small_title" class="form-control"
                            value="{{ old('small_title', $aboutSectionSetting->small_title ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $aboutSectionSetting->title ?? '') }}">
                    </div>
                    <!-- <div class="col-md-4">
                        <label class="form-label">Lead</label>
                        <input type="text" name="lead" class="form-control"
                            value="{{ old('lead', $aboutSectionSetting->lead ?? '') }}">
                    </div> -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        @php
                            $aboutDescription = old('description', $aboutSectionSetting->description ?? '');
                        @endphp
                        <div class="rich-editor">
                            <div class="rich-editor__toolbar">
                                <button type="button" data-editor-command="bold"><strong>G</strong></button>
                                <button type="button" data-editor-command="italic"><em>I</em></button>
                                <button type="button" data-editor-command="underline"><u>S</u></button>
                                <button type="button" data-editor-command="insertUnorderedList">Liste</button>
                                <button type="button" data-editor-command="formatBlock" data-editor-value="p">Paragraphe</button>
                                <button type="button" data-editor-command="formatBlock" data-editor-value="h3">Titre</button>
                                <button type="button" data-editor-command="justifyLeft">Gauche</button>
                                <button type="button" data-editor-command="justifyCenter">Centre</button>
                                <button type="button" data-editor-command="justifyRight">Droite</button>
                                <button type="button" data-editor-command="justifyFull">Justifier</button>
                                <button type="button" data-editor-link="true">Lien</button>
                            </div>
                            <div class="rich-editor__content" id="about_description_editor" contenteditable="true"
                                data-placeholder="Saisissez la description...">{!! $aboutDescription !!}</div>
                        </div>
                        <textarea name="description" id="about_description" class="form-control d-none"
                            rows="5">{{ $aboutDescription }}</textarea>
                    </div>
                    <!-- <div class="col-md-4">
                        <label class="form-label">Signature</label>
                        <input type="text" name="signature" class="form-control"
                            value="{{ old('signature', $aboutSectionSetting->signature ?? '') }}">
                    </div> -->
                    <!-- <div class="col-md-6">
                        <label class="form-label">Image principale</label>
                        <input type="file" name="main_image" id="about_main_image" class="form-control" accept="image/*">
                        @if(($pageMeta['title'] ?? '') === 'Piscine')
                            <small class="text-muted d-block mt-1">Format requis: 1920 x 1080 px.</small>
                        @endif
                        <div class="mt-2">
                            <img id="about_main_preview" src="{{ $aboutMainSrc }}" alt="" class="rounded"
                                style="max-height:100px;">
                        </div>
                    </div> -->
                    <!-- <div class="col-md-6">
                        <label class="form-label">Image superposée</label>
                        <input type="file" name="overlay_image" id="about_overlay_image" class="form-control" accept="image/*">
                        <div class="mt-2">
                            <img id="about_overlay_preview" src="{{ $aboutOverlaySrc }}" alt="" class="rounded"
                                style="max-height:100px;">
                        </div>
                    </div> -->
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- @if($pageMeta['extra_text_section']['enabled']) -->
        <!-- <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3">{{ $pageMeta['extra_text_section']['title'] }}</h2>
            <form action="{{ route($pageMeta['extra_text_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $extraImageOneSrc = media_url($extraTextSectionSetting->main_image ?? null);
                    $extraImageTwoSrc = media_url($extraTextSectionSetting->overlay_image ?? null);
                    $extraImageThreeSrc = media_url($extraTextSectionSetting->third_image ?? null);
                @endphp
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Sous-titre</label>
                        <input type="text" name="subtitle" class="form-control"
                            value="{{ old('subtitle', $extraTextSectionSetting->small_title ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $extraTextSectionSetting->title ?? '') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                            rows="4">{{ old('description', $extraTextSectionSetting->description ?? '') }}</textarea>
                    </div>
                    @if($pageMeta['extra_text_section']['show_images'])
                        <div class="col-md-4">
                            <label class="form-label">Photo 1</label>
                            <input type="file" name="image_one" id="extra_image_one" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-1">Format requis: {{ $pageMeta['extra_text_section']['image_dimensions']['width'] }} x {{ $pageMeta['extra_text_section']['image_dimensions']['height'] }} px.</small>
                            <div class="mt-2">
                                <img id="extra_image_one_preview" src="{{ $extraImageOneSrc ?? '' }}" alt="" class="rounded"
                                    style="max-height:120px;{{ empty($extraImageOneSrc) ? 'display:none;' : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Photo 2</label>
                            <input type="file" name="image_two" id="extra_image_two" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-1">Format requis: {{ $pageMeta['extra_text_section']['image_dimensions']['width'] }} x {{ $pageMeta['extra_text_section']['image_dimensions']['height'] }} px.</small>
                            <div class="mt-2">
                                <img id="extra_image_two_preview" src="{{ $extraImageTwoSrc ?? '' }}" alt="" class="rounded"
                                    style="max-height:120px;{{ empty($extraImageTwoSrc) ? 'display:none;' : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Photo 3</label>
                            <input type="file" name="image_three" id="extra_image_three" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-1">Format requis: {{ $pageMeta['extra_text_section']['image_dimensions']['width'] }} x {{ $pageMeta['extra_text_section']['image_dimensions']['height'] }} px.</small>
                            <div class="mt-2">
                                <img id="extra_image_three_preview" src="{{ $extraImageThreeSrc ?? '' }}" alt="" class="rounded"
                                    style="max-height:120px;{{ empty($extraImageThreeSrc) ? 'display:none;' : '' }}">
                            </div>
                        </div>
                    @endif
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div> -->
    <!-- @endif -->

    @if($pageMeta['secondary_extra_section']['enabled'])
        <div class="admin-card p-4 mb-4" id="secondary-extra-section">
            <h2 class="h5 mb-3">{{ $pageMeta['secondary_extra_section']['title'] }}</h2>
            <form action="{{ route($pageMeta['secondary_extra_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $secondaryExtraMainSrc = media_url($secondaryExtraSectionSetting->main_image ?? null);
                    $secondaryExtraOverlaySrc = media_url($secondaryExtraSectionSetting->overlay_image ?? null);
                @endphp
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $secondaryExtraSectionSetting->title ?? '') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                            rows="4">{{ old('description', $secondaryExtraSectionSetting->description ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Photo 1</label>
                        <input type="file" name="main_image" id="secondary_extra_main_image" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-1">Format requis: {{ $pageMeta['secondary_extra_section']['main_image_dimensions']['width'] }} x {{ $pageMeta['secondary_extra_section']['main_image_dimensions']['height'] }} px.</small>
                        <div class="mt-2">
                            <img id="secondary_extra_main_preview" src="{{ $secondaryExtraMainSrc ?? '' }}" alt="" class="rounded"
                                style="max-height:120px;{{ empty($secondaryExtraMainSrc) ? 'display:none;' : '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Photo 2</label>
                        <input type="file" name="overlay_image" id="secondary_extra_overlay_image" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-1">Format requis: {{ $pageMeta['secondary_extra_section']['overlay_image_dimensions']['width'] }} x {{ $pageMeta['secondary_extra_section']['overlay_image_dimensions']['height'] }} px.</small>
                        <div class="mt-2">
                            <img id="secondary_extra_overlay_preview" src="{{ $secondaryExtraOverlaySrc ?? '' }}" alt="" class="rounded"
                                style="max-height:120px;{{ empty($secondaryExtraOverlaySrc) ? 'display:none;' : '' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if(($pageMeta['restaurant_info_section']['enabled'] ?? false))
        <div class="admin-card p-4 mb-4" id="restaurant-info-section">
            <h2 class="h5 mb-3">{{ $pageMeta['restaurant_info_section']['title'] }}</h2>
            <form action="{{ route($pageMeta['restaurant_info_section']['route']) }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Titre réservation</label>
                        <input type="text" name="small_title" class="form-control"
                            value="{{ old('small_title', $restaurantInfoSectionSetting->small_title ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Horaires</label>
                        <textarea name="lead" class="form-control" rows="5">{{ old('lead', $restaurantInfoSectionSetting->lead ?? '') }}</textarea>
                        <small class="text-muted d-block mt-1">Une ligne par horaire.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Titre dress code</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $restaurantInfoSectionSetting->title ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Titre terrasse</label>
                        <input type="text" name="signature" class="form-control"
                            value="{{ old('signature', $restaurantInfoSectionSetting->signature ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Texte dress code</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $restaurantInfoSectionSetting->description ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Texte terrasse</label>
                        <textarea name="main_image" class="form-control" rows="3">{{ old('main_image', $restaurantInfoSectionSetting->main_image ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if(($pageMeta['pool_info_section']['enabled'] ?? false))
        <div class="admin-card p-4 mb-4" id="pool-info-section">
            <h2 class="h5 mb-3">{{ $pageMeta['pool_info_section']['title'] }}</h2>
            <form action="{{ route($pageMeta['pool_info_section']['route']) }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Titre horaires</label>
                        <input type="text" name="small_title" class="form-control"
                            value="{{ old('small_title', $poolInfoSectionSetting->small_title ?? '') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Horaires d'ouverture</label>
                        <textarea name="lead" class="form-control" rows="5">{{ old('lead', $poolInfoSectionSetting->lead ?? '') }}</textarea>
                        <small class="text-muted d-block mt-1">Une ligne par horaire.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Titre règles</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $poolInfoSectionSetting->title ?? '') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Texte règles</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $poolInfoSectionSetting->description ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Titre services</label>
                        <input type="text" name="signature" class="form-control"
                            value="{{ old('signature', $poolInfoSectionSetting->signature ?? '') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Texte services</label>
                        <textarea name="main_image" class="form-control" rows="3">{{ old('main_image', $poolInfoSectionSetting->main_image ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    

    <!-- <div class="mt-3">
        {{ $comodites->links('pagination::bootstrap-5') }}
    </div> -->

    @if(($pageMeta['restaurant_gallery_section']['enabled'] ?? false))
    <div class="admin-card p-4 mt-4" id="gallery-section">
        <h2 class="h5 mb-3">{{ $pageMeta['restaurant_gallery_section']['title'] }}</h2>
        <form action="{{ route($pageMeta['restaurant_gallery_section']['route']) }}" method="post" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="subtitle" class="form-control"
                        value="{{ old('subtitle', $restaurantGallerySectionSetting->small_title ?? 'Image Gallery') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $restaurantGallerySectionSetting->title ?? 'Restaurant Gallery') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Ajouter des photos</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted d-block mt-1">Vous pouvez sélectionner plusieurs fichiers à la fois.</small>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </div>
            </div>
        </form>
        @php
            $currentGallery = $restaurantGallerySectionSetting->gallery ?? [];
        @endphp
        @if(!empty($currentGallery))
            <h6 class="mb-3">Photos actuelles ({{ count($currentGallery) }}) <small class="text-muted">(Glissez pour réorganiser)</small></h6>
            <div class="row g-2 sortable-gallery" id="restaurant-gallery-grid" data-reorder-url="{{ route($pageMeta['restaurant_gallery_section']['reorder_route'] ?? 'admin.dashboard') }}">
                @foreach($currentGallery as $galleryImg)
                <div class="col-6 col-md-3 col-lg-2 position-relative gallery-item" data-path="{{ $galleryImg }}">
                    <img src="{{ media_url($galleryImg) }}" alt=""
                        class="img-fluid rounded" style="height:120px;width:100%;object-fit:cover;">
                    <form action="{{ route($pageMeta['restaurant_gallery_section']['remove_route']) }}" method="post"
                        class="position-absolute top-0 end-0 m-1"
                        onsubmit="return confirm('Supprimer cette image ?');">
                        @csrf
                        <input type="hidden" name="image" value="{{ $galleryImg }}">
                        <button type="submit" class="btn btn-sm btn-danger lh-1 p-1" title="Supprimer">&times;</button>
                    </form>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aucune photo pour l'instant.</p>
        @endif
    </div>
    @endif

    @if(($pageMeta['pool_gallery_section']['enabled'] ?? false))
    <div class="admin-card p-4 mt-4" id="pool-gallery-section">
        <h2 class="h5 mb-3">{{ $pageMeta['pool_gallery_section']['title'] }}</h2>
        <form action="{{ route($pageMeta['pool_gallery_section']['route']) }}" method="post" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="subtitle" class="form-control"
                        value="{{ old('subtitle', $poolGallerySectionSetting->small_title ?? 'Galerie Photos') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $poolGallerySectionSetting->title ?? 'Piscine Gallery') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Ajouter des photos</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted d-block mt-1">Vous pouvez sélectionner plusieurs fichiers à la fois.</small>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </div>
            </div>
        </form>
        @php
            $currentPoolGallery = $poolGallerySectionSetting->gallery ?? [];
        @endphp
        @if(!empty($currentPoolGallery))
            <h6 class="mb-3">Photos actuelles ({{ count($currentPoolGallery) }}) <small class="text-muted">(Glissez pour réorganiser)</small></h6>
            <div class="row g-2 sortable-gallery" id="pool-gallery-grid" data-reorder-url="{{ route($pageMeta['pool_gallery_section']['reorder_route'] ?? 'admin.dashboard') }}">
                @foreach($currentPoolGallery as $galleryImg)
                <div class="col-6 col-md-3 col-lg-2 position-relative gallery-item" data-path="{{ $galleryImg }}">
                    <img src="{{ media_url($galleryImg) }}" alt=""
                        class="img-fluid rounded" style="height:120px;width:100%;object-fit:cover;">
                    <form action="{{ route($pageMeta['pool_gallery_section']['remove_route']) }}" method="post"
                        class="position-absolute top-0 end-0 m-1"
                        onsubmit="return confirm('Supprimer cette image ?');">
                        @csrf
                        <input type="hidden" name="image" value="{{ $galleryImg }}">
                        <button type="submit" class="btn btn-sm btn-danger lh-1 p-1" title="Supprimer">&times;</button>
                    </form>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aucune photo pour l'instant.</p>
        @endif
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!@json($pageMeta['section_settings']['enabled'])) {
                return;
            }

            const input = document.getElementById('restaurant_header_image');
            const preview = document.getElementById('restaurant_header_preview');

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function (event) {
                const file = event.target.files && event.target.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });

            const bindPreview = function (inputId, previewId) {
                const fileInput = document.getElementById(inputId);
                const filePreview = document.getElementById(previewId);

                if (!fileInput || !filePreview) {
                    return;
                }

                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file) {
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        filePreview.src = e.target.result;
                        filePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                });
            };

            bindPreview('about_main_image', 'about_main_preview');
            bindPreview('about_overlay_image', 'about_overlay_preview');
            bindPreview('extra_image_one', 'extra_image_one_preview');
            bindPreview('extra_image_two', 'extra_image_two_preview');
            bindPreview('extra_image_three', 'extra_image_three_preview');
            bindPreview('secondary_extra_main_image', 'secondary_extra_main_preview');
            bindPreview('secondary_extra_overlay_image', 'secondary_extra_overlay_preview');

            // Gallery Sortable
            document.querySelectorAll('.sortable-gallery').forEach(grid => {
                new Sortable(grid, {
                    animation: 150,
                    ghostClass: 'bg-light',
                    onEnd: function() {
                        const url = grid.dataset.reorderUrl;
                        if (!url || url.includes('dashboard')) return;

                        const order = Array.from(grid.querySelectorAll('.gallery-item')).map(el => el.dataset.path);
                        
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Optional: show toast or success indicator
                            }
                        })
                        .catch(err => console.error('Error reordering gallery:', err));
                    }
                });
            });

            // Rich Editor
            const editor = document.getElementById('about_description_editor');
            const textarea = document.getElementById('about_description');
            const toolbarButtons = document.querySelectorAll('[data-editor-command], [data-editor-link]');

            if (editor && textarea) {
                const syncEditor = () => {
                    textarea.value = editor.innerHTML.trim();
                };

                toolbarButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const command = this.dataset.editorCommand;
                        const value = this.dataset.editorValue;

                        editor.focus();

                        if (this.dataset.editorLink) {
                            const url = window.prompt('URL du lien');
                            if (!url) return;
                            document.execCommand('createLink', false, url);
                            syncEditor();
                            return;
                        }

                        document.execCommand(command, false, value || null);
                        syncEditor();
                    });
                });

                editor.addEventListener('input', syncEditor);
                editor.closest('form')?.addEventListener('submit', syncEditor);
            }
        });
    </script>
@endsection
