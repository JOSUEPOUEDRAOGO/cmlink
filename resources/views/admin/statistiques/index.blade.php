@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Statistiques</h2>
        <p class="text-muted mb-0">Vue globale des performances et données de la plateforme.</p>
    </div>

    @include('admin.statistiques._cards')
    @include('admin.statistiques._charts')
    @include('admin.statistiques._tables')
</div>
@endsection