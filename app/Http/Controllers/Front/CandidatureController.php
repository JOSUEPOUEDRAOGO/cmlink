<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\NewApplicationMail;
use App\Mail\ApplicationReceivedMail;
use App\Models\Entreprise\Offre;
use App\Models\Recrutement\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CandidatureController extends Controller
{
    public function create(Offre $offre)
    {
        $offre->load(['entreprise', 'categorie', 'competences']);

        return view('front.offres.apply', compact('offre'));
    }

    public function store(Request $request, Offre $offre)
    {
        $utiliseCvPrincipal = $request->boolean('utiliser_cv_principal');
        $etudiant = auth()->user()?->etudiant;

        $validated = $request->validate([
            'nom'                  => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255'],
            'telephone'            => ['nullable', 'string', 'max:50'],
            'message'              => ['nullable', 'string', 'max:3000'],
            'lettre_motivation_id' => ['nullable', 'exists:lettre_motivations,id'],
            'cv_path'              => [
                $utiliseCvPrincipal ? 'nullable' : 'required',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
        ], [
            'cv_path.required' => 'Veuillez uploader un CV ou cocher "Utiliser mon CV principal".',
            'cv_path.mimes'    => 'Le CV doit être un fichier PDF.',
            'cv_path.max'      => 'Le CV ne doit pas dépasser 5 Mo.',
        ]);

        // Déterminer le chemin du CV
        if ($utiliseCvPrincipal && $etudiant?->cvPrincipal) {
            $cvPath = $etudiant->cvPrincipal->cv_path;
        } else {
            $cvPath = $request->file('cv_path')->store('candidatures/cv', 'public');
        }

        $candidature = Candidature::create([
            'offre_id'             => $offre->id,
            'etudiant_id'          => $etudiant?->id,
            'statut'               => 'en_attente',
            'nom'                  => $validated['nom'],
            'email'                => $validated['email'],
            'telephone'            => $validated['telephone'] ?? null,
            'message'              => $validated['message'] ?? null,
            'cv_path'              => $cvPath,
            'lettre_motivation_id' => $validated['lettre_motivation_id'] ?? null,
        ]);
        $candidature->load(['offre.entreprise', 'offre.categorie']);

        $entreprise = $candidature->offre?->entreprise;
        if ($entreprise && !empty($entreprise->email)) {
            Mail::to($entreprise->email)->send(new NewApplicationMail($candidature));
        }

        Mail::to($candidature->email)->send(new ApplicationReceivedMail($candidature));
        return redirect()
            ->route('front.offres.show', $offre)
            ->with('success', 'Votre candidature a été envoyée avec succès.');
    }
}
