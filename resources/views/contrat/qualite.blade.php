@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Qualité - Suivi de la Performance par Service</h1>
    
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
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table1', this)">Prime Nette par Type d'Affaire</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table2', this)">Encaissement par Type d'Affaire</button>
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('table3', this)">Affaires Nouvelles par Agent</button>
        </div>

        <!-- Tableau 1 -->
        <div class="col-lg-6 mb-3 d-none" id="table1">
            <div class="card">
                <div class="card-header">Prime Nette par Type d'Affaire
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <label for="produitSelect">Produit :</label>
                    <select id="produitSelect" class="form-select mb-3">
                        <option value="">Produit</option>
                        <option value="1">Produit A</option>
                    </select>
                    <label for="impayeSelect">Impayé :</label>
                    <select id="impayeSelect" class="form-select mb-3">
                        <option value="">Impayé</option>
                        <option value="1">Oui</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type d'Affaire</th>
                                <th>Janvier</th>
                                <th>Février</th>
                                <th>Mars</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nouvelle</td>
                                <td>1000</td>
                                <td>1200</td>
                                <td>1100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau 2 -->
        <div class="col-lg-6 mb-3 d-none" id="table2">
            <div class="card">
                <div class="card-header">Encaissement par Type d'Affaire
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type d'Affaire</th>
                                <th>Janvier</th>
                                <th>Février</th>
                                <th>Mars</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nouvelle</td>
                                <td>2000</td>
                                <td>2300</td>
                                <td>2100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau 3 -->
        <div class="col-lg-6 mb-3 d-none" id="table3">
            <div class="card">
                <div class="card-header">Affaires Nouvelles par Agent
                    <button onclick="" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                </div>
                <div class="card-body">
                    <label for="produitSelect">Produit :</label>
                    <select id="produitSelect" class="form-select mb-3">
                        <option value="">Produit</option>
                        <option value="1">Produit A</option>
                    </select>
                    <label for="semaineSelect">Semaine :</label>
                    <select id="semaineSelect" class="form-select mb-3">
                        <option value="">Semaine</option>
                        <option value="1">Semaine 1</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Janvier</th>
                                <th>Février</th>
                                <th>Mars</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Agent 1</td>
                                <td>5</td>
                                <td>7</td>
                                <td>6</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection