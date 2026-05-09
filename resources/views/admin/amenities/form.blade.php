<!-- 'icon-hotel-double_bed_2',
        'icon-hotel-safety_box',
        'icon-hotel-patio',
        'icon-hotel-tv',
        'icon-hotel-disable',
        'icon-hotel-dog',
        'icon-hotel-bottle',
        'icon-hotel-wifi',
        'icon-hotel-hairdryer',
        'icon-hotel-condition',
        'icon-hotel-loundry',
        'customicon-double-bed',
        'customicon-television',
        'customicon-private-parking',
        'customicon-wifi',
        'customicon-cocktail',
        'customicon-swimming-pool', -->
@php
    $isEdit = isset($amenity);
    $currentIcon = old('icon', $amenity->icon ?? '');
    $iconOptions = [
        
        'fa-thin fa-bed-front',
        'fa-thin fa-bath',
        'fa-light fa-baby-carriage',
        'fa-light fa-refrigerator',
        'fa-light fa-dryer',
        'fa-light fa-martini-glass',
        'fa-light fa-water-ladder',
        'fa-light fa-bed',
        'fa-light fa-air-conditioner',
        'fa-light fa-tv',
        'fa-light fa-wifi'
    ];
    $iconInList = in_array($currentIcon, $iconOptions, true);
@endphp

<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $amenity->title ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Classe d’icône</label>
            <div class="d-flex align-items-center gap-2">
                <select name="icon" id="amenity_icon_select" class="form-select" style="max-width: 340px;">
                    <option value="">Aucune icône</option>
                    @if($currentIcon && !$iconInList)
                        <option value="{{ $currentIcon }}" selected>{{ $currentIcon }} (actuelle)</option>
                    @endif
                    @foreach($iconOptions as $iconClass)
                        <option value="{{ $iconClass }}" {{ $currentIcon === $iconClass ? 'selected' : '' }}>
                            {{ $iconClass }}
                        </option>
                    @endforeach
                </select>
                <div id="amenity_icon_preview_wrap" style="{{ empty($currentIcon) ? 'display:none;' : '' }}">
                    <span class="d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:8px;background:#f1f3f5;">
                        <i id="amenity_icon_preview" class="{{ $currentIcon }}"></i>
                    </span>
                </div>
            </div>
            <div class="form-text">Sélectionne une classe d’icône du thème.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Portée</label>
            <select name="scope" class="form-select">
                <option value="room" {{ old('scope', $amenity->scope ?? 'room') === 'room' ? 'selected' : '' }}>Chambres seulement</option>
                <option value="both" {{ old('scope', $amenity->scope ?? 'room') === 'both' ? 'selected' : '' }}>Chambres + Installations</option>
            </select>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('amenity_icon_select');
    const previewWrap = document.getElementById('amenity_icon_preview_wrap');
    const preview = document.getElementById('amenity_icon_preview');

    if (!select || !previewWrap || !preview) return;

    select.addEventListener('change', function () {
        const iconClass = select.value.trim();
        preview.className = iconClass;
        previewWrap.style.display = iconClass ? 'block' : 'none';
    });
});
</script>
