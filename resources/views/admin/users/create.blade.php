@extends('admin.layout')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Créer un utilisateur</h1>
        <div class="text-muted">Ajouter un nouvel accès au back-office</div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        Merci de corriger les champs en erreur.
    </div>
@endif

<form action="{{ route('admin.users.store') }}" method="post">
    @csrf
    @include('admin.users.form')

    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
