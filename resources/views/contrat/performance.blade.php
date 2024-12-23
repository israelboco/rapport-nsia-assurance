@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Performance Globale</h1>
    
    <!-- Navigation et Bouton Import -->
    <!-- ... (Identique à l'exemple) ... -->

    <!-- <div class="row"> -->
        <!-- Boutons pour afficher les tableaux -->
        <div class="col-12 mb-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tablePerf1', this)">Performance des services</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tablePerf2', this)">Comparaison des performances</button>
        </div>

        <!-- Tableau des performances des services -->
        <div class="col-12 mb-3 d-none" id="tablePerf1">
            <div class="card">
                <div class="card-header">Performance des services
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Production Brute</th>
                                <th>Production Nette</th>
                                <th>Encaissements</th>
                                <th>Impayés</th>
                                <th>CA 2023 à date</th>
                                <th>TX Pg/Rg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Force de Vente</td>
                                <td>10000</td>
                                <td>9000</td>
                                <td>8000</td>
                                <td>1000</td>
                                <td>50000</td>
                                <td>90%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau de comparaison des performances -->
        <div class="col-12 mb-3 d-none" id="tablePerf2">
            <div class="card">
                <div class="card-header">Comparaison des performances
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Réalisation 13 milliards</th>
                                <th>Réalisation 15 milliards</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Banque</td>
                                <td>12.5M</td>
                                <td>14M</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

@endsection