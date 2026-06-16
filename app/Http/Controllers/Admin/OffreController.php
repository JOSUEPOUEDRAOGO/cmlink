<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OffreRequest;
use App\Models\Competence;
use App\Models\Entreprise\Offre;
use App\Models\Entreprise\Entreprise;
use App\Models\Referentiel\Categorie;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::with(['entreprise', 'categorie', 'competences'])
            ->withCount('candidatures');

        // Recherche titre ou entreprise
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('titre', 'like', "%{$q}%")
                    ->orWhereHas('entreprise', fn ($e) => $e->where('nom', 'like', "%{$q}%"));
            });
        }

        // Filtre type (stage / emploi)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre télétravail
        if ($request->filled('teletravail')) {
            $query->where('teletravail', $request->teletravail);
        }

        // Filtre statut (actif / expiré)
        if ($request->filled('statut')) {
            if ($request->statut === 'actif') {
                $query->where(function ($sub) {
                    $sub->whereNull('date_expiration')
                        ->orWhere('date_expiration', '>=', now());
                });
            } elseif ($request->statut === 'expire') {
                $query->where('date_expiration', '<', now());
            }
        }

        $offres = $query->latest()->paginate(20)->withQueryString();

        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        $entreprises = Entreprise::orderBy('nom')->get();
        $categories  = Categorie::orderBy('nom')->get();
        $competences = Competence::orderBy('nom')->get();

        // Si c'est une entreprise connectée, pré-sélectionner la sienne
        $entrepriseConnectee = null;
        if (auth()->user()->account_type === 'entreprise') {
            $entrepriseConnectee = auth()->user()->entreprise;
        }

        return view('admin.offres.create', compact(
            'entreprises',
            'categories',
            'competences',
            'entrepriseConnectee'
        ));
    }

    public function store(OffreRequest $request)
    {
        $offre = Offre::create($request->safe()->except('competences'));

        if ($request->filled('competences')) {
            $pivot = collect($request->competences)
                ->filter(fn ($c) => !empty($c['id']))
                ->mapWithKeys(fn ($c) => [
                    $c['id'] => [
                        'niveau_requis' => $c['niveau_requis'],
                        'obligatoire'   => isset($c['obligatoire']) ? (bool) $c['obligatoire'] : true,
                    ],
                ]);
            $offre->competences()->sync($pivot);
        }

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre créée avec succès.');
    }

    public function show(Offre $offre)
    {
        $offre->load([
            'entreprise',
            'categorie',
            'competences',
            'candidatures.etudiant',
        ]);

        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $offre->load('competences');

        $entreprises = Entreprise::orderBy('nom')->get();
        $categories  = Categorie::orderBy('nom')->get();
        $competences = Competence::orderBy('nom')->get();

        return view('admin.offres.edit', compact(
            'offre',
            'entreprises',
            'categories',
            'competences'
        ));
    }

    public function update(OffreRequest $request, Offre $offre)
    {
        $offre->update($request->safe()->except('competences'));

        $pivot = collect($request->competences ?? [])
            ->filter(fn ($c) => !empty($c['id']))
            ->mapWithKeys(fn ($c) => [
                $c['id'] => [
                    'niveau_requis' => $c['niveau_requis'],
                    'obligatoire'   => isset($c['obligatoire']) ? (bool) $c['obligatoire'] : true,
                ],
            ]);

        $offre->competences()->sync($pivot);

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre mise à jour.');
    }

    public function destroy(Offre $offre)
    {
        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', 'Offre supprimée.');
    }
}
