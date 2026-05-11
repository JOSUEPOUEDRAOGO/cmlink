@component('mail::message')
# Mise à jour de votre candidature

Bonjour {{ $candidature->nom ?? $candidature->etudiant?->nom_complet ?? 'cher candidat' }},

Votre candidature pour l’offre :

**{{ $candidature->offre->titre ?? 'Offre' }}**

a été mise à jour.

Nouveau statut : **{{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}**

@if($candidature->statut === 'accepte')
Félicitations, votre candidature a été acceptée.
@elseif($candidature->statut === 'refuse')
Votre candidature n’a pas été retenue cette fois-ci.
@else
Votre candidature est en cours de traitement.
@endif

@component('mail::button', ['url' => route('front.offres.show', $candidature->offre)])
Voir l’offre
@endcomponent

Merci,<br>
L’équipe Cmlink
@endcomponent
