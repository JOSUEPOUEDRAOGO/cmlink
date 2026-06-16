<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametresSeeder extends Seeder
{
    public function run(): void
    {
        $parametres = [

            // ── GÉNÉRAL ──────────────────────────────────────────
            ['groupe' => 'general', 'cle' => 'site_nom',          'valeur' => 'Cmlink',           'type' => 'text',    'label' => 'Nom de la plateforme',      'description' => 'Nom affiché dans le header et les emails.'],
            ['groupe' => 'general', 'cle' => 'site_slogan',       'valeur' => 'Connecter les talents aux opportunités', 'type' => 'text', 'label' => 'Slogan'],
            ['groupe' => 'general', 'cle' => 'site_email',        'valeur' => 'contact@cmlink.com','type' => 'text',    'label' => 'Email de contact'],
            ['groupe' => 'general', 'cle' => 'site_telephone',    'valeur' => '',                  'type' => 'text',    'label' => 'Téléphone'],
            ['groupe' => 'general', 'cle' => 'site_adresse',      'valeur' => '',                  'type' => 'text',    'label' => 'Adresse'],
            ['groupe' => 'general', 'cle' => 'site_logo',         'valeur' => '',                  'type' => 'text',    'label' => 'URL du logo'],
            ['groupe' => 'general', 'cle' => 'site_favicon',      'valeur' => '',                  'type' => 'text',    'label' => 'URL du favicon'],
            ['groupe' => 'general', 'cle' => 'site_couleur',      'valeur' => '#1e4a76',           'type' => 'text',    'label' => 'Couleur principale'],

            // ── INSCRIPTION & ACCÈS ───────────────────────────────
            ['groupe' => 'inscription', 'cle' => 'inscription_ouverte',         'valeur' => '1',  'type' => 'boolean', 'label' => 'Inscriptions ouvertes',           'description' => 'Désactiver pour bloquer toutes les nouvelles inscriptions.'],
            ['groupe' => 'inscription', 'cle' => 'inscription_etudiant',        'valeur' => '1',  'type' => 'boolean', 'label' => 'Inscription étudiants autorisée', 'description' => 'Permet ou bloque les nouvelles inscriptions étudiants.'],
            ['groupe' => 'inscription', 'cle' => 'inscription_entreprise',      'valeur' => '1',  'type' => 'boolean', 'label' => 'Inscription entreprises autorisée'],
            ['groupe' => 'inscription', 'cle' => 'validation_manuelle_compte',  'valeur' => '1',  'type' => 'boolean', 'label' => 'Validation manuelle des comptes',  'description' => 'Si activé, l\'admin doit valider chaque nouveau compte avant qu\'il soit actif.'],
            ['groupe' => 'inscription', 'cle' => 'email_verification',          'valeur' => '0',  'type' => 'boolean', 'label' => 'Vérification email obligatoire'],
            ['groupe' => 'inscription', 'cle' => 'auto_approve_entreprise',     'valeur' => '0',  'type' => 'boolean', 'label' => 'Approbation auto des entreprises',  'description' => 'Si désactivé, chaque entreprise doit être approuvée manuellement.'],

            // ── OFFRES ───────────────────────────────────────────
            ['groupe' => 'offres', 'cle' => 'offres_actives',              'valeur' => '1',  'type' => 'boolean', 'label' => 'Publication d\'offres activée',    'description' => 'Désactiver pour empêcher toute nouvelle publication d\'offres.'],
            ['groupe' => 'offres', 'cle' => 'validation_offre_manuelle',   'valeur' => '0',  'type' => 'boolean', 'label' => 'Validation manuelle des offres',   'description' => 'Si activé, chaque offre doit être approuvée par l\'admin avant publication.'],
            ['groupe' => 'offres', 'cle' => 'offre_duree_max_jours',       'valeur' => '90', 'type' => 'number',  'label' => 'Durée max d\'une offre (jours)',   'description' => 'Nombre de jours avant expiration automatique.'],
            ['groupe' => 'offres', 'cle' => 'offre_max_par_entreprise',    'valeur' => '10', 'type' => 'number',  'label' => 'Offres max par entreprise'],
            ['groupe' => 'offres', 'cle' => 'offre_visible_sans_compte',   'valeur' => '1',  'type' => 'boolean', 'label' => 'Offres visibles sans compte'],

            // ── CANDIDATURES ─────────────────────────────────────
            ['groupe' => 'candidatures', 'cle' => 'candidatures_actives',          'valeur' => '1',  'type' => 'boolean', 'label' => 'Candidatures activées',           'description' => 'Désactiver pour bloquer toutes les nouvelles candidatures.'],
            ['groupe' => 'candidatures', 'cle' => 'max_candidatures_par_etudiant', 'valeur' => '5',  'type' => 'number',  'label' => 'Candidatures max par étudiant',   'description' => '0 = illimité.'],
            ['groupe' => 'candidatures', 'cle' => 'cv_obligatoire',                'valeur' => '1',  'type' => 'boolean', 'label' => 'CV obligatoire pour candidater'],
            ['groupe' => 'candidatures', 'cle' => 'formats_cv_acceptes',           'valeur' => 'pdf','type' => 'text',    'label' => 'Formats CV acceptés',             'description' => 'Ex: pdf,doc,docx'],
            ['groupe' => 'candidatures', 'cle' => 'taille_max_cv_mo',             'valeur' => '5',  'type' => 'number',  'label' => 'Taille max CV (Mo)'],

            // ── EMAILS & NOTIFICATIONS ────────────────────────────
            ['groupe' => 'notifications', 'cle' => 'email_nouvelle_candidature',  'valeur' => '1',  'type' => 'boolean', 'label' => 'Email nouvelle candidature',      'description' => 'Notifier l\'entreprise à chaque nouvelle candidature.'],
            ['groupe' => 'notifications', 'cle' => 'email_statut_candidature',    'valeur' => '1',  'type' => 'boolean', 'label' => 'Email changement de statut',      'description' => 'Notifier l\'étudiant quand son statut change.'],
            ['groupe' => 'notifications', 'cle' => 'email_nouveau_compte',        'valeur' => '1',  'type' => 'boolean', 'label' => 'Email nouveau compte admin',      'description' => 'Notifier l\'admin à chaque nouvelle inscription.'],
            ['groupe' => 'notifications', 'cle' => 'email_expiration_offre',      'valeur' => '1',  'type' => 'boolean', 'label' => 'Email expiration offre',          'description' => 'Alerter l\'entreprise quand son offre expire bientôt.'],
            ['groupe' => 'notifications', 'cle' => 'delai_alerte_expiration_j',   'valeur' => '7',  'type' => 'number',  'label' => 'Jours avant alerte expiration'],

            // ── MAINTENANCE ───────────────────────────────────────
            ['groupe' => 'maintenance', 'cle' => 'mode_maintenance',         'valeur' => '0',                    'type' => 'boolean', 'label' => 'Mode maintenance',              'description' => 'Affiche une page de maintenance aux visiteurs. L\'admin garde l\'accès.', 'is_locked' => true],
            ['groupe' => 'maintenance', 'cle' => 'message_maintenance',      'valeur' => 'Site en maintenance.', 'type' => 'text',    'label' => 'Message de maintenance'],
            ['groupe' => 'maintenance', 'cle' => 'ip_whitelist_maintenance', 'valeur' => '',                     'type' => 'text',    'label' => 'IPs autorisées (maintenance)',   'description' => 'IPs séparées par des virgules qui voient le site même en maintenance.'],

            // ── SÉCURITÉ ─────────────────────────────────────────
            ['groupe' => 'securite', 'cle' => 'max_tentatives_connexion',  'valeur' => '5',  'type' => 'number',  'label' => 'Tentatives de connexion max',      'description' => 'Nombre d\'essais avant blocage temporaire.'],
            ['groupe' => 'securite', 'cle' => 'duree_blocage_minutes',     'valeur' => '15', 'type' => 'number',  'label' => 'Durée de blocage (minutes)'],
            ['groupe' => 'securite', 'cle' => 'session_duree_minutes',     'valeur' => '120','type' => 'number',  'label' => 'Durée de session (minutes)'],
            ['groupe' => 'securite', 'cle' => 'force_https',               'valeur' => '0',  'type' => 'boolean', 'label' => 'Forcer HTTPS'],
            ['groupe' => 'securite', 'cle' => 'recaptcha_active',          'valeur' => '0',  'type' => 'boolean', 'label' => 'reCAPTCHA activé'],
            ['groupe' => 'securite', 'cle' => 'recaptcha_site_key',        'valeur' => '',   'type' => 'text',    'label' => 'reCAPTCHA clé publique'],
            ['groupe' => 'securite', 'cle' => 'recaptcha_secret_key',      'valeur' => '',   'type' => 'text',    'label' => 'reCAPTCHA clé secrète'],

        ];

        foreach ($parametres as $p) {
            \App\Models\Admin\Parametre::updateOrCreate(
                ['cle' => $p['cle']],
                array_merge([
                    'groupe'      => 'general',
                    'type'        => 'text',
                    'label'       => null,
                    'description' => null,
                    'options'     => null,
                    'is_public'   => false,
                    'is_locked'   => false,
                ], $p)
            );
        }
    }
}
