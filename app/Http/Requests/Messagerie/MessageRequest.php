<?php

namespace App\Http\Requests\Messagerie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [];

        if ($this->isMethod('POST')) {
            // Store
            $rules = [
                'destinataire_id' => [
                    'required',
                    'exists:users,id',
                    function ($attribute, $value, $fail) {
                        if ($value == auth()->id()) {
                            $fail('Vous ne pouvez pas vous envoyer un message à vous-même.');
                        }
                    },
                ],
                'contenu' => ['required', 'string', 'min:10', 'max:1000'],
            ];
        } elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Update
            $rules = [
                'contenu' => ['sometimes', 'required', 'string', 'min:10', 'max:1000'],
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'destinataire_id.required' => 'Le destinataire est requis.',
            'destinataire_id.exists' => 'Le destinataire n’existe pas.',
            'contenu.required' => 'Le message ne peut pas être vide.',
            'contenu.min' => 'Le message doit contenir au moins 10 caractères.',
            'contenu.max' => 'Le message ne doit pas dépasser 1000 caractères.',
        ];
    }
}
