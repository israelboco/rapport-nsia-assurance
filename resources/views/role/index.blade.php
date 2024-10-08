@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Roles</h1>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <!-- Navbar à gauche -->
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

        <script>
            function updateSelectedService(nom, serviceId) {
                document.getElementById('selectedServiceName').textContent = nom;
                document.getElementById('selectedServiceId').value = serviceId;
                // Fetch roles of the selected service and update the table dynamically
                fetchRolesForService(serviceId);
            }

            function fetchRolesForService(serviceId) {
                // Requête AJAX pour récupérer les rôles en fonction du serviceId

                let $services;
                let serviceOptions = '';

                $.ajax({
                    url: "{{ route('service.select') }}", // Assurez-vous que cette route existe
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $services = data; // Stocker les services pour une utilisation ultérieure
                    }
                });

                console.log($services)
                $.ajax({
                    url: `${serviceId}`, // Assurez-vous que cette route existe
                    type: 'GET',
                    dataType: 'json', // Les données doivent être en format JSON
                    success: function(data) {
                        // Vider les lignes de table existantes
                        $('#rolesTableBody').empty();

                        data.forEach(function(role) {

                            $services.forEach(function(service) {
                                let selected = (service.id === role.service.id) ? 'selected' : '';
                                serviceOptions += `<option value="${service.id}" ${selected}>${service.nom}</option>`;
                            });
                        });
                        
                        // Parcourir les rôles renvoyés par la requête AJAX
                        data.forEach(function(role) {
                            // Créer des lignes de table avec des IDs dynamiques pour les modales
                            const roleRow = `
                                <tr>
                                    <td>${role.service.nom}</td>
                                    <td>${role.nom}</td>
                                    <td>${role.niveau}</td>
                                    <td>
                                        <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                            <ul class="navbar-nav d-flex">
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAction${role.id}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdownAction${role.id}">
                                                        <!-- Modifier -->
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#updateRoleModal${role.id}">
                                                            <button class="btn btn-warning btn-circle btn-sm">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                            <span class="ml-2">Modifier</span>
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <!-- Supprimer -->
                                                        <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#deleteRoleModal${role.id}">
                                                            <button class="btn btn-danger btn-circle btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <span class="ml-2">Supprimer</span>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </nav>
                                    </td>
                                </tr>
                            `;
                            // Ajouter la ligne et les modales à la table
                            $('#rolesTableBody').append(roleRow);

                            if ($("#updateRoleModal" + role.id).length === 0) {
                            var modalHTML = `
                                <div class="modal fade" id="updateRoleModal${role.id}" tabindex="-1" role="dialog" aria-labelledby="updateRoleModalLabel${role.id}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateRoleModalLabel${role.id}">Modifier le rôle</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form class="user" action="/role/update/${role.id}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" placeholder="Entrer le Nom..." name="nom" value="${role.nom}">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-user" placeholder="Entrer le Niveau..." name="niveau" value="${role.niveau}">
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="service_id" class="form-control" required>
                                                            ${serviceOptions}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>`;
                            
                            // Ajouter le modal dans le div card-body
                            $(".card-body").append(modalHTML);
}

                        });
                    },
                    error: function(error) {
                        console.error('Erreur lors de la récupération des rôles:', error);
                    }
                });
            }

        </script>


        <!-- Bouton à droite -->
        <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addRoleModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
        </a>
    </div>

    <div>
        <p class="mb-4">Liste des rôles.</p>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Nom</th>
                            <th>Niveau</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody">
                        @foreach($roles as $item)
                            <tr>
                                <td>{{ $item->service->nom }}</td>
                                <td>{{ $item->nom }}</td>
                                <td>{{ $item->niveau }}</td>
                                <td>
                                    <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                        <ul class="navbar-nav d-flex">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAction{{ $item->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdownAction{{ $item->id }}">
                                                    <!-- Update -->
                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#updateRoleModal{{ $item->id }}">
                                                        <button class="btn btn-warning btn-circle btn-sm">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                        <span class="ml-2">Modifier</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <!-- Delete -->
                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#deleteRoleModal{{ $item->id }}">
                                                        <button class="btn btn-danger btn-circle btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <span class="ml-2">Supprimer</span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </nav>
                                </td>

                                <!-- Modifier Service Modal -->
                                <div class="modal fade" id="updateRoleModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateRoleModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateRoleModalLabel{{ $item->id }}">Modifier le rôle</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form class="user" action="{{ route('role.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" value="{{ $item->nom }}" required>
                                                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-user" id="niveau" placeholder="Entrer le Niveau..." name="niveau" value="{{ $item->niveau }}" required>
                                                        <span class="text-danger small">@error('niveau'){{ $message }} @enderror</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="service_id" id="service_id" class="form-control" required>
                                                            <option value="" disabled selected>Veuillez choisir</option>
                                                            @foreach($services as $service)
                                                                <option value="{{$service->id}}" {{ $item->service->id == $service->id ? 'selected' : '' }}>
                                                                    {{$service->nom}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">@error('service_id'){{ $message }} @enderror</span>
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

                                <!-- Delete Role Modal -->
                                <div class="modal fade" id="deleteRoleModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteRoleModalLabel{{ $item->id }}">Voulez-vous supprimer ce rôle ?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Sélectionnez « Supprimer » ci-dessous si vous êtes prêt à supprimer le rôle.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                                <a class="btn btn-primary" href="{{ route('role.delete', $item->id) }}">Supprimer</a>
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
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrer un nouveau service</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{route('role.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input id="selectedServiceId" type="text" hidden class="form-control form-control-user"  name="service_id">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Nom..." name="nom" required>
                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-user" id="niveau" aria-describedby="emailHelp" placeholder="Entrer le Niveau..." name="niveau" required>
                        <span class="text-danger small">@error('niveau'){{ $message }} @enderror</span>
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