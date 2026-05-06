<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Academique\Etudiant;
use App\Models\Entreprise\Entreprise;
use App\Models\Academique\Filiere;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        $type = $request->query('type', 'etudiant');

        if (!in_array($type, ['etudiant', 'entreprise'])) {
            $type = 'etudiant';
        }

        $filieres = Filiere::orderBy('nom')->get();

        return view('auth.register', compact('type', 'filieres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $type = $request->input('account_type', 'etudiant');

        if (!in_array($type, ['etudiant', 'entreprise'])) {
            throw ValidationException::withMessages([
                'account_type' => 'Type de compte invalide.',
            ]);
        }

        $rules = [
            'account_type' => ['required', 'in:etudiant,entreprise'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telephone' => ['nullable', 'string', 'max:50'],
        ];

        if ($type === 'etudiant') {
            $rules = array_merge($rules, [
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'filiere_id' => ['required', 'exists:filieres,id'],
            ]);
        }

        if ($type === 'entreprise') {
            $rules = array_merge($rules, [
                'nom_entreprise' => ['required', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
            ]);
        }

        $validated = $request->validate($rules);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'account_type' => $validated['account_type'],
            'status' => 'en_attente',
        ]);

        if ($type === 'etudiant') {
            Etudiant::create([
                'user_id' => $user->id,
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? null,
                'filiere_id' => $validated['filiere_id'],
            ]);

            $user->assignRole('etudiant');
        }

        if ($type === 'entreprise') {
            Entreprise::create([
                'user_id' => $user->id,
                'nom' => $validated['nom_entreprise'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? null,
                'adresse' => $validated['adresse'] ?? null,
            ]);

            $user->assignRole('entreprise');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()
            ->route('front.home')
            ->with('success', 'Votre compte a été créé. Il est en attente de validation par l’administration.');
    }
}
