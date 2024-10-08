@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Agents</h1>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <!-- Navbar à gauche -->
        <div>
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a class="navbar-brand" href="#">Services : </a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedServiceName">Selectionner Service</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                            @foreach($services as $item)
                                <a class="dropdown-item" href="#" onclick="updateSelectedService('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
            
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a class="navbar-brand" href="#">Roles : </a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedRoleName">Selectionner Role</span>
                        </a>
                        <div id="rolesSelect" class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                            @foreach($roles as $item)
                                <a class="dropdown-item" href="#" onclick="updateSelectedRole('{{ $item->nom }}', '{{ $item->id }}')">{{ $item->nom }}</a>
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
                fetchRolesForService(serviceId);
            }

            function updateSelectedRole(nom, roleId) {
                document.getElementById('selectedRoleName').textContent = nom;
                document.getElementById('selectedRoleId').value = roleId; // Correct usage of roleId
                // Fetch roles of the selected service and update the table dynamically
                // fetchRolesForRole(roleId);
            }

            function fetchRolesForService(serviceId) {
                // Requête AJAX pour récupérer les rôles en fonction du serviceId
                let $roles;
                let $roleOptions = ''; // Initialize as an empty string

                $.ajax({
                    url: "{{ route('role.select') }}", // Assurez-vous que cette route existe
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $roles = data;
                        $roles.forEach(function(role) {
                            $roleOptions += `<a class="dropdown-item" href="#" onclick="updateSelectedRole('${role.nom}', '${role.id}')">${role.nom}</a>`;
                        });
                        $('#rolesSelect').empty();
                        $('#rolesSelect').append($roleOptions);
                    }
                });
            };
        </script>


        <!-- Bouton à droite -->
        <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addAgentModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
        </a>
    </div>



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Agents</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Profile</th>
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
                                                <button class="btn btn-circle btn-sm" style="background-color: #fd7e14; color: white;">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                                <span class="ml-2">Blocked</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <!-- Contrat -->
                                            <a href="{{route('user.contrat', $item->id)}}" class="dropdown-item d-flex align-items-center">
                                                <button class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                                <span class="ml-2">Contrat</span>
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
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" value="{{ $item->nom }}">
                                                <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
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
                                        <h5 class="modal-title" id="blockedAgentModalLabel{{ $item->id }}">Voulez-vous bloquer l'agent?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Sélectionnez « Bloquer » ci-dessous si vous êtes prêt à bloquer l'agent.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                        <a class="btn btn-primary" href="{{ route('user.blocked', $item->id) }}">Bloquer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>

          </table>
        </div>
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
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Nom..." name="nom" required>
                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Prenom..." name="prenom" required>
                        <span class="text-danger small">@error('prenom'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Code..." name="code_unique" required>
                        <span class="text-danger small">@error('code_unique'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Email..." name="email" required>
                        <span class="text-danger small">@error('email'){{ $message }} @enderror</span>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Telephone..." name="telephone" required>
                        <span class="text-danger small">@error('telephone'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Domicile..." name="domicile" required>
                        <span class="text-danger small">@error('domicile'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le IFU..." name="ifu">
                        <span class="text-danger small">@error('ifu'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Compte bancaire..." name="compte_bancaire">
                        <span class="text-danger small">@error('compte_bancaire'){{ $message }} @enderror</span>
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