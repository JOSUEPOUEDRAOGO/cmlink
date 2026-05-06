@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="fw-bold mb-3">Détail sanction</h2>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <p><strong>Utilisateur :</strong> {{ $sanction->user->name }}</p>
            <p><strong>Type :</strong> {{ $sanction->type }}</p>
            <p><strong>Titre :</strong> {{ $sanction->titre }}</p>
            <p><strong>Motif :</strong> {{ $sanction->motif }}</p>

            @if($sanction->montant)
                <p><strong>Montant :</strong> {{ $sanction->montant }} €</p>
            @endif

            <p><strong>Début :</strong> {{ $sanction->starts_at }}</p>
            <p><strong>Fin :</strong> {{ $sanction->ends_at }}</p>

            <a href="{{ route('admin.sanctions.index') }}" class="btn btn-light border mt-3">
                Retour
            </a>

        </div>
    </div>
</div>
@endsection