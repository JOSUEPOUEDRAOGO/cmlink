<?php

namespace App\Http\Requests\Admin\Entreprise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class OffreRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        // Seuls les admins et les entreprises peuvent créer/modifier des offres
        return $user && in_array($user->account_type, ['admin', 'entreprise']);
    }

    /**
     * Prépare les données avant validation
     */
    protected function prepareForValidation(): void
    {
        $data = [
            'titre' => trim((string) $this->titre),
            'description' => trim((string) $this->description),
        ];

        // Ajouter localisation seulement si présente
        if ($this->filled('localisation')) {
            $data['localisation'] = trim((string) $this->localisation);
        }

        // Ajouter date_expiration seulement si présente
        if ($this->filled('date_expiration')) {
            $data['date_expiration'] = $this->date_expiration;
        }

        $this->merge($data);
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->account_type === 'admin';
        $isEntreprise = $user && $user->account_type === 'entreprise';

        // Règle pour entreprise_id
        $entrepriseRule = ['required', 'integer', 'exists:entreprises,id'];

        if ($isEntreprise) {
            // L'entreprise ne peut sélectionner que sa propre entreprise
            $entrepriseRule[] = Rule::exists('entreprises', 'id')
                ->where('user_id', $user->id);
        }

        $rules = [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'type' => ['required', Rule::in(['stage', 'emploi', 'alternance'])],
            'entreprise_id' => $entrepriseRule,
            'categorie_id' => ['nullable', 'integer', 'exists:categories,id'],
            'localisation' => ['nullable', 'string', 'max:150'],
            'date_expiration' => ['nullable', 'date', 'after_or_equal:today'],
        ];

        // Pour l'admin, ajouter des champs optionnels supplémentaires
        if ($isAdmin) {
            $rules['status'] = ['nullable', Rule::in(['active', 'closed', 'archived'])];
            $rules['duree'] = ['nullable', 'string', 'max:100'];
            $rules['remuneration'] = ['nullable', 'string', 'max:100'];
        }

        return $rules;
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            // Titre
            'titre.required' => 'Le titre de l\'offre est obligatoire.',
            'titre.max' => 'Le titre de l\'offre ne doit pas dépasser 255 caractères.',

            // Description
            'description.required' => 'La description est obligatoire.',
            'description.min' => 'La description doit contenir au moins 20 caractères.',

            // Type
            'type.required' => 'Le type d\'offre est obligatoire.',
            'type.in' => 'Le type d\'offre doit être : stage, emploi ou alternance.',

            // Entreprise
            'entreprise_id.required' => 'L\'entreprise est obligatoire.',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée est invalide ou ne vous appartient pas.',

            // Catégorie
            'categorie_id.exists' => 'La catégorie sélectionnée est invalide.',

            // Localisation
            'localisation.max' => 'La localisation ne doit pas dépasser 150 caractères.',

            // Date expiration
            'date_expiration.date' => 'La date d\'expiration doit être une date valide.',
            'date_expiration.after_or_equal' => 'La date d\'expiration doit être aujourd\'hui ou plus tard.',

            // Champs admin
            'status.in' => 'Le statut doit être : active, closed ou archived.',
            'duree.max' => 'La durée ne doit pas dépasser 100 caractères.',
            'remuneration.max' => 'La rémunération ne doit pas dépasser 100 caractères.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'titre' => 'titre',
            'description' => 'description',
            'type' => 'type d\'offre',
            'entreprise_id' => 'entreprise',
            'categorie_id' => 'catégorie',
            'localisation' => 'localisation',
            'date_expiration' => 'date d\'expiration',
            'status' => 'statut',
            'duree' => 'durée',
            'remuneration' => 'rémunération',
        ];
    }

    /**
     * Valide après la validation principale
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            // Vérifier que l'entreprise existe bien pour l'utilisateur connecté
            if ($user && $user->account_type === 'entreprise') {
                $entrepriseId = $this->input('entreprise_id');

                if ($entrepriseId) {
                    $exists = \App\Models\Entreprise\Entreprise::where('id', $entrepriseId)
                        ->where('user_id', $user->id)
                        ->exists();

                    if (!$exists) {
                        $validator->errors()->add('entreprise_id', 'Vous ne pouvez créer une offre que pour votre propre entreprise.');
                    }
                }
            }
        });
    }

    /**
     * Récupère les données validées avec valeurs par défaut
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        // Définir les valeurs par défaut
        $validated['status'] = $validated['status'] ?? 'active';

        // Nettoyer les champs vides
        foreach ($validated as $key => $value) {
            if ($value === null || $value === '') {
                unset($validated[$key]);
            }
        }

        return $validated;
    }
}
