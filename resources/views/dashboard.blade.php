@extends("index")

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Chiffre d'affaire</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$chiffre_affaire}} XOF</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Agents</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$agent_count}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-fw fa-user fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Contrats</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$deal_count}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Contrats en cours</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$deal_encours}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-file-alt fa-2x text-warning"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <!-- Content Row -->

    <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Chiffres d'affaire</h6>
                <div class="dropdown no-arrow">
                    <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div> -->
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Produits</h6>
            <div class="dropdown no-arrow">
            <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Dropdown Header:</div>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div> -->
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
            <span class="mr-2">
                <i class="fas fa-circle text-primary"></i> {{ $productPercentages[0]['name'] }}
            </span>
            <span class="mr-2">
                <i class="fas fa-circle text-success"></i> {{ isset($productPercentages[1]) ? $productPercentages[1]['name'] : '' }}
            </span>
            <span class="mr-2">
                <i class="fas fa-circle text-info"></i> {{ isset($productPercentages[2]) ? $productPercentages[2]['name'] : '' }}
            </span>
            </div>
            <!-- @foreach ($productPercentages as $product)
                <span class="mr-2">
                    <i class="fas fa-circle text-success"></i>
                    <p>{{ $product['name'] }}: {{ $product['percentage'] }}%</p>
                </span>
            @endforeach -->
        </div>
        </div>
    </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardImport" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardImport">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Importation
                    </h6>
                </a>
                <div class="collapse" id="collapseCardImport">
                    <form class="user">
                        <div class="modal-body">
                        <div class="ml-auto">
                            <form class="form-inline d-flex align-items-center" action="{{route('agent.import')}}" method="POST" enctype="multipart/form-data" id="importFormAgent">
                                @csrf
                            </form>
                        </div>
                        <div class="ml-auto">
                            <form class="form-inline d-flex align-items-center" action="{{route('agent.import')}}" method="POST" enctype="multipart/form-data" id="importFormAgent">
                                @csrf
                                <div class="input-group mb-3">
                                    <label class="mr-2">Importer les agents</label>
                                    <input type="file" name="fichier_excel" class="form-control form-control-sm">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-sm" type="submit">Importer</button>
                                    </div>
                                </div>
                                <div id="loadingSpinnerAgent" style="display: none; margin-left: 10px; align-items: center; color: #007bff;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...
                                </div>
                            </form>
                        </div>

                        <div class="ml-auto">
                            <form class="form-inline d-flex align-items-center" action="{{route('agent_sup.import')}}" method="POST" enctype="multipart/form-data" id="importFormAgentSup">
                                @csrf
                                <div class="input-group mb-3">
                                    <label class="mr-2">Importer les superviseur d'un agent</label>
                                    <input type="file" name="fichier_excel" class="form-control form-control-sm">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-sm" type="submit">Importer</button>
                                    </div>
                                </div>
                                <!-- Loading Spinner -->
                                <div id="loadingSpinnerAgentSup" style="display: none; margin-left: 10px; align-items: center; color: #007bff;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...
                                </div>
                            </form>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('importFormAgent').addEventListener('submit', function() {
                // Show the loading spinner
                document.getElementById('loadingSpinnerAgent').style.display = 'inline-flex';
            });
            document.getElementById('importFormAgentSup').addEventListener('submit', function() {
                // Show the loading spinner
                document.getElementById('loadingSpinnerAgentSup').style.display = 'inline-flex';
            });
        </script>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardExport" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExport">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Exportation
                    </h6>
                </a>
                <div class="collapse" id="collapseCardExport">
                    <form class="user">
                        <div class="modal-body">
                            <div class="ml-auto">
                                <div class="d-flex align-items-center justify-content-between p-2">
                                    <h6 class="mb-2 font-weight-bold text-primary">Racap sur les dials</h6>
                                    <a class="btn btn-primary btn-sm" href="{{route('deal_object_all.export')}}">
                                        <i class="fas fa-file-excel fa-sm text-white-50"></i> Exporter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function () {
            // Initialisation de myAreaChart
            var ctx = document.getElementById('myAreaChart').getContext('2d');
            var myAreaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Chiffre d\'affaires annuel (Deal) XOF',
                            data: {!! json_encode($chiffre_affaire_annuel) !!},
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            borderColor: 'rgba(78, 115, 223, 1)',
                            borderWidth: 2
                        },
                        {
                            label: 'Chiffre d\'affaires annuel (Contrat) XOF',
                            data: {!! json_encode($chiffre_affaire_contrat_annuel) !!},
                            backgroundColor: 'rgba(54, 185, 204, 0.05)',
                            borderColor: 'rgba(54, 185, 204, 1)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Initialisation de myPieChart
            var pieCtx = document.getElementById('myPieChart').getContext('2d');
            var productLabels = {!! json_encode($productPercentages->pluck('name')) !!};
            var productData = {!! json_encode($productPercentages->pluck('percentage')) !!};

            var myPieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: productLabels,
                    datasets: [{
                        data: productData,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    }],
                }
            });
        }
    </script>


 </div>
 <!-- /.container-fluid -->

@endsection