<?php

namespace App\Http\Controllers\Admin\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Entreprise\OffreRequest;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Referentiel\Categorie;

class OffreController extends Controller
{
    public function index()
    {
        $offres = Offre::with('entreprise', 'categorie')
            ->latest()
            ->paginate(15);

        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        $entreprises = Entreprise::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.offres.create', compact('entreprises', 'categories'));
    }

    public function store(OffreRequest $request)
    {
        Offre::create($request->validated());

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre créée avec succès.');
    }

    public function show(Offre $offre)
    {
        $offre->load('entreprise', 'categorie', 'candidatures.etudiant');

        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $entreprises = Entreprise::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.offres.edit', compact('offre', 'entreprises', 'categories'));
    }

    public function update(OffreRequest $request, Offre $offre)
    {
        $offre->update($request->validated());

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre mise à jour avec succès.');
    }

    public function destroy(Offre $offre)
    {
        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}