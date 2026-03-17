<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $comodite->title ?? '') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ordre</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $comodite->sort_order ?? 0) }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published" {{ old('is_published', $comodite->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publiée</label>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $comodite->description ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Lien (optionnel)</label>
            <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $comodite->link_url ?? '/restaurant') }}" placeholder="/restaurant">
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="comodite_image" class="form-control" accept="image/*">
            @php
                $existingSrc = media_url($comodite->image_path ?? null);
            @endphp
            <div class="mt-2">
                <img id="comodite_image_preview" src="{{ $existingSrc ?? '' }}" alt="" class="rounded" style="max-height:120px;{{ empty($existingSrc) ? 'display:none;' : '' }}">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('comodite_image');
    const preview = document.getElementById('comodite_image_preview');

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
