<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Academique\Filiere;
use Illuminate\Http\Request;

class EtudiantFrontController extends Controller
{
    public function index(Request $request)
    {
        $query = Etudiant::with('filiere')->latest();

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filiere')) {
            $query->where('filiere_id', $request->filiere);
        }

        $etudiants = $query->paginate(9)->withQueryString();
        $filieres = Filiere::orderBy('nom')->get();

        return view('front.etudiants.index', compact('etudiants', 'filieres'));
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load('filiere', 'candidatures.offre.entreprise');

        return view('front.etudiants.show', compact('etudiant'));
    }
}
