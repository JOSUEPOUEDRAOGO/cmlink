<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [

            /*
            |--------------------------------------------------------------------------
            | HERO
            |--------------------------------------------------------------------------
            */

            'hero' => [

                'badge' => '🔗 Connexion directe entre talents et entreprises',

                'title' => 'Construisez votre avenir professionnel avec Cmlink',

                'subtitle' => 'La plateforme marocaine qui connecte les étudiants, les entreprises et les établissements d’enseignement pour créer de nouvelles opportunités.',

                'button_primary' => 'Créer mon profil',

                'button_secondary' => 'Découvrir les offres',

            ],



            /*
            |--------------------------------------------------------------------------
            | WHY
            |--------------------------------------------------------------------------
            */

            'why' => [

                'title' => 'Pourquoi choisir Cmlink ?',

                'card_1_title' => 'Des opportunités adaptées',

                'card_1_text' => 'Accédez à des stages, emplois et opportunités professionnelles correspondant à votre profil.',


                'card_2_title' => 'Une visibilité auprès des recruteurs',

                'card_2_text' => 'Présentez vos compétences et permettez aux entreprises de découvrir votre potentiel.',


                'card_3_title' => 'Un réseau professionnel puissant',

                'card_3_text' => 'Connectez étudiants, écoles et entreprises dans un même environnement digital.',


                'card_4_title' => 'Une plateforme simple et moderne',

                'card_4_text' => 'Gérez votre carrière ou vos recrutements facilement grâce à une expérience intuitive.',

            ],



            /*
            |--------------------------------------------------------------------------
            | AUDIENCE
            |--------------------------------------------------------------------------
            */

            'audience' => [

                'student_title' => 'Étudiants',

                'student_text' => 'Développez votre carrière en trouvant les meilleures opportunités professionnelles.',

                'student_benefit_1' => 'Créez un profil professionnel',

                'student_benefit_2' => 'Postulez aux offres disponibles',

                'student_benefit_3' => 'Soyez visible auprès des entreprises',

                'student_button' => 'Rejoindre Cmlink',



                'company_title' => 'Entreprises',

                'company_text' => 'Trouvez les talents dont votre entreprise a besoin et simplifiez vos recrutements.',

                'company_benefit_1' => 'Publiez vos offres',

                'company_benefit_2' => 'Découvrez les CV publics',

                'company_benefit_3' => 'Recrutez plus rapidement',

                'company_button' => 'Créer un compte entreprise',

            ],



            /*
            |--------------------------------------------------------------------------
            | HOW
            |--------------------------------------------------------------------------
            */

            'how' => [

                'title' => 'Comment ça marche ?',

                'step_1_title' => 'Créer votre compte',

                'step_1_text' => 'Inscrivez-vous gratuitement et complétez votre profil.',


                'step_2_title' => 'Présenter votre profil',

                'step_2_text' => 'Ajoutez votre CV, vos compétences et vos expériences.',


                'step_3_title' => 'Trouver des opportunités',

                'step_3_text' => 'Consultez les offres et découvrez les entreprises.',


                'step_4_title' => 'Créer des connexions',

                'step_4_text' => 'Échangez avec les acteurs professionnels et développez votre avenir.',

            ],



            /*
            |--------------------------------------------------------------------------
            | CTA
            |--------------------------------------------------------------------------
            */

            'cta' => [

                'title' => 'Prêt à rejoindre Cmlink ?',

                'text' => 'Construisez votre avenir professionnel avec une plateforme pensée pour le Maroc.',

                'button_primary' => 'Créer un compte',

                'button_secondary' => 'Explorer les offres',

                'note' => 'Inscription gratuite pour étudiants et premières offres gratuites pour entreprises.',

            ],



            /*
            |--------------------------------------------------------------------------
            | FOOTER
            |--------------------------------------------------------------------------
            */

            'footer' => [

                'brand_title' => 'Cmlink',

                'brand_description' => 'Cmlink connecte les étudiants, entreprises et établissements d’enseignement pour faciliter l’accès aux opportunités professionnelles.',


                'student_title' => 'Pour les étudiants',

                'student_link_1_text' => 'Voir les offres',

                'student_link_1_url' => '/offres',

                'student_link_2_text' => 'Créer mon profil',

                'student_link_2_url' => '/register',

                'student_link_3_text' => 'Mes candidatures',

                'student_link_3_url' => '/mes-candidatures',



                'company_title' => 'Pour les entreprises',

                'company_link_1_text' => 'Publier une offre',

                'company_link_1_url' => '/dashboard',

                'company_link_2_text' => 'Découvrir les profils',

                'company_link_2_url' => '/etudiants',

                'company_link_3_text' => 'Créer un compte entreprise',

                'company_link_3_url' => '/register',



                'social_title' => 'Nous suivre',

                'social_link_1_text' => 'LinkedIn',

                'social_link_1_url' => '#',

                'social_link_2_text' => 'Facebook',

                'social_link_2_url' => '#',

                'social_link_3_text' => 'Instagram',

                'social_link_3_url' => '#',


                'copyright' => '© 2026 Cmlink – Tous droits réservés.',

            ],

        ];


        foreach ($sections as $section => $values) {

            foreach ($values as $key => $value) {

                PageSection::updateOrCreate(

                    [
                        'page' => 'home',
                        'section' => $section,
                        'key' => $key,
                    ],

                    [
                        'value' => $value,
                        'is_active' => true,
                    ]

                );

            }

        }
    }
}
