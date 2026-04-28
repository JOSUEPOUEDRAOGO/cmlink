<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            // ===== HERO =====
            ['home', 'hero', 'title', 'Trouvez votre prochaine opportunité'],
            ['home', 'hero', 'subtitle', 'Connectez-vous directement avec les meilleures entreprises pour vos stages et premiers emplois.'],
            ['home', 'hero', 'button_primary', 'Commencer maintenant'],
            ['home', 'hero', 'button_secondary', 'En savoir plus →'],

            // ===== FOOTER =====
            ['home', 'footer', 'brand_title', 'Cmlink'],
            ['home', 'footer', 'brand_description', 'La plateforme qui connecte les talents aux meilleures opportunités.'],

            // Étudiants
            ['home', 'footer', 'student_title', 'Pour les étudiants'],
            ['home', 'footer', 'student_link_1_text', 'Parcourir les offres'],
            ['home', 'footer', 'student_link_1_url', '/offres'],
            ['home', 'footer', 'student_link_2_text', 'Mon profil'],
            ['home', 'footer', 'student_link_2_url', '/login'],
            ['home', 'footer', 'student_link_3_text', 'Mes candidatures'],
            ['home', 'footer', 'student_link_3_url', '/login'],
            ['home', 'footer', 'student_link_4_text', 'Conseils carrière'],
            ['home', 'footer', 'student_link_4_url', '#'],

            // Entreprises
            ['home', 'footer', 'company_title', 'Pour les entreprises'],
            ['home', 'footer', 'company_link_1_text', 'Publiez une offre'],
            ['home', 'footer', 'company_link_1_url', '/login'],
            ['home', 'footer', 'company_link_2_text', 'Trouvez des talents'],
            ['home', 'footer', 'company_link_2_url', '/login'],
            ['home', 'footer', 'company_link_3_text', 'Tableau de bord'],
            ['home', 'footer', 'company_link_3_url', '/admin/dashboard'],
            ['home', 'footer', 'company_link_4_text', 'Tarifs'],
            ['home', 'footer', 'company_link_4_url', '#'],

            // Social / légal
            ['home', 'footer', 'social_title', 'Nous suivre'],
            ['home', 'footer', 'social_link_1_text', 'LinkedIn'],
            ['home', 'footer', 'social_link_1_url', '#'],
            ['home', 'footer', 'social_link_2_text', 'Instagram'],
            ['home', 'footer', 'social_link_2_url', '#'],
            ['home', 'footer', 'social_link_3_text', 'Twitter'],
            ['home', 'footer', 'social_link_3_url', '#'],
            ['home', 'footer', 'social_link_4_text', 'Mentions légales'],
            ['home', 'footer', 'social_link_4_url', '#'],
            ['home', 'footer', 'social_link_5_text', 'Politique de confidentialité'],
            ['home', 'footer', 'social_link_5_url', '#'],

            // Copyright
            ['home', 'footer', 'copyright', '© 2025 Cmlink – Tous droits réservés. Simplifiez votre avenir professionnel.'],
        ];

        foreach ($items as [$page, $section, $key, $value]) {
            PageSection::updateOrCreate(
                [
                    'page' => $page,
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
