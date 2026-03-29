@extends('admin.layout')

@section('title', 'À propos')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Section À propos</h1>
            <div class="text-muted">Gérer le contenu affiché sur l'accueil et la page À propos</div>
        </div>
        <a href="{{ url('/') }}#first_section" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la
            page</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <style>
        .rich-editor {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            background: #fff;
        }

        .rich-editor__toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .rich-editor__toolbar button {
            border: 1px solid #d0d7de;
            background: #fff;
            border-radius: 0.375rem;
            padding: 0.35rem 0.65rem;
            font-size: 0.875rem;
            line-height: 1;
        }

        .rich-editor__content {
            min-height: 220px;
            padding: 1rem;
            outline: none;
        }

        .rich-editor__content:empty:before {
            content: attr(data-placeholder);
            color: #6c757d;
        }
    </style>

    <div class="admin-card p-4">
        <form action="{{ route('admin.about.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @php
                $mainSrc = null;
                if (!empty($aboutSetting->main_image ?? null)) {
                    $mainSrc = str_starts_with($aboutSetting->main_image, 'img/')
                        ? asset($aboutSetting->main_image)
                        : asset('storage/' . $aboutSetting->main_image);
                }

                $overlaySrc = null;
                if (!empty($aboutSetting->overlay_image ?? null)) {
                    $overlaySrc = str_starts_with($aboutSetting->overlay_image, 'img/')
                        ? asset($aboutSetting->overlay_image)
                        : asset('storage/' . $aboutSetting->overlay_image);
                }
            @endphp

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Petit titre</label>
                    <input type="text" name="small_title" class="form-control"
                        value="{{ old('small_title', $aboutSetting->small_title ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $aboutSetting->title ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lead</label>
                    <input type="text" name="lead" class="form-control"
                        value="{{ old('lead', $aboutSetting->lead ?? '') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Description</label>
                    @php
                        $aboutDescription = old('description', $aboutSetting->description ?? '');
                    @endphp
                    <div class="rich-editor">
                        <div class="rich-editor__toolbar">
                            <button type="button" data-editor-command="bold"><strong>G</strong></button>
                            <button type="button" data-editor-command="italic"><em>I</em></button>
                            <button type="button" data-editor-command="underline"><u>S</u></button>
                            <button type="button" data-editor-command="insertUnorderedList">Liste</button>
                            <button type="button" data-editor-command="formatBlock"
                                data-editor-value="p">Paragraphe</button>
                            <button type="button" data-editor-command="formatBlock" data-editor-value="h3">Titre</button>
                            <button type="button" data-editor-command="justifyLeft">Gauche</button>
                            <button type="button" data-editor-command="justifyCenter">Centre</button>
                            <button type="button" data-editor-command="justifyRight">Droite</button>
                            <button type="button" data-editor-command="justifyFull">Justifier</button>
                            <button type="button" data-editor-link="true">Lien</button>
                        </div>
                        <div class="rich-editor__content" id="about_description_editor" contenteditable="true"
                            data-placeholder="Saisissez la description...">{!! $aboutDescription !!}</div>
                    </div>
                    <textarea name="description" id="about_description" class="form-control d-none"
                        rows="5">{{ $aboutDescription }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Signature</label>
                    <input type="text" name="signature" class="form-control"
                        value="{{ old('signature', $aboutSetting->signature ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image principale</label>
                    <input type="file" name="main_image" id="about_main_image" class="form-control" accept="image/*">
                    <div class="form-text">L'image sera recadrée automatiquement en 600x750 exact.</div>
                    <div class="mt-2">
                        <img id="about_main_preview" src="{{ $mainSrc ?? '' }}" alt="" class="rounded"
                            style="max-height:100px;{{ empty($mainSrc) ? 'display:none;' : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image superposée</label>
                    <input type="file" name="overlay_image" id="about_overlay_image" class="form-control" accept="image/*">
                    <div class="form-text">Même règle : recadrage automatique en 600x750 exact.</div>
                    <div class="mt-2">
                        <img id="about_overlay_preview" src="{{ $overlaySrc ?? '' }}" alt="" class="rounded"
                            style="max-height:100px;{{ empty($overlaySrc) ? 'display:none;' : '' }}">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bindPreview = (inputId, previewId) => {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                if (!input || !preview) return;

                input.addEventListener('change', function (event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                });
            };

            bindPreview('about_main_image', 'about_main_preview');
            bindPreview('about_overlay_image', 'about_overlay_preview');

            const editor = document.getElementById('about_description_editor');
            const textarea = document.getElementById('about_description');
            const toolbarButtons = document.querySelectorAll('[data-editor-command], [data-editor-link]');

            if (!editor || !textarea) return;

            const syncEditor = () => {
                textarea.value = editor.innerHTML.trim();
            };

            toolbarButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    const command = this.dataset.editorCommand;
                    const value = this.dataset.editorValue;

                    editor.focus();

                    if (this.dataset.editorLink) {
                        const url = window.prompt('URL du lien');
                        if (!url) return;
                        document.execCommand('createLink', false, url);
                        syncEditor();
                        return;
                    }

                    document.execCommand(command, false, value || null);
                    syncEditor();
                });
            });

            editor.addEventListener('input', syncEditor);
            editor.closest('form')?.addEventListener('submit', syncEditor);
        });
    </script>
@endsection
