<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Recrutement\Candidature;
use App\Models\Entreprise\Entreprise;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCandidatureAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est connecté
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez être connecté pour accéder à cette ressource.',
                ], 401);
            }
            abort(403, 'Vous devez être connecté pour accéder à cette ressource.');
        }

        // ADMIN : accès total à toutes les candidatures
        if ($user->account_type === 'admin') {
            return $next($request);
        }

        // Récupérer l'ID de la candidature depuis les paramètres de route
        $candidatureId = $request->route('candidature');

        if (!$candidatureId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidature non spécifiée.',
                ], 400);
            }
            abort(400, 'Candidature non spécifiée.');
        }

        // Récupérer la candidature avec ses relations
        $candidature = Candidature::with('offre.entreprise')->find($candidatureId);

        if (!$candidature) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidature non trouvée.',
                ], 404);
            }
            abort(404, 'Candidature non trouvée.');
        }

        // ENTREPRISE : vérifier que la candidature concerne une de ses offres
        if ($user->account_type === 'entreprise') {
            // Récupérer l'entreprise liée à cet utilisateur
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous n\'avez pas de profil entreprise associé à votre compte.',
                    ], 403);
                }
                abort(403, 'Vous n\'avez pas de profil entreprise associé à votre compte.');
            }

            // Vérifier que l'offre de la candidature appartient à cette entreprise
            if (!$candidature->offre || $candidature->offre->entreprise_id !== $entreprise->id) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous n\'avez pas accès à cette candidature. Vous ne pouvez voir que les candidatures de vos propres offres.',
                        'candidature_id' => $candidatureId,
                        'votre_entreprise_id' => $entreprise->id,
                        'offre_entreprise_id' => $candidature->offre->entreprise_id ?? null,
                    ], 403);
                }
                abort(403, 'Vous n\'avez pas accès à cette candidature. Vous ne pouvez voir que les candidatures de vos propres offres.');
            }

            return $next($request);
        }

        // Les autres types (étudiant, etc.) n'ont pas accès
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'avez pas les droits nécessaires pour accéder à cette ressource.',
            ], 403);
        }
        abort(403, 'Vous n\'avez pas les droits nécessaires pour accéder à cette ressource.');
    }
}
