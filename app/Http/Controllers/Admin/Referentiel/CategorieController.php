<?php

namespace App\Http\Controllers\Admin\Referentiel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Referentiel\CategorieRequest;
use App\Models\Referentiel\Categorie;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('offres')
            ->latest()
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategorieRequest $request)
    {
        Categorie::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(Categorie $categorie)
    {
        $categorie->load('offres');

        return view('admin.categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categories.edit', compact('categorie'));
    }

    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $categorie->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}