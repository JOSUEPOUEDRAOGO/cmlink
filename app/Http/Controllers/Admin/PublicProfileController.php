<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicProfileController extends Controller
{
    /**
     * Affiche la liste des étudiants ayant rendu public leur CV ou leur lettre.
     */
    public function index()
    {
        $etudiants = Etudiant::where(function ($query) {
                $query->where('cv_public', true)
                      ->orWhere('lettre_public', true);
            })
            ->with(['user', 'filiere', 'cvs' => function ($q) {
                $q->where('principal', true); // CV principal uniquement
            }, 'lettres' => function ($q) {
                $q->latest()->limit(1); // Dernière lettre
            }])
            ->latest()
            ->paginate(20);

        return view('admin.profils-publics.index', compact('etudiants'));
    }

    /**
     * Télécharge le CV principal d’un étudiant (si public).
     */
    public function downloadCv(Etudiant $etudiant)
    {
        // Vérifier que l'étudiant a rendu son CV public
        if (!$etudiant->cv_public) {
            abort(403, 'Ce CV n’est pas accessible publiquement.');
        }

        $cv = $etudiant->cvs()->where('principal', true)->first();

        if (!$cv || !$cv->cv_path || !Storage::disk('public')->exists($cv->cv_path)) {
            abort(404, 'Aucun CV trouvé pour cet étudiant.');
        }

        return response()->download(Storage::disk('public')->path($cv->cv_path), $cv->titre . '.pdf');
    }

    /**
     * Affiche la dernière lettre de motivation d’un étudiant (si publique).
     */
   public function viewLettre(Etudiant $etudiant)
{
    if (!$etudiant->lettre_public) abort(403, 'Lettre non accessible.');
    $lettre = $etudiant->derniereLettre;
    if (!$lettre) abort(404, 'Aucune lettre trouvée.');
    return view('admin.profils-publics.lettre', compact('etudiant', 'lettre'));
}
}
