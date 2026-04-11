@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="mb-1 fw-bold">Messages</h2>
            <p class="text-muted mb-0">Gestion des messages entre étudiants et entreprises.</p>
        </div>

        <a href="{{ route('admin.messages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Ajouter un message
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
                            <th class="py-3">Étudiant</th>
                            <th class="py-3">Entreprise</th>
                            <th class="py-3">Message</th>
                            <th class="py-3">Date</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td class="px-4">{{ $message->id }}</td>
                                <td>
                                    @if($message->etudiant)
                                        {{ $message->etudiant->prenom }} {{ $message->etudiant->nom }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $message->entreprise->nom ?? '-' }}
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Str::limit($message->contenu, 70) }}
                                </td>
                                <td>{{ $message->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.messages.edit', $message) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
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
                                    Aucun message trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($messages->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection