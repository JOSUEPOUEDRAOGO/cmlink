@extends('layouts.admin')
@section('title', 'Offres sauvegardées')
@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Offres sauvegardées</h4>
            <p class="text-muted mb-0" style="font-size:13px;">{{ $favoris->total() }} offre(s) dans vos favoris</p>
        </div>
        <a href="{{ route('front.offres.index') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-search me-2"></i> Parcourir les offres
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($favoris->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-bookmark-heart fs-1 d-block mb-3 text-muted"></i>
                <h5 class="fw-bold mb-1">Aucune offre sauvegardée</h5>
                <p class="text-muted mb-4" style="font-size:14px;">
                    Parcourez les offres et cliquez sur le signet pour les retrouver ici.
                </p>
                <a href="{{ route('front.offres.index') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-search me-2"></i> Voir les offres
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($favoris as $favori)
                @php $offre = $favori->offre; @endphp
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start gap-3">

                                {{-- Infos offre --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;
                                            background:{{ $offre->type === 'stage' ? '#EEEDFE' : '#E1F5EE' }};
                                            color:{{ $offre->type === 'stage' ? '#3C3489' : '#085041' }};">
                                            {{ $offre->type === 'stage' ? 'Stage' : 'Emploi' }}
                                        </span>
                                        @if($offre->teletravail)
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#FAEEDA;color:#633806;">
                                                Télétravail
                                            </span>
                                        @endif
                                        @if($offre->date_expiration && $offre->date_expiration->isPast())
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#FCEBEB;color:#791F1F;">
                                                Expirée
                                            </span>
                                        @endif
                                    </div>

                                    <h5 class="fw-bold mb-1" style="font-size:16px;">
                                        <a href="{{ route('front.offres.show', $offre) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $offre->titre }}
                                        </a>
                                    </h5>

                                    <p class="text-muted mb-2" style="font-size:13px;">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $offre->entreprise->nom ?? '—' }}
                                        @if($offre->localisation)
                                            &nbsp;·&nbsp;
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $offre->localisation }}
                                        @endif
                                        @if($offre->salaire_min || $offre->salaire_max)
                                            &nbsp;·&nbsp;
                                            <i class="bi bi-cash me-1"></i>
                                            @if($offre->salaire_min && $offre->salaire_max)
                                                {{ number_format($offre->salaire_min, 0, ',', ' ') }}
                                                – {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                                            @elseif($offre->salaire_min)
                                                À partir de {{ number_format($offre->salaire_min, 0, ',', ' ') }} MAD
                                            @endif
                                        @endif
                                    </p>

                                    <p class="text-muted mb-0" style="font-size:12px;">
                                        <i class="bi bi-bookmark me-1"></i>
                                        Sauvegardé le {{ $favori->created_at->format('d/m/Y') }}
                                        @if($offre->date_expiration && !$offre->date_expiration->isPast())
                                            &nbsp;·&nbsp;
                                            <i class="bi bi-clock me-1"></i>
                                            Expire le {{ $offre->date_expiration->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>

                                {{-- Actions --}}
                                <div class="d-flex flex-column gap-2 flex-shrink-0">
                                    @if(!$offre->date_expiration || !$offre->date_expiration->isPast())
                                        <a href="{{ route('front.offres.apply', $offre) }}"
                                            class="btn btn-sm btn-primary rounded-pill">
                                            <i class="bi bi-send me-1"></i> Postuler
                                        </a>
                                    @endif
                                    <a href="{{ route('front.offres.show', $offre) }}"
                                        class="btn btn-sm btn-light rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Voir
                                    </a>
                                    <form action="{{ route('admin.favoris.destroy', $favori) }}"
                                        method="POST"
                                        onsubmit="return confirm('Retirer cette offre des favoris ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-light rounded-pill text-danger w-100">
                                            <i class="bi bi-bookmark-x me-1"></i> Retirer
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($favoris->hasPages())
            <div class="mt-4">
                {{ $favoris->links() }}
            </div>
        @endif
    @endif

</div>

@endsection
