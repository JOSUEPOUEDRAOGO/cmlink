@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h2 class="fw-bold mb-3">Nouvelle sanction</h2>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.sanctions.store') }}" method="POST">
                @csrf

                <label class="form-label">Utilisateur</label>
                <select name="user_id" class="form-select mb-3">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>

                <label class="form-label">Type</label>
                <select name="type" class="form-select mb-3">
                    <option value="avertissement">Avertissement</option>
                    <option value="blocage">Blocage</option>
                    <option value="suspension">Suspension</option>
                    <option value="radiation">Radiation</option>
                    <option value="penalite">Pénalité</option>
                    <option value="alerte">Alerte</option>
                </select>

                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control mb-3">

                <label class="form-label">Motif</label>
                <textarea name="motif" class="form-control mb-3"></textarea>

                <label class="form-label">Montant (si pénalité)</label>
                <input type="number" step="0.01" name="montant" class="form-control mb-3">

                <label class="form-label">Début</label>
                <input type="datetime-local" name="starts_at" class="form-control mb-3">

                <label class="form-label">Fin</label>
                <input type="datetime-local" name="ends_at" class="form-control mb-3">

                <button class="btn btn-danger">
                    Appliquer la sanction
                </button>

            </form>

        </div>
    </div>
</div>
@endsection