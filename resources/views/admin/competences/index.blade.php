@extends('layouts.admin')
@section('title', 'Compétences')
@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Compétences</h4>
            <p class="text-muted mb-0" style="font-size:13px;">{{ $competences->total() }} compétence(s) enregistrée(s)</p>
        </div>
        <a href="{{ route('admin.competences.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-2"></i> Nouvelle compétence
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
                        <th class="ps-4 py-3">Nom</th>
                        <th class="py-3">Catégorie</th>
                        <th class="py-3 text-center">Étudiants</th>
                        <th class="py-3 text-center">Offres</th>
                        <th class="py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($competences as $competence)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $competence->nom }}</td>
                            <td>
                                @if($competence->categorie)
                                    <span class="badge rounded-pill bg-light text-dark border">
                                        {{ $competence->categorie }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill"
                                    style="background:#EEEDFE;color:#3C3489;">
                                    {{ $competence->etudiants_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill"
                                    style="background:#E1F5EE;color:#085041;">
                                    {{ $competence->offres_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.competences.show', $competence) }}"
                                        class="btn btn-sm btn-light rounded-pill">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.competences.edit', $competence) }}"
                                        class="btn btn-sm btn-light rounded-pill">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.competences.destroy', $competence) }}"
                                        method="POST"
                                        onsubmit="return confirm('Supprimer cette compétence ?')">
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
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-patch-check fs-3 d-block mb-2"></i>
                                Aucune compétence enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($competences->hasPages())
            <div class="card-footer bg-white border-0 p-3">
                {{ $competences->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
