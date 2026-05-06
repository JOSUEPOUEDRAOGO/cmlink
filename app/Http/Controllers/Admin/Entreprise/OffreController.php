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
        $query = Offre::with(['entreprise', 'categorie']);

        if (auth()->user()->account_type === 'entreprise') {
            $query->whereHas('entreprise', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        $offres = $query->latest()->paginate(15);

        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        $entreprises = $this->getAllowedEntreprises();
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
        $this->authorizeEntrepriseAccess($offre);

        $offre->load([
            'entreprise',
            'categorie',
            'candidatures.etudiant',
        ]);

        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $this->authorizeEntrepriseAccess($offre);

        $entreprises = $this->getAllowedEntreprises();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.offres.edit', compact('offre', 'entreprises', 'categories'));
    }

    public function update(OffreRequest $request, Offre $offre)
    {
        $this->authorizeEntrepriseAccess($offre);

        $offre->update($request->validated());

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre mise à jour avec succès.');
    }

    public function destroy(Offre $offre)
    {
        $this->authorizeEntrepriseAccess($offre);

        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre supprimée avec succès.');
    }

    private function getAllowedEntreprises()
    {
        if (auth()->user()->account_type === 'entreprise') {
            return Entreprise::where('user_id', auth()->id())
                ->orderBy('nom')
                ->get();
        }

        return Entreprise::orderBy('nom')->get();
    }

    private function authorizeEntrepriseAccess(Offre $offre): void
    {
        if (auth()->user()->account_type !== 'entreprise') {
            return;
        }

        $offre->loadMissing('entreprise');

        if (!$offre->entreprise || $offre->entreprise->user_id !== auth()->id()) {
            abort(403, "Vous n'avez pas accès à cette offre.");
        }
    }
}
