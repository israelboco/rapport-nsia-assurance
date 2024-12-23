@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Nbrs Contact FV1 - Affaires Nouvelles</h1>
    
    <!-- Navigation et Bouton Import -->
    <!-- ... (similaire à Info Holding) ... -->

    <div class="row">
        <!-- Boutons pour afficher les tableaux -->
        <div class="col-12 mb-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table7', this)">Nombre d'Affaires Nouvelles</button>
        </div>

        <!-- Tableau 7 -->
        <div class="col-lg-6 mb-3 d-none" id="table7">
            <!-- ... (structure similaire avec filtres pour impayés, mois de création, produit) ... -->
        </div>
    </div>
</div>

@endsection