<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalPage;

class LegalPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LegalPage::updateOrCreate(
            [
                'slug' => 'cgu'
            ],
            [
                'title' => 'Conditions Générales d’Utilisation',
                'content' => '
                    <h2>Conditions Générales d’Utilisation de Cmlink</h2>

                    <p>
                        Bienvenue sur Cmlink, une plateforme numérique facilitant
                        la mise en relation entre étudiants, entreprises et
                        établissements d’enseignement supérieur.
                    </p>

                    <h3>1. Objet</h3>

                    <p>
                        Les présentes Conditions Générales d’Utilisation définissent
                        les règles d’accès et d’utilisation des services proposés
                        par Cmlink.
                    </p>

                    <h3>2. Utilisateurs</h3>

                    <p>
                        Cmlink est destiné aux étudiants, entreprises,
                        écoles et universités souhaitant collaborer autour
                        de l’insertion professionnelle.
                    </p>

                    <h3>3. Visibilité des CV</h3>

                    <p>
                        Les étudiants restent propriétaires de leurs informations.
                        Un CV déposé sur Cmlink est privé par défaut.
                        Il devient visible aux entreprises uniquement après
                        activation volontaire de l’option de publication.
                    </p>

                    <h3>4. Comptes entreprises</h3>

                    <p>
                        Chaque entreprise bénéficie de deux publications
                        gratuites d’offres. Au-delà, une formule d’abonnement
                        sera nécessaire.
                    </p>

                    <h3>5. Responsabilités</h3>

                    <p>
                        Chaque utilisateur est responsable des informations
                        publiées sur la plateforme.
                    </p>
                ',
                'status' => true,
            ]
        );


        LegalPage::updateOrCreate(
            [
                'slug' => 'pdc'
            ],
            [
                'title' => 'Politique de Confidentialité',
                'content' => '
                    <h2>Politique de Confidentialité Cmlink</h2>

                    <p>
                        Cmlink accorde une importance particulière à la protection
                        des données personnelles de ses utilisateurs.
                    </p>

                    <h3>Données collectées</h3>

                    <p>
                        Nous pouvons collecter les informations nécessaires
                        à la création des comptes étudiants, entreprises et
                        établissements.
                    </p>

                    <h3>Utilisation des données</h3>

                    <p>
                        Les données sont utilisées afin de fournir les services
                        de mise en relation professionnelle.
                    </p>

                    <h3>Droits des utilisateurs</h3>

                    <p>
                        Chaque utilisateur dispose de droits concernant
                        ses données personnelles conformément aux lois applicables.
                    </p>
                ',
                'status' => true,
            ]
        );


        LegalPage::updateOrCreate(
            [
                'slug' => 'support'
            ],
            [
                'title' => 'Support Cmlink',
                'content' => '
                    <h2>Centre de Support Cmlink</h2>

                    <p>
                        Notre équipe est disponible pour accompagner les
                        étudiants, entreprises et établissements dans
                        l’utilisation de la plateforme.
                    </p>

                    <h3>Besoin d’aide ?</h3>

                    <p>
                        Contactez-nous pour toute question technique,
                        demande d’assistance ou suggestion d’amélioration.
                    </p>
                ',
                'status' => true,
            ]
        );
    }
}
