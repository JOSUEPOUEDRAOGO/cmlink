<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonProfilController extends Controller
{
    /**
     * Affiche le profil de l'étudiant connecté.
     */
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $etudiant->load([
            'filiere',
            'cvs',
            'cvPrincipal',
            'lettres',
            'derniereLettre',
            'competences',
            'candidatures.offre.entreprise',
        ]);

        $competencesDisponibles = Competence::orderBy('nom')->get();

        return view('admin.mon-profil.index', compact('etudiant', 'competencesDisponibles'));
    }

    /**
     * Met à jour les infos personnelles de l'étudiant.
     */
    public function update(Request $request)
    {
        $etudiant = $this->getEtudiant();

        $validated = $request->validate([
            'ville'         => ['nullable', 'string', 'max:255'],
            'telephone'     => ['nullable', 'string', 'max:20'],
            'date_naissance'=> ['nullable', 'date'],
            'disponible_le' => ['nullable', 'date'],
            'niveau_etudes' => ['nullable', 'in:bac,bac+2,bac+3,bac+5,doctorat'],
        ]);

        $etudiant->update($validated);

        return redirect()
            ->route('admin.mon-profil.index')
            ->with('success', 'Profil mis à jour.');
    }

    /**
     * Ajoute une compétence au profil de l'étudiant.
     */
    public function ajouterCompetence(Request $request)
    {
        $etudiant = $this->getEtudiant();

        $validated = $request->validate([
            'competence_id' => ['required', 'exists:competences,id'],
            'niveau'        => ['required', 'in:debutant,intermediaire,avance,expert'],
        ], [
            'competence_id.required' => 'Veuillez sélectionner une compétence.',
            'competence_id.exists'   => 'Cette compétence n\'existe pas.',
            'niveau.required'        => 'Veuillez sélectionner un niveau.',
            'niveau.in'              => 'Niveau invalide.',
        ]);

        // Vérifier si la compétence est déjà ajoutée
        if ($etudiant->competences()->where('competence_id', $validated['competence_id'])->exists()) {
            return redirect()
                ->route('admin.mon-profil.index')
                ->with('error', 'Cette compétence est déjà dans votre profil.');
        }

        $etudiant->competences()->attach($validated['competence_id'], [
            'niveau' => $validated['niveau'],
        ]);

        return redirect()
            ->route('admin.mon-profil.index')
            ->with('success', 'Compétence ajoutée à votre profil.');
    }

    /**
     * Met à jour le niveau d'une compétence existante.
     */
    public function updateCompetence(Request $request, Competence $competence)
    {
        $etudiant = $this->getEtudiant();

        $validated = $request->validate([
            'niveau' => ['required', 'in:debutant,intermediaire,avance,expert'],
        ]);

        $etudiant->competences()->updateExistingPivot($competence->id, [
            'niveau' => $validated['niveau'],
        ]);

        return redirect()
            ->route('admin.mon-profil.index')
            ->with('success', 'Niveau mis à jour.');
    }

    /**
     * Retire une compétence du profil de l'étudiant.
     */
    public function retirerCompetence(Competence $competence)
    {
        $etudiant = $this->getEtudiant();

        $etudiant->competences()->detach($competence->id);

        return redirect()
            ->route('admin.mon-profil.index')
            ->with('success', 'Compétence retirée de votre profil.');
    }

    /**
     * Bascule la visibilité publique du CV.
     */
    public function toggleCvPublic()
    {
        $etudiant = $this->getEtudiant();

        $etudiant->update(['cv_public' => !$etudiant->cv_public]);

        $msg = $etudiant->cv_public
            ? 'Votre CV est maintenant public.'
            : 'Votre CV est maintenant privé.';

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Bascule la visibilité publique de la lettre.
     */
    public function toggleLettrePublic()
    {
        $etudiant = $this->getEtudiant();

        $etudiant->update(['lettre_public' => !$etudiant->lettre_public]);

        $msg = $etudiant->lettre_public
            ? 'Votre lettre est maintenant publique.'
            : 'Votre lettre est maintenant privée.';

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Helper — récupère l'étudiant lié à l'utilisateur connecté.
     */
    private function getEtudiant(): Etudiant
    {
        $etudiant = Auth::user()->etudiant;

        if (!$etudiant) {
            abort(403, 'Aucun profil étudiant associé à ce compte.');
        }

        return $etudiant;
    }
}
