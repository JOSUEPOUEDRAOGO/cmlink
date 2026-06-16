<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Entreprise\Offre;
use App\Models\Referentiel\Categorie;
use Illuminate\Http\Request;

class OffreFrontController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::with(['entreprise', 'categorie'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('localisation', 'like', "%{$search}%");
            });
        }

        $offres = $query->paginate(9)->withQueryString();
        $categories = Categorie::orderBy('nom')->get();

        // Précharger les favoris de l'étudiant connecté
        if (auth()->check() && auth()->user()->account_type === 'etudiant') {
            auth()->user()->etudiant?->load('favoris');
        }

        return view('front.offres.index', compact('offres', 'categories'));
    }

    public function show(Offre $offre)
    {
        $offre->load([
            'entreprise',
            'categorie',
            'competences',
            'candidatures',
        ]);

        // Précharger les favoris de l'étudiant connecté
        if (auth()->check() && auth()->user()->account_type === 'etudiant') {
            auth()->user()->etudiant?->load('favoris');
        }

        return view('front.offres.show', compact('offre'));
    }
}
