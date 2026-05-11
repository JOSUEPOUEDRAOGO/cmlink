<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'telephone' => ['nullable', 'string', 'max:20'],
        ];

        if ($user->account_type === 'etudiant') {
            $rules['nom'] = ['nullable', 'string', 'max:100'];
            $rules['prenom'] = ['nullable', 'string', 'max:100'];
            $rules['filiere_id'] = ['nullable', 'exists:filieres,id'];
        }

        if ($user->account_type === 'entreprise') {
            $rules['nom_entreprise'] = ['nullable', 'string', 'max:255'];
            $rules['adresse'] = ['nullable', 'string', 'max:500'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom complet est requis.',
            'email.required' => 'L\'adresse email est requise.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation ne correspond pas.',
        ];
    }
}