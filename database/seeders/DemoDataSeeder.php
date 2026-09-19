<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Academique\Etudiant;
use App\Models\Academique\Filiere;
use App\Models\Entreprise\Entreprise;

use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Création des rôles s'ils n'existent pas
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $etudiantRole = Role::firstOrCreate(['name' => 'etudiant']);
        $entrepriseRole = Role::firstOrCreate(['name' => 'entreprise']);


        /*
        |--------------------------------------------------------------------------
        | FILIERES
        |--------------------------------------------------------------------------
        */

        $filieres = [

            'Développement Web',
            'Génie Logiciel',
            'Réseaux et Télécommunications',
            'Cybersécurité',
            'Intelligence Artificielle',
            'Data Science',
            'Marketing Digital',
            'Finance et Comptabilité',
            'Gestion des Ressources Humaines',
            'Management des Organisations',

        ];

        $idsFilieres = [];

        foreach ($filieres as $nom) {

            $filiere = Filiere::updateOrCreate(
                ['nom' => $nom],
                ['nom' => $nom]
            );

            $idsFilieres[] = $filiere->id;
        }


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRATEURS
        |--------------------------------------------------------------------------
        */

        $administrateurs = [

            [
                'name' => 'Ouedraogo Josue Pawendtaore',

                'email' => 'josueservicedigital@gmail.com',

                'password' => 'Josueservicedigital@gmail.com',

                'bio' => 'Administrateur principal de la plateforme Cmlink.',
            ],

            [
                'name' => 'Ouedraogo Moussa David',

                'email' => 'ouedraogomoussadavid@gmail.com',

                'password' => '57mou27ssa22@',

                'bio' => 'Administrateur de la plateforme Cmlink.',
            ],

            [
                'name' => 'Wendkbr',

                'email' => 'wendkbr617@gmail.com',

                'password' => 'Wendk0617!',

                'bio' => 'Administrateur de la plateforme Cmlink.',
            ],

            [
                'name' => 'Windingou Daisaac Kabore',

                'email' => 'windingoudaisaackabore@gmail.com',

                'password' => 'Le76739159@',

                'bio' => 'Administrateur de la plateforme Cmlink.',
            ],

        ];

        foreach ($administrateurs as $data) {

            $admin = User::updateOrCreate(

                [
                    'email' => $data['email'],
                ],

                [
                    'name' => $data['name'],

                    'password' => Hash::make(
                        $data['password']
                    ),

                    'account_type' => 'admin',

                    'status' => 'actif',

                    'email_verified_at' => now(),

                    'bio' => $data['bio'],
                ]

            );

            $admin->syncRoles([$adminRole]);
        }


        /*
        |--------------------------------------------------------------------------
        | ETUDIANTS
        |--------------------------------------------------------------------------
        */

        $etudiants = [

            [

                'nom' => 'KABORE',
                'prenom' => 'Adolphe',

                'email' => 'adolphek203@gmail.com',

                'telephone' => '0612745207',

                'ville' => 'Rabat',

                'niveau' => 'bac+3',

                'filiere' => $idsFilieres[0],

            ],

            [

                'nom' => 'OUEDRAOGO',
                'prenom' => 'Josue',

                'email' => 'josueofpptproject@gmail.com',

                'telephone' => '0772376608',

                'ville' => 'Rabat',

                'niveau' => 'bac+5',

                'filiere' => $idsFilieres[1],

            ],

            [

                'nom' => 'SANFO',
                'prenom' => 'Sakinatou',

                'email' => 'sakinatousanfo6@gmail.com',

                'telephone' => '0612778926',

                'ville' => 'Rabat',

                'niveau' => 'bac+2',

                'filiere' => $idsFilieres[2],

            ],

            [

                'nom' => 'OUEDRAOGO',
                'prenom' => 'Moussa',

                'email' => 'odgbiigamoussa@gmail.com',

                'telephone' => '0600000000',

                'ville' => 'Rabat',

                'niveau' => 'bac+3',

                'filiere' => $idsFilieres[3],

            ],

        ];

        foreach ($etudiants as $data) {

            $password = ucfirst($data['email']);

            $user = User::updateOrCreate(

                [
                    'email' => $data['email']
                ],

                [
                    'name' => $data['prenom'] . ' ' . $data['nom'],

                    'password' => Hash::make($password),

                    'account_type' => 'etudiant',

                    'status' => 'actif',

                    'email_verified_at' => now(),

                    'bio' => 'Etudiant inscrit sur la plateforme Cmlink.',
                ]

            );

            $user->syncRoles([$etudiantRole]);


            Etudiant::updateOrCreate(

                [
                    'email' => $data['email']
                ],

                [

                    'user_id' => $user->id,

                    'nom' => $data['nom'],

                    'prenom' => $data['prenom'],

                    'email' => $data['email'],

                    'telephone' => $data['telephone'],

                    'date_naissance' => '2001-01-01',

                    'ville' => $data['ville'],

                    'disponible_le' => now()->addDays(rand(1, 20)),

                    'niveau_etudes' => $data['niveau'],

                    'filiere_id' => $data['filiere'],

                    'cv_public' => true,

                    'lettre_public' => true,

                    'photo_publique' => true,

                ]

            );
        }


        /*
        |--------------------------------------------------------------------------
        | ENTREPRISES
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        | ouedraogomoussadavid@gmail.com a été retiré d'ici car cette
        | adresse est maintenant utilisée pour un administrateur.
        |
        |--------------------------------------------------------------------------
        */

        $entreprises = [

            [

                'nom' => 'Digitalima',

                'email' => 'digitalima@gmail.com',

                'telephone' => '0772376608',

                'adresse' => '03 Rue Don Bosco, Rabat',

                'secteur' => 'Développement Web',

                'taille' => '11-50',

                'site_web' => 'https://digitalima.ma',

                'description' => 'Entreprise spécialisée dans la transformation digitale des organisations.'

            ],

            [

                'nom' => 'ProtecVIRA',

                'email' => 'kaborewindingoudaisaac@gmail.com',

                'telephone' => '0612838974',

                'adresse' => 'Casablanca',

                'secteur' => 'Cybersécurité',

                'taille' => '51-200',

                'site_web' => 'https://protecvira.com',

                'description' => 'Entreprise spécialisée en cybersécurité et protection des infrastructures numériques.'

            ],

        ];

        foreach ($entreprises as $data) {

            $password = ucfirst($data['email']);

            $user = User::updateOrCreate(

                [
                    'email' => $data['email']
                ],

                [

                    'name' => $data['nom'],

                    'password' => Hash::make($password),

                    'account_type' => 'entreprise',

                    'status' => 'actif',

                    'email_verified_at' => now(),

                    'bio' => 'Entreprise partenaire de la plateforme Cmlink.',

                ]

            );

            $user->syncRoles([$entrepriseRole]);


            Entreprise::updateOrCreate(

                [
                    'email' => $data['email']
                ],

                [

                    'user_id'     => $user->id,

                    'nom'         => $data['nom'],

                    'email'       => $data['email'],

                    'telephone'   => $data['telephone'],

                    'adresse'     => $data['adresse'],

                    'secteur'     => $data['secteur'],

                    'taille'      => $data['taille'],

                    'site_web'    => $data['site_web'],

                    'description' => $data['description'],

                ]

            );
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE DE FIN
        |--------------------------------------------------------------------------
        */

        $this->command->info('');

        $this->command->info('========================================');

        $this->command->info(
            '     CMLINK - DONNÉES DE DÉMONSTRATION'
        );

        $this->command->info('========================================');

        $this->command->info('✔ 10 filières créées');

        $this->command->info('✔ 4 administrateurs créés');

        $this->command->info('✔ 4 étudiants créés');

        $this->command->info('✔ 2 entreprises créées');

        $this->command->info('✔ Rôles Spatie attribués');

        $this->command->info('========================================');
    }
}
