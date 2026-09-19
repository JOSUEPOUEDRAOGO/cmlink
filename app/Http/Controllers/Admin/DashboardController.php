<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES DU DASHBOARD
        |--------------------------------------------------------------------------
        */

        $stats = [
            'etudiants' => Etudiant::count(),

            'entreprises' => Entreprise::count(),

            'offres' => Offre::count(),

            'candidatures' => Candidature::count(),

            'stages' => Offre::where('type', 'stage')->count(),

            'emplois' => Offre::where('type', 'emploi')->count(),

            'candidatures_en_attente' => Candidature::where(
                'statut',
                'en_attente'
            )->count(),

            'candidatures_acceptees' => Candidature::where(
                'statut',
                'accepte'
            )->count(),

            /*
            |--------------------------------------------------------------------------
            | UTILISATEURS ACTUELLEMENT EN LIGNE
            |--------------------------------------------------------------------------
            |
            | Un utilisateur est considéré comme en ligne uniquement s'il
            | a envoyé un signal de présence au cours des 30 dernières secondes.
            |
            */

            'online' => User::whereNotNull('last_seen_at')
                ->where(
                    'last_seen_at',
                    '>=',
                    now()->subSeconds(45)
                )
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | DERNIÈRES OFFRES
        |--------------------------------------------------------------------------
        */

        $dernieresOffres = Offre::with('entreprise', 'categorie')
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DERNIÈRES CANDIDATURES
        |--------------------------------------------------------------------------
        */

        $dernieresCandidatures = Candidature::with(
            'etudiant.filiere',
            'offre.entreprise'
        )
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | OFFRES PAR TYPE
        |--------------------------------------------------------------------------
        */

        $offresParType = [
            'stage' => $stats['stages'],
            'emploi' => $stats['emplois'],
        ];

        /*
        |--------------------------------------------------------------------------
        | CANDIDATURES PAR STATUT
        |--------------------------------------------------------------------------
        */

        $candidaturesParStatut = [
            'en_attente' => Candidature::where(
                'statut',
                'en_attente'
            )->count(),

            'accepte' => Candidature::where(
                'statut',
                'accepte'
            )->count(),

            'refuse' => Candidature::where(
                'statut',
                'refuse'
            )->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | INSCRIPTIONS MENSUELLES
        |--------------------------------------------------------------------------
        */

        $inscriptionsMensuelles = Etudiant::selectRaw(
            'MONTH(created_at) as mois, COUNT(*) as total'
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | OFFRES MENSUELLES
        |--------------------------------------------------------------------------
        */

        $offresMensuelles = Offre::selectRaw(
            'MONTH(created_at) as mois, COUNT(*) as total'
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | LABELS DES MOIS
        |--------------------------------------------------------------------------
        */

        $moisLabels = [
            'Jan',
            'Fév',
            'Mar',
            'Avr',
            'Mai',
            'Juin',
            'Juil',
            'Août',
            'Sep',
            'Oct',
            'Nov',
            'Déc',
        ];

        /*
        |--------------------------------------------------------------------------
        | ÉTUDIANTS PAR MOIS
        |--------------------------------------------------------------------------
        */

        $etudiantsParMois = array_fill(0, 12, 0);

        foreach ($inscriptionsMensuelles as $item) {
            $etudiantsParMois[$item->mois - 1] = $item->total;
        }

        /*
        |--------------------------------------------------------------------------
        | OFFRES PAR MOIS
        |--------------------------------------------------------------------------
        */

        $offresParMois = array_fill(0, 12, 0);

        foreach ($offresMensuelles as $item) {
            $offresParMois[$item->mois - 1] = $item->total;
        }

        /*
        |--------------------------------------------------------------------------
        | TOP ENTREPRISES
        |--------------------------------------------------------------------------
        */

        $topEntreprises = Entreprise::withCount('offres')
            ->orderByDesc('offres_count')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DU DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard.index', compact(
            'stats',
            'dernieresOffres',
            'dernieresCandidatures',
            'offresParType',
            'candidaturesParStatut',
            'moisLabels',
            'etudiantsParMois',
            'offresParMois',
            'topEntreprises'
        ));
    }
}
