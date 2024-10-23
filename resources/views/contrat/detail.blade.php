@extends("index")

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contrat du produit : {{ (isset($contrat->produit)) ? $contrat->produit->nom: ''}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoContrat" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoContrat">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informations sur le contrat
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoContrat">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Police:</strong> {{ $contrat->Police }}</p>
                            <p class="card-text"><strong>N° Quittance:</strong> {{ $contrat->N_Quittance }}</p>
                            <p class="card-text"><strong>N° Quittance Annulée:</strong> {{ $contrat->N_Quittance_Annulee }}</p>
                            <p class="card-text"><strong>N° Police:</strong> {{ $contrat->N_Police }}</p>
                            <p class="card-text"><strong>Mois Effet Quittance:</strong> {{ $contrat->Mois_Effet_Quittance }}</p>
                            <p class="card-text"><strong>Code Produit:</strong> {{ $contrat->produit_code }}</p>
                            <p class="card-text"><strong>Nom Produit:</strong> {{ isset($contrat->produit) ? $contrat->produit->nom : ''}}</p>
                            <p class="card-text"><strong>Type d'affaire:</strong> {{ $contrat->Typeaffaire }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoFinan" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoFinan">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informations financières
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoFinan">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Prime_Pure:</strong> {{ $contrat->Prime_Pure }}</p>
                            <p class="card-text"><strong>Charges Gestion:</strong> {{ $contrat->Charges_Gestion }}</p>
                            <p class="card-text"><strong>Ccial externe:</strong> {{ $contrat->Ccial_externe }}</p>
                            <p class="card-text"><strong>Ccial externe:</strong> {{ $contrat->Ccial_externe }}</p>
                            <p class="card-text"><strong>Frais d'acquisition:</strong> {{ $contrat->Frais_acquisition }}</p>
                            <p class="card-text"><strong>Frais de fractionnement:</strong> {{ $contrat->Frais_de_fractionnement }}</p>
                            <p class="card-text"><strong>Droit d'entree:</strong> {{ $contrat->Droit_entree }}</p>
                            <p class="card-text"><strong>Cout Piece:</strong> {{ $contrat->Cout_Piece }}</p>
                            <p class="card-text"><strong>Prime Nette:</strong> {{ $contrat->Prime_Nette }}</p>
                            <p class="card-text"><strong>Solde:</strong> {{ $contrat->Solde }}</p>
                            <p class="card-text"><strong>Montant a payer:</strong> {{ $contrat->Montant_a_payer }}</p>
                            <p class="card-text"><strong>Impayes:</strong> {{ $contrat->Impayes }}</p>
                            <p class="card-text"><strong>Encaissements:</strong> {{ $contrat->Encaissements }}</p>
                            <p class="card-text"><strong>inenc:</strong> {{ $contrat->inenc }}</p>
                            <p class="card-text"><strong>Production_brute_exo:</strong> {{ $contrat->Production_brute_exo }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoDate" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoDate">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Dates importantes
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoDate">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Date de Comptable:</strong> {{ $contrat->Date_Comptable }}</p>
                            <p class="card-text"><strong>Date debut Quittance:</strong> {{ $contrat->Date_debut_Quittance }}</p>
                            <p class="card-text"><strong>Date fin Quittance:</strong> {{ $contrat->Date_Fin_Quittance }}</p>
                            <p class="card-text"><strong>Date Effet Police:</strong> {{ $contrat->Date_Effet_Police }}</p>
                            <p class="card-text"><strong>Date Fin effet Police:</strong> {{ $contrat->Date_Fin_effet_Police }}</p>
                            <p class="card-text"><strong>Date Resiliation:</strong> {{ $contrat->Date_Resiliation }}</p>
                            <p class="card-text"><strong>Date Creation:</strong> {{ $contrat->Date_Creation }}</p>
                            <p class="card-text"><strong>Date Creation QCO:</strong> {{ $contrat->Date_Creation_QCO }}</p>
                            <p class="card-text"><strong>Date Annulation QCO:</strong> {{ $contrat->Date_Annulation_QCO }}</p>
                            <p class="card-text"><strong>Mois création:</strong> {{ $contrat->mois_creation }}</p>
                            <p class="card-text"><strong>SEMAINE:</strong> {{ $contrat->SEMAINE }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoPerio" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoPerio">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Périodicité et fractionnement
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoPerio">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Periodicite:</strong> {{ $contrat->Periodicite }}</p>
                            <p class="card-text"><strong>Fractionnement:</strong> {{ $contrat->Fractionnement }}</p>
                            <p class="card-text"><strong>PERIODICITE:</strong> {{ $contrat->PERIODICITE }}</p>
                            <p class="card-text"><strong>Fractionnement2:</strong> {{ $contrat->Fractionnement2 }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoAssure" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoAssure">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informations sur l'assuré et le payeur
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoAssure">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>N° Assure:</strong> {{ $contrat->N_Assure }}</p>
                            <p class="card-text"><strong>N° Payeur:</strong> {{ $contrat->N_Payeur }}</p>
                            <p class="card-text"><strong>Nom et Prenoms Assure:</strong> {{ $contrat->Nom_et_Prenoms_Assure }}</p>
                            <p class="card-text"><strong>Date_Naissance:</strong> {{ $contrat->Date_Naissance }}</p>
                            <p class="card-text"><strong>Adresse:</strong> {{ $contrat->Adresse }}</p>
                            <p class="card-text"><strong>Contact1:</strong> {{ $contrat->Contact1 }}</p>
                            <p class="card-text"><strong>Contact2:</strong> {{ $contrat->Contact2 }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoPoint" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoPoint">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Points de vente et réseau
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoPoint">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>N° Point de vente:</strong> {{ $contrat->NPoint_de_vente }}</p>
                            <p class="card-text"><strong>Nom Point de vente:</strong> {{ $contrat->Nom_Point_de_vente }}</p>
                            <p class="card-text"><strong>Reseau:</strong> {{ $contrat->Reseau }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoStatut" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoStatut">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Statut du contrat et autres informations
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoStatut">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>Type apporteur:</strong> {{ $contrat->Typeapporteur }}</p>
                            <p class="card-text"><strong>Branche:</strong> {{ $contrat->Branche }}</p>
                            <p class="card-text"><strong>convention:</strong> {{ $contrat->convention }}</p>
                            <p class="card-text"><strong>Tout les contacts:</strong> {{ $contrat->contact_tout }}</p>
                            <p class="card-text"><strong>Mode:</strong> {{ $contrat->mode }}</p>
                            <p class="card-text"><strong>PROMESSES:</strong> {{ $contrat->PROMESSES }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">  
            <div class="card shadow mb-4">
                <a href="#collapseCardInfoEncadre" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardInfoEncadre">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Encadrement et gestion
                    </h6>
                </a>
                <div class="collapse" id="collapseCardInfoEncadre">
                    <form class="user">
                        <div class="modal-body">
                            <p class="card-text"><strong>CA SERVICE:</strong> </p>
                            <p class="card-text"><strong>CHEF EQUIPE:</strong> </p>
                            <p class="card-text"><strong>CHEF INSPECTION:</strong> </p>
                            <p class="card-text"><strong>CHEF CG:</strong> </p>
                            <p class="card-text"><strong>com encadrement:</strong> </p>
                            <p class="card-text"><strong>Affaires Nvles reel:</strong> </p>
                            <p class="card-text"><strong>Affaires Nvles NBR:</strong> </p>
                            <p class="card-text"><strong>Affaires Nvles NBR:</strong> </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

 </div>

@endsection