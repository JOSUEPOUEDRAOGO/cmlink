@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Utilisateurs</h2>
            <p class="text-muted mb-0">Gestion des comptes étudiants, entreprises et administrateurs.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Utilisateur</th>
                        <th>Type</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Profil lié</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4">
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($user->account_type ?? 'inconnu') }}
                                </span>
                            </td>

                            <td>
                                {{ $user->roles->pluck('name')->join(', ') ?: '-' }}
                            </td>

                            <td>
                                @php
                                    $statusClass = match($user->status) {
                                        'actif' => 'bg-success',
                                        'refuse' => 'bg-danger',
                                        'suspendu' => 'bg-dark',
                                        default => 'bg-warning text-dark',
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->status ?? 'en_attente')) }}
                                </span>
                            </td>

                            <td>
                                @if($user->etudiant)
                                    Étudiant : {{ $user->etudiant->prenom }} {{ $user->etudiant->nom }}
                                @elseif($user->entreprise)
                                    Entreprise : {{ $user->entreprise->nom }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $user->created_at?->format('d/m/Y H:i') }}</td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle"
                                            type="button"
                                            data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">
                                        <li>
                                            <a href="{{ route('admin.users.show', $user) }}" class="dropdown-item">
                                                <i class="bi bi-eye me-2 text-info"></i>
                                                Voir détail
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        @foreach(['actif' => 'Activer', 'en_attente' => 'Mettre en attente', 'refuse' => 'Refuser', 'suspendu' => 'Suspendre'] as $status => $label)
                                            <li>
                                                <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ $status }}">
                                                    <button class="dropdown-item" type="submit">
                                                        {{ $label }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection