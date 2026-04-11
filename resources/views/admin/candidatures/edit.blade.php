@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Modifier une candidature</h2>
        <p class="text-muted mb-0">Mettre à jour les informations de la candidature.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.candidatures.update', $candidature) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.candidatures._form', [
                    'buttonLabel' => 'Mettre à jour'
                ])
            </form>
        </div>
    </div>
</div>
@endsection