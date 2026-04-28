@extends('layouts.front')

@section('title', $entreprise->nom . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <div class="offer-card" style="max-width: 950px; margin: 0 auto;">
                <div class="company">{{ $entreprise->nom }}</div>
                <div class="job-title">{{ $entreprise->email }}</div>

                <div class="details" style="margin: 16px 0 20px;">
                    <span>📍 {{ $entreprise->adresse ?: 'Adresse non précisée' }}</span>
                    <span>📞 {{ $entreprise->telephone ?: 'Téléphone non précisé' }}</span>
                </div>

                <h3 style="margin-bottom: 16px;">Offres publiées</h3>

                @if($entreprise->offres->count())
                    <div class="offers-grid">
                        @foreach($entreprise->offres as $offre)
                            <div class="offer-card">
                                <div class="job-title">{{ $offre->titre }}</div>

                                <div class="details">
                                    <span>{{ $offre->type === 'stage' ? '📘 Stage' : '💼 Emploi' }}</span>
                                    <span>📍 {{ $offre->localisation ?: 'Non précisée' }}</span>
                                </div>

                                <div class="tags">
                                    <span class="tag">{{ ucfirst($offre->type) }}</span>
                                    @if($offre->categorie)
                                        <span class="tag">{{ $offre->categorie->nom }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('front.offres.show', $offre) }}" class="view-link">Voir l'offre →</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color:#557c9c;">Cette entreprise n'a pas encore publié d'offre.</p>
                @endif
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
