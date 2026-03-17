@extends('admin.layout')

@section('title', 'Maintenance')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Maintenance</h1>
        <div class="text-muted">Activer ou désactiver la page de maintenance globale du site.</div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir le site</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <form action="{{ route('admin.maintenance.update') }}" method="post">
        @csrf
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="maintenance-card">
                    <span class="dashboard-eyebrow">Statut du site</span>
                    <h2 class="h4 mt-2 mb-2">{{ ($siteSetting->maintenance_enabled ?? false) ? 'Maintenance active' : 'Site en ligne' }}</h2>
                    <p class="text-muted mb-0">Quand la maintenance est active, les visiteurs voient une page de maintenance. Un admin connecté garde l’accès complet au front et au back-office.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="admin-card p-4 h-100">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="maintenance_enabled" name="maintenance_enabled" value="1" {{ old('maintenance_enabled', $siteSetting->maintenance_enabled ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="maintenance_enabled">Activer la maintenance</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
