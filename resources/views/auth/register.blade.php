<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-brand">
                <h1>Cmlink</h1>
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
                            @error('nom') <small>{{ $message }}</small> @enderror
                        </div>

                        <div>
                            <label>Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" required>
                            @error('prenom') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div>
                        <label>Filière</label>
                        <select name="filiere_id" required>
                            <option value="">Choisir une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" @selected(old('filiere_id') == $filiere->id)>
                                    {{ $filiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiere_id') <small>{{ $message }}</small> @enderror
                    </div>
                @endif

                @if($type === 'entreprise')
                    <div>
                        <label>Nom de l’entreprise</label>
                        <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise') }}" required>
                        @error('nom_entreprise') <small>{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label>Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse') }}">
                        @error('adresse') <small>{{ $message }}</small> @enderror
                    </div>
                @endif

                <div>
                    <label>Nom du compte</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}">
                    @error('telephone') <small>{{ $message }}</small> @enderror
                </div>

                <div class="auth-grid">
                    <div>
                        <label>Mot de passe</label>
                        <input type="password" name="password" required>
                        @error('password') <small>{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label>Confirmer</label>
                        <input type="password" name="password_confirmation" required>
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
</x-guest-layout>