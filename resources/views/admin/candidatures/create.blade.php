@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter une candidature</h2>
        <p class="text-muted mb-0">Créer une nouvelle candidature pour un étudiant.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.candidatures.store') }}" method="POST">
                @csrf

                @include('admin.candidatures._form', [
                    'buttonLabel' => 'Créer la candidature'
                ])
            </form>
        </div>
    </div>
</div>
@endsection