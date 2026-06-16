<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offre_id' => [
                'required',
                'exists:offres,id',
                Rule::unique('favoris')->where(fn ($query) =>
                    $query->where('etudiant_id', $this->route('etudiant')?->id
                        ?? auth()->user()->etudiant?->id)
                ),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'offre_id.required' => 'L\'offre est obligatoire.',
            'offre_id.exists'   => 'Cette offre n\'existe pas.',
            'offre_id.unique'   => 'Cette offre est déjà dans les favoris.',
        ];
    }
}
