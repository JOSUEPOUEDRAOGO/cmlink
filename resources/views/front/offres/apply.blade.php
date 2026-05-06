@extends('layouts.front')

@section('title', 'Postuler | Cmlink')

@section('content')
@include('front.partials.header')

<section>
    <div class="container">
        <div class="offer-card" style="max-width: 760px; margin: 0 auto;">
            <h2 class="section-title" style="margin-bottom: 14px;">
                Postuler à : {{ $offre->titre }}
            </h2>

            <p class="text-muted mb-4">
                {{ $offre->entreprise->nom ?? 'Entreprise' }} — {{ $offre->localisation ?: 'Localisation non précisée' }}
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Vérifie les informations du formulaire.
                </div>
            @endif

            <form action="{{ route('front.offres.postuler', $offre) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="form-label">Nom complet</label>
                <input type="text" name="nom" class="form-control mb-3" value="{{ old('nom', auth()->user()->name) }}" required>

                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control mb-3" value="{{ old('email', auth()->user()->email) }}" required>

                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control mb-3" value="{{ old('telephone') }}">

                <label class="form-label">Message de motivation</label>
                <textarea name="message" class="form-control mb-3" rows="5">{{ old('message') }}</textarea>

                <label class="form-label">CV</label>
                <input type="file" name="cv" class="form-control mb-4" accept=".pdf,.doc,.docx" required>

                <div style="display:flex; gap:14px; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">
                        Envoyer ma candidature
                    </button>

                    <a href="{{ route('front.offres.show', $offre) }}" class="btn-outline">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

@include('front.partials.footer')
@endsection
