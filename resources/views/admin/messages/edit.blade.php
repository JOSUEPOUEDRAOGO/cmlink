@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Modifier un message</h2>
        <p class="text-muted mb-0">Mettre à jour le contenu du message.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.messages.update', $message) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.messages._form', [
                    'buttonLabel' => 'Mettre à jour'
                ])
            </form>
        </div>
    </div>
</div>
@endsection