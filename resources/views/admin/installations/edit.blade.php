@extends('admin.layout')

@section('title', 'Modifier une installation')

@section('content')
<h1 class="h3 mb-4">Modifier une installation</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.installations.update', $installation) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.installations.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.installations.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
