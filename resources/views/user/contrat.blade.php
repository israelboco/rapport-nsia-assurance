@extends("index")

@section('content')

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contrat</h1>


    <!-- eTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste Contrats:</h6>
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
                                            @if($profile->id == $item->user->id)
                                                <a href="#" class="dropdown-item d-flex align-items-center" e-toggle="modal" e-target="#updateContratModal{{ $item->id }}">
                                                    <button class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                    <span class="ml-2">Update</span>
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </td>
                        @if($profile->id == $item->user->id)
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
                        @endif

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

@endsection