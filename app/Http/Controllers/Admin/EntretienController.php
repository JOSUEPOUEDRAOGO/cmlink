<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EntretienRequest;
use App\Models\Entretien;
use App\Models\Recrutement\Candidature;

class EntretienController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Entretien::with(['candidature.etudiant', 'candidature.offre.entreprise'])
            ->latest();

        // Entreprise : filtrer sur ses propres candidatures
        if ($user->account_type === 'entreprise') {
            $entreprise = $user->entreprise;
            if (!$entreprise) {
                abort(403, 'Aucun profil entreprise associé.');
            }
            $query->whereHas('candidature.offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            });
        }

        $entretiens = $query->paginate(20);

        return view('admin.entretiens.index', compact('entretiens'));
    }

    public function create()
    {
        $candidatures = Candidature::with(['etudiant', 'offre'])
            ->where('statut', 'accepte')
            ->whereDoesntHave('entretien')
            ->get();

        return view('admin.entretiens.create', compact('candidatures'));
    }

    public function store(EntretienRequest $request)
    {
        Entretien::create($request->validated());

        return redirect()
            ->route('admin.entretiens.index')
            ->with('success', 'Entretien planifié avec succès.');
    }

    public function show(Entretien $entretien)
    {
        $entretien->load(['candidature.etudiant', 'candidature.offre.entreprise']);

        return view('admin.entretiens.show', compact('entretien'));
    }

    public function edit(Entretien $entretien)
    {
        $entretien->load(['candidature.etudiant', 'candidature.offre']);

        return view('admin.entretiens.edit', compact('entretien'));
    }

    public function update(EntretienRequest $request, Entretien $entretien)
    {
        $entretien->update($request->validated());

        return redirect()
            ->route('admin.entretiens.index')
            ->with('success', 'Entretien mis à jour.');
    }

    public function destroy(Entretien $entretien)
    {
        $entretien->delete();

        return redirect()
            ->route('admin.entretiens.index')
            ->with('success', 'Entretien supprimé.');
    }
}
