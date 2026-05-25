@php
    $toggleName = $name ?? 'remove_media';
    $toggleId = $id ?? ('toggle_' . preg_replace('/[^a-z0-9_]+/i', '_', $toggleName));
    $toggleLabel = $label ?? 'Supprimer le fichier actuel';
@endphp

<div class="mt-2">
    <input
        type="checkbox"
        class="btn-check"
        name="{{ $toggleName }}"
        id="{{ $toggleId }}"
        value="1"
        autocomplete="off"
        {{ old($toggleName) ? 'checked' : '' }}
    >
    <label class="btn btn-sm btn-outline-danger" for="{{ $toggleId }}">{{ $toggleLabel }}</label>
</div>
