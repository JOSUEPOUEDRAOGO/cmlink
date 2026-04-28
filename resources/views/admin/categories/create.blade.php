@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter une catégorie</h2>
        <p class="text-muted mb-0">Créer une nouvelle catégorie pour les offres.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                @include('admin.categories._form', [
                    'buttonLabel' => 'Créer la catégorie'
                ])
            </form>
        </div>
    </div>
</div>
@endsection
