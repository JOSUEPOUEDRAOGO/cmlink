<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        if ($isUpdate) {
            return [
                'statut'               => ['required', 'in:en_attente,accepte,refuse'],
                'lettre_motivation_id' => ['nullable', 'exists:lettre_motivations,id'],
            ];
        }

        return [
            'nom'                  => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255'],
            'telephone'            => ['nullable', 'string', 'max:20'],
            'message'              => ['nullable', 'string'],
            'cv_path'              => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'lettre_motivation_id' => ['nullable', 'exists:lettre_motivations,id'],
            'offre_id'             => ['required', 'exists:offres,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'                => 'Le nom est obligatoire.',
            'email.required'              => 'L\'email est obligatoire.',
            'email.email'                 => 'L\'email n\'est pas valide.',
            'offre_id.required'           => 'L\'offre est obligatoire.',
            'offre_id.exists'             => 'Cette offre n\'existe pas.',
            'cv_path.mimes'               => 'Le CV doit être un fichier PDF.',
            'cv_path.max'                 => 'Le CV ne doit pas dépasser 5 Mo.',
            'statut.required'             => 'Le statut est obligatoire.',
            'statut.in'                   => 'Le statut doit être en_attente, accepte ou refuse.',
            'lettre_motivation_id.exists' => 'Cette lettre de motivation n\'existe pas.',
        ];
    }
}
