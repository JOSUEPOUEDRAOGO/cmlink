@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Ajouter un message</h2>
        <p class="text-muted mb-0">Créer un nouveau message entre un étudiant et une entreprise.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.messages.store') }}" method="POST">
                @csrf

                @include('admin.messages._form', [
                    'buttonLabel' => 'Créer le message'
                ])
            </form>
        </div>
    </div>
</div>
@endsection