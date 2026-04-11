<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParametreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cle' => trim((string) $this->cle),
            'valeur' => $this->valeur !== null ? trim((string) $this->valeur) : null,
        ]);
    }

    public function rules(): array
    {
        $parametre = $this->route('parametre');
        $parametreId = is_object($parametre) ? $parametre->id : $parametre;

        return [
            'cle' => [
                'required',
                'string',
                'max:150',
                Rule::unique('parametres', 'cle')->ignore($parametreId),
            ],
            'valeur' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'cle.required' => 'La clé du paramètre est obligatoire.',
            'cle.max' => 'La clé du paramètre ne doit pas dépasser 150 caractères.',
            'cle.unique' => 'Cette clé de paramètre existe déjà.',
        ];
    }
}
