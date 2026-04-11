@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter une filière</h2>
        <p class="text-muted mb-0">Créer une nouvelle filière académique.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.filieres.store') }}" method="POST">
                @csrf

                @include('admin.filieres._form', [
                    'buttonLabel' => 'Créer la filière'
                ])
            </form>
        </div>
    </div>
</div>
@endsection