<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\SignalementRequest;
use App\Models\Academique\Etudiant;
use App\Models\Admin\Signalement;
use App\Models\Entreprise\Entreprise;

class SignalementController extends Controller
{
    public function index()
    {
        $signalements = Signalement::with('etudiant', 'entreprise')
            ->latest()
            ->paginate(15);

        return view('admin.signalements.index', compact('signalements'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('admin.signalements.create', compact('etudiants', 'entreprises'));
    }

    public function store(SignalementRequest $request)
    {
        Signalement::create($request->validated());

        return redirect()
            ->route('admin.signalements.index')
            ->with('success', 'Signalement créé avec succès.');
    }

    public function show(Signalement $signalement)
    {
        $signalement->load('etudiant', 'entreprise');

        return view('admin.signalements.show', compact('signalement'));
    }

    public function edit(Signalement $signalement)
    {
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('admin.signalements.edit', compact('signalement', 'etudiants', 'entreprises'));
    }

    public function update(SignalementRequest $request, Signalement $signalement)
    {
        $signalement->update($request->validated());

        return redirect()
            ->route('admin.signalements.index')
            ->with('success', 'Signalement mis à jour avec succès.');
    }

    public function destroy(Signalement $signalement)
    {
        $signalement->delete();

        return redirect()
            ->route('admin.signalements.index')
            ->with('success', 'Signalement supprimé avec succès.');
    }
}