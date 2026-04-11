<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Academique\Filiere;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use App\Models\Referentiel\Categorie;

class StatistiqueController extends Controller
{
    public function index()
    {
        $stats = [
            'total_etudiants' => Etudiant::count(),
            'total_entreprises' => Entreprise::count(),
            'total_offres' => Offre::count(),
            'total_candidatures' => Candidature::count(),
            'total_stages' => Offre::where('type', 'stage')->count(),
            'total_emplois' => Offre::where('type', 'emploi')->count(),
            'total_filieres' => Filiere::count(),
            'total_categories' => Categorie::count(),
        ];

        $offresParType = [
            'stages' => Offre::where('type', 'stage')->count(),
            'emplois' => Offre::where('type', 'emploi')->count(),
        ];

        $candidaturesParStatut = [
            'en_attente' => Candidature::where('statut', 'en_attente')->count(),
            'accepte' => Candidature::where('statut', 'accepte')->count(),
            'refuse' => Candidature::where('statut', 'refuse')->count(),
        ];

        $topFilieres = Filiere::withCount('etudiants')
            ->orderByDesc('etudiants_count')
            ->take(5)
            ->get();

        $topCategories = Categorie::withCount('offres')
            ->orderByDesc('offres_count')
            ->take(5)
            ->get();

        $topEntreprises = Entreprise::withCount('offres')
            ->orderByDesc('offres_count')
            ->take(5)
            ->get();

        return view('admin.statistiques.index', compact(
            'stats',
            'offresParType',
            'candidaturesParStatut',
            'topFilieres',
            'topCategories',
            'topEntreprises'
        ));
    }
}