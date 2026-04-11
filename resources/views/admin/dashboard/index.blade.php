@extends('layouts.admin')

@section('page_title', 'Tableau de bord administrateur')
@section('page_subtitle', "Vue d'ensemble de la plateforme Cmlink")

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-1 fw-bold">Tableau de bord administrateur</h2>
        <p class="text-muted mb-0">Vue d'ensemble de la plateforme Cmlink.</p>
    </div>

    @include('admin.dashboard._cards')
    @include('admin.dashboard._charts')
    @include('admin.dashboard._tables')
</div>
@endsection