@extends('admin.layout')

@section('title', 'Conditions & Confidentialité')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Conditions & Confidentialité</h1>
            <div class="text-muted">Modifier les contenus FR et gérer ensuite les traductions depuis l’écran Traductions.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('termsOfUse.index') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir Conditions</a>
            <a href="{{ route('privacy.index') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir Confidentialité</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="admin-card p-4">
        <form action="{{ route('admin.legal.update') }}" method="post">
            @csrf

            <div class="row g-4">
                <div class="col-12">
                    <h2 class="h5 mb-0">Header Confidentialité</h2>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="privacy_header_subtitle" class="form-control" value="{{ old('privacy_header_subtitle', $privacyPage->header_subtitle ?? '') }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Titre</label>
                    <input type="text" name="privacy_header_title" class="form-control" value="{{ old('privacy_header_title', $privacyPage->header_title ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Couleur fond</label>
                    <input type="color" name="privacy_header_background_color" class="form-control form-control-color w-100" value="{{ old('privacy_header_background_color', $privacyPage->header_background_color ?? '#000000') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Confidentialité</label>
                    <textarea name="privacy_body" class="form-control js-tinymce" rows="20">{{ old('privacy_body', $privacyPage->body ?? '') }}</textarea>
                    <div class="form-text">Contenu FR principal de la page confidentialité.</div>
                </div>
                <div class="col-12">
                    <hr class="my-0">
                </div>
                <div class="col-12">
                    <h2 class="h5 mb-0">Header Conditions</h2>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="terms_header_subtitle" class="form-control" value="{{ old('terms_header_subtitle', $termsPage->header_subtitle ?? '') }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Titre</label>
                    <input type="text" name="terms_header_title" class="form-control" value="{{ old('terms_header_title', $termsPage->header_title ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Couleur fond</label>
                    <input type="color" name="terms_header_background_color" class="form-control form-control-color w-100" value="{{ old('terms_header_background_color', $termsPage->header_background_color ?? '#000000') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Conditions</label>
                    <textarea name="terms_body" class="form-control js-tinymce" rows="20">{{ old('terms_body', $termsPage->body ?? '') }}</textarea>
                    <div class="form-text">Contenu FR principal de la page conditions.</div>
                </div>
                <div class="col-12 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('admin.translations.index', ['type' => 'legal_pages']) }}" class="btn btn-outline-secondary">Ouvrir Traductions</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof tinymce === 'undefined') return;

            tinymce.init({
                selector: '.js-tinymce',
                height: 420,
                menubar: false,
                branding: false,
                plugins: 'lists link table code fullscreen',
                toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | link table | code fullscreen',
                convert_urls: false,
                promotion: false
            });
        });
    </script>
@endpush
