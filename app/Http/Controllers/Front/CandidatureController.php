<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CandidatureController extends Controller
{
    public function create(Offre $offre)
    {
        return view('front.offres.apply', compact('offre'));
    }

    public function store(Request $request, Offre $offre)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:3000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);

        $cvPath = $request->file('cv')->store('candidatures/cv', 'public');

        $candidature = Candidature::create([
            'offre_id' => $offre->id,
            'etudiant_id' => null,
            'statut' => 'en_attente',
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'message' => $validated['message'] ?? null,
            'cv_path' => $cvPath,
        ]);

        return redirect()
            ->route('front.offres.show', $offre)
            ->with('success', 'Votre candidature a été envoyée avec succès.');
    }
}
