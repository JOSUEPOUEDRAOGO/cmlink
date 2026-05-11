@extends('layouts.front')

@section('title', $etudiant->prenom . ' ' . $etudiant->nom . ' | Cmlink')

@section('content')
    @include('front.partials.header')

    @php
        $canSeePrivateStudentInfo = auth()->check()
            && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('entreprise'));

        $initials = strtoupper(substr($etudiant->prenom ?? 'E', 0, 1) . substr($etudiant->nom ?? '', 0, 1));
    @endphp

    <section class="student-profile-section" id="studentProfile">
        <div class="container">
            <div class="student-profile-card">

                <div class="profile-cover"></div>

                <div class="profile-header">
                    <div class="profile-avatar">
                        @if($canSeePrivateStudentInfo && !empty($etudiant->photo_path))
                            <img src="{{ asset('storage/'.$etudiant->photo_path) }}" alt="Photo de {{ $etudiant->prenom }} {{ $etudiant->nom }}">
                        @else
                            <span>{{ $initials }}</span>
                        @endif
                    </div>

                    <div class="profile-main-info">
                        <span class="profile-kicker">
                            <i class="bi bi-person-badge"></i>
                            Profil étudiant
                        </span>

                        <h1>{{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>

                        <p>
                            <i class="bi bi-mortarboard"></i>
                            {{ $etudiant->filiere->nom ?? 'Filière non précisée' }}
                        </p>
                    </div>
                </div>

                <div class="profile-content-grid">
                    <div class="profile-info-panel">
                        <h2>Informations du profil</h2>

                        <div class="profile-info-list">
                            <div class="profile-info-item">
                                <i class="bi bi-mortarboard"></i>
                                <div>
                                    <span>Filière</span>
                                    <strong>{{ $etudiant->filiere->nom ?? 'Non précisée' }}</strong>
                                </div>
                            </div>

                            @if($canSeePrivateStudentInfo)
                                <div class="profile-info-item">
                                    <i class="bi bi-envelope"></i>
                                    <div>
                                        <span>Email</span>
                                        <strong>{{ $etudiant->email }}</strong>
                                    </div>
                                </div>

                                <div class="profile-info-item">
                                    <i class="bi bi-telephone"></i>
                                    <div>
                                        <span>Téléphone</span>
                                        <strong>{{ $etudiant->telephone ?: 'Non précisé' }}</strong>
                                    </div>
                                </div>
                            @else
                                <div class="profile-info-item locked">
                                    <i class="bi bi-shield-lock"></i>
                                    <div>
                                        <span>Contact</span>
                                        <strong>Informations protégées</strong>
                                    </div>
                                </div>

                                <div class="profile-info-item locked">
                                    <i class="bi bi-eye-slash"></i>
                                    <div>
                                        <span>Confidentialité</span>
                                        <strong>Email, téléphone et photo masqués</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="profile-note-panel">
                        <div class="note-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <h2>Confidentialité du candidat</h2>

                        @if($canSeePrivateStudentInfo)
                            <p>
                                Vous avez accès aux informations de contact parce que votre rôle est autorisé à consulter les profils étudiants.
                            </p>
                        @else
                            <p>
                                Pour protéger les étudiants, les candidatures personnelles, l’email, le téléphone et la photo ne sont pas affichés publiquement.
                            </p>
                        @endif

                        <a href="{{ route('front.etudiants.index') }}" class="back-students-btn">
                            <i class="bi bi-arrow-left"></i>
                            Retour aux étudiants
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('front.partials.footer')

    <style>
        .student-profile-section {
            padding: 88px 0;
            background:
                radial-gradient(circle at 12% 14%, rgba(30, 74, 118, 0.10), transparent 34%),
                radial-gradient(circle at 88% 82%, rgba(37, 99, 235, 0.08), transparent 35%),
                #fbfdff;
            overflow: hidden;
        }

        .student-profile-card {
            position: relative;
            max-width: 1050px;
            margin: 0 auto;
            border-radius: 36px;
            background: rgba(255,255,255,0.94);
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 38px 90px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            opacity: 0;
            transform: translateY(44px) scale(0.98);
            transition: opacity 0.75s ease, transform 0.75s cubic-bezier(.2,.85,.25,1);
        }

        .student-profile-section.is-visible .student-profile-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .profile-cover {
            height: 180px;
            background:
                linear-gradient(135deg, rgba(30,74,118,0.96), rgba(43,106,159,0.88)),
                radial-gradient(circle at 90% 20%, rgba(255,255,255,0.28), transparent 35%);
        }

        .profile-header {
            position: relative;
            display: flex;
            gap: 26px;
            align-items: flex-end;
            padding: 0 42px 36px;
            margin-top: -70px;
        }

        .profile-avatar {
            width: 142px;
            height: 142px;
            min-width: 142px;
            border-radius: 34px;
            border: 6px solid #ffffff;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-weight: 950;
            font-size: 2rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-main-info {
            padding-bottom: 8px;
        }

        .profile-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            font-size: 0.86rem;
            font-weight: 850;
            margin-bottom: 14px;
        }

        .profile-main-info h1 {
            color: #0c2e44;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.045em;
            margin-bottom: 10px;
        }

        .profile-main-info p {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #557c9c;
            font-size: 1.05rem;
            font-weight: 750;
            margin: 0;
        }

        .profile-content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(300px, 0.8fr);
            gap: 26px;
            padding: 0 42px 42px;
        }

        .profile-info-panel,
        .profile-note-panel {
            border-radius: 30px;
            padding: 30px;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.96), rgba(239,246,255,0.80));
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.09);
        }

        .profile-info-panel h2,
        .profile-note-panel h2 {
            color: #0c2e44;
            font-size: 1.35rem;
            font-weight: 900;
            margin-bottom: 20px;
        }

        .profile-info-list {
            display: grid;
            gap: 14px;
        }

        .profile-info-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 16px;
            border-radius: 22px;
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(226, 232, 240, 0.95);
        }

        .profile-info-item i {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 16px;
            background: rgba(30, 74, 118, 0.08);
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .profile-info-item span {
            display: block;
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 750;
            margin-bottom: 4px;
        }

        .profile-info-item strong {
            color: #0c2e44;
            font-size: 1rem;
            line-height: 1.45;
        }

        .profile-info-item.locked i {
            background: rgba(100, 116, 139, 0.10);
            color: #64748b;
        }

        .note-icon {
            width: 62px;
            height: 62px;
            border-radius: 22px;
            background: #ffffff;
            color: #1e4a76;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
            margin-bottom: 20px;
        }

        .profile-note-panel p {
            color: #557c9c;
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .back-students-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 11px 18px;
            border-radius: 999px;
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(135deg, #1e4a76, #2b6a9f);
            font-weight: 850;
            box-shadow: 0 14px 30px rgba(30, 74, 118, 0.20);
        }

        @media (max-width: 900px) {
            .profile-content-grid {
                grid-template-columns: 1fr;
            }

            .profile-header {
                align-items: center;
            }
        }

        @media (max-width: 640px) {
            .student-profile-section {
                padding: 60px 0;
            }

            .profile-cover {
                height: 145px;
            }

            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 0 24px 30px;
            }

            .profile-avatar {
                width: 118px;
                height: 118px;
                min-width: 118px;
                border-radius: 28px;
            }

            .profile-content-grid {
                padding: 0 24px 28px;
            }

            .profile-info-panel,
            .profile-note-panel {
                padding: 24px;
                border-radius: 26px;
            }

            .back-students-btn {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const section = document.getElementById('studentProfile');

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