@extends('layouts.front')

@section('title', 'Étudiants | Cmlink')

@section('content')
    @include('front.partials.header')

    <section>
        <div class="container">
            <h1 class="section-title" style="margin-bottom: 24px;">Étudiants</h1>

            <form method="GET" action="{{ route('front.etudiants.index') }}" style="margin-bottom: 32px;">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Rechercher un étudiant..."
                        style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;"
                    >

                    <select name="filiere" style="padding:12px 16px; border-radius:14px; border:1px solid #dbe6f0;">
                        <option value="">Toutes les filières</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" @selected((string) request('filiere') === (string) $filiere->id)>
                                {{ $filiere->nom }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary">Filtrer</button>
                </div>
            </form>

            <div class="offers-grid">
                @forelse($etudiants as $etudiant)
                    <div class="offer-card">
                        <div class="company">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                        <div class="job-title">{{ $etudiant->email }}</div>

                        <div class="details">
                            <span>🎓 {{ $etudiant->filiere->nom ?? 'Filière non précisée' }}</span>
                            <span>📞 {{ $etudiant->telephone ?: 'Téléphone non précisé' }}</span>
                        </div>

                        <a href="{{ route('front.etudiants.show', $etudiant) }}" class="view-link">Voir le profil →</a>
                    </div>
                @empty
                    <p style="text-align:center; width:100%; color:#557c9c;">Aucun étudiant trouvé.</p>
                @endforelse
            </div>

            <div style="margin-top: 32px;">
                {{ $etudiants->links() }}
            </div>
        </div>
    </section>

    @include('front.partials.footer')
@endsection
