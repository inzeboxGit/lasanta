@extends('admin.layout')

@section('title', 'Offres')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Offres</h1>
        <div class="text-muted">Créer des offres </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline-primary">Nouvelle offre</a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la home</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<!-- <div class="alert alert-info">
    Une seule promotion peut être active à la fois. Si vous activez une promo, toutes les autres seront automatiquement désactivées.
</div> -->

<div class="admin-card p-4 mb-4">
    @php
        $phImg = $promoHeaderSetting->header_image ?? '';
        $phSrc = '';
        if (!empty($phImg)) {
            $phSrc = str_starts_with($phImg, 'img/')
                ? asset('themes/lasanta/' . $phImg)
                : asset('storage/' . $phImg);
        }
    @endphp
    <!-- <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">En-tête de la section Offres</h2>
        <small class="text-muted">Titre et bannière affichés au-dessus de la liste des offres</small>
    </div>
    <form action="{{ route('admin.promo.section.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $promoHeaderSetting->subtitle ?? 'NOS OFFRES') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $promoHeaderSetting->title ?? 'OFFRES SPÉCIALES') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Image bannière</label>
                <input type="file" name="header_image" id="promo_section_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="promo_section_image_preview" src="{{ $phSrc }}" alt="" class="rounded"
                        style="max-height:120px;{{ empty($phSrc) ? 'display:none;' : '' }}">
                </div>
                <div class="form-text">Format recommandé : 1920×600 px. Laisser vide pour conserver l'image actuelle.</div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer l'en-tête</button>
            </div>
        </div>
    </form>
</div> -->

<div class="admin-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Promos existantes</h2>
        <small class="text-muted">Une seule promo peut être active à la fois.</small>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                    <tr>
                        <td>{{ $promo->id }}</td>
                        <td>
                            @php
                                $_pimg = $promo->image ?? '';
                                if (str_starts_with($_pimg, 'img/')) {
                                    $_pthumb = asset('themes/lasanta/' . $_pimg);
                                } elseif (!empty($_pimg)) {
                                    $_pthumb = asset('storage/' . $_pimg);
                                } else {
                                    $_pthumb = null;
                                }
                            @endphp
                            @if($_pthumb)
                                <img src="{{ $_pthumb }}" alt="" class="rounded" style="height:48px; width:72px; object-fit:cover;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $promo->title ?: ('Promo #' . $promo->id) }}</div>
                            @if(!empty($promo->subtitle))
                                <small class="text-muted">{{ $promo->subtitle }}</small>
                            @endif
                        </td>
                        <td>
                            @if($promo->start_date || $promo->end_date)
                                {{ $promo->start_date?->format('d/m/Y') ?: 'Immédiat' }}
                                -
                                {{ $promo->end_date?->format('d/m/Y') ?: 'Sans fin' }}
                            @else
                                <span class="text-muted">Sans limite</span>
                            @endif
                        </td>
                        <td>
                            @if($promo->is_enabled)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.promo.index', ['edit' => $promo->id]) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route('admin.promo.destroy', $promo) }}" method="post" onsubmit="return confirm('Supprimer cette promo ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucune promo enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="admin-card p-4">
    @php
        $imageSrc = null;
        if (!empty($promoSetting->image ?? null)) {
            $imageSrc = str_starts_with($promoSetting->image, 'img/')
                ? asset('themes/lasanta/' . $promoSetting->image)
                : asset('storage/' . $promoSetting->image);
        }
        $isEditing = $editingPromo !== null;
    @endphp

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">{{ $isEditing ? 'Modifier la promo' : 'Créer une promo' }}</h2>
        @if($isEditing)
            <small class="text-muted">Promo #{{ $editingPromo->id }}</small>
        @endif
    </div>

    <form action="{{ $isEditing ? route('admin.promo.update', $editingPromo) : route('admin.promo.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($isEditing)
            @method('PUT')
        @endif

        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="promo_enabled" name="is_enabled" value="1" {{ old('is_enabled', $promoSetting->is_enabled ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="promo_enabled">Activer cette promo sur la home</label>
                </div>
                <div class="form-text">Si cette promo est activée, toutes les autres seront désactivées automatiquement.</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Promotion Discount</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $promoSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $promoSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Texte</label>
                <textarea name="text" class="form-control" rows="5">{{ old('text', $promoSetting->text ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de debut</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', !empty($promoSetting->start_date) ? \Illuminate\Support\Carbon::parse($promoSetting->start_date)->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', !empty($promoSetting->end_date) ? \Illuminate\Support\Carbon::parse($promoSetting->end_date)->format('Y-m-d') : '') }}">
                <div class="form-text">Laissez vide pour afficher sans limite de date.</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Lien du bouton</label>
                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $promoSetting->button_link ?? '') }}" placeholder="https://... ou /appartements">
            </div>
            <div class="col-md-4">
                <label class="form-label">Texte du bouton</label>
                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $promoSetting->button_text ?? '') }}" placeholder="Voir l'offre">
                <div class="form-text">Ce texte sera affiché dans le modal (traduisible dans l'onglet Traductions).</div>
                @if($isEditing)
                    <a href="{{ route('admin.translations.index', ['type' => 'promo_section', 'id' => $editingPromo->id, 'locale' => 'en']) }}" class="btn btn-sm btn-outline-secondary mt-2">Modifier les traductions du bouton</a>
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label">Image</label>
                <input type="file" name="image" id="promo_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="promo_image_preview" src="{{ $imageSrc ?? '' }}" alt="" class="rounded" style="max-height:100px;{{ empty($imageSrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Mettre à jour' : 'Créer la promo' }}</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Preview bannière section
    const sectionInput = document.getElementById('promo_section_image');
    const sectionPreview = document.getElementById('promo_section_image_preview');
    if (sectionInput && sectionPreview) {
        sectionInput.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                sectionPreview.src = e.target.result;
                sectionPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    // Preview image promo
    const input = document.getElementById('promo_image');
    const preview = document.getElementById('promo_image_preview');

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
});
</script>
@endsection
