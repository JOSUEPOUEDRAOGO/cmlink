<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academique\Etudiant;
use App\Models\Recrutement\EtudiantCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicProfileController extends Controller
{
    /**
     * Liste des profils publics (vue admin/entreprise).
     */
    public function index()
    {
        $etudiants = Etudiant::with(['user', 'filiere', 'cvPrincipal', 'derniereLettre'])
            ->where('cv_public', true)
            ->orWhere('lettre_public', true)
            ->orWhere('photo_publique', true)
            ->latest()
            ->paginate(20);

        return view('admin.profils-publics.index', compact('etudiants'));
    }

    public function downloadCv(Etudiant $etudiant)
    {
        if (!$etudiant->cv_public) {
            abort(403, 'Ce CV n\'est pas accessible publiquement.');
        }

        $cv = $etudiant->cvPrincipal;

        if (!$cv || !$cv->cv_path || !Storage::disk('public')->exists($cv->cv_path)) {
            abort(404, 'Aucun CV trouvé pour cet étudiant.');
        }

        $nomFichier = Str::slug($cv->titre) . '.pdf';

        return response()->download(Storage::disk('public')->path($cv->cv_path), $nomFichier);
    }

    public function viewLettre(Etudiant $etudiant)
    {
        if (!$etudiant->lettre_public) {
            abort(403, 'Lettre non accessible.');
        }

        $lettre = $etudiant->derniereLettre;

        if (!$lettre) {
            abort(404, 'Aucune lettre trouvée.');
        }

        return view('admin.profils-publics.lettre', compact('etudiant', 'lettre'));
    }

    public function toggleLettre(Etudiant $etudiant)
    {
        $etudiant->update(['lettre_public' => !$etudiant->lettre_public]);

        return redirect()->back()->with(
            'success',
            $etudiant->lettre_public ? 'La lettre est maintenant publique.' : 'La lettre est maintenant privée.'
        );
    }

    // ──────────────────────────────────────────────────────────
    // ESPACE ÉTUDIANT — Gestion de son propre profil public
    // ──────────────────────────────────────────────────────────

    /**
     * Page "Mon profil public" pour l'étudiant connecté.
     */
    public function monProfil()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            abort(403, 'Aucun profil étudiant associé à ce compte.');
        }

        $etudiant->load(['cvs' => fn($q) => $q->latest(), 'derniereLettre']);

        return view('admin.mon-profil.public', compact('etudiant'));
    }

    /**
     * Bascule la visibilité du CV principal.
     */
    public function toggleMonCv()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant->cvPrincipal) {
            return back()->with('error', 'Vous devez définir un CV principal avant de le rendre public.');
        }

        $etudiant->update(['cv_public' => !$etudiant->cv_public]);

        return back()->with(
            'success',
            $etudiant->cv_public ? 'Votre CV est maintenant public.' : 'Votre CV est maintenant privé.'
        );
    }

    /**
     * Bascule la visibilité de la lettre de motivation.
     */
    public function toggleMaLettre()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant->derniereLettre) {
            return back()->with('error', 'Vous devez rédiger une lettre avant de la rendre publique.');
        }

        $etudiant->update(['lettre_public' => !$etudiant->lettre_public]);

        return back()->with(
            'success',
            $etudiant->lettre_public ? 'Votre lettre est maintenant publique.' : 'Votre lettre est maintenant privée.'
        );
    }

    /**
     * Bascule la visibilité de la photo de profil
     * (récupère automatiquement l'avatar du compte User).
     */
    public function togglePhoto()
    {
        $user = auth()->user();
        $etudiant = $user->etudiant;

        if (!$user->avatar) {
            return back()->with('error', 'Vous devez d\'abord ajouter une photo de profil dans les paramètres de votre compte.');
        }

        $etudiant->update(['photo_publique' => !$etudiant->photo_publique]);

        return back()->with(
            'success',
            $etudiant->photo_publique ? 'Votre photo est maintenant visible par les entreprises.' : 'Votre photo est maintenant privée.'
        );
    }

    /**
     * Upload d'un nouveau CV dans la liste de l'étudiant.
     */
    public function storeCv(Request $request)
    {
        $etudiant = auth()->user()->etudiant;

        $validated = $request->validate([
            'titre'   => ['required', 'string', 'max:255'],
            'cv_file' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'titre.required'   => 'Veuillez donner un nom à ce CV.',
            'cv_file.required' => 'Veuillez sélectionner un fichier PDF.',
            'cv_file.mimes'    => 'Le CV doit être un fichier PDF.',
            'cv_file.max'      => 'Le CV ne doit pas dépasser 5 Mo.',
        ]);

        $path = $request->file('cv_file')->store('cv', 'public');

        $estPremierCv = $etudiant->cvs()->count() === 0;

        EtudiantCv::create([
            'etudiant_id' => $etudiant->id,
            'titre'       => $validated['titre'],
            'cv_path'     => $path,
            'principal'   => $estPremierCv, // le 1er CV devient principal automatiquement
        ]);

        return back()->with('success', 'CV ajouté avec succès.');
    }

    /**
     * Définit un CV comme principal (et retire le statut des autres).
     */
    public function setCvPrincipal(EtudiantCv $cv)
    {
        $etudiant = auth()->user()->etudiant;

        if ($cv->etudiant_id !== $etudiant->id) {
            abort(403, 'Action non autorisée.');
        }

        $etudiant->cvs()->update(['principal' => false]);
        $cv->update(['principal' => true]);

        return back()->with('success', "\"{$cv->titre}\" est maintenant votre CV principal.");
    }

    /**
     * Supprime un CV de la liste.
     */
    public function destroyCv(EtudiantCv $cv)
    {
        $etudiant = auth()->user()->etudiant;

        if ($cv->etudiant_id !== $etudiant->id) {
            abort(403, 'Action non autorisée.');
        }

        $etaitPrincipal = $cv->principal;

        if ($cv->cv_path && Storage::disk('public')->exists($cv->cv_path)) {
            Storage::disk('public')->delete($cv->cv_path);
        }

        $cv->delete();

        // Si le CV supprimé était le principal, en désigner un autre automatiquement
        if ($etaitPrincipal) {
            $nouveauPrincipal = $etudiant->cvs()->latest()->first();
            if ($nouveauPrincipal) {
                $nouveauPrincipal->update(['principal' => true]);
            } else {
                // plus aucun CV → désactiver la visibilité publique
                $etudiant->update(['cv_public' => false]);
            }
        }

        return back()->with('success', 'CV supprimé avec succès.');
    }
}