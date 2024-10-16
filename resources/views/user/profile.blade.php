@extends("index")

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile: {{$profile->nom}} {{$profile->prenom}}</h1>
    <a href="{{route('user.deal', $profile->id)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-file-alt fa-sm text-white-50"></i> Deals
    </a>

    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Chiffre d'affaire</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$chiffre_affaire}} XOF</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Subordonnées</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$subordinates_count}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-fw fa-user fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Deal conclure</div>
                <div class="row no-gutters align-items-center">
                <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$pourcental_deal}}%</div>
                </div>
                <div class="col">
                    <div class="progress progress-sm mr-2">
                    <div class="progress">
                            <style>
                                .progress {
                                    width: 100%;
                                    height: 15px;
                                }
                            </style>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                    <script>
                        window.onload = function () {
                            var progressBar = document.getElementById('progress-bar');
                            var progress = 0;
                            var targetProgress = parseInt("{{ $pourcental_deal }}"); // valeur à partir de la variable PHP

                            var interval = setInterval(function() {
                                if (progress < targetProgress) {
                                    progress++;
                                    progressBar.style.width = progress + '%';
                                    progressBar.setAttribute('aria-valuenow', progress);
                                } else {
                                    clearInterval(interval);  // Arrête l'animation quand la valeur cible est atteinte
                                }
                            }, 20); // 20ms pour ajuster la vitesse de progression
                        };
                    </script>

                    </div>
                </div>
                </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Deal en cours</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$deal_encours}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-file-alt fa-2x text-warning"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4 w-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Traitement du chiffres d'affaire</h6>
                </div>
                <div class="card-body">
                    <!-- Parametre -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paramètre</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="option1" id="surbordonnes">
                                        <label class="form-check-label" for="surbordonnes">
                                            Surbordonnées
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dateInput">Date:</label>
                                        <input class="form-control" type="date" id="dateInput" placeholder="Date...">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="calculerChiffreAffaire()">Voir</button>
                        </div>
                    </div>
                    <!-- Calcule -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Calcule du chiffre d'affaire</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="resultatInput">Chiffre d'affaire</label>
                                <p id="resultatInput" class="font-weight-bold">0 <span>XOF</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function calculerChiffreAffaire() {
                const surbordonnes = document.getElementById('surbordonnes').checked;
                const dateInput = document.getElementById('dateInput').value;
                let chiffreAffaire;
                console.log(document.getElementById('surbordonnes'));
                console.log(surbordonnes);
                $.ajax({
                    url: "{{ url('user/calcule/ca') }}" + "?user_id=" + '{{$profile->id}}' + "&datesearch=" + dateInput + "&sub=" + surbordonnes,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        chiffreAffaire = data;
                        console.log(chiffreAffaire);
                        document.getElementById('resultatInput').innerHTML = `${chiffreAffaire} <span>XOF</span>`;
                    }
                });
            }
        </script>

    </div>

    <!-- Content Row -->
    <div class="row">


    <!-- Content Column -->
    <div class="{{$profile->id == $user->id ? 'col-lg-6': 'col-lg-12'}} mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informations sur l'agent</h6>
            </div>
            <div class="card-body">
                <form class="user">
                    <div class="modal-body">
                        <!-- Informations personnelles -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputNom">Nom:</label>
                                            <p id="exampleInputNom" class="font-weight-bold">{{$profile->nom}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPrenom">Prénom:</label>
                                            <p id="exampleInputPrenom" class="font-weight-bold">{{ $profile->prenom }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputCode">Code unique:</label>
                                            <p id="exampleInputCode" class="font-weight-bold">{{ $profile->code_unique }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Email:</label>
                                            <p id="exampleInputEmail" class="font-weight-bold">{{ $profile->email }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_naissance">Telephone:</label>
                                            <p id="date_naissance" class="font-weight-bold">{{ $profile->telephone }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sexe">Sexe:</label>
                                            <p id="sexe" class="font-weight-bold">{{ $profile->sexe }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_naissance">Date de Naissance:</label> 
                                            <p id="date_naissance" class="font-weight-bold">{{ \Carbon\Carbon::parse($profile->date_naissance)->format('d F Y') }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Informations bancaires -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Informations bancaires</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputBanque">Banque:</label>
                                            <p id="exampleInputBanque" class="font-weight-bold">{{ $profile->banque }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputCompteBancaire">Compte bancaire:</label>
                                            <p id="exampleInputCompteBancaire" class="font-weight-bold">{{ $profile->compte_bancaire }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Superviseurs -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Superviseurs</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <p id="supervo_id">
                                            @foreach($agent_sup as $agent)
                                                <span>{{ $agent->nom }} {{ $agent->prenom }} ({{ $agent->role->nom }})</span><br>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>


    </div>

    <div class="col-lg-6 mb-4">

        @if($user->id == $profile->id)
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modifier mot de passe</h6>
                </div>
                <div class="card-body">
                    <form class="user" action="{{route('user.update_password', $profile->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer l'ancien Mot de passe..." name="old_password" required>
                                <span class="text-danger small">@error('old_password'){{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Mot de passe..." name="password" required>
                                <span class="text-danger small">@error('password'){{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password_confirmation" aria-describedby="emailHelp" placeholder="Confirmation mot de passe..." name="password_confirmation" required>
                                <span class="text-danger small">@error('password_confirmation'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button> -->
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($user->id == $profile->id)
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modifier l'image de Profile</h6>
                </div>
                <div class="card-body">
                    <form class="user" action="{{route('user.image_profile', $profile->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <img id="imagePreview" src="{{ asset($profile->profile) }}" alt="" class="img-profile rounded-circle img-fluid">
                                </div>
                            <div>
                                <input type="file" id="url_profil" name="image" class="form-control-file">
                            </div>
                            <span class="text-danger small">@error('image'){{ $message }} @enderror</span>
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button> -->
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                    document.getElementById('url_profil').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('imagePreview').src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
            </script>
        @endif


        <!-- Approach -->
        <!-- <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>
            </div>
        </div> -->

    </div>
    </div>

 </div>
 <!-- /.container-fluid -->

@endsection