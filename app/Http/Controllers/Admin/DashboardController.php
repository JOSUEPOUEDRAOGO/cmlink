<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'etudiants' => Etudiant::count(),
            'entreprises' => Entreprise::count(),
            'offres' => Offre::count(),
            'candidatures' => Candidature::count(),
            'stages' => Offre::where('type', 'stage')->count(),
            'emplois' => Offre::where('type', 'emploi')->count(),
            'candidatures_en_attente' => Candidature::where('statut', 'en_attente')->count(),
            'candidatures_acceptees' => Candidature::where('statut', 'accepte')->count(),
        ];

        $dernieresOffres = Offre::with('entreprise', 'categorie')
            ->latest()
            ->take(6)
            ->get();

        $dernieresCandidatures = Candidature::with('etudiant.filiere', 'offre.entreprise')
            ->latest()
            ->take(6)
            ->get();

        $offresParType = [
            'stage' => $stats['stages'],
            'emploi' => $stats['emplois'],
        ];

        $candidaturesParStatut = [
            'en_attente' => Candidature::where('statut', 'en_attente')->count(),
            'accepte' => Candidature::where('statut', 'accepte')->count(),
            'refuse' => Candidature::where('statut', 'refuse')->count(),
        ];

        $inscriptionsMensuelles = Etudiant::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $offresMensuelles = Offre::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $moisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        $etudiantsParMois = array_fill(0, 12, 0);
        foreach ($inscriptionsMensuelles as $item) {
            $etudiantsParMois[$item->mois - 1] = $item->total;
        }

        $offresParMois = array_fill(0, 12, 0);
        foreach ($offresMensuelles as $item) {
            $offresParMois[$item->mois - 1] = $item->total;
        }

        $topEntreprises = Entreprise::withCount('offres')
            ->orderByDesc('offres_count')
            ->take(5)
            ->get();

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