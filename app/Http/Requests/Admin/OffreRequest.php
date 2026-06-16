<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'titre'                       => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'description'                 => [$isUpdate ? 'sometimes' : 'required', 'string'],
            'type'                        => [$isUpdate ? 'sometimes' : 'required', 'in:stage,emploi'],
            'entreprise_id'               => [$isUpdate ? 'sometimes' : 'required', 'exists:entreprises,id'],
            'categorie_id'                => ['nullable', 'exists:categories,id'],
            'localisation'                => ['nullable', 'string', 'max:255'],
            'date_expiration'             => ['nullable', 'date', 'after:today'],
            'salaire_min'                 => ['nullable', 'integer', 'min:0'],
            'salaire_max'                 => ['nullable', 'integer', 'min:0', 'gte:salaire_min'],
            'niveau_experience'           => ['nullable', 'in:debutant,junior,intermediaire,senior'],
            'teletravail'                 => ['boolean'],
            'nb_postes'                   => [$isUpdate ? 'sometimes' : 'required', 'integer', 'min:1'],
            'competences'                 => ['nullable', 'array'],
            'competences.*.id'            => ['required_with:competences', 'exists:competences,id'],
            'competences.*.niveau_requis' => ['required_with:competences', 'in:debutant,intermediaire,avance,expert'],
            'competences.*.obligatoire'   => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'         => 'Le titre de l\'offre est obligatoire.',
            'description.required'   => 'La description est obligatoire.',
            'type.required'          => 'Le type (stage ou emploi) est obligatoire.',
            'type.in'                => 'Le type doit être stage ou emploi.',
            'entreprise_id.required' => 'L\'entreprise est obligatoire.',
            'entreprise_id.exists'   => 'Cette entreprise n\'existe pas.',
            'date_expiration.after'  => 'La date d\'expiration doit être dans le futur.',
            'salaire_max.gte'        => 'Le salaire max doit être supérieur ou égal au salaire min.',
            'nb_postes.min'          => 'Il doit y avoir au moins 1 poste.',
        ];
    }
}
