@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Agents</h1>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <!-- Navbar à gauche -->
        <div>
            <!-- Navbar pour Services -->
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a class="navbar-brand" href="#">Services :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedServiceName">{{ $select_service ? $select_service->nom : 'Sélectionner Service' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                            @foreach($services as $item)
                                <a class="dropdown-item" href="{{ $select_role ? url('user/index?service_id='.$item->id.'&role_id='.$select_role->id) : url('user/index?service_id='.$item->id.'&role_id=') }}" onclick="updateSelectedService('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Navbar pour Rôles -->
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a class="navbar-brand" href="#">Rôles :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedRoleName">{{ $select_role ? $select_role->nom : 'Sélectionner Rôle' }}</span>
                        </a>
                        <div id="rolesSelect" class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                            @foreach($roles as $item)
                                <a class="dropdown-item" href="{{$select_service ? url('user/index?service_id='.$select_service->id.'&role_id='.$item->id) : url('user/index?service_id=&role_id='.$item->id)}}" onclick="updateSelectedRole('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
        </div>

        <script>
            function updateSelectedService(nom, serviceId) {
                document.getElementById('selectedServiceName').textContent = nom;
                document.getElementById('selectedServiceId').value = serviceId;
                // Fetch roles of the selected service and update the table dynamically
            }

            function updateSelectedRole(nom, roleId) {
                document.getElementById('selectedRoleName').textContent = nom;
                document.getElementById('selectedRoleId').value = roleId;
                // Fetch roles of the selected service and update the table dynamically
            }
        </script>

        <!-- Bouton à droite -->
        <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addAgentModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Agents</h6>
        <a class="btn btn-primary btn-sm" href="{{route('user.export')}}">
            <i class="fas fa-file-excel fa-sm text-white-50"></i> Exporter
        </a>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Profil</th>
                <th>Nom et Prenom</th>
                <th>Code</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Domicile</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($agents as $item)
                    <tr>
                        <td>
                            <img class="img-profile rounded-circle img-fluid" src="{{asset($item->profile)}}" alt="profile" style="max-width: 50px; max-height: 50px;">
                        </td>

                        <td>{{ $item->nom }} {{ $item->prenom }}</td>
                        <td>{{ $item->code_unique }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telephone}}</td>
                        <td>{{ $item->domicile}}</td>
                        <td>
                            <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                <ul class="navbar-nav d-flex">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                                            <!-- Update -->
                                            <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#updateAgentModal{{ $item->id }}">
                                                <button class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                                <span class="ml-2">Update</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($user->is_admin)
                                                <!-- Delete -->
                                                <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#deleteAgentModal{{ $item->id }}">
                                                    <button class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <span class="ml-2">Delete</span>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- Blocked -->
                                                <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#blockedAgentModal{{ $item->id }}">
                                                    @if(!$item->is_blocked)
                                                        <button class="btn btn-circle btn-sm" style="background-color: #fd7e14; color: white;">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                        <span class="ml-2">Blocked</span>
                                                    @else
                                                        <button class="btn btn-circle btn-sm" style="background-color: #28a745; color: white;">
                                                            <i class="fas fa-unlock-alt"></i>
                                                        </button>
                                                        <span class="ml-2">Unlock</span>
                                                    @endif
                                                </a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            <!-- Contrat -->
                                            <a href="{{route('user.profile', $item->id)}}" class="dropdown-item d-flex align-items-center">
                                                <button class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                                <span class="ml-2">Profile</span>
                                            </a>

                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </td>

                        <!-- ModifierService Modal-->
                        <div class="modal fade" id="updateAgentModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateAgentModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateAgentModalLabel{{ $item->id }}">Modifier l'Agent</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form class="user" action="{{ route('user.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" required value="{{$item->nom}}">
                                                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputPrenom" placeholder="Entrer le Prenom..." name="prenom" required value="{{$item->prenom}}">
                                                        <span class="text-danger small">@error('prenom'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputCode" placeholder="Entrer le Code..." name="code_unique" required value="{{$item->code_unique}}">
                                                        <span class="text-danger small">@error('code_unique'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Entrer l' Email..." name="email" required value="{{$item->email}}">
                                                        <span class="text-danger small">@error('email'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sexe">Sélectionner: le Sexe</label>
                                                        <select name="sexe" id="sexe" class="form-control" required style="border-radius: 10rem;">
                                                            <option value="" disabled selected>Sexe</option>
                                                                <option value="MASCULIN" {{ $item->sexe == 'MASCULIN' ? 'selected' : '' }}>MASCULIN</option>
                                                                <option value="FEMININ" {{ $item->sexe == 'FEMININ' ? 'selected' : '' }}>FEMININ</option>
                                                        </select>
                                                        <span class="text-danger small">@error('sexe'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_naissance">Entrer la Date de Naissance</label>
                                                        <input type="date" class="form-control form-control-user" id="date_naissance" aria-describedby="emailHelp" placeholder="Entrer la Date de Naissance..." name="date_naissance" required value="{{$item->date_naissance}}">
                                                        <span class="text-danger small">@error('date_naissance'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Telephone..." name="telephone" required value="{{$item->telephone}}">
                                                        <span class="text-danger small">@error('telephone'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Domicile..." name="domicile" required value="{{$item->domicile}}">
                                                        <span class="text-danger small">@error('domicile'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Lieu de naissance..." name="lieu_naissance" required value="{{$item->lieu_naissance}}">
                                                        <span class="text-danger small">@error('lieu_naissance'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer la Banque..." name="banque" value="{{$item->banque}}">
                                                        <span class="text-danger small">@error('banque'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer l' IFU..." name="ifu" value="{{$item->ifu}}">
                                                        <span class="text-danger small">@error('ifu'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Compte bancaire..." name="compte_bancaire" value="{{$item->compte_bancaire}}">
                                                        <span class="text-danger small">@error('compte_bancaire'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mode_reglement">Sélectionner : le Mode de paiement</label>
                                                        <select name="mode_reglement" id="mode_reglement" class="form-control" required style="border-radius: 10rem;">
                                                            <option value="" disabled selected>Mode de paiement</option>
                                                                <option value="MOMO" {{ $item->mode_reglement == 'MOMO' ? 'selected' : '' }}>MOMO</option>
                                                                <option value="BANQUE" {{ $item->mode_reglement == 'BANQUE' ? 'selected' : '' }}>BANQUE</option>
                                                                <option value="VIREMENT" {{ $item->mode_reglement == 'VIREMENT' ? 'selected' : '' }}>VIREMENT</option>
                                                                <option value="CHEQUE" {{ $item->mode_reglement == 'CHEQUE' ? 'selected' : '' }}>CHEQUE</option>
                                                        </select>
                                                        <span class="text-danger small">@error('mode_reglement'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_collaboration">Entrer la Date de collaboration</label>
                                                        <input type="date" class="form-control form-control-user" id="date_collaboration" aria-describedby="emailHelp" placeholder="Entrer la Date de collaboration..." name="date_collaboration" value="{{$item->date_collaboration}}">
                                                        <span class="text-danger small">@error('date_collaboration'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select name="service_id" id="service_id" class="form-control" required style="border-radius: 10rem;">
                                                            <option value="" disabled selected>Sélectionner: le Service</option>
                                                            @foreach($services as $service)
                                                                <option value="{{$service->id}}" {{ (isset($item->service) && $item->service->id == $service->id) ? 'selected' : '' }}>
                                                                    {{$service->nom}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('service_id'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select name="role_id" id="role_id" class="form-control" required style="border-radius: 10rem;">
                                                            <option value="" disabled selected>Sélectionner: le Rôle</option>
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}" {{ (isset($item->role) && $item->role->id == $role->id) ? 'selected' : '' }}>
                                                                    {{$role->nom}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('role_id'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="supervo_id">Sélectionner : ces supérieurs</label>
                                                <select name="supervo_id[]" id="supervo_id" class="form-control" multiple>
                                                    @foreach($agent_sup as $agent)
                                                        <option value="{{$agent->id}}" {{ in_array($agent->id, $item->supervo_ids->toArray()) ? 'selected' : '' }}>
                                                            {{$agent->nom}} {{$agent->prenom}} ({{$agent->role->nom}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <style>
                                                    select option:checked {
                                                        background-color: #28a745;
                                                        color: white;
                                                    }
                                                </style>
                                                <span class="text-danger">@error('supervo_id'){{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if($user->is_admin)
                            <!-- Delete Service Modal-->
                            <div class="modal fade" id="deleteAgentModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteAgentModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteAgentModalLabel{{ $item->id }}">Voulez-vous supprimer l'agent?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Sélectionnez « Supprimer » ci-dessous si vous êtes prêt à supprimer l'agent.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            <a class="btn btn-primary" href="{{ route('user.delete', $item->id) }}">Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Blocked Service Modal-->
                            <div class="modal fade" id="blockedAgentModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="blockedAgentModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="blockedAgentModalLabel{{ $item->id }}">{{ $item->is_blocked ? 'Voulez-vous débloquer l\'agent?' : 'Voulez-vous bloquer l\'agent?'}}</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">{{ $item->is_blocked ? 'Sélectionnez « débloquer » ci-dessous si vous êtes prêt à débloquer l\'agent.' : 'Sélectionnez « Bloquer » ci-dessous si vous êtes prêt à bloquer l\'agent.'}}</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            <a class="btn btn-primary" href="{{ route('user.blocked', $item->id) }}">{{ $item->is_blocked ? 'Débloquer': 'Bloquer'}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        {{ $agents->links() }}
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

 <!-- addService Modal-->
<div class="modal fade" id="addAgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrer un nouveau Agent</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{route('user.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" required>
                                <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPrenom" placeholder="Entrer le Prenom..." name="prenom" required>
                                <span class="text-danger small">@error('prenom'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputCode" placeholder="Entrer le Code..." name="code_unique" required>
                                <span class="text-danger small">@error('code_unique'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Entrer l' Email..." name="email" required>
                                <span class="text-danger small">@error('email'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sexe">Sélectionner: le Sexe</label>
                                <select name="sexe" id="sexe" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Sexe</option>
                                        <option value="MASCULIN">MASCULIN</option>
                                        <option value="FEMININ">FEMININ</option>
                                </select>
                                <span class="text-danger small">@error('sexe'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_naissance">Entrer la Date de Naissance</label>
                                <input type="date" class="form-control form-control-user" id="date_naissance" aria-describedby="emailHelp" placeholder="Entrer la Date de Naissance..." name="date_naissance" required>
                                <span class="text-danger small">@error('date_naissance'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Telephone..." name="telephone" required>
                                <span class="text-danger small">@error('telephone'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Domicile..." name="domicile" required>
                                <span class="text-danger small">@error('domicile'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Lieu de naissance..." name="lieu_naissance" required>
                                <span class="text-danger small">@error('lieu_naissance'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer la Banque..." name="banque" required>
                                <span class="text-danger small">@error('banque'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer l' IFU..." name="ifu">
                                <span class="text-danger small">@error('ifu'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Compte bancaire..." name="compte_bancaire">
                                <span class="text-danger small">@error('compte_bancaire'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mode_reglement">Sélectionner : le Mode de paiement</label>
                                <select name="mode_reglement" id="mode_reglement" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Mode de paiement</option>
                                        <option value="MOMO">MOMO</option>
                                        <option value="BANQUE">BANQUE</option>
                                        <option value="VIREMENT">VIREMENT</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                </select>
                                <span class="text-danger small">@error('mode_reglement'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_collaboration">Entrer la Date de collaboration</label>
                                <input type="date" class="form-control form-control-user" id="date_collaboration" aria-describedby="emailHelp" placeholder="Entrer la Date de collaboration..." name="date_collaboration">
                                <span class="text-danger small">@error('date_collaboration'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="service_id" id="service_id" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Sélectionner: le Service</option>
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}">
                                            {{$service->nom}}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('service_id'){{ $message }} @enderror</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="role_id" id="role_id" class="form-control" required style="border-radius: 10rem;">
                                    <option value="" disabled selected>Sélectionner: le Rôle</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">
                                            {{$role->nom}}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('role_id'){{ $message }} @enderror</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supervo_id">Sélectionner : ces supérieurs</label>
                        <select name="supervo_id[]" id="supervo_id" class="form-control" multiple>
                            @foreach($agent_sup as $agent)
                                <option value="{{$agent->id}}">
                                    {{$agent->nom}} {{$agent->prenom}} ({{$agent->role->nom}})
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger">@error('supervo_id'){{ $message }} @enderror</span>
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