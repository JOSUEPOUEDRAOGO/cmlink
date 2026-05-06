@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Sanctions</h2>
            <p class="text-muted mb-0">Gestion des pénalités et actions disciplinaires.</p>
        </div>

        <a href="{{ route('admin.sanctions.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-circle me-1"></i>
            Nouvelle sanction
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Utilisateur</th>
                        <th>Type</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sanctions as $sanction)
                        <tr>
                            <td class="px-4">
                                {{ $sanction->user->name ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    {{ ucfirst($sanction->type) }}
                                </span>
                            </td>

                            <td>{{ $sanction->titre }}</td>

                            <td>
                                <span class="badge {{ $sanction->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $sanction->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>{{ $sanction->created_at->format('d/m/Y') }}</td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle"
                                            data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end rounded-4 shadow-sm">

                                        <li>
                                            <a href="{{ route('admin.sanctions.show', $sanction) }}" class="dropdown-item">
                                                <i class="bi bi-eye me-2"></i> Voir
                                            </a>
                                        </li>

                                        <li><hr></li>

                                        <li>
                                            <form action="{{ route('admin.sanctions.destroy', $sanction) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer cette sanction ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="dropdown-item text-danger">
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
                                Aucune sanction trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sanctions->hasPages())
            <div class="card-footer bg-white">
                {{ $sanctions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection