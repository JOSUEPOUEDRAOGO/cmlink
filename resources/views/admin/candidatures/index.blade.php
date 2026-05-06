@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="mb-1 fw-bold">Candidatures</h2>
                <p class="text-muted mb-0">Gestion des candidatures envoyées depuis le front-office.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="py-3">Candidat</th>
                                <th class="py-3">Contact</th>
                                <th class="py-3">Offre</th>
                                <th class="py-3">Entreprise</th>
                                <th class="py-3">CV</th>
                                <th class="py-3">Statut</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($candidatures as $candidature)
                                <tr>
                                    <td class="px-4">{{ $candidature->id }}</td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $candidature->nom ??
                                            trim(($candidature->etudiant->prenom ?? '') . ' ' . ($candidature->etudiant->nom ?? '')) ?:
                                                'Candidat inconnu' }}
                                        </div>

                                        @if ($candidature->message)
                                            <small class="text-muted">
                                                {{ \Illuminate\Support\Str::limit($candidature->message, 45) }}
                                            </small>
                                        @endif
                                    </td>

                                    <td>
                                        <div>{{ $candidature->email ?? '-' }}</div>
                                        <small
                                            class="text-muted">{{ $candidature->telephone ?? 'Téléphone non renseigné' }}</small>
                                    </td>

                                    <td>{{ $candidature->offre->titre ?? '-' }}</td>

                                    <td>{{ $candidature->offre->entreprise->nom ?? '-' }}</td>

                                    <td>
                                        @if ($candidature->cv_path)
                                            <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                                Voir CV
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun CV</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $badgeClass = match ($candidature->statut) {
                                                'accepte' => 'bg-success',
                                                'refuse' => 'bg-danger',
                                                default => 'bg-warning text-dark',
                                            };
                                        @endphp

                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                                        </span>
                                    </td>

                                    <td>{{ $candidature->created_at?->format('d/m/Y H:i') }}</td>

                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border rounded-circle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">
                                                <li>
                                                    <a href="{{ route('admin.candidatures.show', $candidature) }}"
                                                        class="dropdown-item">
                                                        <i class="bi bi-eye me-2 text-info"></i>
                                                        Voir détail
                                                    </a>
                                                </li>

                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>

                                                <li>
                                                    <form action="{{ route('admin.candidatures.destroy', $candidature) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Supprimer cette candidature ?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash me-2"></i>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        Aucune candidature trouvée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if (method_exists($candidatures, 'hasPages') && $candidatures->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $candidatures->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
