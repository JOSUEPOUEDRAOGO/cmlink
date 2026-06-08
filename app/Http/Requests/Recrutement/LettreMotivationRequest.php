<?php

namespace App\Http\Requests\Recrutement;

use Illuminate\Foundation\Http\FormRequest;

class LettreMotivationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->account_type === 'etudiant';
    }

    public function rules(): array
    {
        $rules = [
            'lettre_motivation' => [
                'required',
                'string',
                'min:50',
                'max:2000',
            ],
            'titre' => ['nullable', 'string', 'max:255'], // Titre optionnel
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules['lettre_motivation'][0] = 'sometimes';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'lettre_motivation.required' => 'La lettre de motivation est obligatoire.',
            'lettre_motivation.min' => 'La lettre doit contenir au moins 50 caractères.',
            'lettre_motivation.max' => 'La lettre ne doit pas dépasser 2000 caractères.',
        ];
    }
}
