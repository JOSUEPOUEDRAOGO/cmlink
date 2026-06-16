<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EntretienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'candidature_id' => [$isUpdate ? 'sometimes' : 'required', 'exists:candidatures,id'],
            'date_rdv'       => [$isUpdate ? 'sometimes' : 'required', 'date', 'after:now'],
            'type'           => [$isUpdate ? 'sometimes' : 'required', 'in:presentiel,visio,telephonique'],
            'statut'         => [$isUpdate ? 'sometimes' : 'required', 'in:planifie,confirme,annule,effectue'],
            'lien_visio'     => ['nullable', 'url', 'required_if:type,visio'],
            'adresse'        => ['nullable', 'string', 'max:255', 'required_if:type,presentiel'],
            'notes'          => ['nullable', 'string'],
            'resultat'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'candidature_id.required' => 'La candidature est obligatoire.',
            'candidature_id.exists'   => 'Cette candidature n\'existe pas.',
            'date_rdv.required'       => 'La date du rendez-vous est obligatoire.',
            'date_rdv.after'          => 'La date doit être dans le futur.',
            'type.required'           => 'Le type d\'entretien est obligatoire.',
            'type.in'                 => 'Le type doit être présentiel, visio ou téléphonique.',
            'statut.in'               => 'Statut invalide.',
            'lien_visio.required_if'  => 'Le lien visio est obligatoire pour un entretien en visio.',
            'lien_visio.url'          => 'Le lien visio doit être une URL valide.',
            'adresse.required_if'     => 'L\'adresse est obligatoire pour un entretien en présentiel.',
        ];
    }
}
