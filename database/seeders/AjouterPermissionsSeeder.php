<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AjouterPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Vider le cache Spatie avant tout
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Compétences
            'manage competences',

            // Entretiens
            'manage entretiens',

            // Favoris
            'manage favoris',

            // Profils publics
            'view profils publics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Donner toutes les nouvelles permissions à l'admin
        $admin = Role::findByName('admin');
        $admin->givePermissionTo($permissions);

        // Donner uniquement les permissions pertinentes à l'entreprise
        $entreprise = Role::findByName('entreprise');
        $entreprise->givePermissionTo([
            'manage offres',
            'manage candidatures',
            'manage entretiens',
            'view profils publics',
        ]);

        // Permissions étudiant (nouveau rôle si pas encore créé)
        $etudiant = Role::firstOrCreate(['name' => 'etudiant', 'guard_name' => 'web']);
        $etudiant->givePermissionTo([
            'manage favoris',
        ]);
    }
}