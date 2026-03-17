@extends('admin.layout')

@section('title', 'Traductions')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Traductions du site</h1>
        <div class="text-muted">Gérer FR / EN / DE / NL pour les contenus</div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <form method="get" action="{{ route('admin.translations.index') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Type de contenu</label>
                <select name="type" class="form-select" onchange="this.form.submit()">
                    @foreach($types as $key => $cfg)
                        <option value="{{ $key }}" {{ $selectedType === $key ? 'selected' : '' }}>{{ $cfg['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Élément</label>
                <select name="id" class="form-select" onchange="this.form.submit()">
                    @forelse($records as $item)
                        @php
                            $displayField = $typeConfig['display_field'] ?? 'id';
                            $displayValue = $item->{$displayField} ?? ('#' . $item->id);
                        @endphp
                        <option value="{{ $item->id }}" {{ (string) $selectedId === (string) $item->id ? 'selected' : '' }}>
                            #{{ $item->id }} - {{ $displayValue }}
                        </option>
                    @empty
                        <option value="">Aucun élément</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Langue</label>
                <select name="locale" class="form-select" onchange="this.form.submit()">
                    @foreach($locales as $localeKey => $localeLabel)
                        <option value="{{ $localeKey }}" {{ $selectedLocale === $localeKey ? 'selected' : '' }}>{{ $localeLabel }} ({{ $localeKey }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>

@if($record && $typeConfig)
    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.translations.update') }}">
            @csrf
            <input type="hidden" name="type" value="{{ $selectedType }}">
            <input type="hidden" name="id" value="{{ $record->id }}">
            <input type="hidden" name="locale" value="{{ $selectedLocale }}">

            <div class="row g-3">
                @foreach(($typeConfig['fields'] ?? []) as $field)
                    @php
                        $current = $selectedLocale === 'fr'
                            ? ($record->{$field} ?? '')
                            : ($record->t($field, $selectedLocale) ?? '');
                        $frValue = $record->{$field} ?? '';
                        $isLong = in_array($field, ['description', 'body', 'content', 'excerpt'], true);
                    @endphp
                    <div class="col-12">
                        <label class="form-label text-capitalize">{{ str_replace('_', ' ', $field) }}</label>
                        @if($isLong)
                            <textarea name="fields[{{ $field }}]" class="form-control" rows="5">{{ old('fields.' . $field, $current) }}</textarea>
                        @else
                            <input type="text" name="fields[{{ $field }}]" class="form-control" value="{{ old('fields.' . $field, $current) }}">
                        @endif
                        @if($selectedLocale !== 'fr')
                            <small class="text-muted d-block mt-1">FR source: {{ \Illuminate\Support\Str::limit($frValue, 180) }}</small>
                        @endif
                    </div>
                @endforeach
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Enregistrer traductions</button>
                </div>
            </div>
        </form>
    </div>
@endif
@endsection
