<?php

namespace App\Http\Controllers\Admin\Entreprise;

use App\Events\NouvelleOffrePubliee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Entreprise\OffreRequest;
use App\Models\Competence;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Referentiel\Categorie;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = Offre::with(['entreprise', 'categorie', 'competences'])
            ->withCount('candidatures');

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise avant de gérer vos offres.');
            }

            $query->where('entreprise_id', $entreprise->id);
        }

        // Filtres
        if (request()->filled('q')) {
            $q = request('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('titre', 'like', "%{$q}%")
                    ->orWhereHas('entreprise', fn ($e) => $e->where('nom', 'like', "%{$q}%"));
            });
        }

        if (request()->filled('type')) {
            $query->where('type', request('type'));
        }

        if (request()->filled('teletravail')) {
            $query->where('teletravail', request('teletravail'));
        }

        if (request()->filled('statut')) {
            if (request('statut') === 'actif') {
                $query->where(function ($sub) {
                    $sub->whereNull('date_expiration')
                        ->orWhere('date_expiration', '>=', now());
                });
            } elseif (request('statut') === 'expire') {
                $query->where('date_expiration', '<', now());
            }
        }

        $offres = $query->latest()->paginate(15)->withQueryString();

        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        $user        = Auth::user();
        $categories  = Categorie::orderBy('nom')->get();
        $competences = Competence::orderBy('nom')->get();

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise avant de créer une offre.');
            }

            $entreprises         = collect([$entreprise]);
            $entrepriseConnectee = $entreprise;
        } else {
            $entreprises         = Entreprise::orderBy('nom')->get();
            $entrepriseConnectee = null;
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
        $user      = Auth::user();
        $validated = $request->validated();

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return back()->withInput()->with('error', 'Profil entreprise non trouvé.');
            }

            $validated['entreprise_id'] = $entreprise->id;
        }

        if (!isset($validated['entreprise_id'])) {
            return back()->withInput()->with('error', 'Veuillez sélectionner une entreprise.');
        }

        $offre = Offre::create(
            collect($validated)->except('competences')->toArray()
        );

        // Sync compétences
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

        // ← Déclencher la notification temps réel
        broadcast(new NouvelleOffrePubliee($offre));

        return redirect()
            ->route('admin.offres.index')
            ->with('success', "L'offre \"{$offre->titre}\" a été créée avec succès.");
    }

    public function show(Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $offre->load([
            'entreprise',
            'categorie',
            'competences',
            'candidatures' => function ($query) {
                $query->latest()->with('etudiant');
            },
        ]);

        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $user = Auth::user();

        $this->authorizeOffreAccess($offre);

        $offre->load('competences');

        $categories  = Categorie::orderBy('nom')->get();
        $competences = Competence::orderBy('nom')->get();

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise.');
            }

            $entreprises         = collect([$entreprise]);
            $entrepriseConnectee = $entreprise;
        } else {
            $entreprises         = Entreprise::orderBy('nom')->get();
            $entrepriseConnectee = null;
        }

        return view('admin.offres.edit', compact(
            'offre',
            'entreprises',
            'categories',
            'competences',
            'entrepriseConnectee'
        ));
    }

    public function update(OffreRequest $request, Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $user      = Auth::user();
        $validated = $request->validated();

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();
            if ($entreprise) {
                $validated['entreprise_id'] = $entreprise->id;
            }
        }

        $offre->update(
            collect($validated)->except('competences')->toArray()
        );

        // Sync compétences
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
            ->with('success', "L'offre \"{$offre->titre}\" a été mise à jour avec succès.");
    }

    public function destroy(Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $titre = $offre->titre;
        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', "L'offre \"{$titre}\" a été supprimée avec succès.");
    }

    public function duplicate(Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $nouvelleOffre         = $offre->replicate();
        $nouvelleOffre->titre  = $offre->titre . ' (Copie)';
        $nouvelleOffre->created_at = now();
        $nouvelleOffre->save();

        return redirect()
            ->route('admin.offres.edit', $nouvelleOffre)
            ->with('success', 'Offre dupliquée avec succès.');
    }

    public function changeStatus(Offre $offre, string $status)
    {
        $this->authorizeOffreAccess($offre);

        $validStatuses = ['active', 'closed', 'archived'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Statut invalide.');
        }

        $offre->update(['status' => $status]);

        $statusLabels = [
            'active'   => 'activée',
            'closed'   => 'fermée',
            'archived' => 'archivée',
        ];

        return redirect()->back()
            ->with('success', "L'offre a été {$statusLabels[$status]} avec succès.");
    }

    public function resetViews(Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $offre->update(['views_count' => 0]);

        return redirect()->back()
            ->with('success', 'Le compteur de vues a été réinitialisé.');
    }

    private function authorizeOffreAccess(Offre $offre): void
    {
        $user = Auth::user();

        if ($user->account_type === 'admin') return;

        if ($user->account_type === 'entreprise') {
            if (!$offre->relationLoaded('entreprise')) {
                $offre->load('entreprise');
            }

            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                abort(403, "Vous n'avez pas de profil entreprise associé à votre compte.");
            }

            if (!$offre->entreprise || $offre->entreprise_id !== $entreprise->id) {
                abort(403, "Vous n'avez pas accès à cette offre.");
            }

            return;
        }

        abort(403, "Vous n'avez pas les droits nécessaires.");
    }
}
