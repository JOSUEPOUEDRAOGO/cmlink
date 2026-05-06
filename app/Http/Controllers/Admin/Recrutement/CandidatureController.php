<?php

namespace App\Http\Controllers\Admin\Recrutement;

use App\Http\Controllers\Controller;
use App\Models\Recrutement\Candidature;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::with([
                'etudiant.filiere',
                'offre.entreprise',
                'offre.categorie',
            ])
            ->latest()
            ->paginate(15);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    public function show(Candidature $candidature)
    {
        $candidature->load([
            'etudiant.filiere',
            'offre.entreprise',
            'offre.categorie',
        ]);

        return view('admin.candidatures.show', compact('candidature'));
    }

    public function updateStatus(Request $request, Candidature $candidature)
    {
        $validated = $request->validate([
            'statut' => ['required', 'in:en_attente,accepte,refuse'],
        ]);

        $candidature->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with('success', 'Statut de la candidature mis à jour avec succès.');
    }

    public function destroy(Candidature $candidature)
    {
        $candidature->delete();

        return redirect()
            ->route('admin.candidatures.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }
}
