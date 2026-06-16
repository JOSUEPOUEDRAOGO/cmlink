@extends('layouts.admin')
@section('title', 'Lettre de motivation')
@section('content')

@php
  $initiales = strtoupper(substr($etudiant->prenom, 0, 1) . substr($etudiant->nom, 0, 1));
@endphp

<div class="container py-4" style="max-width: 720px;">

  {{-- Toast succès --}}
  @if(session('success'))
  <div class="d-flex align-items-center gap-2 mb-4 px-3 py-2 rounded-3"
       style="background: var(--bs-success-bg-subtle); border: 0.5px solid var(--bs-success-border-subtle); font-size: 13px; color: var(--bs-success-text-emphasis);">
    <i class="bi bi-check-circle"></i>
    {{ session('success') }}
  </div>
  @endif

  {{-- Carte identité étudiant --}}
  <div class="d-flex align-items-center gap-3 p-4 mb-3 rounded-4 bg-white border"
       style="border-color: rgba(0,0,0,.08) !important;">
    <div class="rounded-circle d-flex align-items-center justify-content-center fw-500 flex-shrink-0"
         style="width:52px;height:52px;background:#EEEDFE;color:#3C3489;font-size:15px;">
      {{ $initiales }}
    </div>
    <div class="flex-grow-1">
      <p class="mb-0 fw-semibold" style="font-size:15px;">{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
      <p class="mb-0 text-muted" style="font-size:13px;">
        {{ $etudiant->filiere->nom ?? '—' }}
      </p>
    </div>
    @if($etudiant->lettre_public)
      <span class="badge rounded-pill d-flex align-items-center gap-1"
            style="background:#D1FAE5;color:#065F46;font-size:12px;font-weight:500;">
        <i class="bi bi-eye"></i> Publique
      </span>
    @else
      <span class="badge rounded-pill d-flex align-items-center gap-1"
            style="background:#F3F4F6;color:#6B7280;font-size:12px;font-weight:500;">
        <i class="bi bi-eye-slash"></i> Privée
      </span>
    @endif
  </div>

  {{-- Bloc CTA contextuel --}}
  @if(!$etudiant->lettre_public)
  <div class="d-flex align-items-center gap-3 p-3 mb-3 rounded-3"
       style="background:#F5F3FF;border:0.5px solid #C4B5FD;">
    <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
         style="width:36px;height:36px;background:#7C3AED;">
      <i class="bi bi-rocket text-white" style="font-size:16px;"></i>
    </div>
    <div>
      <p class="mb-0 fw-semibold" style="font-size:14px;color:#3730A3;">Rendre la lettre visible aux recruteurs</p>
      <p class="mb-0" style="font-size:12px;color:#6D28D9;">
        Cette lettre n'est pas encore publique. Les recruteurs ne peuvent pas la consulter.
      </p>
    </div>
  </div>
  @else
  <div class="d-flex align-items-center gap-3 p-3 mb-3 rounded-3"
       style="background:#ECFDF5;border:0.5px solid #6EE7B7;">
    <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
         style="width:36px;height:36px;background:#10B981;">
      <i class="bi bi-check-circle text-white" style="font-size:16px;"></i>
    </div>
    <div>
      <p class="mb-0 fw-semibold" style="font-size:14px;color:#065F46;">Lettre visible par les recruteurs</p>
      <p class="mb-0" style="font-size:12px;color:#059669;">
        Les recruteurs peuvent consulter cette lettre depuis le profil public de l'étudiant.
      </p>
    </div>
  </div>
  @endif

  {{-- Carte lettre --}}
  <div class="rounded-4 bg-white border overflow-hidden mb-0"
       style="border-color: rgba(0,0,0,.08) !important;">
    <div class="px-4 py-3 d-flex justify-content-between align-items-center"
         style="border-bottom: 0.5px solid rgba(0,0,0,.07);">
      <span class="d-flex align-items-center gap-2 text-muted" style="font-size:13px;">
        <i class="bi bi-file-text"></i>
        Lettre de motivation
      </span>
      @if($lettre->titre)
        <span class="text-muted fst-italic" style="font-size:13px;">{{ $lettre->titre }}</span>
      @endif
    </div>

    <div class="p-4" style="font-size:14px;line-height:1.75;white-space:pre-wrap;
         background: #FAFAFA; min-height: 140px; color: var(--bs-body-color);">
      {!! nl2br(e($lettre->contenu)) !!}
    </div>

    <div class="px-4 py-3 d-flex justify-content-between align-items-center"
         style="border-top: 0.5px solid rgba(0,0,0,.07);">
      <a href="{{ route('admin.profils-publics.index') }}"
         class="btn btn-sm btn-light rounded-pill d-flex align-items-center gap-2"
         style="font-size:13px;">
        <i class="bi bi-arrow-left"></i> Retour
      </a>

      <form action="{{ route('admin.profils-publics.toggle-lettre', $etudiant) }}" method="POST">
        @csrf
        @method('PATCH')
        @if($etudiant->lettre_public)
          <button type="submit" class="btn btn-sm rounded-pill d-flex align-items-center gap-2"
                  style="font-size:13px;background:#F3F4F6;color:#374151;border:0.5px solid #D1D5DB;">
            <i class="bi bi-eye-slash"></i> Rendre privée
          </button>
        @else
          <button type="submit" class="btn btn-sm rounded-pill d-flex align-items-center gap-2"
                  style="font-size:13px;background:#EEEDFE;color:#3C3489;border:0.5px solid #AFA9EC;font-weight:500;">
            <i class="bi bi-eye"></i> Rendre publique
          </button>
        @endif
      </form>
    </div>
  </div>

</div>
@endsection
