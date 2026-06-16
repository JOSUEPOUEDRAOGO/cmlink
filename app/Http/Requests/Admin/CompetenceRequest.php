<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompetenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $competence = $this->route('competence');

        return [
            'nom'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('competences', 'nom')->ignore($competence),
            ],
            'categorie' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la compétence est obligatoire.',
            'nom.unique'   => 'Cette compétence existe déjà.',
        ];
    }
}
