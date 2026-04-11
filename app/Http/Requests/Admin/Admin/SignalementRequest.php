<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SignalementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'description' => trim((string) $this->description),
        ]);
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'etudiant_id' => ['nullable', 'integer', 'exists:etudiants,id'],
            'entreprise_id' => ['nullable', 'integer', 'exists:entreprises,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'La description du signalement est obligatoire.',
            'etudiant_id.exists' => "L'étudiant sélectionné est invalide.",
            'entreprise_id.exists' => "L'entreprise sélectionnée est invalide.",
        ];
    }
}
