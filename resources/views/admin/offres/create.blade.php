@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter une offre</h2>
        <p class="text-muted mb-0">Créer une nouvelle offre de stage ou d'emploi.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.offres.store') }}" method="POST">
                @csrf

                @include('admin.offres._form', [
                    'buttonLabel' => 'Créer l\'offre'
                ])
            </form>
        </div>
    </div>
</div>
@endsection