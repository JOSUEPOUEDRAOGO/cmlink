<?php

namespace App\Http\Requests\Admin\Academique;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nom' => trim((string) $this->nom),
        ]);
    }

    public function rules(): array
    {
        $filiere = $this->route('filiere');
        $filiereId = is_object($filiere) ? $filiere->id : $filiere;

        return [
            'nom' => [
                'required',
                'string',
                'max:150',
                Rule::unique('filieres', 'nom')->ignore($filiereId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la filière est obligatoire.',
            'nom.max' => 'Le nom de la filière ne doit pas dépasser 150 caractères.',
            'nom.unique' => 'Cette filière existe déjà.',
        ];
    }
}
