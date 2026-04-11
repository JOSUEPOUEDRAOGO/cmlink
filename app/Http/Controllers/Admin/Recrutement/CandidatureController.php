<?php

namespace App\Http\Controllers\Admin\Recrutement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recrutement\CandidatureRequest;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::with('etudiant.filiere', 'offre.entreprise')
            ->latest()
            ->paginate(15);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $offres = Offre::with('entreprise')->latest()->get();

        return view('admin.candidatures.create', compact('etudiants', 'offres'));
    }

    public function store(CandidatureRequest $request)
    {
        Candidature::create($request->validated());

        return redirect()
            ->route('admin.candidatures.index')
            ->with('success', 'Candidature créée avec succès.');
    }

    public function show(Candidature $candidature)
    {
        $candidature->load('etudiant.filiere', 'offre.entreprise', 'offre.categorie');

        return view('admin.candidatures.show', compact('candidature'));
    }

    public function edit(Candidature $candidature)
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $offres = Offre::with('entreprise')->latest()->get();

        return view('admin.candidatures.edit', compact('candidature', 'etudiants', 'offres'));
    }

    public function update(CandidatureRequest $request, Candidature $candidature)
    {
        $candidature->update($request->validated());

        return redirect()
            ->route('admin.candidatures.index')
            ->with('success', 'Candidature mise à jour avec succès.');
    }

    public function destroy(Candidature $candidature)
    {
        $candidature->delete();

        return redirect()
            ->route('admin.candidatures.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }
}