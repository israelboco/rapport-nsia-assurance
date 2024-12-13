@extends("index")

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contrat</h1>
    
    <!-- Navigation et Bouton Import -->
    <div class="d-flex flex-wrap align-items-center mb-2">
        <nav class="navbar navbar-expand-md navbar-light bg-light p-0 mr-3"> <!-- Added mr-3 to add space between the two navbars -->
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


    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
        <!-- Search Form aligned to the left -->
        <div class="col-12 col-md-auto">
            <form class="form-inline" action="{{ route('contrat.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Rechercher un contrat"
                        value="{{ request()->query('search') }}" aria-label="Recherche" style="width: 200px;">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Import Form aligned to the right -->
        <div class="ml-auto">
            <form class="form-inline" action="{{route('contrat.import')}}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="file" name="fichier_excel" class="form-control form-control-sm">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="submit">Importer</button>
                    </div>
                </div>
                <!-- Loading Spinner -->
                <div id="loadingSpinner" style="display: none; margin-left: 10px; align-items: center; color: #007bff;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('importForm').addEventListener('submit', function() {
            // Show the loading spinner
            document.getElementById('loadingSpinner').style.display = 'inline-flex';
        });
    </script>




    <div class="d-flex align-items-center justify-content-between p-2">
        <h6 class="mb-2 font-weight-bold text-primary">Liste Contrats</h6>
        <a class="btn btn-primary btn-sm" href="{{route('contrat.export')}}" id="exportButton">
            <i class="fas fa-file-excel fa-sm text-white-50"></i> Exporter
        </a>
        <div id="loadingSpinnerExport" style="display: none; margin-left: 10px; align-items: center; color: #007bff;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...
        </div>
    </div>

    <!-- <script>
        document.getElementById('exportButton').onclick = function() {
            document.getElementById('loadingSpinnerExport').style.display = 'inline-flex';
        };
    </script> -->


     
    <div class="row">
        @foreach ($contrats as $contrat)
            <div class="col-md-6 mb-4">  
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Contrat du produit : {{ isset($contrat->produit) ? $contrat->produit->nom : $contrat->produit_code }}
                        </h6>
                        <a href="{{ route('contrat.detail', $contrat->id) }}" class="btn btn-primary btn-sm">Voir</a>
                    </div>
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Police:</strong> {{ $contrat->Police }}</p>
                            <p class="card-text"><strong>N° Quittance:</strong> {{ $contrat->N_Quittance }}</p>
                            <p class="card-text"><strong>N° Quittance Annulée:</strong> {{ $contrat->N_Quittance_Annulee }}</p>
                            <p class="card-text"><strong>N° Police:</strong> {{ $contrat->N_Police }}</p>
                            <p class="card-text"><strong>Mois Effet Quittance:</strong> {{ $contrat->Mois_Effet_Quittance }}</p>
                            <p class="card-text"><strong>Nom Produit:</strong> {{ isset($contrat->produit) ? $contrat->produit->nom : $contrat->produit_code}}</p>
                            <p class="card-text"><strong>Type d'affaire:</strong> {{ $contrat->Typeaffaire }}</p>
                        </div>
                    </form>
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