<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use App\Models\Referentiel\Categorie;
use App\Models\PageSection;


class HomeController extends Controller
{

    public function index()
    {
        $stats = [
            'offres' => Offre::count(),
            'entreprises' => Entreprise::count(),
            'etudiants' => Etudiant::count(),
            'candidatures' => Candidature::count(),
        ];

        $categories = Categorie::withCount('offres')
            ->orderBy('nom')
            ->get();

        $offresRecentes = Offre::with(['entreprise', 'categorie'])
            ->latest()
            ->take(6)
            ->get();

        $pageContent = PageSection::where('page', 'home')
            ->where('is_active', true)
            ->get()
            ->groupBy('section')
            ->map(fn($items) => $items->pluck('value', 'key'));

        return view('front.home', compact(
            'stats',
            'categories',
            'offresRecentes',
            'pageContent'
        ));
    }
}
