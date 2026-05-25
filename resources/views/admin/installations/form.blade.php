@php
    $currentIcon = old('icon', $installation->icon ?? '');
    $iconOptions = [
        'Aeroport' => 'fa-thin fa-truck-plane',
        'Parking' => 'fa-thin fa-circle-parking',
        'Piscine' => 'fa-thin fa-water-ladder',
        'Wifi' => 'fa-thin fa-wifi',
        'Cafe' => 'fa-thin fa-mug-saucer',
        'Salle de sport' => 'fa-thin fa-dumbbell',
        'Chambre' => 'fa-thin fa-bed-front',
    ];
    $iconInList = in_array($currentIcon, array_values($iconOptions), true);
@endphp

<div class="admin-card p-4">
    <input type="hidden" name="scope" value="{{ old('scope', $installation->scope ?? 'home') }}">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $installation->title ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Classe d’icône</label>
            <div class="d-flex align-items-center gap-2">
                <select name="icon" id="installation_icon_select" class="form-select" style="max-width: 340px;">
                    <option value="">Aucune icône</option>
                    @if($currentIcon && !$iconInList)
                        <option value="{{ $currentIcon }}" selected>{{ $currentIcon }} (actuelle)</option>
                    @endif
                    @foreach($iconOptions as $iconLabel => $iconClass)
                        <option value="{{ $iconClass }}" {{ $currentIcon === $iconClass ? 'selected' : '' }}>
                            {{ $iconLabel }}
                        </option>
                    @endforeach
                </select>
                <div id="installation_icon_preview_wrap" style="{{ empty($currentIcon) ? 'display:none;' : '' }}">
                    <span class="d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:8px;background:#f1f3f5;">
                        <i id="installation_icon_preview" class="{{ $currentIcon }}"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $installation->description ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="installation_image" class="form-control" accept="image/*">
            <div class="mt-2">
                <img
                    id="installation_image_preview"
                    src="{{ !empty($installation->image_path) ? media_url($installation->image_path) : '' }}"
                    alt=""
                    style="max-height:120px;{{ empty($installation->image_path) ? 'display:none;' : '' }}"
                    class="rounded"
                >
            </div>
            @if(!empty($installation->image_path ?? null))
                @include('admin.partials.remove-media-toggle', ['name' => 'remove_image', 'label' => 'Supprimer l’image'])
            @endif
        </div>
        <div class="col-md-3">
            <label class="form-label">Ordre</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $installation->sort_order ?? 0) }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published" {{ old('is_published', $installation->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">
                    Publier sur la page d'accueil
                </label>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <label class="form-label">Portée</label>
            <select name="scope" class="form-select">
                <option value="home" {{ old('scope', $installation->scope ?? 'home') === 'home' ? 'selected' : '' }}>Installations seulement</option>
                <option value="both" {{ old('scope', $installation->scope ?? 'home') === 'both' ? 'selected' : '' }}>Installations + chambres</option>
            </select>
        </div> -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('installation_image');
    const preview = document.getElementById('installation_image_preview');
    const iconSelect = document.getElementById('installation_icon_select');
    const iconPreviewWrap = document.getElementById('installation_icon_preview_wrap');
    const iconPreview = document.getElementById('installation_icon_preview');

    if (iconSelect && iconPreviewWrap && iconPreview) {
        iconSelect.addEventListener('change', function () {
            const iconClass = iconSelect.value.trim();
            iconPreview.className = iconClass;
            iconPreviewWrap.style.display = iconClass ? 'block' : 'none';
        });
    }

    if (!input || !preview) return;

    input.addEventListener('change', function (event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});
</script>
