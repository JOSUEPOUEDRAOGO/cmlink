<?php

namespace App\Http\Controllers\Admin\Recrutement;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationStatusMail;
use App\Models\Entreprise\Entreprise;
use App\Models\Recrutement\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CandidatureController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Candidature::with([
            'etudiant.filiere',
            'offre.entreprise',
            'offre.categorie',
        ]);

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                return redirect()
                    ->route('admin.entreprises.index')
                    ->with('warning', 'Veuillez compléter votre profil entreprise pour voir vos candidatures.');
            }

            $query->whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            });
        }

        $candidatures = $query->latest()->paginate(15);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    public function show(Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $candidature->load([
            'etudiant.filiere',
            'offre.entreprise',
            'offre.categorie',
        ]);

        return view('admin.candidatures.show', compact('candidature'));
    }

    public function updateStatus(Request $request, Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $validated = $request->validate([
            'statut' => ['required', 'in:en_attente,accepte,refuse'],
        ]);

        $oldStatus = $candidature->statut;

        $data = [
            'statut' => $validated['statut'],
        ];

        if (in_array($validated['statut'], ['accepte', 'refuse'])) {
            $data['date_reponse'] = now();
        }

        $candidature->update($data);

        $candidature->load([
            'etudiant',
            'offre.entreprise',
        ]);

        if ($oldStatus !== $validated['statut']) {
            $this->sendStatusEmail($candidature);
        }

        $statusLabels = [
            'en_attente' => 'en attente',
            'accepte' => 'acceptée',
            'refuse' => 'refusée',
        ];

        return back()->with(
            'success',
            'Statut de la candidature mis à jour avec succès : ' . $statusLabels[$validated['statut']]
        );
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $candidature->delete();

        return redirect()
            ->route('admin.candidatures.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }

    public function accept(Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $oldStatus = $candidature->statut;

        $candidature->update([
            'statut' => 'accepte',
            'date_reponse' => now(),
        ]);

        $candidature->load(['etudiant', 'offre.entreprise']);

        if ($oldStatus !== 'accepte') {
            $this->sendStatusEmail($candidature);
        }

        return back()->with('success', 'Candidature acceptée avec succès.');
    }

    public function reject(Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $oldStatus = $candidature->statut;

        $candidature->update([
            'statut' => 'refuse',
            'date_reponse' => now(),
        ]);

        $candidature->load(['etudiant', 'offre.entreprise']);

        if ($oldStatus !== 'refuse') {
            $this->sendStatusEmail($candidature);
        }

        return back()->with('success', 'Candidature refusée.');
    }

    public function pending(Candidature $candidature)
    {
        $this->authorizeCandidatureAccess($candidature);

        $oldStatus = $candidature->statut;

        $candidature->update([
            'statut' => 'en_attente',
            'date_reponse' => null,
        ]);

        $candidature->load(['etudiant', 'offre.entreprise']);

        if ($oldStatus !== 'en_attente') {
            $this->sendStatusEmail($candidature);
        }

        return back()->with('success', 'Candidature remise en attente.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();

        $query = Candidature::with(['etudiant', 'offre.entreprise']);

        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if ($entreprise) {
                $query->whereHas('offre', function ($q) use ($entreprise) {
                    $q->where('entreprise_id', $entreprise->id);
                });
            }
        }

        $candidatures = $query->get();

        $filename = 'candidatures_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w');

        fputcsv($handle, ['ID', 'Étudiant', 'Offre', 'Entreprise', 'Statut', 'Date candidature', 'Date réponse']);

        foreach ($candidatures as $candidature) {
            fputcsv($handle, [
                $candidature->id,
                $candidature->nom
                    ?? $candidature->etudiant?->nom_complet
                    ?? 'N/A',
                $candidature->offre?->titre ?? 'N/A',
                $candidature->offre?->entreprise?->nom ?? 'N/A',
                $candidature->statut,
                $candidature->created_at?->format('d/m/Y'),
                $candidature->date_reponse ? $candidature->date_reponse->format('d/m/Y') : '-',
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function stats()
    {
        $user = Auth::user();

        if ($user->account_type !== 'entreprise') {
            abort(403, 'Seules les entreprises peuvent accéder à ces statistiques.');
        }

        $entreprise = Entreprise::where('user_id', $user->id)->first();

        if (!$entreprise) {
            return redirect()
                ->route('admin.entreprises.index')
                ->with('warning', 'Veuillez compléter votre profil entreprise.');
        }

        $stats = [
            'total' => Candidature::whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })->count(),

            'en_attente' => Candidature::whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })->where('statut', 'en_attente')->count(),

            'accepte' => Candidature::whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })->where('statut', 'accepte')->count(),

            'refuse' => Candidature::whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })->where('statut', 'refuse')->count(),

            'par_offre' => Candidature::whereHas('offre', function ($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })
                ->selectRaw('offre_id, count(*) as total')
                ->groupBy('offre_id')
                ->with('offre')
                ->get(),
        ];

        return view('admin.candidatures.stats', compact('stats'));
    }

    private function sendStatusEmail(Candidature $candidature): void
    {
        $email = $candidature->email ?? $candidature->etudiant?->email;

        if ($email) {
            Mail::to($email)->send(new ApplicationStatusMail($candidature));
        }
    }

    private function authorizeCandidatureAccess(Candidature $candidature): void
    {
        $user = Auth::user();

        if ($user->account_type === 'admin') {
            return;
        }

        if ($user->account_type === 'entreprise') {
            $candidature->loadMissing('offre.entreprise');

            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                abort(403, "Vous n'avez pas de profil entreprise associé à votre compte.");
            }

            if (!$candidature->offre || $candidature->offre->entreprise_id !== $entreprise->id) {
                abort(403, "Vous n'avez pas accès à cette candidature.");
            }

            return;
        }

        abort(403, "Vous n'avez pas les droits nécessaires.");
    }
}
