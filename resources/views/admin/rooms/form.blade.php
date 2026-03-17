@php
    $isEdit = isset($room);
@endphp

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
            <label class="form-label">Prix / nuit</label>
            <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', $room->price_per_night ?? '') }}">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $room->description ?? '') }}</textarea>
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
            <input type="file" name="main_image" class="form-control">
            @if(!empty($room->main_image))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $room->main_image) }}" alt="" style="max-height:120px;" class="rounded">
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label">Galerie (plusieurs images)</label>
            <input type="file" name="gallery[]" class="form-control" multiple>
            @if(!empty($room->gallery))
                <div class="mt-2 d-flex flex-wrap gap-2">
                    @foreach($room->gallery as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="" style="max-height:80px;" class="rounded">
                    @endforeach
                </div>
            @endif
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
