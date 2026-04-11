@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter une entreprise</h2>
        <p class="text-muted mb-0">Créer une nouvelle entreprise partenaire.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.entreprises.store') }}" method="POST">
                @csrf

                @include('admin.entreprises._form', [
                    'buttonLabel' => 'Créer l\'entreprise'
                ])
            </form>
        </div>
    </div>
</div>
@endsection