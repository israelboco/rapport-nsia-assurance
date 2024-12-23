@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">CA FV1 - Gestion des Chefs CG et Fioles</h1>
    
    <!-- Navigation et Bouton Import -->
    <!-- ... (similaire à Info Holding) ... -->

    <div class="row">
        <!-- Boutons pour afficher les tableaux -->
        <div class="col-12 mb-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table5', this)">Prime Nette des Chefs CG</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table6', this)">Promesses des Chefs CG</button>
        </div>

        <!-- Tableau 5 -->
        <div class="col-lg-6 mb-3 d-none" id="table5">
            <!-- ... (structure similaire avec filtres pour impayés, mois de création, produit) ... -->
        </div>

        <!-- Tableau 6 -->
        <div class="col-lg-6 mb-3 d-none" id="table6">
            <!-- ... (structure similaire avec filtres pour mois de création) ... -->
        </div>
    </div>
</div>

@endsection