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
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Mot de passe</label>
                    <input type="password" name="password" required>
                    @error('password') <small>{{ $message }}</small> @enderror
                </div>

                <div class="auth-row">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                    @endif
                </div>

                <button type="submit" class="auth-btn">
                    Se connecter
                </button>

                <p class="auth-bottom">
                    Pas encore de compte ?
                    <a href="{{ route('register', ['type' => 'etudiant']) }}">Étudiant</a>
                    ·
                    <a href="{{ route('register', ['type' => 'entreprise']) }}">Entreprise</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>