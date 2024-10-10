@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contrat</h1>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <!-- Navbar à gauche -->
        <!-- <nav class="navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </nav> -->
        <p class="mb-4">Liste des Contrats.</p>

        <!-- Bouton à droite -->
        <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addContratModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
        </a>
    </div>



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Contrat</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Action</th>
                <!-- <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th> -->
              </tr>
            </thead>
            <tbody>
                @foreach($contrats as $item)
                    <tr>
                        <td>{{ $item->nom }}</td>
                        <td>
                            <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                <ul class="navbar-nav d-flex">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdown">
                                            <!-- Update -->
                                            <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#updateServiceModal{{ $item->id }}">
                                                <button class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                                <span class="ml-2">Update</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <!-- Delete -->
                                            <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#deleteServiceModal{{ $item->id }}">
                                                <button class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <span class="ml-2">Delete</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </td>

                        <!-- ModifierService Modal-->
                        <div class="modal fade" id="updateServiceModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateServiceModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateServiceModalLabel{{ $item->id }}">Modifier le service</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form class="user" action="{{ route('service.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" value="{{ $item->nom }}" required>
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
                        <div class="modal fade" id="deleteServiceModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteServiceModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteServiceModalLabel{{ $item->id }}">Voulez-vous supprimer le service?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Sélectionnez « Supprimer » ci-dessous si vous êtes prêt à supprimer le service.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                        <a class="btn btn-primary" href="{{ route('service.delete', $item->id) }}">Supprimer</a>
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
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Nom..." name="nom" required>
                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
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