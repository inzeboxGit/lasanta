<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderByDesc('id')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, isUpdate: false);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validatedData($request, isUpdate: true, user: $user);

        if ($user->is($request->user()) && isset($data['is_active']) && ! $data['is_active']) {
            throw ValidationException::withMessages([
                'is_active' => 'Tu ne peux pas désactiver ton propre compte.',
            ]);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
    }

    private function validatedData(Request $request, bool $isUpdate, ?User $user = null): array
    {
        $passwordRules = $isUpdate
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => $passwordRules,
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($isUpdate && blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        return $data;
    }
}
