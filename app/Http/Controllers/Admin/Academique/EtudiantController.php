<?php

namespace App\Http\Controllers\Admin\Academique;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Academique\EtudiantRequest;
use App\Models\Academique\Etudiant;
use App\Models\Academique\Filiere;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with('filiere')
            ->latest()
            ->paginate(15);

        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();

        return view('admin.etudiants.create', compact('filieres'));
    }

    public function store(EtudiantRequest $request)
    {
        Etudiant::create($request->validated());

        return redirect()
            ->route('admin.etudiants.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load('filiere', 'candidatures.offre');

        return view('admin.etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $filieres = Filiere::orderBy('nom')->get();

        return view('admin.etudiants.edit', compact('etudiant', 'filieres'));
    }

    public function update(EtudiantRequest $request, Etudiant $etudiant)
    {
        $etudiant->update($request->validated());

        return redirect()
            ->route('admin.etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()
            ->route('admin.etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}
