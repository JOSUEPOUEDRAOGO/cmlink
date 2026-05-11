<?php

namespace App\Http\Controllers\Admin\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Entreprise\OffreRequest;
use App\Models\Entreprise\Entreprise;
use App\Models\Entreprise\Offre;
use App\Models\Referentiel\Categorie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffreController extends Controller
{
    /**
     * Affiche la liste des offres
     * - Admin : voit toutes les offres
     * - Entreprise : voit uniquement ses propres offres
     */
    public function index()
    {
        $user = Auth::user();
        $query = Offre::with(['entreprise', 'categorie']);

        // Filtrer pour les entreprises : uniquement leurs offres
        if ($user->account_type === 'entreprise') {
            // Récupérer l'ID de l'entreprise liée à cet utilisateur
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise avant de gérer vos offres.');
            }

            $query->where('entreprise_id', $entreprise->id);
        }

        $offres = $query->latest()->paginate(15);

        return view('admin.offres.index', compact('offres'));
    }

    /**
     * Affiche le formulaire de création d'offre
     */
    public function create()
    {
        $user = Auth::user();
        $categories = Categorie::orderBy('nom')->get();

        // Pour les entreprises : récupérer automatiquement leur entreprise
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise avant de créer une offre.');
            }

            $entreprises = collect([$entreprise]); // Une seule entreprise possible
        } else {
            // Admin : voit toutes les entreprises
            $entreprises = Entreprise::orderBy('nom')->get();
        }

        return view('admin.offres.create', compact('entreprises', 'categories'));
    }

    /**
     * Enregistre une nouvelle offre
     */
    public function store(OffreRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        // Sécuriser l'entreprise_id pour les entreprises
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return back()
                    ->withInput()
                    ->with('error', 'Profil entreprise non trouvé.');
            }

            // Forcer l'entreprise_id à celle de l'utilisateur connecté
            $validated['entreprise_id'] = $entreprise->id;
        }

        // Vérifier que l'entreprise existe
        if (!isset($validated['entreprise_id'])) {
            return back()
                ->withInput()
                ->with('error', 'Veuillez sélectionner une entreprise.');
        }

        // Ajouter l'user_id (optionnel, selon ta structure)
        $validated['user_id'] = $user->id;
        $validated['status'] = $validated['status'] ?? 'active';

        $offre = Offre::create($validated);

        return redirect()
            ->route('admin.offres.index')
            ->with('success', "L'offre \"{$offre->titre}\" a été créée avec succès.");
    }

    /**
     * Affiche les détails d'une offre
     */
    public function show(Offre $offre)
    {
        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $offre->load([
            'entreprise',
            'categorie',
            'candidatures' => function ($query) {
                $query->latest()->with('etudiant');
            },
        ]);

        return view('admin.offres.show', compact('offre'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Offre $offre)
    {
        $user = Auth::user();

        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $categories = Categorie::orderBy('nom')->get();

        // Pour les entreprises : récupérer automatiquement leur entreprise
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.edit', ['entreprise' => $user->id])
                    ->with('warning', 'Veuillez compléter votre profil entreprise.');
            }

            $entreprises = collect([$entreprise]);
        } else {
            // Admin : voit toutes les entreprises
            $entreprises = Entreprise::orderBy('nom')->get();
        }

        return view('admin.offres.edit', compact('offre', 'entreprises', 'categories'));
    }

    /**
     * Met à jour une offre
     */
    public function update(OffreRequest $request, Offre $offre)
    {
        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $user = Auth::user();
        $validated = $request->validated();

        // Sécuriser l'entreprise_id pour les entreprises
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if ($entreprise) {
                // Impossible de changer l'entreprise_id
                $validated['entreprise_id'] = $entreprise->id;
            }
        }

        $offre->update($validated);

        return redirect()
            ->route('admin.offres.index')
            ->with('success', "L'offre \"{$offre->titre}\" a été mise à jour avec succès.");
    }

    /**
     * Supprime une offre
     */
    public function destroy(Offre $offre)
    {
        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $titre = $offre->titre;
        $offre->delete();

        return redirect()
            ->route('admin.offres.index')
            ->with('success', "L'offre \"{$titre}\" a été supprimée avec succès.");
    }

    /**
     * Duplique une offre (pratique pour créer des offres similaires)
     */
    public function duplicate(Offre $offre)
    {
        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $nouvelleOffre = $offre->replicate();
        $nouvelleOffre->titre = $offre->titre . ' (Copie)';
        $nouvelleOffre->created_at = now();
        $nouvelleOffre->save();

        return redirect()
            ->route('admin.offres.edit', $nouvelleOffre)
            ->with('success', 'Offre dupliquée avec succès. Veuillez modifier les informations nécessaires.');
    }

    /**
     * Change le statut d'une offre (active/fermée/archivée)
     */
    public function changeStatus(Offre $offre, string $status)
    {
        // Vérifier les droits d'accès
        $this->authorizeOffreAccess($offre);

        $validStatuses = ['active', 'closed', 'archived'];

        if (!in_array($status, $validStatuses)) {
            return redirect()
                ->back()
                ->with('error', 'Statut invalide.');
        }

        $offre->update(['status' => $status]);

        $statusLabels = [
            'active' => 'activée',
            'closed' => 'fermée',
            'archived' => 'archivée',
        ];

        return redirect()
            ->back()
            ->with('success', "L'offre a été {$statusLabels[$status]} avec succès.");
    }

    /**
     * Réinitialise le compteur de vues (optionnel)
     */
    public function resetViews(Offre $offre)
    {
        $this->authorizeOffreAccess($offre);

        $offre->update(['views_count' => 0]);

        return redirect()
            ->back()
            ->with('success', 'Le compteur de vues a été réinitialisé.');
    }

    /**
     * Récupère la liste des entreprises autorisées pour l'utilisateur connecté
     */
    private function getAllowedEntreprises()
    {
        $user = Auth::user();

        if ($user->account_type === 'entreprise') {
            return Entreprise::where('user_id', $user->id)
                ->orderBy('nom')
                ->get();
        }

        return Entreprise::orderBy('nom')->get();
    }

    /**
     * Vérifie qu'une entreprise a le droit d'accéder à une offre
     * - Admin : accès total (passe sans vérification)
     * - Entreprise : accès uniquement si l'offre lui appartient
     */
    private function authorizeOffreAccess(Offre $offre): void
    {
        $user = Auth::user();

        // Admin a accès à tout
        if ($user->account_type === 'admin') {
            return;
        }

        // Pour les entreprises, vérifier l'appartenance
        if ($user->account_type === 'entreprise') {
            // Charger la relation entreprise si pas déjà fait
            if (!$offre->relationLoaded('entreprise')) {
                $offre->load('entreprise');
            }

            // Récupérer l'ID de l'entreprise de l'utilisateur
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                abort(403, "Vous n'avez pas de profil entreprise associé à votre compte.");
            }

            if (!$offre->entreprise || $offre->entreprise_id !== $entreprise->id) {
                abort(403, "Vous n'avez pas accès à cette offre. Vous ne pouvez voir et gérer que vos propres offres.");
            }

            return;
        }

        // Autres types de comptes (étudiant, etc.) n'ont pas accès
        abort(403, "Vous n'avez pas les droits nécessaires pour accéder à cette ressource.");
    }
}
