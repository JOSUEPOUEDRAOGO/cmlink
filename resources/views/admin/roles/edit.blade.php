@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-1">Modifier le rôle</h2>
    <p class="text-muted mb-4">{{ $role->name }}</p>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <label class="form-label fw-semibold">Nom du rôle</label>
                <input type="text" name="name" class="form-control mb-3"
                       value="{{ old('name', $role->name) }}">

                @error('name')
                    <div class="text-danger small mb-3">{{ $message }}</div>
                @enderror

                <button class="btn btn-primary">
                    Mettre à jour
                </button>

                <a href="{{ route('admin.roles.index') }}" class="btn btn-light border">
                    Annuler
                </a>
            </form>
        </div>
    </div>
</div>
@endsection