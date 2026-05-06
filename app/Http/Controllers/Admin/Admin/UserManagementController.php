<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'etudiant', 'entreprise'])
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['roles', 'etudiant.filiere', 'entreprise']);

        $roles = Role::orderBy('name')->get();

        return view('admin.users.show', compact('user', 'roles'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:actif,en_attente,refuse,suspendu'],
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre statut.');
        }

        $user->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Statut utilisateur mis à jour.');
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->syncRoles([$validated['role']]);

        return back()->with('success', 'Rôle utilisateur mis à jour.');
    }
}