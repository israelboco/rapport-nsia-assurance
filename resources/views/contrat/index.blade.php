@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contrat</h1>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Services :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedServiceName">{{ $select_service ? $select_service->nom : 'Selectionner Service'}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach($services as $item)
                                <a class="dropdown-item" href="{{ $select_role ? url('contrat/index?service_id='.$item->id.'&role_id='.$select_role->id) : url('contrat/index?service_id='.$item->id.'&role_id=') }}" onclick="updateSelectedService('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Roles :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedRoleName">{{ $select_role ? $select_role->nom : 'Selectionner Role'}}</span>
                        </a>
                        <div id="rolesSelect" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach($roles as $item)
                                <a class="dropdown-item" href="{{$select_service ? url('contrat/index?service_id='.$select_service->id.'&role_id='.$item->id) : url('contrat/index?service_id=&role_id='.$item->id)}}" onclick="updateSelectedRole('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Statut :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedStatut">{{ $statut ? $statut : 'Selectionner Statut'}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('contrat/index?service_id=' . ($select_service ? $select_service->id : '') . '&role_id=' . ($select_role ? $select_role->id : '') . '&statut=' . 'en attente') }}">En attente</a>
                            <a class="dropdown-item" href="{{url('contrat/index?service_id='. ($select_service ? $select_service->id : '') .'&role_id='. ($select_role ? $select_role->id : '') .'&statut='. 'à conclure')}}">A Conclure</a>
                            <a class="dropdown-item" href="{{url('contrat/index?service_id='. ($select_service ? $select_service->id : '') .'&role_id='. ($select_role ? $select_role->id : '') .'&statut='. 'annuler')}}">Annuler</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Date :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedDateLabel">{{ $date ? $date : 'Selectionner Date'}}</span>
                        </a>
                        <div id="dateSelect" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div>
                                <a class="dropdown-item" id="dynamic-link" href="{{url('contrat/index?service_id='. ($select_service ? $select_service->id : '') .'&role_id='. ($select_role ? $select_role->id : '') .'&statut='.( $statut ? $statut : '') . '&date=')}}">
                                    <input type="date" class="form-control" id="date-input" placeholder="Entrer la date">
                                    <!-- <span id="datelabel"></span> -->
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Bouton à droite -->
        <div class="col-12 col-md-auto">
            <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addContratModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
            </a>
        </div>
    </div>


    <script>
        document.getElementById('date-input').addEventListener('change', function() {
            const selectedDate = this.value;
            const link = document.getElementById('dynamic-link');
            link.href = "{{ url('contrat/index?service_id='. ($select_service ? $select_service->id : '') .'&role_id='. ($select_role ? $select_role->id : '') .'&statut='. ($statut ? $statut : '')) . '&date=' }}" + selectedDate;

            // document.getElementById('datelabel').textContent = selectedDate;
            document.getElementById('selectedDateLabel').textContent = selectedDate;
        });
    </script>





    <!-- eTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Contrat</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="eTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nom et Prenom du prospect</th>
                <th>Email du prospect</th>
                <th>Telephone du prospect</th>
                <th>Lieu de signature</th>
                <th>Nature</th>
                <th>Produit</th>
                <th>Statut</th>
                <th>Date de conclusion</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($contrats as $item)
                    <tr>
                        <td>{{ $item->prospect_nom }} {{ $item->prospect_prenom }}</td>
                        <td>{{ $item->prospect_email }}</td>
                        <td>{{ $item->prospect_telephone }}</td>
                        <td>{{ $item->lieu_signature }}</td>
                        <td>{{ $item->nature }}</td>
                        <td>{{ $item->produit->nom }}</td>
                        <td>{{ $item->statut }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date_conclusion)->format('d F Y') }}</td>
                        <td>
                            <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                <ul class="navbar-nav d-flex">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" e-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                                            <!-- Update -->
                                            <a href="#" class="dropdown-item d-flex align-items-center" e-toggle="modal" e-target="#updateContratModal{{ $item->id }}">
                                                <button class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                                <span class="ml-2">Update</span>
                                            </a>
                                            <!-- <div class="dropdown-divider"></div> -->
                                            <!-- Delete -->
                                            <!-- <a href="#" class="dropdown-item d-flex align-items-center" e-toggle="modal" e-target="#deleteContratModal{{$item->id}}">
                                                <button class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <span class="ml-2">Delete</span>
                                            </a> -->
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </td>

                        <!-- ModifierService Modal-->
                        <div class="modal fade" id="updateContratModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateContratModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateContratModalLabel{{ $item->id }}">Modifier le service</h5>
                                        <button class="close" type="button" e-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form class="user" action="{{ route('contrat.update', $item->id) }}" method="post" enctype="multipart/form-e">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="prospect_nom" required value="{{$item->prospect_nom}}">
                                                        <span class="text-danger small">@error('prospect_nom'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputPrenom" placeholder="Entrer le Prenom..." name="prospect_prenom" required value="{{$item->prospect_prenom}}">
                                                        <span class="text-danger small">@error('prospect_prenom'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control form-control-user" id="exampleInputCode" placeholder="Entrer le Mail..." name="prospect_email" required value="{{$item->prospect_email}}">
                                                        <span class="text-danger small">@error('prospect_email'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="Entrer le Telephone..." name="prospect_telephone" required value="{{$item->prospect_telephone}}">
                                                        <span class="text-danger small">@error('prospect_telephone'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="produit_id">Sélectionner: le Produit</label>
                                                        <select name="produit_id" id="produit_id" class="form-control" required>
                                                            <option value="" disabled selected>Produit</option>
                                                            @foreach($produits as $produit)
                                                                <option value="{{$produit->id}}" {{$item->produit->id == $produit->id ? 'selected' : ''}}>
                                                                    {{$produit->nom}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger small">@error('produit_id'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="montant">Entrer le Montant</label>
                                                        <input type="number" class="form-control form-control-user" id="montant" aria-describedby="emailHelp" placeholder="Entrer le montant..." name="montant" required value="{{$item->montant}}">
                                                        <span class="text-danger small">@error('montant'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer la Nature..." name="nature" required value="{{$item->nature}}">
                                                        <span class="text-danger small">@error('nature'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le lieu de la Signature..." name="lieu_signature" required value="{{$item->lieu_signature}}">
                                                        <span class="text-danger small">@error('lieu_signature'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="statut">Sélectionner : l'Etat</label>
                                                        <select name="statut" id="statut" class="form-control" required>
                                                            <option value="" disabled selected>Statut Contrat</option>
                                                                <option value="en attente" {{$item->statut == 'en attente' ? 'selected' : ''}}>En attente</option>
                                                                <option value="à conclure" {{$item->statut == 'à conclure' ? 'selected' : ''}}>A conclure</option>
                                                                <option value="annuler" {{$item->statut == 'annuler' ? 'selected' : ''}}>Annuler</option>
                                                        </select>
                                                        <span class="text-danger small">@error('statut'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_conclusion">Entrer la date de conclusion</label>
                                                        <input type="date" class="form-control form-control-user" id="date_conclusion" aria-describedby="emailHelp" placeholder="Entrer la date de conclusion..." name="date_conclusion" value="{{$item->date_conclusion}}">
                                                        <span class="text-danger small">@error('date_conclusion'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" e-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Service Modal-->
                        <!-- <div class="modal fade" id="deleteContratModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteContratModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteContratModalLabel{{ $item->id }}">Voulez-vous supprimer le service?</h5>
                                        <button class="close" type="button" e-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Sélectionnez « Supprimer » ci-dessous si vous êtes prêt à supprimer le contrat.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                        <a class="btn btn-primary" href="{{ route('contrat.delete', $item->id) }}">Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        {{ $contrats->links() }}
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

 <!-- addService Modal-->
<div class="modal fade" id="addContratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrer un nouveau service</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{route('contrat.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="prospect_nom" required>
                                <span class="text-danger small">@error('prospect_nom'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPrenom" placeholder="Entrer le Prenom..." name="prospect_prenom" required>
                                <span class="text-danger small">@error('prospect_prenom'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputCode" placeholder="Entrer le Mail..." name="prospect_email" required>
                                <span class="text-danger small">@error('prospect_email'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="Entrer le Telephone..." name="prospect_telephone" required>
                                <span class="text-danger small">@error('prospect_telephone'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="produit_id">Sélectionner: le Produit</label>
                                <select name="produit_id" id="produit_id" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Produit</option>
                                    @foreach($produits as $item)
                                        <option value="{{$item->id}}">{{$item->nom}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger small">@error('produit_id'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="montant">Entrer le Montant</label>
                                <input type="number" class="form-control form-control-user" id="montant" aria-describedby="emailHelp" placeholder="Entrer le montant..." name="montant" required>
                                <span class="text-danger small">@error('montant'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer la Nature..." name="nature" required>
                                <span class="text-danger small">@error('nature'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le lieu de la Signature..." name="lieu_signature" required>
                                <span class="text-danger small">@error('lieu_signature'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="statut">Sélectionner : l'Etat</label>
                                <select name="statut" id="statut" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Statut Contrat</option>
                                        <option value="en attente">En attente</option>
                                        <option value="à conclure">A conclure</option>
                                        <option value="annuler">Annuler</option>
                                </select>
                                <style>
                                    select option:checked {
                                        background-color: #28a745;
                                        color: white;
                                    }
                                </style>
                                <span class="text-danger small">@error('statut'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_conclusion">Entrer la date de conclusion</label>
                                <input type="date" class="form-control form-control-user" id="date_conclusion" aria-describedby="emailHelp" placeholder="Entrer la date de conclusion..." name="date_conclusion">
                                <span class="text-danger small">@error('date_conclusion'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection