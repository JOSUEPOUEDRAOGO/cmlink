@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Page d’accueil</h2>
            <p class="text-muted mb-0">
                Gérez les textes et sections affichés sur le front-office Cmlink.
            </p>
        </div>

        <a href="{{ route('front.home') }}" target="_blank" class="btn btn-light border">
            <i class="bi bi-eye me-1"></i>
            Voir la page
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.pages.home.update') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- MENU SECTIONS --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Sections</h6>

                        <div class="nav flex-column nav-pills page-editor-tabs" id="pageTabs" role="tablist">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#hero" type="button">
                                <i class="bi bi-stars me-2"></i> Hero
                            </button>

                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#why" type="button">
                                <i class="bi bi-patch-question me-2"></i> Pourquoi Cmlink
                            </button>

                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#audience" type="button">
                                <i class="bi bi-people me-2"></i> Audiences
                            </button>

                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#how" type="button">
                                <i class="bi bi-diagram-3 me-2"></i> Comment ça marche
                            </button>

                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cta" type="button">
                                <i class="bi bi-megaphone me-2"></i> CTA
                            </button>

                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#footer" type="button">
                                <i class="bi bi-layout-text-window me-2"></i> Footer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENU --}}
            <div class="col-lg-9">
                <div class="tab-content">

                    {{-- HERO --}}
                    <div class="tab-pane fade show active" id="hero">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h5 class="fw-bold mb-1">Section Hero</h5>
                                <p class="text-muted mb-0">Première section visible sur la page d’accueil.</p>
                            </div>

                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Titre principal</label>
                                    <input type="text" name="sections[hero][title]" class="form-control form-control-lg"
                                           value="{{ $sections['hero']['title'] ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Sous-titre</label>
                                    <textarea name="sections[hero][subtitle]" class="form-control" rows="4">{{ $sections['hero']['subtitle'] ?? '' }}</textarea>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bouton principal</label>
                                        <input type="text" name="sections[hero][button_primary]" class="form-control"
                                               value="{{ $sections['hero']['button_primary'] ?? '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bouton secondaire</label>
                                        <input type="text" name="sections[hero][button_secondary]" class="form-control"
                                               value="{{ $sections['hero']['button_secondary'] ?? '' }}">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Badge Hero</label>
                                    <input type="text" name="sections[hero][badge]" class="form-control"
                                           value="{{ $sections['hero']['badge'] ?? '🔗 Connexion directe avec les entreprises' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- WHY --}}
                    <div class="tab-pane fade" id="why">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h5 class="fw-bold mb-1">Pourquoi choisir Cmlink ?</h5>
                                <p class="text-muted mb-0">Gérez les arguments principaux affichés sous forme de cartes.</p>
                            </div>

                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Titre de la section</label>
                                    <input type="text" name="sections[why][title]" class="form-control form-control-lg"
                                           value="{{ $sections['why']['title'] ?? 'Pourquoi choisir Cmlink ?' }}">
                                </div>

                                <div class="row g-3">
                                    @for($i = 1; $i <= 4; $i++)
                                        <div class="col-md-6">
                                            <div class="border rounded-4 p-3 h-100 bg-light">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="fw-bold mb-0">Carte {{ $i }}</h6>
                                                    <span class="badge bg-primary-subtle text-primary">Feature</span>
                                                </div>

                                                <label class="form-label fw-semibold">Titre</label>
                                                <input type="text"
                                                       name="sections[why][card_{{ $i }}_title]"
                                                       class="form-control mb-3"
                                                       value="{{ $sections['why']["card_{$i}_title"] ?? '' }}">

                                                <label class="form-label fw-semibold">Texte</label>
                                                <textarea name="sections[why][card_{{ $i }}_text]"
                                                          class="form-control"
                                                          rows="4">{{ $sections['why']["card_{$i}_text"] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AUDIENCE --}}
                    <div class="tab-pane fade" id="audience">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h5 class="fw-bold mb-1">Section Audiences</h5>
                                <p class="text-muted mb-0">Textes pour étudiants et entreprises.</p>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="border rounded-4 p-3 h-100">
                                            <h6 class="fw-bold mb-3">Bloc étudiants</h6>

                                            <label class="form-label fw-semibold">Titre</label>
                                            <input type="text" name="sections[audience][student_title]" class="form-control mb-3"
                                                   value="{{ $sections['audience']['student_title'] ?? '' }}">

                                            <label class="form-label fw-semibold">Texte</label>
                                            <textarea name="sections[audience][student_text]" class="form-control mb-3" rows="3">{{ $sections['audience']['student_text'] ?? '' }}</textarea>

                                            <label class="form-label fw-semibold">Avantage 1</label>
                                            <input type="text" name="sections[audience][student_benefit_1]" class="form-control mb-2"
                                                   value="{{ $sections['audience']['student_benefit_1'] ?? '' }}">

                                            <label class="form-label fw-semibold">Avantage 2</label>
                                            <input type="text" name="sections[audience][student_benefit_2]" class="form-control mb-2"
                                                   value="{{ $sections['audience']['student_benefit_2'] ?? '' }}">

                                            <label class="form-label fw-semibold">Avantage 3</label>
                                            <input type="text" name="sections[audience][student_benefit_3]" class="form-control mb-3"
                                                   value="{{ $sections['audience']['student_benefit_3'] ?? '' }}">

                                            <label class="form-label fw-semibold">Bouton</label>
                                            <input type="text" name="sections[audience][student_button]" class="form-control"
                                                   value="{{ $sections['audience']['student_button'] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="border rounded-4 p-3 h-100">
                                            <h6 class="fw-bold mb-3">Bloc entreprises</h6>

                                            <label class="form-label fw-semibold">Titre</label>
                                            <input type="text" name="sections[audience][company_title]" class="form-control mb-3"
                                                   value="{{ $sections['audience']['company_title'] ?? '' }}">

                                            <label class="form-label fw-semibold">Texte</label>
                                            <textarea name="sections[audience][company_text]" class="form-control mb-3" rows="3">{{ $sections['audience']['company_text'] ?? '' }}</textarea>

                                            <label class="form-label fw-semibold">Avantage 1</label>
                                            <input type="text" name="sections[audience][company_benefit_1]" class="form-control mb-2"
                                                   value="{{ $sections['audience']['company_benefit_1'] ?? '' }}">

                                            <label class="form-label fw-semibold">Avantage 2</label>
                                            <input type="text" name="sections[audience][company_benefit_2]" class="form-control mb-2"
                                                   value="{{ $sections['audience']['company_benefit_2'] ?? '' }}">

                                            <label class="form-label fw-semibold">Avantage 3</label>
                                            <input type="text" name="sections[audience][company_benefit_3]" class="form-control mb-3"
                                                   value="{{ $sections['audience']['company_benefit_3'] ?? '' }}">

                                            <label class="form-label fw-semibold">Bouton</label>
                                            <input type="text" name="sections[audience][company_button]" class="form-control"
                                                   value="{{ $sections['audience']['company_button'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HOW --}}
                    <div class="tab-pane fade" id="how">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h5 class="fw-bold mb-1">Comment ça marche ?</h5>
                                <p class="text-muted mb-0">Les 4 étapes du processus utilisateur.</p>
                            </div>

                            <div class="card-body p-4">
                                <label class="form-label fw-semibold">Titre de la section</label>
                                <input type="text" name="sections[how][title]" class="form-control form-control-lg mb-4"
                                       value="{{ $sections['how']['title'] ?? 'Comment ça marche ?' }}">

                                <div class="row g-3">
                                    @for($i = 1; $i <= 4; $i++)
                                        <div class="col-md-6">
                                            <div class="border rounded-4 p-3 h-100 bg-light">
                                                <h6 class="fw-bold mb-3">Étape {{ $i }}</h6>

                                                <label class="form-label fw-semibold">Titre</label>
                                                <input type="text"
                                                       name="sections[how][step_{{ $i }}_title]"
                                                       class="form-control mb-3"
                                                       value="{{ $sections['how']["step_{$i}_title"] ?? '' }}">

                                                <label class="form-label fw-semibold">Texte</label>
                                                <textarea name="sections[how][step_{{ $i }}_text]"
                                                          class="form-control"
                                                          rows="4">{{ $sections['how']["step_{$i}_text"] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="tab-pane fade" id="cta">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 p-4">
                                <h5 class="fw-bold mb-1">Section CTA</h5>
                                <p class="text-muted mb-0">Bloc final pour pousser l’utilisateur à s’inscrire.</p>
                            </div>

                            <div class="card-body p-4">
                                <label class="form-label fw-semibold">Titre</label>
                                <input type="text" name="sections[cta][title]" class="form-control mb-3"
                                       value="{{ $sections['cta']['title'] ?? '' }}">

                                <label class="form-label fw-semibold">Texte</label>
                                <textarea name="sections[cta][text]" class="form-control mb-3" rows="3">{{ $sections['cta']['text'] ?? '' }}</textarea>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bouton principal</label>
                                        <input type="text" name="sections[cta][button_primary]" class="form-control"
                                               value="{{ $sections['cta']['button_primary'] ?? '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bouton secondaire</label>
                                        <input type="text" name="sections[cta][button_secondary]" class="form-control"
                                               value="{{ $sections['cta']['button_secondary'] ?? '' }}">
                                    </div>
                                </div>

                                <label class="form-label fw-semibold mt-3">Note</label>
                                <input type="text" name="sections[cta][note]" class="form-control"
                                       value="{{ $sections['cta']['note'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    {{-- FOOTER --}}
<div class="tab-pane fade" id="footer">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-1">Footer</h5>
            <p class="text-muted mb-0">Modifier les colonnes, liens et copyright du pied de page.</p>
        </div>

        <div class="card-body p-4">

            {{-- Colonne marque --}}
            <div class="border rounded-4 p-3 mb-4 bg-light">
                <h6 class="fw-bold mb-3">Colonne marque</h6>

                <label class="form-label fw-semibold">Nom</label>
                <input type="text" name="sections[footer][brand_title]" class="form-control mb-3"
                       value="{{ $sections['footer']['brand_title'] ?? 'Cmlink' }}">

                <label class="form-label fw-semibold">Description</label>
                <textarea name="sections[footer][brand_description]" class="form-control" rows="3">{{ $sections['footer']['brand_description'] ?? 'La plateforme qui connecte les talents aux meilleures opportunités.' }}</textarea>
            </div>

            <div class="row g-4">
                {{-- Étudiants --}}
                <div class="col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <h6 class="fw-bold mb-3">Pour les étudiants</h6>

                        <label class="form-label fw-semibold">Titre colonne</label>
                        <input type="text" name="sections[footer][student_title]" class="form-control mb-3"
                               value="{{ $sections['footer']['student_title'] ?? 'Pour les étudiants' }}">

                        @for($i = 1; $i <= 4; $i++)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Lien {{ $i }} - Texte</label>
                                <input type="text" name="sections[footer][student_link_{{ $i }}_text]" class="form-control mb-2"
                                       value="{{ $sections['footer']["student_link_{$i}_text"] ?? '' }}">

                                <label class="form-label small text-muted">Lien {{ $i }} - URL</label>
                                <input type="text" name="sections[footer][student_link_{{ $i }}_url]" class="form-control"
                                       value="{{ $sections['footer']["student_link_{$i}_url"] ?? '#' }}">
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Entreprises --}}
                <div class="col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <h6 class="fw-bold mb-3">Pour les entreprises</h6>

                        <label class="form-label fw-semibold">Titre colonne</label>
                        <input type="text" name="sections[footer][company_title]" class="form-control mb-3"
                               value="{{ $sections['footer']['company_title'] ?? 'Pour les entreprises' }}">

                        @for($i = 1; $i <= 4; $i++)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Lien {{ $i }} - Texte</label>
                                <input type="text" name="sections[footer][company_link_{{ $i }}_text]" class="form-control mb-2"
                                       value="{{ $sections['footer']["company_link_{$i}_text"] ?? '' }}">

                                <label class="form-label small text-muted">Lien {{ $i }} - URL</label>
                                <input type="text" name="sections[footer][company_link_{{ $i }}_url]" class="form-control"
                                       value="{{ $sections['footer']["company_link_{$i}_url"] ?? '#' }}">
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Suivi / légal --}}
                <div class="col-md-4">
                    <div class="border rounded-4 p-3 h-100">
                        <h6 class="fw-bold mb-3">Nous suivre</h6>

                        <label class="form-label fw-semibold">Titre colonne</label>
                        <input type="text" name="sections[footer][social_title]" class="form-control mb-3"
                               value="{{ $sections['footer']['social_title'] ?? 'Nous suivre' }}">

                        @for($i = 1; $i <= 5; $i++)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Lien {{ $i }} - Texte</label>
                                <input type="text" name="sections[footer][social_link_{{ $i }}_text]" class="form-control mb-2"
                                       value="{{ $sections['footer']["social_link_{$i}_text"] ?? '' }}">

                                <label class="form-label small text-muted">Lien {{ $i }} - URL</label>
                                <input type="text" name="sections[footer][social_link_{{ $i }}_url]" class="form-control"
                                       value="{{ $sections['footer']["social_link_{$i}_url"] ?? '#' }}">
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="border rounded-4 p-3 mt-4 bg-light">
                <label class="form-label fw-semibold">Copyright</label>
                <input type="text" name="sections[footer][copyright]" class="form-control"
                       value="{{ $sections['footer']['copyright'] ?? '© 2025 Cmlink – Tous droits réservés. Simplifiez votre avenir professionnel.' }}">
            </div>

        </div>
    </div>
</div>

                </div>

                <div class="sticky-bottom bg-white border rounded-4 shadow-sm p-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Les modifications seront visibles sur le front-office après enregistrement.
                    </div>

                    <button class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i>
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
