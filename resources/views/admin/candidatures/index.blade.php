@extends('layouts.admin')

@section('title', 'Candidatures')

@section('content')
<div class="container-fluid">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-0">Candidatures</h4>
            <p class="text-muted mb-0" style="font-size:13px;">
                {{ $candidatures->total() }} candidature(s) au total
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.candidatures.export') }}"
                class="btn btn-light rounded-pill border"
                style="font-size:13px;">
                <i class="bi bi-download me-2"></i> Exporter
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats rapides --}}
    <div class="row g-3 mb-4">
        @php
            $total    = $candidatures->total();
            $attente  = $statsStatuts['en_attente'] ?? 0;
            $acceptes = $statsStatuts['accepte'] ?? 0;
            $refuses  = $statsStatuts['refuse'] ?? 0;
        @endphp
        <div class="col-6 col-md-3">
            <div class="rounded-4 text-center py-3"
                style="background:#EEEDFE;">
                <p class="fw-bold mb-0" style="font-size:22px;color:#3C3489;">{{ $total }}</p>
                <p class="mb-0" style="font-size:12px;color:#534AB7;">Total</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="rounded-4 text-center py-3"
                style="background:#FAEEDA;">
                <p class="fw-bold mb-0" style="font-size:22px;color:#633806;">{{ $attente }}</p>
                <p class="mb-0" style="font-size:12px;color:#854F0B;">En attente</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="rounded-4 text-center py-3"
                style="background:#E1F5EE;">
                <p class="fw-bold mb-0" style="font-size:22px;color:#085041;">{{ $acceptes }}</p>
                <p class="mb-0" style="font-size:12px;color:#0F6E56;">Acceptées</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="rounded-4 text-center py-3"
                style="background:#FCEBEB;">
                <p class="fw-bold mb-0" style="font-size:22px;color:#791F1F;">{{ $refuses }}</p>
                <p class="mb-0" style="font-size:12px;color:#A32D2D;">Refusées</p>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.candidatures.index') }}"
                class="d-flex flex-wrap gap-2 align-items-end">

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Recherche</label>
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="form-control form-control-sm rounded-3"
                        placeholder="Nom, email, offre..."
                        style="min-width:200px;">
                </div>

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Statut</label>
                    <select name="statut" class="form-select form-select-sm rounded-3">
                        <option value="">Tous</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="accepte"    {{ request('statut') === 'accepte'    ? 'selected' : '' }}>Acceptée</option>
                        <option value="refuse"     {{ request('statut') === 'refuse'     ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1" style="font-size:12px;color:var(--bs-secondary);">Période</label>
                    <select name="periode" class="form-select form-select-sm rounded-3">
                        <option value="">Toutes</option>
                        <option value="today"  {{ request('periode') === 'today'  ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="week"   {{ request('periode') === 'week'   ? 'selected' : '' }}>Cette semaine</option>
                        <option value="month"  {{ request('periode') === 'month'  ? 'selected' : '' }}>Ce mois</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-search me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.candidatures.index') }}"
                        class="btn btn-sm btn-light rounded-pill border">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Candidat</th>
                            <th class="py-3">Offre</th>
                            <th class="py-3">Documents</th>
                            <th class="py-3">Statut</th>
                            <th class="py-3">Date</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatures as $candidature)
                            <tr>

                                {{-- Candidat --}}
                                <td class="ps-4">
                                    @php
                                        $nom = $candidature->etudiant
                                            ? trim($candidature->etudiant->prenom . ' ' . $candidature->etudiant->nom)
                                            : ($candidature->nom ?? 'Candidat inconnu');
                                        $initiales = collect(explode(' ', $nom))
                                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                            ->take(2)
                                            ->join('');
                                    @endphp
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                            style="width:38px;height:38px;background:#EEEDFE;color:#3C3489;font-size:13px;">
                                            {{ $initiales }}
                                        </div>
                                        <div>
                                            <p class="fw-semibold mb-0" style="font-size:14px;">{{ $nom }}</p>
                                            <p class="text-muted mb-0" style="font-size:12px;">
                                                {{ $candidature->email }}
                                                @if($candidature->telephone)
                                                    &nbsp;·&nbsp; {{ $candidature->telephone }}
                                                @endif
                                            </p>
                                            @if($candidature->message)
                                                <p class="text-muted mb-0" style="font-size:11px;font-style:italic;">
                                                    "{{ \Illuminate\Support\Str::limit($candidature->message, 50) }}"
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Offre --}}
                                <td>
                                    <p class="fw-semibold mb-0" style="font-size:13px;">
                                        {{ $candidature->offre->titre ?? '—' }}
                                    </p>
                                    <p class="text-muted mb-0" style="font-size:12px;">
                                        {{ $candidature->offre->entreprise->nom ?? '—' }}
                                    </p>
                                    @if($candidature->offre)
                                        <span class="badge rounded-pill"
                                            style="font-size:11px;
                                            background:{{ $candidature->offre->type === 'stage' ? '#EEEDFE' : '#E1F5EE' }};
                                            color:{{ $candidature->offre->type === 'stage' ? '#3C3489' : '#085041' }};">
                                            {{ $candidature->offre->type === 'stage' ? 'Stage' : 'Emploi' }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Documents --}}
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($candidature->cv_path)
                                            <a href="{{ asset('storage/' . $candidature->cv_path) }}"
                                                target="_blank"
                                                class="btn btn-sm rounded-pill d-inline-flex align-items-center gap-1"
                                                style="font-size:11px;background:#EEEDFE;color:#3C3489;border:none;">
                                                <i class="bi bi-file-earmark-pdf"></i> CV
                                            </a>
                                        @endif
                                        @if($candidature->lettre)
                                            <span class="badge rounded-pill"
                                                style="font-size:11px;background:#E1F5EE;color:#085041;">
                                                <i class="bi bi-file-earmark-text me-1"></i>
                                                Lettre jointe
                                            </span>
                                        @endif
                                        @if(!$candidature->cv_path && !$candidature->lettre)
                                            <span class="text-muted" style="font-size:12px;">—</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Statut --}}
                                <td>
                                    @php
                                        $statutConfig = [
                                            'en_attente' => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'En attente'],
                                            'accepte'    => ['bg' => '#E1F5EE', 'color' => '#085041', 'label' => 'Acceptée'],
                                            'refuse'     => ['bg' => '#FCEBEB', 'color' => '#791F1F', 'label' => 'Refusée'],
                                        ];
                                        $s = $statutConfig[$candidature->statut] ?? ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => $candidature->statut];
                                    @endphp
                                    <span class="badge rounded-pill"
                                        style="font-size:11px;padding:5px 10px;background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                                        {{ $s['label'] }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <p class="mb-0" style="font-size:13px;">
                                        {{ $candidature->created_at?->format('d/m/Y') }}
                                    </p>
                                    <p class="text-muted mb-0" style="font-size:11px;">
                                        {{ $candidature->created_at?->format('H:i') }}
                                    </p>
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill border"
                                            type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 p-2">
                                            <li>
                                                <a href="{{ route('admin.candidatures.show', $candidature) }}"
                                                    class="dropdown-item rounded-3 py-2">
                                                    <i class="bi bi-eye me-2 text-info"></i> Voir détail
                                                </a>
                                            </li>
                                            @if($candidature->statut === 'en_attente')
                                                <li>
                                                    <form action="{{ route('admin.candidatures.accept', $candidature) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="dropdown-item rounded-3 py-2 text-success">
                                                            <i class="bi bi-check-circle me-2"></i> Accepter
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.candidatures.reject', $candidature) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="dropdown-item rounded-3 py-2 text-danger">
                                                            <i class="bi bi-x-circle me-2"></i> Refuser
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($candidature->statut !== 'en_attente')
                                                <li>
                                                    <form action="{{ route('admin.candidatures.pending', $candidature) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="dropdown-item rounded-3 py-2">
                                                            <i class="bi bi-arrow-counterclockwise me-2 text-warning"></i>
                                                            Remettre en attente
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.candidatures.destroy', $candidature) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Supprimer cette candidature ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item rounded-3 py-2 text-danger">
                                                        <i class="bi bi-trash me-2"></i> Supprimer
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-send fs-3 d-block mb-2"></i>
                                    Aucune candidature trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($candidatures->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $candidatures->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
