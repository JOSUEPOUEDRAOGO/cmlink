<?php

namespace App\Http\Controllers\Recrutement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recrutement\LettreMotivationRequest;
use App\Models\Recrutement\LettreMotivation;

class LettreMotivationController extends Controller
{
    public function __invoke(LettreMotivationRequest $request)
    {
        $user = auth()->user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            return back()->with('error', 'Profil étudiant introuvable.');
        }

        // Créer une nouvelle lettre (on conserve l'historique)
        LettreMotivation::create([
            'etudiant_id' => $etudiant->id,
            'titre' => $request->input('titre', 'Lettre de motivation - ' . now()->format('d/m/Y H:i')),
            'contenu' => $request->lettre_motivation,
        ]);

        $message = ($request->isMethod('PATCH') || $request->isMethod('PUT'))
            ? 'Votre lettre de motivation a été mise à jour (nouvelle version).'
            : 'Votre lettre de motivation a été enregistrée.';

        return back()->with('success', $message);
    }
}
