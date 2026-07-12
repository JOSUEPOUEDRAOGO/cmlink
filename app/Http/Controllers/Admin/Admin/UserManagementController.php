<?php

namespace App\Http\Controllers\Admin\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementController extends Controller
{
    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        $users = User::with([
            'roles',
            'permissions',
            'etudiant',
            'entreprise'
        ])
        ->latest()
        ->paginate(15);


        return view('admin.users.index', compact('users'));
    }



    /**
     * Formulaire création utilisateur
     */
    public function create()
    {
        $roles = Role::orderBy('name')
            ->get();


        $permissions = Permission::orderBy('name')
            ->get();


        return view('admin.users.create', compact(
            'roles',
            'permissions'
        ));
    }



    /**
     * Enregistrer un utilisateur
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],


            'password' => [
                'required',
                'min:8',
                'confirmed'
            ],


            'account_type' => [
                'required',
                Rule::in([
                    'admin',
                    'etudiant',
                    'entreprise'
                ])
            ],


            'status' => [
                'required',
                Rule::in([
                    'actif',
                    'en_attente',
                    'refuse',
                    'suspendu'
                ])
            ],


            'roles' => [
                'nullable',
                'array'
            ],


            'roles.*' => [
                'exists:roles,id'
            ],


            'permissions' => [
                'nullable',
                'array'
            ],


            'permissions.*' => [
                'exists:permissions,id'
            ],

        ]);



        /*
        |--------------------------------------------------------------------------
        | Création utilisateur
        |--------------------------------------------------------------------------
        */


        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'account_type' =>
                $validated['account_type'],

            'status' =>
                $validated['status'],

            'email_verified_at' => now(),

        ]);




        /*
        |--------------------------------------------------------------------------
        | Attribution rôles Spatie
        |--------------------------------------------------------------------------
        */


        if ($request->filled('roles')) {

            $roles = Role::whereIn(
                'id',
                $request->roles
            )->get();


            $user->syncRoles($roles);

        }




        /*
        |--------------------------------------------------------------------------
        | Attribution permissions directes
        |--------------------------------------------------------------------------
        */


        if ($request->filled('permissions')) {

            $permissions = Permission::whereIn(
                'id',
                $request->permissions
            )->get();


            $user->syncPermissions($permissions);

        }



        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Utilisateur créé avec succès.'
            );

    }





    /**
     * Afficher détail utilisateur
     */
    public function show(User $user)
    {

        $user->load([
            'roles',
            'permissions',
            'etudiant',
            'entreprise'
        ]);


        return view(
            'admin.users.show',
            compact('user')
        );

    }





    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {

        $user->delete();


        return back()->with(
            'success',
            'Utilisateur supprimé.'
        );

    }





    /**
     * Suppression multiple
     */
    public function bulkDelete(Request $request)
    {

        $request->validate([

            'users'=>[
                'required',
                'array'
            ],

            'users.*'=>[
                'exists:users,id'
            ]

        ]);



        User::whereIn(
            'id',
            $request->users
        )->delete();



        return back()->with(
            'success',
            'Utilisateurs supprimés avec succès.'
        );

    }





    /**
     * Changement statut multiple
     */
    public function bulkStatus(Request $request)
    {

        $request->validate([

            'users'=>[
                'required',
                'array'
            ],


            'status'=>[
                'required',
                Rule::in([
                    'actif',
                    'en_attente',
                    'refuse',
                    'suspendu'
                ])
            ]

        ]);



        User::whereIn(
            'id',
            $request->users
        )
        ->update([
            'status'=>$request->status
        ]);



        return back()->with(
            'success',
            'Statut mis à jour.'
        );

    }





    /**
     * Mise à jour statut individuel
     */
    public function updateStatus(
        Request $request,
        User $user
    )
    {

        $request->validate([

            'status'=>[
                'required',
                Rule::in([
                    'actif',
                    'en_attente',
                    'refuse',
                    'suspendu'
                ])
            ]

        ]);



        $user->update([

            'status'=>$request->status

        ]);



        return back()->with(
            'success',
            'Statut utilisateur modifié.'
        );

    }




    /**
     * Modifier rôle utilisateur
     */
    public function updateRole(
        Request $request,
        User $user
    )
    {

        $request->validate([

            'roles'=>[
                'nullable',
                'array'
            ]

        ]);



        $user->syncRoles(
            $request->roles ?? []
        );



        return back()->with(
            'success',
            'Rôles mis à jour.'
        );

    }

}
