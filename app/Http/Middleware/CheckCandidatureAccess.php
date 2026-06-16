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
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Vous devez être connecté.');
        }

        // Admin : accès total
        if ($user->account_type === 'admin') {
            return $next($request);
        }

        // Récupérer la candidature — gère route model binding ET ID brut
        $routeParam = $request->route('candidature');

        if ($routeParam instanceof Candidature) {
            // Laravel a déjà résolu le modèle via route model binding
            $candidature = $routeParam;
            $candidature->loadMissing('offre.entreprise');
        } elseif (is_numeric($routeParam)) {
            // C'est un ID brut
            $candidature = Candidature::with('offre.entreprise')->find($routeParam);
        } else {
            abort(400, 'Candidature non spécifiée.');
        }

        if (!$candidature) {
            abort(404, 'Candidature non trouvée.');
        }

        // Entreprise : vérifier que la candidature concerne une de ses offres
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();

            if (!$entreprise) {
                abort(403, 'Vous n\'avez pas de profil entreprise associé à votre compte.');
            }

            if (!$candidature->offre || $candidature->offre->entreprise_id !== $entreprise->id) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success'             => false,
                        'message'             => 'Vous n\'avez pas accès à cette candidature.',
                        'candidature_id'      => $candidature->id,
                        'votre_entreprise_id' => $entreprise->id,
                        'offre_entreprise_id' => $candidature->offre?->entreprise_id,
                    ], 403);
                }
                abort(403, 'Vous n\'avez pas accès à cette candidature.');
            }

            return $next($request);
        }

        // Autres rôles : accès refusé
        abort(403, 'Vous n\'avez pas les droits nécessaires.');
    }
}
