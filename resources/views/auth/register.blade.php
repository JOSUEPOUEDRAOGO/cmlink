<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-brand">
                {{-- Logo au lieu du texte --}}
                <img src="{{ asset('assets/img/cmlink.png') }}" alt="Cmlink Logo" class="auth-logo">

            <p>
                @if($type === 'entreprise')
                    Créez votre espace entreprise
                @else
                    Créez votre espace étudiant
                @endif
            </p>
        </div>

        <div class="auth-switch">
            <a href="{{ route('register', ['type' => 'etudiant']) }}"
               class="{{ $type === 'etudiant' ? 'active' : '' }}">
                Étudiant
            </a>

            <a href="{{ route('register', ['type' => 'entreprise']) }}"
               class="{{ $type === 'entreprise' ? 'active' : '' }}">
                Entreprise
            </a>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="hidden" name="account_type" value="{{ $type }}">

            @if($type === 'etudiant')
                <div class="auth-grid">
                    <div>
                        <label>Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label>Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div>
                    <label>Filière</label>
                    <select name="filiere_id" required>
                        <option value="">Choisir une filière</option>

                        @foreach($filieres as $filiere)
                            <option
                                value="{{ $filiere->id }}"
                                @selected(old('filiere_id') == $filiere->id)
                            >
                                {{ $filiere->nom }}
                            </option>
                        @endforeach
                    </select>

                    @error('filiere_id')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            @endif

            @if($type === 'entreprise')
                <div>
                    <label>Nom de l’entreprise</label>
                    <input
                        type="text"
                        name="nom_entreprise"
                        value="{{ old('nom_entreprise') }}"
                        required
                    >

                    @error('nom_entreprise')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label>Adresse</label>
                    <input
                        type="text"
                        name="adresse"
                        value="{{ old('adresse') }}"
                    >

                    @error('adresse')
                        <small>{{ $message }}</small>
                    @enderror
                </div>
            @endif

            <div>
                <label>Nom du compte</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                >

                @error('name')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >

                @error('email')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label>Téléphone</label>
                <input
                    type="text"
                    name="telephone"
                    value="{{ old('telephone') }}"
                >

                @error('telephone')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-grid">

                {{-- MOT DE PASSE --}}
                <div>
                    <label>Mot de passe</label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="register-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-target="register-password"
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

                {{-- CONFIRMATION --}}
                <div>
                    <label>Confirmer</label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="register-password-confirmation"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            data-target="register-password-confirmation"
                            aria-label="Afficher la confirmation"
                            title="Afficher la confirmation"
                        >
                            👁
                        </button>
                    </div>
                </div>

            </div>

            <button type="submit" class="auth-btn">
                Créer mon compte
            </button>

            <p class="auth-bottom">
                Déjà inscrit ?
                <a href="{{ route('login') }}">Se connecter</a>
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
        const toggleButtons = document.querySelectorAll('.password-toggle');

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';

                button.textContent = isPassword ? '🙈' : '👁';

                button.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Masquer le mot de passe'
                        : 'Afficher le mot de passe'
                );

                button.setAttribute(
                    'title',
                    isPassword
                        ? 'Masquer le mot de passe'
                        : 'Afficher le mot de passe'
                );
            });
        });
    });
</script>

</x-guest-layout>
