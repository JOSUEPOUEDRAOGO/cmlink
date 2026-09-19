<x-guest-layout>

    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 430px;
            background: #fff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-logo {
            width: 85px;
            height: 85px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .auth-brand h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .auth-brand p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .auth-description {
            margin-bottom: 22px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #f8fafc;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .auth-form-group {
            margin-bottom: 18px;
        }

        .auth-form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .auth-form-group input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #fff;
            color: #111827;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .auth-form-group input:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
        }

        .auth-error {
            display: block;
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .auth-session-status {
            margin-bottom: 18px;
            padding: 10px 14px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #047857;
            font-size: 13px;
        }

        .auth-submit {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 13px 18px;
            background: #14b8a6;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .auth-submit:hover {
            background: #0f9f91;
            transform: translateY(-1px);
        }

        .auth-back {
            display: block;
            margin-top: 18px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-back:hover {
            color: #14b8a6;
        }

        @media (max-width: 480px) {
            .auth-page {
                padding: 16px;
            }

            .auth-card {
                padding: 24px 20px;
            }

            .auth-logo {
                width: 75px;
                height: 75px;
            }
        }
    </style>

    <div class="auth-page">

        <div class="auth-card">

            {{-- LOGO --}}
            <div class="auth-brand">

                <img
                    src="{{ asset('assets/img/cmlink.png') }}"
                    alt="CMLINK Logo"
                    class="auth-logo"
                >

                <h1>Mot de passe oublié ?</h1>

                <p>
                    Réinitialisez votre mot de passe
                </p>

            </div>

            {{-- DESCRIPTION --}}
            <div class="auth-description">
                {{ __('Pas de problème. Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.') }}
            </div>

            {{-- SESSION STATUS --}}
            @if (session('status'))
                <div class="auth-session-status">
                    {{ session('status') }}
                </div>
            @endif

            {{-- FORMULAIRE --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="auth-form-group">

                    <label for="email">
                        Adresse e-mail
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="exemple@email.com"
                    >

                    @error('email')
                        <span class="auth-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <button type="submit" class="auth-btn">
                    Envoyer le lien de réinitialisation
                </button>

            </form>

            {{-- RETOUR LOGIN --}}
            <a href="{{ route('login') }}" class="auth-back">
                ← Retour à la connexion
            </a>

        </div>

    </div>

</x-guest-layout>
