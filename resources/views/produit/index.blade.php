@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Produits</h1>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <!-- Navbar à gauche -->


        <!-- Bouton à droite -->
        <a href="#" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addRoleModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter
        </a>
    </div>

    <div>
        <p class="mb-4">Liste des produits.</p>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Produits</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ProduitsTableBody">
                        @foreach($produits as $item)
                            <tr>
                                <td>{{ $item->code_unique }}</td>
                                <td>{{ $item->nom }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <nav class="navbar navbar-expand navbar-light bg-light" style="width: auto;">
                                        <ul class="navbar-nav d-flex">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAction{{ $item->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="navbarDropdownAction{{ $item->id }}">
                                                    <!-- Update -->
                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#updateProduitModal{{ $item->id }}">
                                                        <button class="btn btn-warning btn-circle btn-sm">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                        <span class="ml-2">Modifier</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <!-- Delete -->
                                                    <a href="#" class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#deleteProduitModal{{ $item->id }}">
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
                                <div class="modal fade" id="updateProduitModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateProduitModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateProduitModalLabel{{ $item->id }}">Modifier le produit</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form class="user" action="{{ route('produit.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" placeholder="Entrer le Nom..." name="nom" value="{{ $item->nom }}" required>
                                                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Code du produit..." value="{{ $item->code_unique }}" name="code_unique" required>
                                                        <span class="text-danger small">@error('code_unique'){{ $message }} @enderror</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description:</label>
                                                        <textarea id="description" name="description" rows="4" cols="50">{{ $item->code_unique }}</textarea>
                                                        <span class="text-danger small">@error('description'){{ $message }} @enderror</span>
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
                                <div class="modal fade" id="deleteProduitModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteProduitModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteProduitModalLabel{{ $item->id }}">Voulez-vous supprimer ce produit ?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Sélectionnez « Supprimer » ci-dessous si vous êtes prêt à supprimer le produit.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                                <a class="btn btn-primary" href="{{ route('produit.delete', $item->id) }}">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $produits->links() }}
        </div>
    </div>
 </div>

  <!-- /.container-fluid -->

 <!-- addService Modal-->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enregistrer un nouveau produit</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{route('produit.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Nom..." name="nom" required>
                        <span class="text-danger small">@error('nom'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputNom" aria-describedby="emailHelp" placeholder="Entrer le Code du produit..." name="code_unique" required>
                        <span class="text-danger small">@error('code_unique'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4" cols="50"></textarea>
                        <span class="text-danger small">@error('description'){{ $message }} @enderror</span>
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