@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Informations sur la détention</h1>
    
    <!-- Navigation et Bouton Import -->

    <div class="row mb-3 justify-content-between align-items-center">
        <div class="col-auto">
            <button class="btn btn-primary" id="prevWeek">Semaine précédente</button>
        </div>
        <div class="col-auto text-center">
            <label for="startDate">Date Début:</label>
            <input type="date" id="startDate" name="startDate" class="form-control" value="{{$startDate}}">
        </div>
        <div class="col-auto text-center">
            <label for="endDate">Date Fin:</label>
            <input type="date" id="endDate" name="endDate" class="form-control" value="{{$endDate}}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" id="nextWeek">Semaine suivante</button>
        </div>
    </div>


    <div class="row">
        <!-- Boutons pour afficher les tableaux -->
        <div class="col-12 mb-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table1', this)">Sommes des montants à payer</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table2', this)">Sommes de primes nettes</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table3', this)">Sommes d'encaissements</button>
        </div>

        <!-- Tableau 1 -->
        <div class="col-lg-6 mb-3 d-none" id="table1">
            <div class="card">
                <div class="card-header">Sommes des montants à payer 
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <label for="serviceSelect">Service :</label>
                    <select id="serviceSelect" class="form-select mb-3">
                        <option value="">Service</option>
                        <option value="1">Force de Vente</option>
                        <option value="2">Banque</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Services</th>
                                <th>Affaire nouvelle</th>
                                <th>Renouvellement</th>
                                <th>Autre</th>
                                <th>Total Général</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Exemple</td>
                                <td>1000</td>
                                <td>2000</td>
                                <td>500</td>
                                <td>3500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Répétez pour les autres tableaux -->
        <div class="col-lg-6 mb-3 d-none" id="table2">
            <div class="card">
                <div class="card-header">Sommes de primes nettes
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <label for="impayeSelect">Impayé :</label>
                    <select id="impayeSelect" class="form-select mb-3">
                        <option value="">Impayé</option>
                        <option value="1">Produit</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mois de création</th>
                                <th>Affaire nouvelle</th>
                                <th>Renouvellement</th>
                                <th>Autre</th>
                                <th>Total Général</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Janvier</td>
                                <td>3000</td>
                                <td>1500</td>
                                <td>800</td>
                                <td>5300</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau 3 -->
        <div class="col-lg-6 mb-3 d-none" id="table3">
            <div class="card">
                <div class="card-header">Sommes d'encaissements
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <label for="produitSelect">Produit :</label>
                    <select id="produitSelect" class="form-select mb-3">
                        <option value="">Impayé</option>
                        <option value="1">Produit</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mois de création</th>
                                <th>Affaire nouvelle</th>
                                <th>Renouvellement</th>
                                <th>Autre</th>
                                <th>Total Général</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Février</td>
                                <td>4000</td>
                                <td>2500</td>
                                <td>1200</td>
                                <td>7700</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
