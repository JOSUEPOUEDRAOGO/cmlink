<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompetenceRequest;
use App\Models\Competence;
use App\Models\Entreprise\Offre; // ← corriger ici
class CompetenceController extends Controller
{
    public function index()
    {
        $competences = Competence::withCount(['etudiants', 'offres'])
            ->latest()
            ->paginate(20);

        return view('admin.competences.index', compact('competences'));
    }

    public function create()
    {
        return view('admin.competences.create');
    }

    public function store(CompetenceRequest $request)
    {
        Competence::create($request->validated());

        return redirect()
            ->route('admin.competences.index')
            ->with('success', 'Compétence créée avec succès.');
    }

    public function show(Competence $competence)
    {
        $competence->loadCount(['etudiants', 'offres']);

        return view('admin.competences.show', compact('competence'));
    }

    public function edit(Competence $competence)
    {
        return view('admin.competences.edit', compact('competence'));
    }

    public function update(CompetenceRequest $request, Competence $competence)
    {
        $competence->update($request->validated());

        return redirect()
            ->route('admin.competences.index')
            ->with('success', 'Compétence mise à jour.');
    }

    public function destroy(Competence $competence)
    {
        $competence->delete();

        return redirect()
            ->route('admin.competences.index')
            ->with('success', 'Compétence supprimée.');
    }
}
