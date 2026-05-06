<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
        ]);

        Role::create([
            'name' => strtolower(trim($validated['name'])),
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,' . $role->id],
        ]);

        $role->update([
            'name' => strtolower(trim($validated['name'])),
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'etudiant', 'entreprise'])) {
            return back()->with('error', 'Ce rôle système ne peut pas être supprimé.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un rôle déjà attribué.');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }
}