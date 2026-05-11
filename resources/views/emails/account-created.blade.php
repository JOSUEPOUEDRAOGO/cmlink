@component('mail::message')
# Bienvenue sur Cmlink

Bonjour {{ $user->name }},

Votre compte a été créé avec succès.

Statut actuel : **{{ ucfirst($user->status) }}**

@if($user->status === 'en_attente')
Votre compte est en attente de validation par l’administration.
@endif

@component('mail::button', ['url' => route('front.home')])
Accéder à Cmlink
@endcomponent

Merci,<br>
L’équipe Cmlink
@endcomponent
