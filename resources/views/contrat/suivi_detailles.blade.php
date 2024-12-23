@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Suivi Détaillé</h1>
    
    <!-- Navigation et Bouton Import -->
    <!-- ... (Identique à l'exemple) ... -->

    <!-- <div class="row"> -->
        <!-- Boutons pour afficher les tableaux -->
        <div class="col-12 mb-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tableSuivi1', this)">Objectifs par service</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tableSuivi2', this)">Objectifs par agent</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tableSuivi3', this)">Objectifs par produit</button>
        </div>

        <!-- Tableau des objectifs par service -->
        <div class="col-12 mb-3 d-none" id="tableSuivi1">
            <div class="card">
                <div class="card-header">Objectifs par service
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type d'Affaire</th>
                                <th>Service</th>
                                <th>Objectif</th>
                                <th>Réalisation</th>
                                <th>Encaissement</th>
                                <th>Taux Réalisation</th>
                                <th>Taux Encaissement</th>
                                <th>Contribution</th>
                                <th>CA 2023 à date</th>
                                <th>TX Pg/Rg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nouvelle</td>
                                <td>Force de Vente</td>
                                <td>10000</td>
                                <td>9000</td>
                                <td>8000</td>
                                <td>90%</td>
                                <td>80%</td>
                                <td>50%</td>
                                <td>50000</td>
                                <td>90%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau des objectifs par agent -->
        <div class="col-12 mb-3 d-none" id="tableSuivi2">
            <div class="card">
                <div class="card-header">Objectifs par agent
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type d'Affaire</th>
                                <th>Agent</th>
                                <th>Service</th>
                                <th>Objectif</th>
                                <th>Réalisation</th>
                                <th>Encaissement</th>
                                <th>Taux Réalisation</th>
                                <th>Taux Encaissement</th>
                                <th>Contribution</th>
                                <th>CA 2023 à date</th>
                                <th>TX Pg/Rg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Renouvellement</td>
                                <td>Agent Y</td>
                                <td>Banque</td>
                                <td>5000</td>
                                <td>4500</td>
                                <td>4000</td>
                                <td>90%</td>
                                <td>80%</td>
                                <td>25%</td>
                                <td>20000</td>
                                <td>85%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau des objectifs par produit -->
        <div class="col-12 mb-3 d-none" id="tableSuivi3">
            <div class="card">
                <div class="card-header">Objectifs par produit
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type d'Affaire</th>
                                <th>Produit</th>
                                <th>Objectif</th>
                                <th>Réalisation</th>
                                <th>Encaissement</th>
                                <th>Taux Réalisation</th>
                                <th>Taux Encaissement</th>
                                <th>Contribution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Autre</td>
                                <td>Produit B</td>
                                <td>3000</td>
                                <td>2800</td>
                                <td>2600</td>
                                <td>93%</td>
                                <td>87%</td>
                                <td>15%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

@endsection