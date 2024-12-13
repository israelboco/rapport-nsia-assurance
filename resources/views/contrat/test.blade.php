@extends("index")

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Informations sur la détention</h1>
    
    <!-- Navigation et Bouton Import -->

    <div class="row mb-3">
        <div class="col-auto">
            <button class="btn btn-primary" id="prevWeek">Semaine précédente</button>
        </div>
        <div class="col-auto">
            <label for="startDate">Date Début:</label>
            <input type="date" id="startDate" name="startDate" class="form-control" value="{{$startDate}}">
        </div>
        <div class="col-auto">
            <label for="endDate">Date Fin:</label>
            <input type="date" id="endDate" name="endDate" class="form-control" value="{{$endDate}}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" id="nextWeek">Semaine suivante</button>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="#collapseCardSommeMP" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardSommeMP">
            <!-- <div class="card-header py-3 d-flex justify-content-between align-items-center"> -->
                <h6 class="m-0 font-weight-bold text-primary">
                    Sommes des montants à payer
                </h6>
            <!-- </div> -->
        </a>
        <div class="card-body collapse" id="collapseCardSommeMP">
            <div class="row mb-3">
                <div class="col">
                    <label for="serviceFilter">Service:</label>
                    <select id="serviceFilter" class="form-control">
                        @foreach($services as $item)
                            <option value="{{$item->id}}">{{$item->nom}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <!-- <label for="startDateFilter">Date Début:</label>
                    <input type="date" id="startDateFilter" class="form-control"> -->
                    <a href="" class="btn btn-primary btn-sm">Voir</a>
                </div>
                <!-- <div class="col">
                    <label for="endDateFilter">Date Fin:</label>
                    <input type="date" id="endDateFilter" class="form-control">
                </div> -->
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Services</th>
                        <th>Affaire Nouvelle</th>
                        <th>Renouvellement</th>
                        <th>Autre</th>
                        <th>Total Général</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Les données seront insérées ici dynamiquement -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        
    </script>

    
</div>



@endsection