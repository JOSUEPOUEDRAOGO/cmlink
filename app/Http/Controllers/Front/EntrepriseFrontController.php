<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Entreprise\Entreprise;
use Illuminate\Http\Request;

class EntrepriseFrontController extends Controller
{
    public function index(Request $request)
    {
        $query = Entreprise::withCount('offres')->latest();

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%");
            });
        }

        $entreprises = $query->paginate(9)->withQueryString();

        return view('front.entreprises.index', compact('entreprises'));
    }

    public function show(Entreprise $entreprise)
    {
        $entreprise->load('offres.categorie');

        return view('front.entreprises.show', compact('entreprise'));
    }
}
