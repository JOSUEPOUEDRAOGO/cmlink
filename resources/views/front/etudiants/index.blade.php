@extends('layouts.front')

@section('title', 'Étudiants | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $canSeePrivateStudentInfo = auth()->check()
            && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('entreprise'));
    @endphp

    <section class="students-page-section" id="studentsPage">
        <div class="container">

            <div class="students-hero">
                <span class="students-kicker">
                    <i class="bi bi-people"></i>
                    Talents disponibles
                </span>

                <h1>Découvrez les profils étudiants</h1>

                <p>
                    Parcourez les talents, leurs filières et leurs profils. Les informations sensibles restent protégées selon votre rôle.
                </p>
            </div>

            <form method="GET" action="{{ route('front.etudiants.index') }}" class="students-filter-card">
                <div class="filter-field filter-search">
                    <div class="filter-input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, prénom, filière...">
                    </div>
                </div>

                <div class="filter-field">
                    <select name="filiere">
                        <option value="">Toutes les filières</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" @selected((string) request('filiere') === (string) $filiere->id)>
                                {{ $filiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-submit">
                        <i class="bi bi-sliders"></i>
                        Filtrer
                    </button>

                    <a href="{{ route('front.etudiants.index') }}" class="filter-reset">
                        Réinitialiser
                    </a>
                </div>
            </form>

            <div class="students-grid">
                @forelse($etudiants as $etudiant)
                    @php
                        $initials = strtoupper(substr($etudiant->prenom ?? 'E', 0, 1) . substr($etudiant->nom ?? '', 0, 1));
                    @endphp

                    <article class="student-card">
                        <div class="student-card-bg"></div>

                        <div class="student-top">
                            <div class="student-avatar">
                                @if($canSeePrivateStudentInfo && !empty($etudiant->photo_path))
                                    <img src="{{ asset('storage/'.$etudiant->photo_path) }}" alt="Photo de {{ $etudiant->prenom }} {{ $etudiant->nom }}">
                                @else
                                    <span>{{ $initials }}</span>
                                @endif
                            </div>

                            <div class="student-identity">
                                <h2>{{ $etudiant->prenom }} {{ $etudiant->nom }}</h2>

                                <span>
                                    <i class="bi bi-mortarboard"></i>
                                    {{ $etudiant->filiere->nom ?? 'Filière non précisée' }}
                                </span>
                            </div>
                        </div>

                        <div class="student-info-list">
                            @if($canSeePrivateStudentInfo)
                                <div class="student-info-item">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ $etudiant->email }}</span>
                                </div>

                                <div class="student-info-item">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ $etudiant->telephone ?: 'Téléphone non précisé' }}</span>
                                </div>
                            @else
                                <div class="student-info-item muted">
                                    <i class="bi bi-shield-lock"></i>
                                    <span>Contact privé protégé</span>
                                </div>

                                <div class="student-info-item muted">
                                    <i class="bi bi-eye-slash"></i>
                                    <span>Email et téléphone masqués</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('front.etudiants.show', $etudiant) }}" class="student-view-btn">
                            Voir le profil
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </article>
                @empty
                    <div class="empty-students-box">
                        <i class="bi bi-person-x"></i>
                        <h3>Aucun étudiant trouvé</h3>
                        <p>Essayez de modifier vos filtres ou revenez plus tard.</p>
                    </div>
                @endforelse
            </div>

            @if($etudiants->hasPages())
                <div class="students-pagination">
                    {{ $etudiants->links() }}
                </div>
            @endif
        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .students-page-section {
            padding: 88px 0;
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 88% 82%, rgba(37, 99, 235, 0.08), transparent 35%),
                #fbfdff;
            overflow: hidden;
        }

        .students-hero {
            max-width: 850px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .students-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            font-size: 0.88rem;
            font-weight: 850;
            margin-bottom: 18px;
        }

        .students-hero h1 {
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.045em;
            color: #0c2e44;
            margin-bottom: 18px;
        }

        .students-hero p {
            color: #557c9c;
            font-size: 1.08rem;
            line-height: 1.75;
            max-width: 650px;
            margin: 0 auto;
        }

        .students-filter-card {
            display: grid;
            grid-template-columns: minmax(250px, 1.5fr) minmax(220px, 1fr) auto;
            gap: 16px;
            align-items: end;
            background: rgba(255,255,255,0.94);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 30px;
            padding: 22px;
            box-shadow: 0 28px 65px rgba(15, 23, 42, 0.11);
            margin-bottom: 30px;
        }

        .filter-field label {
            display: block;
            color: #0c2e44;
            font-size: 0.84rem;
            font-weight: 850;
            margin-bottom: 8px;
        }

        .filter-input-icon {
            position: relative;
        }

        .filter-input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            border: 1px solid #dbe6f0;
            background: #ffffff;
            color: #0c2e44;
            padding: 12px 15px;
            outline: none;
            font-weight: 600;
        }

        .filter-search input {
            padding-left: 42px;
        }

        .filter-field input:focus,
        .filter-field select:focus {
            border-color: #1e4a76;
            box-shadow: 0 0 0 4px rgba(30, 74, 118, 0.10);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .filter-submit,
        .filter-reset {
            min-height: 48px;
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 850;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .filter-submit {
            border: none;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            color: #ffffff;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        .filter-reset {
            border: 1px solid rgba(30, 74, 118, 0.18);
            color: #1e4a76;
            background: #ffffff;
        }

        .students-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
        }

        .student-card {
            position: relative;
            min-height: 330px;
            padding: 26px;
            border-radius: 30px;
            background: rgba(255,255,255,0.93);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow:
                0 28px 65px rgba(15, 23, 42, 0.12),
                inset 0 1px 0 rgba(255,255,255,0.95);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(42px) scale(0.97);
            transition: opacity 0.72s ease, transform 0.72s cubic-bezier(.2,.85,.25,1), box-shadow 0.3s ease;
        }

        .students-page-section.is-visible .student-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .student-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 42px 90px rgba(15, 23, 42, 0.18);
        }

        .student-card-bg {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(239,246,255,0.80)),
                radial-gradient(circle at 92% 8%, rgba(30, 74, 118, 0.16), transparent 35%);
            pointer-events: none;
        }

        .student-top,
        .student-info-list,
        .student-view-btn {
            position: relative;
            z-index: 2;
        }

        .student-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 24px;
        }

        .student-avatar {
            width: 70px;
            height: 70px;
            min-width: 70px;
            border-radius: 24px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-weight: 950;
            font-size: 1.2rem;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-identity h2 {
            color: #0c2e44;
            font-size: 1.32rem;
            line-height: 1.25;
            font-weight: 900;
            margin: 0 0 8px;
        }

        .student-identity span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #557c9c;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .student-info-list {
            display: grid;
            gap: 12px;
            margin-bottom: 24px;
        }

        .student-info-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 14px;
            border-radius: 18px;
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #345a76;
            font-weight: 650;
            line-height: 1.45;
        }

        .student-info-item i {
            color: #1e4a76;
            margin-top: 2px;
        }

        .student-info-item.muted {
            color: #64748b;
            background: rgba(248, 250, 252, 0.88);
        }

        .student-view-btn {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 11px 18px;
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            text-decoration: none;
            font-weight: 850;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        .empty-students-box {
            grid-column: 1 / -1;
            text-align: center;
            background: #ffffff;
            border: 1px solid #eef2f8;
            border-radius: 30px;
            padding: 55px 24px;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
        }

        .empty-students-box i {
            font-size: 2.8rem;
            color: #1e4a76;
            margin-bottom: 14px;
        }

        .empty-students-box h3 {
            color: #0c2e44;
            font-weight: 900;
        }

        .empty-students-box p {
            color: #557c9c;
            margin: 0;
        }

        .students-pagination {
            margin-top: 38px;
        }

        @media (max-width: 1150px) {
            .students-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .students-filter-card {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .filter-actions {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 720px) {
            .students-page-section {
                padding: 62px 0;
            }

            .students-filter-card {
                grid-template-columns: 1fr;
                padding: 18px;
                border-radius: 24px;
            }

            .filter-actions {
                flex-direction: column;
            }

            .filter-submit,
            .filter-reset {
                width: 100%;
            }

            .students-grid {
                grid-template-columns: 1fr;
            }

            .student-card {
                min-height: auto;
                padding: 22px;
                border-radius: 26px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const section = document.getElementById('studentsPage');

            if (!section) return;

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        section.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.15
            });

            observer.observe(section);
        });
    </script>
@endsection