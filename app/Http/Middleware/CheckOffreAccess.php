<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Entreprise\Offre;
use App\Models\Entreprise\Entreprise;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckOffreAccess
{
    /**
     * Liste des méthodes HTTP qui nécessitent une vérification
     */
    protected $protectedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si la méthode nécessite une protection
        if (!in_array($request->method(), $this->protectedMethods)) {
            return $next($request);
        }

        $user = Auth::user();

        // Vérifier l'authentification
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non authentifié.',
                ], 401);
            }

            abort(403, 'Vous devez être connecté pour accéder à cette ressource.');
        }

        // Récupérer l'ID de l'offre (supporte différents noms de paramètre)
        $offreId = $request->route('offre') ?? $request->route('id');

        if (!$offreId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offre non spécifiée.',
                ], 400);
            }

            abort(400, 'Offre non spécifiée.');
        }

        // Récupérer l'offre de manière robuste
        if ($offreId instanceof Offre) {
            $offre = $offreId;
        } elseif ($offreId instanceof Collection) {
            $offre = $offreId->first(fn ($item) => $item instanceof Offre);
        } elseif (is_array($offreId)) {
            $offre = collect($offreId)->first(fn ($item) => $item instanceof Offre);
        } else {
            $offre = Offre::find($offreId);
        }

        if (!$offre || !$offre instanceof Offre) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offre non trouvée.',
                ], 404);
            }

            abort(404, 'Offre non trouvée.');
        }

        $offreEntrepriseId = $offre->getAttribute('entreprise_id');

        // Log pour debug (optionnel)
        Log::info('CheckOffreAccess', [
            'user_id' => $user->id,
            'user_type' => $user->account_type,
            'offre_id' => $offreId,
            'offre_entreprise_id' => $offreEntrepriseId,
        ]);

        // ADMIN : accès total
        if ($user->account_type === 'admin') {
            return $next($request);
        }

        // ENTREPRISE : vérifier que l'offre lui appartient
        if ($user->account_type === 'entreprise') {
            // Récupérer l'entreprise liée à cet utilisateur
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                $error = 'Vous n\'avez pas de profil entreprise associé à votre compte.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $error,
                    ], 403);
                }

                abort(403, $error);
            }

            if ($offreEntrepriseId !== $entreprise->id) {
                $error = 'Vous n\'avez pas accès à cette offre. Vous ne pouvez gérer que vos propres offres.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $error,
                        'offre_id' => $offreId,
                        'votre_entreprise_id' => $entreprise->id,
                        'offre_entreprise_id' => $offreEntrepriseId,
                    ], 403);
                }

                abort(403, $error);
            }

            return $next($request);
        }

        // Les autres types (étudiant, etc.) n'ont pas accès
        $error = 'Vous n\'avez pas les droits nécessaires pour accéder à cette ressource.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $error,
            ], 403);
        }

        abort(403, $error);
    }
}
