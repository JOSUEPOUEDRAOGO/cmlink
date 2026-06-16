<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ParametreController extends Controller
{
    public function index()
    {
        $groupes = Parametre::orderBy('groupe')->orderBy('label')
            ->get()
            ->groupBy('groupe');

        return view('admin.parametres.index', compact('groupes'));
    }

    public function update(Request $request)
    {
        $parametres = $request->input('parametres', []);

        foreach ($parametres as $cle => $valeur) {
            $parametre = Parametre::where('cle', $cle)->first();

            if (!$parametre || $parametre->is_locked) continue;

            // Convertir les booléens
            if ($parametre->type === 'boolean') {
                $valeur = $valeur ? '1' : '0';
            }

            $parametre->update(['valeur' => $valeur]);
        }

        // Gérer les booléens non cochés (non envoyés par le form)
        $tousLesCles = $request->input('all_cles', []);
        foreach ($tousLesCles as $cle) {
            if (!array_key_exists($cle, $parametres)) {
                $parametre = Parametre::where('cle', $cle)
                    ->where('type', 'boolean')
                    ->where('is_locked', false)
                    ->first();
                if ($parametre) {
                    $parametre->update(['valeur' => '0']);
                }
            }
        }

        Cache::forget('parametres');

        return redirect()
            ->route('admin.parametres.index')
            ->with('success', 'Paramètres enregistrés avec succès.');
    }

    public function toggleMaintenance()
    {
        $p = Parametre::where('cle', 'mode_maintenance')->first();
        if ($p) {
            $p->update(['valeur' => $p->valeur === '1' ? '0' : '1']);
        }

        Cache::forget('parametres');

        $msg = $p->valeur === '1'
            ? 'Mode maintenance activé.'
            : 'Mode maintenance désactivé.';

        return redirect()
            ->route('admin.parametres.index')
            ->with('success', $msg);
    }
}
