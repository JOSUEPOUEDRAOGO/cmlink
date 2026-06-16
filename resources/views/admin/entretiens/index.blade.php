@extends('layouts.admin')
@section('title', 'Entretiens')
@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Entretiens</h4>
            <p class="text-muted mb-0" style="font-size:13px;">{{ $entretiens->total() }} entretien(s) planifié(s)</p>
        </div>
        <a href="{{ route('admin.entretiens.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-2"></i> Planifier un entretien
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">Candidat</th>
                        <th class="py-3">Offre</th>
                        <th class="py-3">Date & heure</th>
                        <th class="py-3">Type</th>
                        <th class="py-3">Statut</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entretiens as $entretien)
                        <tr>
                            <td class="ps-4">
                                <p class="fw-semibold mb-0" style="font-size:14px;">
                                    {{ $entretien->candidature->etudiant->prenom ?? $entretien->candidature->nom }}
                                    {{ $entretien->candidature->etudiant->nom ?? '' }}
                                </p>
                                <p class="text-muted mb-0" style="font-size:12px;">
                                    {{ $entretien->candidature->email }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0" style="font-size:13px;">
                                    {{ $entretien->candidature->offre->titre }}
                                </p>
                                <p class="text-muted mb-0" style="font-size:12px;">
                                    {{ $entretien->candidature->offre->entreprise->nom }}
                                </p>
                            </td>
                            <td>
                                <p class="mb-0" style="font-size:13px;">
                                    {{ $entretien->date_rdv->format('d/m/Y') }}
                                </p>
                                <p class="text-muted mb-0" style="font-size:12px;">
                                    {{ $entretien->date_rdv->format('H:i') }}
                                </p>
                            </td>
                            <td>
                                @php
                                    $typeConfig = [
                                        'presentiel'   => ['bg' => '#E1F5EE', 'color' => '#085041', 'label' => 'Présentiel'],
                                        'visio'        => ['bg' => '#EEEDFE', 'color' => '#3C3489', 'label' => 'Visio'],
                                        'telephonique' => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'Téléphonique'],
                                    ];
                                    $t = $typeConfig[$entretien->type] ?? ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => $entretien->type];
                                @endphp
                                <span class="badge rounded-pill"
                                    style="background:{{ $t['bg'] }};color:{{ $t['color'] }};font-size:11px;">
                                    {{ $t['label'] }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statutConfig = [
                                        'planifie'  => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'Planifié'],
                                        'confirme'  => ['bg' => '#E1F5EE', 'color' => '#085041', 'label' => 'Confirmé'],
                                        'annule'    => ['bg' => '#FCEBEB', 'color' => '#791F1F', 'label' => 'Annulé'],
                                        'effectue'  => ['bg' => '#EEEDFE', 'color' => '#3C3489', 'label' => 'Effectué'],
                                    ];
                                    $s = $statutConfig[$entretien->statut] ?? ['bg' => '#F1EFE8', 'color' => '#444441', 'label' => $entretien->statut];
                                @endphp
                                <span class="badge rounded-pill"
                                    style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:11px;">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.entretiens.show', $entretien) }}"
                                        class="btn btn-sm btn-light rounded-pill">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.entretiens.edit', $entretien) }}"
                                        class="btn btn-sm btn-light rounded-pill">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.entretiens.destroy', $entretien) }}"
                                        method="POST"
                                        onsubmit="return confirm('Supprimer cet entretien ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-pill text-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                                Aucun entretien planifié.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($entretiens->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $entretiens->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
