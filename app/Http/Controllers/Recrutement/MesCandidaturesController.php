<?php

namespace App\Http\Controllers\Recrutement;

use App\Http\Controllers\Controller;
use App\Models\Recrutement\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MesCandidaturesController extends Controller
{
    // Helper pour récupérer les candidatures selon le rôle
    private function getCandidaturesQuery()
    {
        $user = Auth::user();
        $query = Candidature::with(['offre.entreprise', 'offre.categorie'])->latest();

        if ($user->account_type === 'etudiant') {
            $query->where('etudiant_id', $user->etudiant->id);
        }
        // admin voit tout

        return $query;
    }

    // Toutes les candidatures
    public function index()
    {
        $candidatures = $this->getCandidaturesQuery()->paginate(15);
        return view('recrutement.mes-candidatures.index', compact('candidatures'));
    }

    // Acceptées
    public function acceptees()
    {
        $candidatures = $this->getCandidaturesQuery()
            ->where('statut', 'accepte')
            ->paginate(15);
        return view('recrutement.mes-candidatures.index', compact('candidatures'));
    }

    // Refusées
    public function refusees()
    {
        $candidatures = $this->getCandidaturesQuery()
            ->where('statut', 'refuse')
            ->paginate(15);
        return view('recrutement.mes-candidatures.index', compact('candidatures'));
    }

    // En attente
    public function enAttente()
    {
        $candidatures = $this->getCandidaturesQuery()
            ->where('statut', 'en_attente')
            ->paginate(15);
        return view('recrutement.mes-candidatures.index', compact('candidatures'));
    }

    // Affichage du CV
public function cv()
{
    $etudiant = auth()->user()->etudiant;
    $cvPrincipal = $etudiant?->cvPrincipal;
    return view('recrutement.mes-candidatures.cv', compact('etudiant', 'cvPrincipal'));
}

public function storeCv(Request $request)
{
    $request->validate([
        'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $etudiant = auth()->user()->etudiant;
    $path = $request->file('cv')->store('cvs', 'public');

    // Désactiver l'ancien principal
    $etudiant->cvs()->update(['principal' => false]);

    // Définir le titre : utiliser celui du formulaire, sinon un titre par défaut
    $titre = $request->input('titre');
    if (empty($titre)) {
        $titre = 'CV - ' . now()->format('d/m/Y H:i');
    }

    // Créer le nouveau CV
    $etudiant->cvs()->create([
        'titre' => $titre,
        'cv_path' => $path,
        'principal' => true,
    ]);

    return back()->with('success', 'CV mis à jour.');
}
public function destroyCv()
{
    $etudiant = auth()->user()->etudiant;
    $cv = $etudiant->cvPrincipal;
    if ($cv) {
        Storage::disk('public')->delete($cv->cv_path);
        $cv->delete();
    }
    return back()->with('success', 'CV supprimé.');
}

    // Upload / remplacement du CV

    public function updateCv(Request $request)
    {
        return $this->storeCv($request);
    }



    // Lettres de motivation

public function storeMotivation(Request $request)
{
    $request->validate([
        'lettre_motivation' => 'required|string|min:50|max:2000',
    ]);

    $etudiant = auth()->user()->etudiant;
    $etudiant->lettres()->create([
        'titre' => $request->input('titre', 'Lettre de motivation - ' . now()->format('d/m/Y H:i')),
        'contenu' => $request->lettre_motivation,
    ]);

    return back()->with('success', 'Lettre enregistrée.');
}

public function destroyMotivation()
{
    $etudiant = auth()->user()->etudiant;
    $lettre = $etudiant->derniereLettre;
    if ($lettre) $lettre->delete();
    return back()->with('success', 'Lettre supprimée.');
}

    public function updateMotivation(Request $request)
    {
        return $this->storeMotivation($request);
    }



    public function show(Candidature $candidature)
    {
        $user = Auth::user();
        if ($user->account_type === 'etudiant' && $candidature->etudiant_id !== $user->etudiant->id) {
            abort(403);
        }
        $candidature->load(['offre.entreprise', 'offre.categorie']);
        return view('recrutement.mes-candidatures.show', compact('candidature'));
    }

    public function destroy(Candidature $candidature)
    {
        $user = Auth::user();
        if ($user->account_type === 'etudiant' && $candidature->etudiant_id !== $user->etudiant->id) {
            abort(403);
        }
        $candidature->delete();
        return redirect()->route('admin.mes-candidatures.index')
            ->with('success', 'Candidature retirée avec succès.');
    }

public function updateCvVisibility(Request $request)
{
    $request->validate([
        'cv_public' => 'sometimes|boolean',
    ]);

    $etudiant = auth()->user()->etudiant;
    if (!$etudiant) {
        return back()->with('error', 'Impossible de mettre à jour la visibilité du CV : profil étudiant introuvable.');
    }

    $etudiant->update([
        'cv_public' => $request->boolean('cv_public'),
    ]);

    return back()->with('success', 'Visibilité du CV mise à jour.');
}

public function updateMotivationVisibility(Request $request)
{
    $request->validate([
        'lettre_public' => 'sometimes|boolean',
    ]);

    $etudiant = auth()->user()->etudiant;
    if (!$etudiant) {
        return back()->with('error', 'Profil étudiant introuvable.');
    }

    $etudiant->update([
        'lettre_public' => $request->boolean('lettre_public'),
    ]);

    return back()->with('success', 'Visibilité de la lettre mise à jour.');
}



public function motivations()
{
    $etudiant = auth()->user()->etudiant;
    if (!$etudiant) {
        return view('recrutement.mes-candidatures.motivations', compact('etudiant'));
    }

    $toutesLesLettres = $etudiant->lettres()->latest()->get();
    $derniereLettre = $toutesLesLettres->first();
    $anciennesLettres = $toutesLesLettres->slice(1);

    return view('recrutement.mes-candidatures.motivations', compact('etudiant', 'derniereLettre', 'anciennesLettres'));
}
}
