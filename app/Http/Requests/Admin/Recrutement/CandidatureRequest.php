<?php

namespace App\Http\Requests\Admin\Recrutement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', Rule::in(['en_attente', 'accepte', 'refuse'])],
        ];
    }

    public function messages(): array
    {
        return [
            'etudiant_id.required' => "L'étudiant est obligatoire.",
            'etudiant_id.exists' => "L'étudiant sélectionné est invalide.",

            'offre_id.required' => "L'offre est obligatoire.",
            'offre_id.exists' => "L'offre sélectionnée est invalide.",

            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut sélectionné est invalide.',
        ];
    }
}
