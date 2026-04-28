@extends('layouts.front')

@section('title', 'Entreprises | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <h1 class="section-title" style="margin-bottom: 24px;">Entreprises</h1>

            <form method="GET" action="{{ route('front.entreprises.index') }}" style="margin-bottom: 32px;">
                <div style="display:grid; grid-template-columns: 1fr auto; gap:16px;">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Rechercher une entreprise..."
                        style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;"
                    >
                    <button type="submit" class="btn-primary">Rechercher</button>
                </div>
            </form>

            <div class="offers-grid">
                @forelse($entreprises as $entreprise)
                    <div class="offer-card">
                        <div class="company">{{ $entreprise->nom }}</div>
                        <div class="job-title">{{ $entreprise->email }}</div>

                        <div class="details">
                            <span>📍 {{ $entreprise->adresse ?: 'Adresse non précisée' }}</span>
                        </div>

                        <div class="tags">
                            <span class="tag">{{ $entreprise->offres_count }} offres</span>
                        </div>

                        <a href="{{ route('front.entreprises.show', $entreprise) }}" class="view-link">Voir l'entreprise →</a>
                    </div>
                @empty
                    <p style="text-align:center; width:100%; color:#557c9c;">Aucune entreprise trouvée.</p>
                @endforelse
            </div>

            <div style="margin-top: 32px;">
                {{ $entreprises->links() }}
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
