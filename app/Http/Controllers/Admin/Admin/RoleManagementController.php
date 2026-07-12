<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    // ═══════════════════════════════════════════════
    // PAGE IAM PRINCIPALE
    // ═══════════════════════════════════════════════

    public function index(Request $request)
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->orderBy('name')
            ->get();

        $permissions = Permission::withCount('roles')
            ->orderBy('name')
            ->get();

        // Stats
        $stats = [
            'roles'          => $roles->count(),
            'permissions'    => $permissions->count(),
            'admins'         => User::where('account_type', 'admin')->count(),
            'entreprises'    => User::where('account_type', 'entreprise')->count(),
            'etudiants'      => User::where('account_type', 'etudiant')->count(),
            'actifs'         => User::where('status', 'actif')->count(),
        ];

        // Utilisateurs pour la section attribution
        $categorie = $request->get('categorie', 'etudiant');
        $search    = $request->get('search', '');

        $utilisateurs = User::with(['roles', 'permissions'])
            ->when($categorie !== 'tous', fn($q) => $q->where('account_type', $categorie))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(10, ['*'], 'users_page');

        return view('admin.roles.index', compact(
            'roles', 'permissions', 'stats', 'utilisateurs', 'categorie', 'search'
        ));
    }

    // ═══════════════════════════════════════════════
    // RÔLES
    // ═══════════════════════════════════════════════

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
        ]);

        Role::create([
            'name'       => strtolower(trim($validated['name'])),
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Rôle \"{$validated['name']}\" créé avec succès.");
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'permissions' => ['nullable', 'array'],
        ]);

        $role->update(['name' => strtolower(trim($validated['name']))]);

        if (isset($validated['permissions'])) {
            $perms = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($perms);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Rôle mis à jour.");
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'etudiant', 'entreprise'])) {
            return back()->with('error', 'Ce rôle système ne peut pas être supprimé.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un rôle déjà attribué à des utilisateurs.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé.');
    }

    // ═══════════════════════════════════════════════
    // PERMISSIONS
    // ═══════════════════════════════════════════════

    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name'],
        ]);

        Permission::create([
            'name'       => strtolower(trim($validated['name'])),
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Permission \"{$validated['name']}\" créée.");
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name,' . $permission->id],
        ]);

        $permission->update(['name' => strtolower(trim($validated['name']))]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Permission mise à jour.');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Permission supprimée.');
    }

    // ═══════════════════════════════════════════════
    // ATTRIBUTION DES ACCÈS
    // ═══════════════════════════════════════════════

    public function giveAccess(Request $request)
    {
        $request->validate([
            'user_ids'      => ['required', 'array'],
            'user_ids.*'    => ['exists:users,id'],
            'roles'         => ['nullable', 'array'],
            'permissions'   => ['nullable', 'array'],
        ]);

        $users       = User::whereIn('id', $request->user_ids)->get();
        $roles       = Role::whereIn('id', $request->roles ?? [])->get();
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

        foreach ($users as $user) {
            if ($roles->isNotEmpty()) {
                $user->assignRole($roles);
            }
            if ($permissions->isNotEmpty()) {
                $user->givePermissionTo($permissions);
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', count($request->user_ids) . ' utilisateur(s) mis à jour.');
    }

    public function revokeAccess(Request $request)
    {
        $request->validate([
            'user_ids'      => ['required', 'array'],
            'user_ids.*'    => ['exists:users,id'],
            'roles'         => ['nullable', 'array'],
            'permissions'   => ['nullable', 'array'],
        ]);

        $users       = User::whereIn('id', $request->user_ids)->get();
        $roles       = Role::whereIn('id', $request->roles ?? [])->get();
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

        foreach ($users as $user) {
            if ($roles->isNotEmpty()) {
                $user->removeRole($roles->first());
            }
            if ($permissions->isNotEmpty()) {
                $user->revokePermissionTo($permissions);
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Accès retirés avec succès.');
    }
}
