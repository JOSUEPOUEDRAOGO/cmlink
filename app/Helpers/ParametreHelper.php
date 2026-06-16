<?php

use App\Models\Admin\Parametre;
use Illuminate\Support\Facades\Cache;

if (!function_exists('parametre')) {
    function parametre(string $cle, mixed $defaut = null): mixed
    {
        $parametres = Cache::remember('parametres', 3600, function () {
            return Parametre::pluck('valeur', 'cle')->toArray();
        });

        $valeur = $parametres[$cle] ?? $defaut;

        // Convertir les booléens
        if ($valeur === '1') return true;
        if ($valeur === '0') return false;

        return $valeur;
    }
}
