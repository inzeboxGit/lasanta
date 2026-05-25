<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input type="date" name="published_at" class="form-control" value="{{ old('published_at', optional($testimonial->published_at ?? null)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Ordre</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Commentaire</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Source</label>
            <input type="text" name="source" class="form-control" value="{{ old('source', $testimonial->source ?? '') }}" placeholder="ex: Tripadvisor, Google, Booking...">
            <div class="form-text">Affiché sous le nom du client.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" id="testimonial_photo" class="form-control" accept="image/*">
            @php
                $existingSrc = null;
                if (!empty($testimonial->photo_path ?? null)) {
                    $existingSrc = str_starts_with($testimonial->photo_path, 'img/')
                        ? asset($testimonial->photo_path)
                        : media_url($testimonial->photo_path);
                }
            @endphp
            <div class="mt-2">
                <img id="testimonial_photo_preview" src="{{ $existingSrc ?? '' }}" alt="" style="width:72px;height:72px;object-fit:cover;border-radius:50%;{{ empty($existingSrc) ? 'display:none;' : '' }}">
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published" {{ old('is_published', $testimonial->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publié</label>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('testimonial_photo');
    const preview = document.getElementById('testimonial_photo_preview');

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
