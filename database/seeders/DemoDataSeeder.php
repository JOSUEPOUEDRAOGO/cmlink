<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Academique\Filiere;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Création des rôles Spatie
        |--------------------------------------------------------------------------
        */

        $roles = [
            'admin',
            'etudiant',
            'entreprise',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Création des filières
        |--------------------------------------------------------------------------
        */

        $filieres = [
            'Informatique et Développement Web',
            'Intelligence Artificielle et Data Science',
            'Réseaux et Cybersécurité',
            'Marketing Digital et Communication',
            'Finance et Comptabilité',
            'Gestion des Entreprises',
            'Génie Civil et Construction',
            'Ressources Humaines',
            'Commerce International',
            'Design Graphique et Multimédia',
        ];

        foreach ($filieres as $nom) {
            Filiere::firstOrCreate([
                'nom' => $nom
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            [
                'email' => 'josueservicedigital@gmail.com'
            ],
            [
                'name' => 'ouedraogo josue pawendtaore',
                'password' => Hash::make('Josueservicedigital@gmail.com'),
                'account_type' => 'admin',
                'status' => 'actif',
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');


        /*
        |--------------------------------------------------------------------------
        | ETUDIANTS
        |--------------------------------------------------------------------------
        */

        $etudiants = [

            [
                'name' => 'Adolphek',
                'email' => 'adolphek203@gmail.com',
                'telephone' => '0612745207',
            ],

            [
                'name' => 'Josuep Ouedaogo',
                'email' => 'josueofpptproject@gmail.com',
                'telephone' => '0772376608',
            ],

            [
                'name' => 'Sakinatou SANFO',
                'email' => 'sakinatousanfo6@gmail.com',
                'telephone' => '0612778926',
            ],

            [
                'name' => 'Moussa OUEDRAOGO',
                'email' => 'odgbiigamoussa@gmail.com',
                'telephone' => '0612998877',
            ],
        ];


        $filiereIds = Filiere::pluck('id')->toArray();


        foreach ($etudiants as $data) {

            $user = User::updateOrCreate(
                [
                    'email' => $data['email']
                ],
                [
                    'name' => $data['name'],
                    'password' => Hash::make(ucfirst(explode('@', $data['email'])[0]) . '@gmail.com'),
                    'account_type' => 'etudiant',
                    'status' => 'actif',
                    'email_verified_at' => now(),
                ]
            );


            $user->assignRole('etudiant');


            Etudiant::updateOrCreate(
                [
                    'email' => $data['email']
                ],
                [
                    'user_id' => $user->id,
                    'nom' => strtoupper($data['name']),
                    'prenom' => $data['name'],
                    'telephone' => $data['telephone'],
                    'niveau_etudes' => 'bac+3',
                    'filiere_id' => $filiereIds[array_rand($filiereIds)],
                    'cv_public' => 1,
                    'lettre_public' => 1,
                    'photo_publique' => 1,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ENTREPRISES
        |--------------------------------------------------------------------------
        */

        $entreprises = [

            [
                'nom' => 'Digitalima',
                'email' => 'digitalima@gmail.com',
                'telephone' => '0772376608',
                'adresse' => '03 rue don bosco Rabat',
                'secteur' => 'Transformation digitale',
            ],

            [
                'nom' => 'ProtecVIRA',
                'email' => 'contact@protecVIRA.com',
                'telephone' => '0612887766',
                'adresse' => 'Rabat Maroc',
                'secteur' => 'Cybersécurité et Protection informatique',
            ],

            [
                'nom' => 'NovaTech Solutions',
                'email' => 'ouedraogomoussadavid@gmail.com',
                'telephone' => '0612554433',
                'adresse' => 'Casablanca Maroc',
                'secteur' => 'Technologie et Innovation',
            ],
        ];


        foreach ($entreprises as $data) {


            $user = User::updateOrCreate(
                [
                    'email' => $data['email']
                ],
                [
                    'name' => $data['nom'],
                    'password' => Hash::make(ucfirst(explode('@', $data['email'])[0]) . '@gmail.com'),
                    'account_type' => 'entreprise',
                    'status' => 'actif',
                    'email_verified_at' => now(),
                ]
            );


            $user->assignRole('entreprise');


            Entreprise::updateOrCreate(
                [
                    'email' => $data['email']
                ],
                [
                    'user_id' => $user->id,
                    'nom' => $data['nom'],
                    'telephone' => $data['telephone'],
                    'adresse' => $data['adresse'],
                    'secteur' => $data['secteur'],
                    'taille' => '11-50',
                    'description' => 'Entreprise partenaire de la plateforme Cmlink.',
                ]
            );
        }


        $this->command->info('✅ Données de démonstration créées avec succès !');
    }
}
