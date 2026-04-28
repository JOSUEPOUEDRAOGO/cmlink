@extends('layouts.front')

@section('title', $etudiant->prenom . ' ' . $etudiant->nom . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <div class="offer-card" style="max-width: 950px; margin: 0 auto;">
                <div class="company">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                <div class="job-title">{{ $etudiant->email }}</div>

                <div class="details" style="margin: 16px 0 20px;">
                    <span>🎓 {{ $etudiant->filiere->nom ?? 'Filière non précisée' }}</span>
                    <span>📞 {{ $etudiant->telephone ?: 'Téléphone non précisé' }}</span>
                </div>

                <h3 style="margin-bottom: 16px;">Candidatures récentes</h3>

                @if($etudiant->candidatures->count())
                    <div class="offers-grid">
                        @foreach($etudiant->candidatures as $candidature)
                            <div class="offer-card">
                                <div class="job-title">{{ $candidature->offre->titre ?? 'Offre' }}</div>

                                <div class="details">
                                    <span>🏢 {{ $candidature->offre->entreprise->nom ?? 'Entreprise' }}</span>
                                    <span>
                                        {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                                    </span>
                                </div>

                                @if($candidature->offre)
                                    <a href="{{ route('front.offres.show', $candidature->offre) }}" class="view-link">Voir l'offre →</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color:#557c9c;">Aucune candidature enregistrée pour cet étudiant.</p>
                @endif
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
