@extends('layouts.front')

@section('title', $offre->titre . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <div class="offer-card" style="max-width: 900px; margin: 0 auto;">
                <div class="company">{{ $offre->entreprise->nom ?? 'Entreprise' }}</div>
                <div class="job-title" style="font-size:1.5rem;">{{ $offre->titre }}</div>

                <div class="details" style="margin: 16px 0 20px;">
                    <span>📍 {{ $offre->localisation ?: 'Non précisée' }}</span>
                    <span>{{ $offre->type === 'stage' ? '📘 Stage' : '💼 Emploi' }}</span>
                    @if ($offre->date_expiration)
                        <span>📅 Expire le {{ $offre->date_expiration->format('d/m/Y') }}</span>
                    @endif
                </div>

                <div class="tags" style="margin-bottom: 20px;">
                    <span class="tag">{{ ucfirst($offre->type) }}</span>
                    @if ($offre->categorie)
                        <span class="tag">{{ $offre->categorie->nom }}</span>
                    @endif
                </div>

                <h3 style="margin-bottom: 12px;">Description</h3>
                <p style="color:#3a5a78; white-space: pre-line;">{{ $offre->description }}</p>

                <div style="margin-top: 28px; display:flex; gap:16px; flex-wrap:wrap;">
                    @auth
                        <a href="{{ route('front.offres.apply', $offre) }}" class="btn-primary">
                            Postuler maintenant
                        </a>
                    @else
                        <a href="{{ route('login', ['redirect' => route('front.offres.apply', $offre)]) }}" class="btn-primary">
                            Connectez-vous pour postuler
                        </a>
                    @endauth

                    <a href="{{ route('front.offres.index') }}" class="btn-outline">Retour aux offres</a>
                </div>
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
