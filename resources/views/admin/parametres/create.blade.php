@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter un paramètre</h2>
        <p class="text-muted mb-0">Créer un nouveau paramètre de plateforme.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.parametres.store') }}" method="POST">
                @csrf

                @include('admin.parametres._form', [
                    'buttonLabel' => 'Créer le paramètre'
                ])
            </form>
        </div>
    </div>
</div>
@endsection