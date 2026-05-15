@extends('admin.layout')

@section('title', 'Ajouter une chambre')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0">Ajouter une chambre</h1>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Retour à la liste des chambres</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.rooms.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('admin.rooms.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Créer</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('gallery-sortable');
    if (container && typeof Sortable !== 'undefined') {
        Sortable.create(container, {
            animation: 200,
            ghostClass: 'opacity-50',
        });
    }
    document.querySelectorAll('.gallery-remove-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            this.closest('.gallery-item').remove();
        });
    });
});
</script>
@endpush
