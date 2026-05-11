<?php

namespace App\Http\Requests\Admin\Recrutement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise\Entreprise;
use App\Models\Recrutement\Candidature;

class CandidatureRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        // Seuls les admins et les entreprises peuvent gérer les candidatures
        if (!$user || !in_array($user->account_type, ['admin', 'entreprise'])) {
            return false;
        }

        // Pour les entreprises, vérifier qu'elles ont un profil
        if ($user->account_type === 'entreprise') {
            $entreprise = Entreprise::where('user_id', $user->id)->first();
            if (!$entreprise) {
                return false;
            }
        }

        // Pour la modification d'une candidature existante
        if ($this->route('candidature')) {
            $candidature = $this->route('candidature');

            // Admin peut tout modifier
            if ($user->account_type === 'admin') {
                return true;
            }

            // Entreprise ne peut modifier que les candidatures de ses offres
            if ($user->account_type === 'entreprise') {
                $entreprise = Entreprise::where('user_id', $user->id)->first();

                if (!$candidature->offre || $candidature->offre->entreprise_id !== $entreprise->id) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Prépare les données avant validation
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer le statut
        if ($this->has('statut')) {
            $this->merge([
                'statut' => trim($this->statut),
            ]);
        }
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->account_type === 'admin';

        // Règles de base
        $rules = [
            'statut' => ['required', Rule::in(['en_attente', 'accepte', 'refuse', 'annulee'])],
        ];

        // Pour la création (admin uniquement ou cas particuliers)
        if ($this->isMethod('POST') && !$this->route('candidature')) {
            $rules['etudiant_id'] = ['required', 'exists:etudiants,id'];
            $rules['offre_id'] = ['required', 'exists:offres,id'];

            // Si l'utilisateur est une entreprise, vérifier que l'offre lui appartient
            if ($user && $user->account_type === 'entreprise') {
                $entreprise = Entreprise::where('user_id', $user->id)->first();
                if ($entreprise) {
                    $rules['offre_id'][] = Rule::exists('offres', 'id')
                        ->where('entreprise_id', $entreprise->id);
                }
            }
        }

        // Pour la mise à jour du statut (admin et entreprise)
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            // Seul le statut peut être modifié via cette requête
            $rules = [
                'statut' => ['required', Rule::in(['en_attente', 'accepte', 'refuse', 'annulee'])],
                'commentaire' => ['nullable', 'string', 'max:500'],
            ];

            // Si c'est un refus, le commentaire peut être obligatoire
            if ($this->statut === 'refuse') {
                $rules['commentaire'][] = 'required';
            }
        }

        return $rules;
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            // Statut
            'statut.required' => 'Le statut de la candidature est obligatoire.',
            'statut.in' => 'Le statut doit être : en attente, accepté, refusé ou annulé.',

            // Étudiant
            'etudiant_id.required' => "L'étudiant est obligatoire.",
            'etudiant_id.exists' => "L'étudiant sélectionné n'existe pas.",

            // Offre
            'offre_id.required' => "L'offre est obligatoire.",
            'offre_id.exists' => "L'offre sélectionnée n'existe pas ou ne vous appartient pas.",

            // Commentaire
            'commentaire.required' => 'Un commentaire est obligatoire pour refuser une candidature.',
            'commentaire.max' => 'Le commentaire ne doit pas dépasser 500 caractères.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages
     */
    public function attributes(): array
    {
        return [
            'statut' => 'statut',
            'etudiant_id' => 'étudiant',
            'offre_id' => 'offre',
            'commentaire' => 'commentaire',
        ];
    }

    /**
     * Validation supplémentaire après les règles
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            // Vérification supplémentaire pour les entreprises
            if ($user && $user->account_type === 'entreprise') {
                $entreprise = Entreprise::where('user_id', $user->id)->first();

                if (!$entreprise) {
                    $validator->errors()->add('entreprise', 'Profil entreprise non trouvé.');
                    return;
                }

                // Si c'est une création, vérifier que l'offre appartient à l'entreprise
                if ($this->isMethod('POST') && !$this->route('candidature') && $this->has('offre_id')) {
                    $offreExiste = \App\Models\Entreprise\Offre::where('id', $this->offre_id)
                        ->where('entreprise_id', $entreprise->id)
                        ->exists();

                    if (!$offreExiste) {
                        $validator->errors()->add('offre_id', 'Vous ne pouvez créer une candidature que pour vos propres offres.');
                    }
                }

                // Si c'est une modification, vérifier que la candidature appartient à l'entreprise
                if ($this->route('candidature')) {
                    $candidature = $this->route('candidature');

                    if ($candidature && $candidature->offre && $candidature->offre->entreprise_id !== $entreprise->id) {
                        $validator->errors()->add('candidature', 'Vous ne pouvez modifier que les candidatures de vos propres offres.');
                    }
                }
            }

            // Vérifier que la date de réponse est cohérente
            if ($this->route('candidature')) {
                $candidature = $this->route('candidature');

                if ($candidature && in_array($this->statut, ['accepte', 'refuse']) && !$candidature->date_reponse) {
                    // La date de réponse sera définie automatiquement dans le contrôleur
                }
            }
        });
    }

    /**
     * Redirection personnalisée en cas d'erreur
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);

            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}
