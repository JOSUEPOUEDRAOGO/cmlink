<?php

namespace App\Http\Controllers\Admin\Academique;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Academique\FiliereRequest;
use App\Models\Academique\Filiere;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount('etudiants')
            ->latest()
            ->paginate(15);

        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(FiliereRequest $request)
    {
        Filiere::create($request->validated());

        return redirect()
            ->route('admin.filieres.index')
            ->with('success', 'Filière créée avec succès.');
    }

    public function show(Filiere $filiere)
    {
        $filiere->load('etudiants');

        return view('admin.filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(FiliereRequest $request, Filiere $filiere)
    {
        $filiere->update($request->validated());

        return redirect()
            ->route('admin.filieres.index')
            ->with('success', 'Filière modifiée avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();

        return redirect()
            ->route('admin.filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}