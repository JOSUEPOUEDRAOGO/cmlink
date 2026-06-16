<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AlerteOffre;
use App\Models\Referentiel\Categorie;
use Illuminate\Http\Request;

class AlerteOffreController extends Controller
{
    public function index()
    {
        $alerte     = AlerteOffre::where('user_id', auth()->id())->first();
        $categories = Categorie::orderBy('nom')->get();

        return view('front.alertes.index', compact('alerte', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'toutes_categories' => ['boolean'],
            'categories_ids'    => ['nullable', 'array'],
            'categories_ids.*'  => ['exists:categories,id'],
            'type_offre'        => ['required', 'in:stage,emploi,les_deux'],
        ]);

        AlerteOffre::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'toutes_categories' => $request->boolean('toutes_categories'),
                'categories_ids'    => $request->boolean('toutes_categories')
                    ? null
                    : ($validated['categories_ids'] ?? []),
                'type_offre'        => $validated['type_offre'],
                'active'            => true,
            ]
        );

        return redirect()->back()->with('success', 'Vos alertes ont été enregistrées.');
    }

    public function toggle()
    {
        $alerte = AlerteOffre::where('user_id', auth()->id())->first();

        if ($alerte) {
            $alerte->update(['active' => !$alerte->active]);
            $msg = $alerte->active
                ? 'Alertes activées.'
                : 'Alertes désactivées.';
        } else {
            AlerteOffre::create([
                'user_id'           => auth()->id(),
                'toutes_categories' => true,
                'type_offre'        => 'les_deux',
                'active'            => true,
            ]);
            $msg = 'Alertes activées.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function destroy()
    {
        AlerteOffre::where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'Alertes supprimées.');
    }
}
