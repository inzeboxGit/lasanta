@extends('admin.layout')

@section('title', 'Modifier une chambre')

@section('content')
<h1 class="h3 mb-4">Modifier une chambre</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.rooms.update', $room) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.rooms.form')
    <div class="mt-3">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
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
            const item = this.closest('.gallery-item');
            const path = item.dataset.path;
            const roomId = '{{ $room->id }}';

            if (confirm('Supprimer cette photo définitivement ?')) {
                fetch(`/admin/rooms/${roomId}/gallery/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ path: path })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        item.remove();
                    } else {
                        alert(data.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur réseau.');
                });
            }
        });
    });
});
</script>
@endpush
