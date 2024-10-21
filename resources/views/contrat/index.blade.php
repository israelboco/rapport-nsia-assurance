@extends("index")

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contrat</h1>
    
    <!-- Navigation et Bouton Import -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Services :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedServiceName">{{ $select_service ? $select_service->nom : 'Selectionner Service' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach($services as $item)
                                <a class="dropdown-item" href="{{ $select_produit ? url('contrat/index?service_id='.$item->id.'&produit_id='.$select_produit->id) : url('contrat/index?service_id='.$item->id.'&produit_id=') }}">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-12 col-md-auto">
            <nav class="navbar navbar-expand-md navbar-light bg-light p-0">
                <a class="navbar-brand" href="#">Produits :</a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selectedProductName">{{ $select_produit ? $select_produit->nom : 'Selectionner Produit' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach($produits as $item)
                                <a class="dropdown-item" href="{{ $select_service ? url('contrat/index?service_id='.$select_service->id.'&produit_id='.$item->id) : url('contrat/index?produit_id='.$item->id) }}">{{ $item->nom }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Bouton Import -->
        <div class="col-12 col-md-auto">
            <button class="btn btn-primary">
                <a href="{{route('contrat.import')}}" class="btn btn-sm btn-primary shadow-sm">                
                    <i class="fas fa-download fa-sm text-white-50"></i>Importer</a>
            </button>
        </div>
    </div>
    
    <div class="ml-auto">
        <form class="form-inline" action="{{ route('contrat.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search"  class="form-control form-control-sm" placeholder="Rechercher un contrat" value="{{ request()->query('search') }}" aria-label="Recherche" style="width: 200px;">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">Rechercher</button>
                </div>
            </div>
        </form>
    </div>

    
    <!-- Contracts List -->
     
    <div class="row">
        <h6 class="mb-2 font-weight-bold text-primary col-12">Liste Contrats</h6>
        @foreach ($contrats as $contrat)
            <div class="col-md-6 mb-4">  <!-- Changer col-md-4 à col-md-6 pour 2 colonnes -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $contrat->Produit }}</h5>
                        <p class="card-text"><strong>Police:</strong> {{ $contrat->Police }}</p>
                        <p class="card-text"><strong>N° Quittance:</strong> {{ $contrat->N_Quittance }}</p>
                        <p class="card-text"><strong>N° Quittance Annulée:</strong> {{ $contrat->N_Quittance_Annulee }}</p>
                        <p class="card-text"><strong>N° Police:</strong> {{ $contrat->N_Police }}</p>
                        <p class="card-text"><strong>Mois Effet Quittance:</strong> {{ $contrat->Mois_Effet_Quittance }}</p>
                        <p class="card-text"><strong>Nom Produit:</strong> {{ $contrat->Nom_produit }}</p>
                        <p class="card-text"><strong>Type d'affaire:</strong> {{ $contrat->Typeaffaire }}</p>
                        <!-- Ajoutez toutes les autres informations ici -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $contrats->links() }}
</div>

</div>



@endsection