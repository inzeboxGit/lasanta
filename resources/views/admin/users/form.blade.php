@php
    $isEdit = isset($user);
@endphp

<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $isEdit ? 'Nouveau mot de passe' : 'Mot de passe' }}</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $isEdit ? '' : 'required' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
                {{ $isEdit ? 'Laisse vide pour conserver le mot de passe actuel.' : 'Minimum 8 caractères.' }}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Confirmation du mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check mb-2">
                <input
                    class="form-check-input @error('is_active') is-invalid @enderror"
                    type="checkbox"
                    value="1"
                    id="is_active"
                    name="is_active"
                    {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="is_active">Compte actif</label>
                @error('is_active')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
