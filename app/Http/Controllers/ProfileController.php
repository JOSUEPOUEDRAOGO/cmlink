<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $filieres = \App\Models\Academique\Filiere::orderBy('nom')->get();

        return view('profile.edit-professional', [
            'user' => $user,
            'filieres' => $filieres,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Mise à jour des champs de users
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // Mise à jour du mot de passe si fourni
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $user->save();
        }

        // Gestion du téléphone et des données spécifiques
        if ($user->account_type === 'etudiant') {
            $etudiant = $user->etudiant ?? new \App\Models\Academique\Etudiant();
            $etudiant->user_id = $user->id;
            $etudiant->nom = $validated['nom'] ?? null;
            $etudiant->prenom = $validated['prenom'] ?? null;
            $etudiant->telephone = $validated['telephone'] ?? null;
            $etudiant->filiere_id = $validated['filiere_id'] ?? null;
            $etudiant->save();
        }

        if ($user->account_type === 'entreprise') {
            $entreprise = $user->entreprise ?? new \App\Models\Entreprise\Entreprise();
            $entreprise->user_id = $user->id;
            $entreprise->nom = $validated['nom_entreprise'] ?? null;
            $entreprise->adresse = $validated['adresse'] ?? null;
            $entreprise->telephone = $validated['telephone'] ?? null;
            $entreprise->save();
        }

        return Redirect::route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

   public function uploadAvatar(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = $request->user();
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path; // ex: "avatars/123456_abc.jpg"
        $user->save();

        return response()->json(['success' => true, 'path' => asset('storage/' . $path)]);
    }

    return response()->json(['success' => false], 400);
}


    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Supprimer les entités liées
        if ($user->etudiant) $user->etudiant->delete();
        if ($user->entreprise) $user->entreprise->delete();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
