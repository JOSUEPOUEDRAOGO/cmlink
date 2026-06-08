<?php

namespace App\Http\Requests\Recrutement;

use Illuminate\Foundation\Http\FormRequest;

class EtudiantCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->account_type === 'etudiant';
    }

    public function rules(): array
    {
        $rules = [
            'cv' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
            'titre' => ['nullable', 'string', 'max:255'], // Ajout du titre optionnel
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules['cv'][0] = 'sometimes';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'cv.required' => 'Veuillez sélectionner un fichier CV.',
            'cv.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 5 Mo.',
        ];
    }
}
