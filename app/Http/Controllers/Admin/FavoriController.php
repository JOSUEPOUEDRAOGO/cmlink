<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FavoriRequest;
use App\Models\Favori;                        // ← manquant
use App\Models\Academique\Etudiant;

class FavoriController extends Controller
{
    public function index()
    {
        $etudiant = auth()->user()->etudiant;

        $favoris = Favori::with(['offre.entreprise', 'offre.categorie'])
            ->where('etudiant_id', $etudiant->id)
            ->latest()
            ->paginate(20);

        return view('admin.favoris.index', compact('favoris'));
    }

    public function store(FavoriRequest $request)
    {
        $etudiant = auth()->user()->etudiant;

        Favori::create([
            'etudiant_id' => $etudiant->id,
            'offre_id'    => $request->offre_id,
        ]);

        return back()->with('success', 'Offre ajoutée aux favoris.');
    }

    public function destroy(Favori $favori)
    {
        $this->authorize('delete', $favori);

        $favori->delete();

        return back()->with('success', 'Offre retirée des favoris.');
    }
}
