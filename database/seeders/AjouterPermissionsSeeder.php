<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AjouterPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | Permissions globales plateforme
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            'view admin dashboard',

            // Administration
            'manage users',
            'manage roles',
            'manage sanctions',

            // Académique
            'manage etudiants',
            'manage entreprises',
            'manage filieres',
            'manage competences',

            // Recrutement
            'manage offres',
            'manage candidatures',
            'manage entretiens',

            // Communication
            'manage messages',

            // Profils
            'view profils publics',

            // Etudiant
            'manage favoris',

            // Administration avancée
            'manage categories',
            'manage pages',
            'manage statistiques',
            'manage parametres',
            'manage signalements',
        ];


        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);

        }



        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */


        $admin = Role::firstOrCreate([
            'name'=>'admin',
            'guard_name'=>'web'
        ]);


        $entreprise = Role::firstOrCreate([
            'name'=>'entreprise',
            'guard_name'=>'web'
        ]);


        $etudiant = Role::firstOrCreate([
            'name'=>'etudiant',
            'guard_name'=>'web'
        ]);



        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(
            Permission::all()
        );



        /*
        |--------------------------------------------------------------------------
        | ENTREPRISE
        |--------------------------------------------------------------------------
        */

        $entreprise->syncPermissions([

            'manage offres',
            'manage candidatures',
            'manage entretiens',
            'manage messages',
            'view profils publics',

        ]);



        /*
        |--------------------------------------------------------------------------
        | ETUDIANT
        |--------------------------------------------------------------------------
        */

        $etudiant->syncPermissions([

            'manage favoris',
            'view profils publics',

        ]);



        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();


        $this->command->info(
            '✅ Rôles et permissions configurés correctement'
        );

    }
}
