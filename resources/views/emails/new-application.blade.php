@component('mail::message')
# Nouvelle candidature reçue

Une nouvelle candidature a été envoyée pour l’offre :

**{{ $candidature->offre->titre ?? 'Offre' }}**

Candidat : **{{ $candidature->nom ?? $candidature->etudiant?->nom_complet ?? 'Candidat' }}**

Email : {{ $candidature->email ?? $candidature->etudiant?->email ?? '-' }}

@component('mail::button', ['url' => route('admin.candidatures.show', $candidature)])
Voir la candidature
@endcomponent

Merci,<br>
Cmlink
@endcomponent
