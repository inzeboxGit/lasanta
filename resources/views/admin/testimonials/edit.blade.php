@extends('admin.layout')

@section('title', 'Modifier un témoignage')

@section('content')
<h1 class="h3 mb-4">Modifier un témoignage</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.testimonials.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection
