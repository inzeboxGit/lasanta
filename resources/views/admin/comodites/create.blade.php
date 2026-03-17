@extends('admin.layout')

@section('title', 'Ajouter un element restaurant')

@section('content')
<h1 class="h3 mb-4">Ajouter un element restaurant</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.comodites.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('admin.comodites.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Créer</button>
        <a href="{{ route('admin.comodites.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
