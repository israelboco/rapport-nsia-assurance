@extends('index')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Suivi des Impayés</h1>
    
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
            <button class="btn btn-primary toggle-btn" onclick="toggleTable('tableImpayes', this)">Impayés par service et agent</button>
        </div>

        <!-- Tableau des Impayés -->
        <div class="col-lg-6 mb-3 d-none" id="tableImpayes">
            <div class="card">
                <div class="card-header">Impayés par service et agent 
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
                    <label for="produitSelect">Produit :</label>
                    <select id="produitSelect" class="form-select mb-3">
                        <option value="">Produit</option>
                        <option value="1">Produit A</option>
                    </select>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Agent</th>
                                <th>Impayés</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Exemple</td>
                                <td>Agent X</td>
                                <td>500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection