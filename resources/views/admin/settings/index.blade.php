@extends('admin.layout')

@section('title', 'Paramètres')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Paramètres du site</h1>
        <div class="text-muted">Téléphones, email, adresse, nom du site et réseaux sociaux</div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <form action="{{ route('admin.settings.update') }}" method="post">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nom du site</label>
                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $siteSetting->site_name ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $siteSetting->email ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone 1</label>
                <input type="text" name="phone_primary" class="form-control" value="{{ old('phone_primary', $siteSetting->phone_primary ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone 2</label>
                <input type="text" name="phone_secondary" class="form-control" value="{{ old('phone_secondary', $siteSetting->phone_secondary ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Adresse</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $siteSetting->address ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Facebook</label>
                <input type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $siteSetting->facebook_url ?? '') }}" placeholder="https://facebook.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram_url" class="form-control" value="{{ old('instagram_url', $siteSetting->instagram_url ?? '') }}" placeholder="https://instagram.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label">WhatsApp</label>
                <input type="text" name="whatsapp_url" class="form-control" value="{{ old('whatsapp_url', $siteSetting->whatsapp_url ?? '') }}" placeholder="https://wa.me/...">
            </div>
            <div class="col-md-6">
                <label class="form-label">Twitter / X</label>
                <input type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $siteSetting->twitter_url ?? '') }}" placeholder="https://x.com/...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
</div>
@endsection
