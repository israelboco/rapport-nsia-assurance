<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/png" href="{{asset('img/logo_nsia.png')}}" />


  <title>Rapport NSIA Vie Assurance</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('css/ca.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('img/logo_nsia.png') }}" alt="Logo NSIA" style="width: 60px; height: 60px;">
        </div>
        <div class="sidebar-brand-text mx-3">Rapport <sup>NSIA</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if($user->is_admin)
      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
          <a class="nav-link" href="{{route('home')}}">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span>
          </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
    @endif

  @if($user->is_admin)
    <!-- Heading -->
    <div class="sidebar-heading">SERVICES</div>

    <!-- Nav Item - Services Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Services</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('service.index')}}">Service</a>
                <a class="collapse-item" href="{{route('role.index', '1')}}">Rôle</a>
                <a class="collapse-item" href="{{route('produit.index', '1')}}">Produit</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

  @endif
    <!-- Heading -->
    <div class="sidebar-heading">PERSONNELLES</div>

    <!-- Nav Item - Agents Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-user"></i>
            <span>Agents</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('user.index')}}">Agent</a>
                <a class="collapse-item" href="{{route('user.profile', $user->id)}}">Profil</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">DEAL</div>

    <!-- Nav Item - Contrat -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('deal.index')}}">
            <i class="fas fa-file-alt"></i>
            <span>Deal</span>
        </a>
    </li>

    @if($user->is_admin)
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Traitement Chiffre d'affaires</div>

    <!-- Nav Item - Agents Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseCA" aria-expanded="true" aria-controls="collapseCA">
          <i class="fas fa-fw fa-file-contract"></i>
          <span>Chiffre d'affaires</span>
      </a>
      <div id="collapseCA" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{route('contrat.index')}}" title="Listes de tout les Contrats">Contrats</a>
              <a class="collapse-item" href="{{route('contrat.info_holding')}}" title="Info Holding - Analyse Financière">Info Holding</a>
              <a class="collapse-item" href="{{route('contrat.prime_unique')}}" title="Prime Unique - Suivi des Commissions">Prime Unique</a>
              <a class="collapse-item" href="{{route('contrat.cafv1')}}" title="CA FV1 - Gestion des Chefs CG et Fioles">CA FV1</a>
              <a class="collapse-item" href="{{route('contrat.nbrs_contrat_fv')}}" title="Nbrs Contact FV1 - Affaires Nouvelles">Nbrs Contact FV1</a>
              <a class="collapse-item" href="{{route('contrat.qualite')}}" title="Qualité - Suivi de la Performance par Service">Qualité</a>
              <a class="collapse-item" href="{{route('contrat.impayes')}}" title="Impayés - Suivi par Service et Agent">Impayés</a>
              <a class="collapse-item" href="{{route('contrat.performance')}}" title="Performance - Analyse Globale">Performance</a>
              <a class="collapse-item" href="{{route('contrat.suivi_detaille')}}" title="Suivi Détaillés - Objectifs vs Réalisations">Suivi Dét.</a>
              <a class="collapse-item" href="{{route('contrat.graphique')}}" title="Graphique">Graphique</a>
          </div>
      </div>
  </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" id="textSearch" class="form-control bg-light border-0 small" placeholder="Recherche agent..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <a id="search" href="{{route('user.index')}}" class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </a>
              </div>
            </div>
          </form>
          <script>
              document.getElementById('textSearch').addEventListener('input', function() {
                  const textSearch = this.value;
                  const link = document.getElementById('search');
                  link.href = "{{ url('user/index?search=')}}" + textSearch;
                  console.log(link)
              });
          </script>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <!-- <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a> -->
              <!-- Dropdown - Messages -->
              <!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li> -->



            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$user->nom}} {{$user->prenom}}</span>
                <img class="img-profile rounded-circle" src="{{asset($user->profile)}}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('user.profile', $user->id)}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Déconnexion
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        @yield('content')

      </div>
      <!-- End of Main Content -->

      <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Rapport quotidien NSIA vie assurance 2024</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Sélectionnez « Déconnexion » ci-dessous si vous êtes prêt à mettre fin à votre session en cours.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="{{route('auth.logout')}}">Déconnexion</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('js/ca.js') }}"></script>
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
