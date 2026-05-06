@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Rôles & accès</h2>
            <p class="text-muted mb-0">Gestion des rôles utilisateurs de la plateforme.</p>
        </div>

        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nouveau rôle
        </a>
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
                        <th class="px-4 py-3">Rôle</th>
                        <th>Guard</th>
                        <th>Utilisateurs</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="px-4 fw-semibold">{{ $role->name }}</td>
                            <td>{{ $role->guard_name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $role->users_count }} utilisateur(s)
                                </span>
                            </td>
                            <td>{{ $role->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-circle" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">
                                        <li>
                                            <a href="{{ route('admin.roles.edit', $role) }}" class="dropdown-item">
                                                <i class="bi bi-pencil-square me-2 text-warning"></i>
                                                Modifier
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer ce rôle ?')">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                Aucun rôle trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($roles->hasPages())
            <div class="card-footer bg-white border-0">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection