<?php

namespace App\Http\Requests\Admin\Referentiel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nom' => trim((string) $this->nom),
            'description' => $this->description ? trim((string) $this->description) : null,
        ]);
    }

    public function rules(): array
    {
        $categorie = $this->route('categorie');
        $categorieId = is_object($categorie) ? $categorie->id : $categorie;

        return [
            'nom' => [
                'required',
                'string',
                'max:150',
                Rule::unique('categories', 'nom')->ignore($categorieId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.max' => 'Le nom de la catégorie ne doit pas dépasser 150 caractères.',
            'nom.unique' => 'Cette catégorie existe déjà.',
        ];
    }
}
