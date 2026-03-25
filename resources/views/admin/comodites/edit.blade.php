@extends('admin.layout')

@section('title', $pageMeta['title'])

@section('content')
<h1 class="h3 mb-4">Modifier {{ $pageMeta['item_label_singular'] }}</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route($pageMeta['routes']['update'], $comodite) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.comodites.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route($pageMeta['routes']['index']) }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
