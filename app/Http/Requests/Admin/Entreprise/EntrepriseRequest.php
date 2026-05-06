<?php

namespace App\Http\Requests\Admin\Entreprise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntrepriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nom' => trim((string) $this->nom),
            'email' => strtolower(trim((string) $this->email)),
            'telephone' => $this->telephone ? trim((string) $this->telephone) : null,
            'adresse' => $this->adresse ? trim((string) $this->adresse) : null,
        ]);
    }

    public function rules(): array
    {
        $entreprise = $this->route('entreprise');
        $entrepriseId = is_object($entreprise) ? $entreprise->id : $entreprise;

        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'nom' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('entreprises', 'email')->ignore($entrepriseId),
            ],
            'telephone' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => "Le nom de l'entreprise est obligatoire.",
            'nom.max' => "Le nom de l'entreprise ne doit pas dépasser 150 caractères.",

            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être valide.",
            'email.unique' => "Cet email d'entreprise existe déjà.",

            'telephone.max' => 'Le téléphone ne doit pas dépasser 30 caractères.',
            'adresse.max' => "L'adresse ne doit pas dépasser 255 caractères.",
        ];
    }
}
