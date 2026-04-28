@extends('layouts.front')

@section('title', 'Toutes les offres | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <h1 class="section-title" style="margin-bottom: 24px;">Toutes les offres</h1>

            <form method="GET" action="{{ route('front.offres.index') }}" style="margin-bottom: 32px;">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Rechercher une offre..."
                        style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;"
                    >

                    <select name="type" style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;">
                        <option value="">Tous les types</option>
                        <option value="stage" @selected(request('type') === 'stage')>Stage</option>
                        <option value="emploi" @selected(request('type') === 'emploi')>Emploi</option>
                    </select>

                    <select name="categorie" style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" @selected((string) request('categorie') === (string) $categorie->id)>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary">Filtrer</button>
                </div>
            </form>

            <div class="offers-grid">
                @forelse($offres as $offre)
                    <div class="offer-card">
                        <div class="company">{{ $offre->entreprise->nom ?? 'Entreprise' }}</div>
                        <div class="job-title">{{ $offre->titre }}</div>

                        <div class="details">
                            <span>📍 {{ $offre->localisation ?: 'Non précisée' }}</span>
                            <span>{{ $offre->type === 'stage' ? '📘 Stage' : '💼 Emploi' }}</span>
                        </div>

                        <div class="salary">
                            {{ $offre->categorie?->nom ? '🏷️ '.$offre->categorie->nom : 'Catégorie non précisée' }}
                        </div>

                        <div class="tags">
                            <span class="tag">{{ ucfirst($offre->type) }}</span>
                            @if($offre->categorie)
                                <span class="tag">{{ $offre->categorie->nom }}</span>
                            @endif
                        </div>

                        <a href="{{ route('front.offres.show', $offre) }}" class="view-link">Voir l'offre →</a>
                    </div>
                @empty
                    <p style="text-align:center; width:100%; color:#557c9c;">Aucune offre trouvée.</p>
                @endforelse
            </div>

            <div style="margin-top: 32px;">
                {{ $offres->links() }}
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
