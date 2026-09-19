<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card auth-card-small">
            <div class="auth-brand">
                {{-- Logo au lieu du texte --}}
                <img src="{{ asset('assets/img/cmlink.png') }}" alt="Cmlink Logo" class="auth-logo">
                <p>Connexion à votre espace</p>
            </div>

        @if(session('error'))
            <div class="auth-alert danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="auth-alert success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif

            <div>
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label>Mot de passe</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        name="password"
                        id="login-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="toggle-password"
                        aria-label="Afficher le mot de passe"
                        title="Afficher le mot de passe"
                    >
                        👁
                    </button>
                </div>

                @error('password')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-row">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Se souvenir de moi
                </label>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button type="submit" class="auth-btn">
                Se connecter
            </button>

            <p class="auth-bottom">
                Pas encore de compte ?
                <a href="{{ route('register', ['type' => 'etudiant']) }}">
                    Étudiant
                </a>
                ·
                <a href="{{ route('register', ['type' => 'entreprise']) }}">
                    Entreprise
                </a>
            </p>
        </form>
    </div>
</div>

<style>
    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        width: 100%;
        padding-right: 48px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);

        border: 0;
        background: transparent;

        padding: 4px;
        margin: 0;

        cursor: pointer;
        font-size: 18px;
        line-height: 1;

        opacity: 0.65;
        transition: opacity 0.2s ease;
    }

    .password-toggle:hover {
        opacity: 1;
    }

    .password-toggle:focus {
        outline: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('login-password');
        const toggleButton = document.getElementById('toggle-password');

        if (!passwordInput || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            toggleButton.textContent = isPassword ? '🙈' : '👁';

            toggleButton.setAttribute(
                'aria-label',
                isPassword
                    ? 'Masquer le mot de passe'
                    : 'Afficher le mot de passe'
            );

            toggleButton.setAttribute(
                'title',
                isPassword
                    ? 'Masquer le mot de passe'
                    : 'Afficher le mot de passe'
            );
        });
    });
</script>

</x-guest-layout>
