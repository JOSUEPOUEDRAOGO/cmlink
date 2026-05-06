<?php

namespace App\Http\Requests\Admin\Academique;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EtudiantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nom' => trim((string) $this->nom),
            'prenom' => trim((string) $this->prenom),
            'email' => strtolower(trim((string) $this->email)),
            'telephone' => $this->telephone ? trim((string) $this->telephone) : null,
        ]);
    }

    public function rules(): array
    {
        $etudiant = $this->route('etudiant');
        $etudiantId = is_object($etudiant) ? $etudiant->id : $etudiant;

        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('etudiants', 'email')->ignore($etudiantId),
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
            'filiere_id' => ['required', 'integer', 'exists:filieres,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 100 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 100 caractères.',

            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être valide.",
            'email.max' => "L'email ne doit pas dépasser 150 caractères.",
            'email.unique' => 'Cet email existe déjà.',

            'telephone.max' => 'Le téléphone ne doit pas dépasser 30 caractères.',

            'filiere_id.required' => 'La filière est obligatoire.',
            'filiere_id.exists' => 'La filière sélectionnée est invalide.',
        ];
    }
}
