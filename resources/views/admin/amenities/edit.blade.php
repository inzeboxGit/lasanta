@extends('admin.layout')

@section('title', 'Modifier un équipement')

@section('content')
<h1 class="h3 mb-4">Modifier un équipement</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.amenities.update', $amenity) }}" method="post">
    @csrf
    @method('PUT')
    @include('admin.amenities.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.amenities.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
