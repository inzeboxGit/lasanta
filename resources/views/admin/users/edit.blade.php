@extends('admin.layout')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Modifier un utilisateur</h1>
        <div class="text-muted">Mettre à jour les accès et le mot de passe</div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        Merci de corriger les champs en erreur.
    </div>
@endif

<form action="{{ route('admin.users.update', $user) }}" method="post">
    @csrf
    @method('PUT')
    @include('admin.users.form', ['user' => $user])

    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
