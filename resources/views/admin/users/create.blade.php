@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Ajouter un utilisateur
            </h2>

            <p class="text-muted mb-0">
                Création d'un compte administrateur, étudiant ou entreprise.
            </p>
        </div>


        <a href="{{ route('admin.users.index') }}"
           class="btn btn-light border rounded-pill px-4">

            <i class="bi bi-arrow-left me-2"></i>
            Retour

        </a>

    </div>



    @if($errors->any())

        <div class="alert alert-danger rounded-4">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif




    <form method="POST"
          action="{{ route('admin.users.store') }}">

        @csrf



        <div class="row g-4">


            {{-- Informations utilisateur --}}

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">


                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold">

                            <i class="bi bi-person me-2"></i>
                            Informations utilisateur

                        </h5>

                    </div>


                    <div class="card-body p-4">


                        <div class="row g-3">


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Nom complet
                                </label>


                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control rounded-3"
                                       required>

                            </div>



                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email
                                </label>


                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control rounded-3"
                                       required>

                            </div>




                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Mot de passe
                                </label>


                                <input type="password"
                                       name="password"
                                       class="form-control rounded-3"
                                       required>

                            </div>




                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Confirmation
                                </label>


                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control rounded-3"
                                       required>

                            </div>



                        </div>

                    </div>

                </div>



                {{-- Rôles --}}

                <div class="card border-0 shadow-sm rounded-4 mt-4">


                    <div class="card-header bg-white border-0 pt-4 px-4">

                        <h5 class="fw-bold">

                            <i class="bi bi-shield-check me-2"></i>

                            Rôles utilisateur

                        </h5>

                        <small class="text-muted">
                            Plusieurs rôles possibles
                        </small>

                    </div>



                    <div class="card-body p-4">


                        <select name="roles[]"
                                class="form-select rounded-3"
                                multiple
                                size="5">


                            @foreach($roles as $role)


                                <option value="{{ $role->id }}">

                                    {{ ucfirst($role->name) }}

                                </option>


                            @endforeach


                        </select>


                    </div>


                </div>





                {{-- Permissions --}}

                <div class="card border-0 shadow-sm rounded-4 mt-4">


                    <div class="card-header bg-white border-0 pt-4 px-4">


                        <h5 class="fw-bold">

                            <i class="bi bi-key me-2"></i>

                            Permissions personnalisées

                        </h5>


                        <small class="text-muted">

                            Vous pouvez ajouter des permissions directes

                        </small>


                    </div>




                    <div class="card-body p-4">


                        <select name="permissions[]"
                                class="form-select rounded-3"
                                multiple
                                size="8">


                            @foreach($permissions as $permission)


                                <option value="{{ $permission->id }}">

                                    {{ $permission->name }}

                                </option>


                            @endforeach


                        </select>


                    </div>


                </div>


            </div>






            {{-- Configuration compte --}}

            <div class="col-lg-4">


                <div class="card border-0 shadow-sm rounded-4">


                    <div class="card-header bg-white border-0 pt-4 px-4">


                        <h5 class="fw-bold">

                            <i class="bi bi-gear me-2"></i>

                            Configuration

                        </h5>


                    </div>



                    <div class="card-body p-4">


                        {{-- Profil --}}

                        <label class="form-label fw-semibold">

                            Profil

                        </label>


                        <select name="account_type"
                                class="form-select rounded-3 mb-4">


                            <option value="">
                                Choisir
                            </option>


                            <option value="admin">
                                Administrateur
                            </option>


                            <option value="etudiant">
                                Étudiant
                            </option>


                            <option value="entreprise">
                                Entreprise
                            </option>


                        </select>





                        {{-- Statut --}}

                        <label class="form-label fw-semibold">

                            Statut

                        </label>



                        <select name="status"
                                class="form-select rounded-3">


                            <option value="actif">
                                Actif
                            </option>


                            <option value="en_attente">
                                En attente
                            </option>


                            <option value="suspendu">
                                Suspendu
                            </option>


                            <option value="refuse">
                                Refusé
                            </option>


                        </select>



                    </div>


                </div>




                <button type="submit"
                        class="btn btn-primary w-100 rounded-pill mt-4 py-3">


                    <i class="bi bi-check-circle me-2"></i>

                    Créer l'utilisateur


                </button>



            </div>


        </div>


    </form>


</div>

@endsection
