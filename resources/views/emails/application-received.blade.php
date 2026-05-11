@component('mail::message')
# Candidature bien reçue

Bonjour {{ $candidature->nom ?? 'cher candidat' }},

Votre candidature pour l’offre :

**{{ $candidature->offre->titre ?? 'Offre' }}**

chez **{{ $candidature->offre->entreprise->nom ?? 'l’entreprise' }}** a bien été envoyée.

L’entreprise a été notifiée et pourra consulter votre dossier.

Nous vous souhaitons bonne chance pour la suite de votre candidature.

@component('mail::button', ['url' => route('front.offres.show', $candidature->offre)])
Voir l’offre
@endcomponent

Merci,<br>
L’équipe Cmlink
@endcomponent
