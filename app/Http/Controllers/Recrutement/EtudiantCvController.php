<?php

namespace App\Http\Controllers\Recrutement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recrutement\EtudiantCvRequest;
use App\Models\Recrutement\EtudiantCv;
use Illuminate\Support\Facades\Storage;

class EtudiantCvController extends Controller
{
    public function __invoke(EtudiantCvRequest $request)
    {
        $user = auth()->user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            return back()->with('error', 'Profil étudiant introuvable.');
        }

        // Désactiver l'ancien CV principal
        $etudiant->cvs()->update(['principal' => false]);

        // Stocker le nouveau fichier
        $path = $request->file('cv')->store('cvs', 'public');

        // Créer le nouveau CV principal
        EtudiantCv::create([
            'etudiant_id' => $etudiant->id,
            'titre' => $request->input('titre', 'CV - ' . now()->format('d/m/Y H:i')),
            'cv_path' => $path,
            'principal' => true,
        ]);

        $message = ($request->isMethod('PATCH') || $request->isMethod('PUT'))
            ? 'Votre CV a été mis à jour avec succès.'
            : 'Votre CV a été téléchargé avec succès.';

        return back()->with('success', $message);
    }
}
