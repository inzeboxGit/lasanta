@php
    $isEdit = isset($room);
@endphp

@push('css')
<style>
    .custom-file-upload {
        position: relative;
    }
    .file-upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        background-color: #f9fafb;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        margin-bottom: 0;
    }
    .file-upload-label:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .file-upload-label i {
        font-size: 1.75rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }
    .file-upload-label span {
        font-weight: 500;
        color: #374151;
        font-size: 0.95rem;
    }
    .file-upload-label small {
        display: block;
        margin-top: 0.25rem;
        color: #6b7280;
        font-size: 0.8rem;
    }
</style>
@endpush

<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $room->title ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $room->slug ?? '') }}" placeholder="auto">
        </div>
        <div class="col-md-8">
            <label class="form-label">Sous-titre</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $room->subtitle ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Superficie</label>
            <input type="text" name="external_id" class="form-control" value="{{ old('external_id', $room->external_id ?? '') }}" placeholder="Ex: APT-102">
        </div>
        <div class="col-md-4">
            <label class="form-label">Prix / nuit</label>
            <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', $room->price_per_night ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Réduction <small class="text-muted">(ex&nbsp;: 25% Off)</small></label>
            <input type="text" name="discount" class="form-control" value="{{ old('discount', $room->discount ?? '') }}" placeholder="Laisser vide pour masquer">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control js-tinymce-room" rows="10">{{ old('description', $room->description ?? '') }}</textarea>
        </div>

        {{-- ===== Politiques / Informations pratiques ===== --}}
        <div class="col-12 mt-2">
            <h6 class="fw-semibold border-bottom pb-2">Politiques &amp; informations pratiques</h6>
        </div>
        <div class="col-md-6">
            <label class="form-label">Check-in <small class="text-muted">(une règle par ligne)</small></label>
            <textarea name="checkin_info" class="form-control" rows="4" placeholder="Check-in from 9:00 AM - anytime&#10;Early check-in subject to availability">{{ old('checkin_info', $room->checkin_info ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Check-out <small class="text-muted">(une règle par ligne)</small></label>
            <textarea name="checkout_info" class="form-control" rows="4" placeholder="Check-out before noon&#10;Express check-out">{{ old('checkout_info', $room->checkout_info ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Instructions spéciales check-in</label>
            <textarea name="special_instructions" class="form-control" rows="4" placeholder="Guests will receive an email 5 days before arrival...">{{ old('special_instructions', $room->special_instructions ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Enfants &amp; lits supplémentaires</label>
            <textarea name="children_policy" class="form-control" rows="4" placeholder="Children are welcome...">{{ old('children_policy', $room->children_policy ?? '') }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Equipements</label>
            <div class="row g-2">
                @forelse($amenities as $amenity)
                    @php
                        $checked = in_array($amenity->id, old('amenities', $selectedAmenities ?? []));
                    @endphp
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" {{ $checked ? 'checked' : '' }}>
                            <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                @if($amenity->icon)
                                    <i class="{{ $amenity->icon }}"></i>
                                @endif
                                {{ $amenity->title }}
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted">Aucun équipement. Crée-en d'abord dans l'admin.</div>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image principale</label>
            <div class="d-flex gap-3 align-items-start">
                <div class="custom-file-upload flex-shrink-0" style="width: 220px;">
                    <label for="main_image" class="file-upload-label">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>{{ !empty($room->main_image ?? null) ? 'Changer l\'image' : 'Choisir une image...' }}</span>
                        <small>PNG, JPG – redimensionné à 1550×1080</small>
                    </label>
                    <input type="file" name="main_image" id="main_image" class="d-none custom-file-input" accept="image/*">
                </div>
                <div id="main-image-preview-wrap" class="flex-grow-1">
                    @if(!empty($room->main_image ?? null))
                        <div id="main-image-saved-wrap">
                            <img id="main-image-saved" src="{{ media_url($room->main_image) }}" alt=""
                                 style="width:100%;max-height:160px;object-fit:cover;" class="rounded shadow-sm">
                            <div class="text-success small mt-1"><i class="bi bi-check-circle-fill"></i> Image actuelle</div>
                        </div>
                    @else
                        <div id="main-image-saved-wrap" class="d-none"></div>
                    @endif
                    <div id="main-image-new-wrap" class="d-none">
                        <img id="main-image-new" src="" alt=""
                             style="width:100%;max-height:160px;object-fit:cover;" class="rounded shadow-sm">
                        <div class="text-primary small mt-1"><i class="bi bi-check2-circle"></i> Nouvelle image sélectionnée – sera redimensionnée à 1550×1080 à l'enregistrement</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Galerie (plusieurs images)</label>

            {{-- Existing gallery: sortable + deletable --}}
            @if(!empty($room->gallery))
                <div id="gallery-sortable" class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($room->gallery as $img)
                        <div class="gallery-item position-relative" data-path="{{ $img }}">
                            <img src="{{ asset('storage/' . $img) }}" alt="" class="rounded shadow-sm" style="height:100px;width:auto;object-fit:cover;cursor:grab;">
                            <input type="hidden" name="gallery_order[]" value="{{ $img }}">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 gallery-remove-btn shadow-sm"
                                    style="width:24px;height:24px;padding:0;line-height:24px;font-size:14px;border-radius:50%;"
                                    title="Supprimer">&times;</button>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Upload new images --}}
            <div class="custom-file-upload">
                <label for="gallery" class="file-upload-label">
                    <i class="bi bi-images"></i>
                    <span>Ajouter des photos à la galerie...</span>
                    <small>Glissez-déposez ou cliquez pour sélectionner plusieurs fichiers</small>
                </label>
                <input type="file" name="gallery[]" id="gallery" class="d-none custom-file-input" multiple>
            </div>
            <small class="text-muted mt-2 d-block">Glissez les images existantes pour réordonner. Cliquez ✕ pour supprimer.</small>
        </div>
        <div class="col-md-4">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select">
                <option value="draft" {{ old('status', $room->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="published" {{ old('status', $room->status ?? 'draft') === 'published' ? 'selected' : '' }}>Publié</option>
            </select>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof tinymce !== 'undefined' && document.querySelector('.js-tinymce-room')) {
        tinymce.init({
            selector: '.js-tinymce-room',
            height: 420,
            menubar: false,
            branding: false,
            plugins: 'lists link table code fullscreen',
            toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | link table | code fullscreen',
            convert_urls: false,
            promotion: false
        });
    }

    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const label = this.parentElement.querySelector('.file-upload-label span');
            const files = e.target.files;
            if (files.length === 1) {
                label.textContent = files[0].name;
            } else if (files.length > 1) {
                label.textContent = files.length + ' fichiers sélectionnés';
            } else {
                label.textContent = this.id === 'gallery' ? 'Ajouter des photos à la galerie...' : 'Choisir une image...';
            }
        });
    });

    // Aperçu image principale
    const mainImageInput = document.getElementById('main_image');
    if (mainImageInput) {
        mainImageInput.addEventListener('change', function () {
            const file = this.files[0];
            const savedWrap = document.getElementById('main-image-saved-wrap');
            const newWrap = document.getElementById('main-image-new-wrap');
            const newImg = document.getElementById('main-image-new');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    newImg.src = e.target.result;
                    if (savedWrap) savedWrap.classList.add('d-none');
                    newWrap.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
