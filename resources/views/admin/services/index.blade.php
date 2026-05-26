@extends('admin.layout')

@section('title', 'Services')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Services</h1>
        <div class="text-muted">Gérez les onglets de services affichés sur la page d'accueil (Restaurant, Spa, Piscine, Fitness…)</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary">Nouveau service</a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la home</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

{{-- Liste --}}
<div class="admin-card p-4 mb-4">
    <h2 class="h5 mb-3">Services existants</h2>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Clé onglet</th>
                    <th>Titre</th>
                    <th>Ordre</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>
                            @php
                                $_simg = $service->image ?? '';
                                if (str_starts_with($_simg, 'img/')) {
                                    $_sthumb = asset('themes/lasanta/' . $_simg);
                                } elseif (str_starts_with($_simg, 'themes/')) {
                                    $_sthumb = asset($_simg);
                                } elseif (!empty($_simg)) {
                                    $_sthumb = media_url($_simg);
                                } else {
                                    $_sthumb = null;
                                }
                            @endphp
                            @if($_sthumb)
                                <img src="{{ $_sthumb }}" alt="" class="rounded" style="height:48px; width:72px; object-fit:cover;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><code>{{ $service->tab_key }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $service->title }}</div>
                            @if($service->subtitle)
                                <small class="text-muted">{{ $service->subtitle }}</small>
                            @endif
                        </td>
                        <td>{{ $service->sort_order }}</td>
                        <td>
                            @if($service->is_published)
                                <span class="badge bg-success">Publié</span>
                            @else
                                <span class="badge bg-secondary">Masqué</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.services.index', ['edit' => $service->id]) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="post" onsubmit="return confirm('Supprimer ce service ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun service enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Formulaire --}}
@php
    $isEditing = $editingService !== null;
    $s = $editingService;
    $imageSrc = null;
    if (!empty($s?->image)) {
        $imageSrc = str_starts_with($s->image, 'img/')
            ? asset('themes/lasanta/' . $s->image)
            : media_url($s->image);
    }
@endphp

<div class="admin-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">{{ $isEditing ? 'Modifier le service' : 'Créer un service' }}</h2>
        @if($isEditing)
            <small class="text-muted">Service #{{ $s->id }}</small>
        @endif
    </div>

    <form action="{{ $isEditing ? route('admin.services.update', $s) : route('admin.services.store') }}"
          method="post" enctype="multipart/form-data">
        @csrf
        @if($isEditing)
            @method('PUT')
        @endif

        <div class="row g-3">
            {{-- Statut --}}
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="svc_published" name="is_published" value="1"
                           {{ old('is_published', $s?->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="svc_published">Publié (visible sur la home)</label>
                </div>
            </div>

            {{-- Clé onglet --}}
            <div class="col-md-6">
                <label class="form-label">Clé onglet <span class="text-danger">*</span></label>
                <input type="text" name="tab_key" class="form-control"
                       value="{{ old('tab_key', $s?->tab_key ?? '') }}"
                       placeholder="restaurant" required>
                <div class="form-text">Identifiant unique (ex: restaurant, spa, pool, fitness)</div>
            </div>

            {{-- Ordre --}}
            <div class="col-md-6">
                <label class="form-label">Ordre d'affichage</label>
                <input type="number" name="sort_order" class="form-control" min="0"
                       value="{{ old('sort_order', $s?->sort_order ?? 0) }}">
            </div>

            {{-- Sous-titre --}}
            <div class="col-12">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control"
                       value="{{ old('subtitle', $s?->subtitle ?? '') }}"
                       placeholder="Addres of taste">
            </div>

            {{-- Titre --}}
            <div class="col-12">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $s?->title ?? '') }}"
                       placeholder="Restaurant" required>
            </div>

            {{-- Description --}}
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"
                          placeholder="Texte descriptif affiché sous le titre…">{{ old('description', $s?->description ?? '') }}</textarea>
            </div>

            {{-- Bouton : texte + lien --}}
            <div class="col-md-6">
                <label class="form-label">Texte du bouton <span class="text-secondary text-sm">(Si vide le button ne s'affiche pas)</span></label>
                <input type="text" name="button_text" class="form-control"
                       value="{{ old('button_text', $s?->button_text ?? '') }}"
                       placeholder="">
            </div>
            <div class="col-md-6">
                <label class="form-label">Lien du bouton</label>
                <input type="text" name="button_link" id="svc_button_link" class="form-control"
                       value="{{ old('button_link', $s?->button_link ?? '') }}"
                       placeholder="https://... ou /restaurant">
            </div>

            {{-- PDF --}}
            <div class="col-md-6">
                <label class="form-label">PDF à télécharger <small class="text-muted">(optionnel — remplace automatiquement le lien du bouton)</small></label>
                <input type="file" name="pdf_file" id="svc_pdf_file" class="form-control" accept="application/pdf">
                @if($isEditing && !empty($s->pdf_file))
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-danger"></i>
                        <a href="{{ media_url($s->pdf_file) }}" download
                           class="text-decoration-none small">Télécharger le PDF actuel</a>
                    </div>
                    @include('admin.partials.remove-media-toggle', ['name' => 'remove_pdf_file', 'label' => 'Supprimer le PDF'])
                @endif
            </div>

            {{-- Icône FontAwesome – sélecteur visuel --}}
            @php
                $currentIcon = old('icon', $s?->icon ?? '');
                $iconChoices = [
                    'fa-solid fa-user-chef'       => 'Chef',
                    'fa-solid fa-spa'              => 'Spa',
                    'fa-solid fa-person-swimming'  => 'Piscine',
                    'fa-solid fa-dumbbell'         => 'Fitness',
                    'fa-solid fa-utensils'         => 'Couverts',
                    'fa-solid fa-wine-glass'       => 'Vin',
                    'fa-solid fa-bed'              => 'Lit',
                    'fa-solid fa-concierge-bell'   => 'Réception',
                    'fa-solid fa-umbrella-beach'   => 'Plage',
                    'fa-solid fa-bicycle'          => 'Vélo',
                    'fa-solid fa-leaf'             => 'Nature',
                    'fa-solid fa-mountain'         => 'Montagne',
                    'fa-solid fa-golf-ball-tee'    => 'Golf',
                    'fa-solid fa-tennis-ball'      => 'Tennis',
                    'fa-solid fa-fire'             => 'Feu / BBQ',
                    'fa-solid fa-mug-hot'          => 'Café',
                    'fa-solid fa-music'            => 'Musique',
                    'fa-solid fa-camera'           => 'Photo',
                    'fa-solid fa-car'              => 'Voiture',
                    'fa-solid fa-shield-heart'     => 'Sécurité',
                ];
            @endphp
            <!-- <div class="col-12">
                <label class="form-label">Icône FontAwesome</label>

                {{-- Champ texte caché qui stocke la valeur --}}
                <input type="hidden" name="icon" id="svc_icon_value" value="{{ $currentIcon }}">

                {{-- Aperçu de l'icône sélectionnée --}}
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div id="svc_icon_preview" style="font-size:2rem; width:2.5rem; text-align:center;">
                        @if($currentIcon)<i class="{{ $currentIcon }}"></i>@endif
                    </div>
                    <input type="text" id="svc_icon_text" class="form-control" style="max-width:280px;"
                           value="{{ $currentIcon }}" placeholder="fa-solid fa-user-chef"
                           oninput="syncIconFromText(this.value)">
                    <small class="text-muted">Ou saisissez manuellement la classe FontAwesome</small>
                </div>

                {{-- Grille visuelle --}}
                <div class="d-flex flex-wrap gap-2 p-3 border rounded" style="background:#f8f9fa; max-height:220px; overflow-y:auto;">
                    @foreach($iconChoices as $cls => $label)
                    <label class="svc-icon-option d-flex flex-column align-items-center justify-content-center gap-1 p-2 rounded border"
                           style="cursor:pointer; min-width:70px; font-size:0.72rem; text-align:center;
                                  background:{{ $currentIcon === $cls ? '#0d6efd' : '#fff' }};
                                  color:{{ $currentIcon === $cls ? '#fff' : '#333' }};
                                  border-color:{{ $currentIcon === $cls ? '#0d6efd' : '#dee2e6' }} !important;"
                           data-icon="{{ $cls }}">
                        <i class="{{ $cls }}" style="font-size:1.4rem; pointer-events:none;"></i>
                        <span style="pointer-events:none;">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div> -->

            {{-- Image --}}
            <div class="col-12">
                <label class="form-label">Image <small class="text-muted">(sera redimensionnée à 1000×900 px, JPEG 90%)</small></label>
                <input type="file" name="image" id="svc_image" class="form-control" accept="image/*">
                @if($imageSrc)
                    <div class="mt-2">
                        <img id="svc_image_preview" src="{{ $imageSrc }}" alt=""
                             class="rounded" style="max-height:120px;">
                    </div>
                    @if(!str_starts_with($s->image, 'img/') && !str_starts_with($s->image, 'themes/'))
                        @include('admin.partials.remove-media-toggle', ['name' => 'remove_image', 'label' => 'Supprimer l’image'])
                    @endif
                @else
                    <div class="mt-2">
                        <img id="svc_image_preview" src="" alt="" class="rounded d-none" style="max-height:120px;">
                    </div>
                @endif
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ $isEditing ? 'Mettre à jour' : 'Créer le service' }}
                </button>
                @if($isEditing)
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
function syncIconFromText(val) {
    document.getElementById('svc_icon_value').value = val;
    const preview = document.getElementById('svc_icon_preview');
    preview.innerHTML = val ? '<i class="' + val + '"></i>' : '';
    document.querySelectorAll('.svc-icon-option').forEach(el => {
        const active = el.dataset.icon === val;
        el.style.background      = active ? '#0d6efd' : '#fff';
        el.style.color           = active ? '#fff'    : '#333';
        el.style.borderColor     = active ? '#0d6efd' : '#dee2e6';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Icon picker clicks
    document.querySelectorAll('.svc-icon-option').forEach(el => {
        el.addEventListener('click', function () {
            const val = this.dataset.icon;
            document.getElementById('svc_icon_value').value = val;
            document.getElementById('svc_icon_text').value  = val;
            document.getElementById('svc_icon_preview').innerHTML = '<i class="' + val + '"></i>';
            document.querySelectorAll('.svc-icon-option').forEach(o => {
                const active = o.dataset.icon === val;
                o.style.background  = active ? '#0d6efd' : '#fff';
                o.style.color       = active ? '#fff'    : '#333';
                o.style.borderColor = active ? '#0d6efd' : '#dee2e6';
            });
        });
    });

    // Image preview
    const imgInput   = document.getElementById('svc_image');
    const imgPreview = document.getElementById('svc_image_preview');
    if (imgInput && imgPreview) {
        imgInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('d-none');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // PDF → auto-fill button_link with filename hint
    const pdfInput      = document.getElementById('svc_pdf_file');
    const btnLinkInput  = document.getElementById('svc_button_link');
    if (pdfInput && btnLinkInput) {
        pdfInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                btnLinkInput.value = '(PDF : ' + this.files[0].name + ')';
            }
        });
    }
});
</script>
@endsection
