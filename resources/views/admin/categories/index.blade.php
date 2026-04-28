@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Catégories</h2>
            <p class="text-muted mb-0">Gestion des catégories d'offres.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter une catégorie
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                            <th class="py-3">Nom</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Nombre d'offres</th>
                            <th class="py-3">Date de création</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $categorie)
                            <tr>
                                <td class="px-4">{{ $categorie->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $categorie->nom }}</div>
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Str::limit($categorie->description, 60) ?: '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $categorie->offres_count ?? 0 }}
                                    </span>
                                </td>
                                <td>{{ $categorie->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.categories.show', $categorie) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $categorie) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Aucune catégorie trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($categories->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
