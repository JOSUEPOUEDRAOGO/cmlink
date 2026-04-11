<?php

namespace App\Http\Requests\Admin\Communication;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'contenu' => trim((string) $this->contenu),
        ]);
    }

    public function rules(): array
    {
        return [
            'contenu' => ['required', 'string'],
            'etudiant_id' => ['nullable', 'integer', 'exists:etudiants,id'],
            'entreprise_id' => ['nullable', 'integer', 'exists:entreprises,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'contenu.required' => 'Le contenu du message est obligatoire.',
            'etudiant_id.exists' => "L'étudiant sélectionné est invalide.",
            'entreprise_id.exists' => "L'entreprise sélectionnée est invalide.",
        ];
    }
}
