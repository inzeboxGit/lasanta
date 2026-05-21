@extends('admin.layout')

@section('title', 'Modifier une actualité')

@section('content')
<h1 class="h3 mb-4">Modifier une actualité</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.news.update', $item) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.news.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>

@if(!empty($item->hero_image))
    <form id="remove-news-hero-image-form" action="{{ route('admin.news.remove-image', $item) }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="field" value="hero_image">
    </form>
@endif

@if(!empty($item->cover_image))
    <form id="remove-news-cover-image-form" action="{{ route('admin.news.remove-image', $item) }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="field" value="cover_image">
    </form>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-remove-news-image').forEach(function (button) {
            button.addEventListener('click', function () {
                const formId = this.dataset.formId;
                const form = document.getElementById(formId);

                if (!form) return;
                if (!window.confirm('Supprimer cette image ?')) return;

                form.submit();
            });
        });
    });
</script>
@endsection
