<?php

namespace App\Http\Controllers\Admin\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Entreprise\EntrepriseRequest;
use App\Models\Entreprise\Entreprise;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::withCount('offres')
            ->latest()
            ->paginate(15);

        return view('admin.entreprises.index', compact('entreprises'));
    }

    public function create()
    {
        return view('admin.entreprises.create');
    }

    public function store(EntrepriseRequest $request)
    {
        Entreprise::create($request->validated());

        return redirect()
            ->route('admin.entreprises.index')
            ->with('success', 'Entreprise créée avec succès.');
    }

    public function show(Entreprise $entreprise)
    {
        $entreprise->load('offres');

        return view('admin.entreprises.show', compact('entreprise'));
    }

    public function edit(Entreprise $entreprise)
    {
        return view('admin.entreprises.edit', compact('entreprise'));
    }

    public function update(EntrepriseRequest $request, Entreprise $entreprise)
    {
        $entreprise->update($request->validated());

        return redirect()
            ->route('admin.entreprises.index')
            ->with('success', 'Entreprise mise à jour avec succès.');
    }

    public function destroy(Entreprise $entreprise)
    {
        $entreprise->delete();

        return redirect()
            ->route('admin.entreprises.index')
            ->with('success', 'Entreprise supprimée avec succès.');
    }
}