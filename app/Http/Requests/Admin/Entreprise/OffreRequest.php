<?php

namespace App\Http\Requests\Admin\Entreprise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'titre' => trim((string) $this->titre),
            'description' => trim((string) $this->description),
            'localisation' => $this->localisation ? trim((string) $this->localisation) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', Rule::in(['stage', 'emploi'])],
            'entreprise_id' => ['required', 'integer', 'exists:entreprises,id'],
            'categorie_id' => ['nullable', 'integer', 'exists:categories,id'],
            'localisation' => ['nullable', 'string', 'max:150'],
            'date_expiration' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => "Le titre de l'offre est obligatoire.",
            'titre.max' => "Le titre de l'offre ne doit pas dépasser 255 caractères.",

            'description.required' => 'La description est obligatoire.',

            'type.required' => "Le type d'offre est obligatoire.",
            'type.in' => "Le type d'offre doit être stage ou emploi.",

            'entreprise_id.required' => "L'entreprise est obligatoire.",
            'entreprise_id.exists' => "L'entreprise sélectionnée est invalide.",

            'categorie_id.exists' => 'La catégorie sélectionnée est invalide.',

            'localisation.max' => 'La localisation ne doit pas dépasser 150 caractères.',

            'date_expiration.date' => "La date d'expiration doit être une date valide.",
            'date_expiration.after_or_equal' => "La date d'expiration doit être aujourd'hui ou plus tard.",
        ];
    }
}
