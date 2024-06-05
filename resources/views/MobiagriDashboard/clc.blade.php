<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('MobiagriDashboard/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Faso Coton | MobiAgri</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('MobiagriDashboard/assets/img/logo_fasocoton.jpeg') }}" />
    <!-- Fonts -->

    <link href="{{ asset('assets/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/fonts/boxicons.css') }}" />
        

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('MobiagriDashboard/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('MobiagriDashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('MobiagriDashboard/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('MobiagriDashboard/assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('MobiagriDashboard.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('MobiagriDashboard.header')

                <!-- / Navbar -->

                <div class="my-2 d-flex justify-content-center align-item-center px-auto">
                    <div class="ms-4 container card text-start justify-content-start w-25">
                        <h4 class="text-primary mt-3">Clc</h4>
                    </div>
                </div>

                <!-- Content wrapper -->
                <div class="content-wrap container mt-4">
                    <div class="my-auto">
                        <div class="row">
                            <div class="col-4">
                                <label for="campagneclc" class="form-label">Campagne Coton :</label>
                                <select class="form-select form-control" name="search_campagne_clc" id="campagneclc" aria-label="Default select example" required>
                                    <option value="" selected>Sélectionner la campagne</option>
                                    <option value="23-24">23-24</option>
                                    <option value="24-25">24-25</option>
                                </select>
                            </div>

                             @if(Auth::user()->nom_role != 'ca')
                            @if(Auth::user()->nom_role == 'ZORGHO' OR Auth::user()->nom_role == 'TENKODOGO' OR Auth::user()->nom_role == 'MANGA' OR  Auth::user()->nom_role == 'KOMBISSIRI' OR Auth::user()->nom_role == 'PO')
                            <div class="col-4">
                                <label for="selectZoneClc" class="form-label">Zone :</label>
                                <select class="form-select" name="by_zone" id="selectZoneClc">
                                    <option class="form-option" value="" selected>Selectionné une zone ...</option>
                                    
                                        <option class="form-option" value="{{ Auth::user()->nom_role }}">
                                            {{ Auth::user()->nom_role }}
                                        </option>
                                   
                                </select>
                            </div>
                            @else
                            <div class="col-4">
                                <label for="selectZoneClc" class="form-label">Zone :</label>
                                <select class="form-select" name="by_zone" id="selectZoneClc">
                                    <option class="form-option" value="" selected>Selectionné une zone ...</option>
                                    @foreach($zone_by_mise_en_place as $item)
                                        <option class="form-option" value="{{ $item->nom_zone }}">
                                            {{ $item->nom_zone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-4">
                                <label for="sectionFilter" class="form-label">Section :</label>
                                <select class="form-select form-control" name="search_section_clc"
                                    id="sectionFilter">
                                    <option value="" selected>sélectionner la section...</option>
                                    {{-- valeur charger dynamiquement ici --}}
                                </select>
                            </div>
                            @endif
                            
                        </div>

                    </div>
                </div>
                @php
                    $segment = request()->input('search_zone_clc');
                    //echo $segment; // article
                    $campa = request()->input('search_campagne_clc');
                @endphp
                <div class="container flex-grow-1 container-p-y">


                    <div class="col-lg-3 mt-2 order-0">
                        <div class="card shadow-none bg-transparent border border-primary mb-3">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png') }}"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                 <span class=" ">Valeur Total Clc</span>
                                <h3 class="card-title mb-2" id="campagnValue"></h3>
                            </div>
                        </div>
                    </div>
                        @php 
                            $owner_nameSection = Auth::user()->section;

                                    $clcscoop_count = DB::table('scoops')->where('closed', 'false')
                                     ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('section', $owner_nameSection)
                                    ->count();
                                
                                    $clcscoop_count_23_24 = DB::table('scoops')->where('closed', 'false')
                                     ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('section', $owner_nameSection)
                                    ->where('campagne_coton', '23-24')
                                    ->count();
                                
                                    $clcscoop_count_24_25 = DB::table('scoops')->where('closed', 'false')
                                     ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('section', $owner_nameSection)
                                    ->where('campagne_coton', '24-25')
                                    ->count();
                                
                                    $producteursHcount = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'homme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                    ->count();
                                    $producteursFcount = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'femme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                   ->count();
                                   $producteursTotalcount = $producteursHcount + $producteursFcount;
                                
                                   $producteursHcount_23_24 = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'homme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                    ->where('producteurs.campagne_coton', '23-24')
                                    ->count();
                                    $producteursFcount_23_24 = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'femme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                    ->where('producteurs.campagne_coton', '23-24')
                                   ->count();
                                   $producteursTotalcount_23_24 = $producteursHcount_23_24 + $producteursFcount_23_24;
                            
                                   $producteursHcount_24_25 = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'homme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                    ->where('producteurs.campagne_coton', '24-25')
                                    ->count();
                                    $producteursFcount_24_25 = DB::table('producteurs')
                                    ->select('producteurs.*')
                                    ->where('producteurs.closed', 'false')
                                    ->where('producteurs.actif', 1)
                                    ->where('producteurs.owner_name', '<>', 'demo')
                                    ->where('producteurs.owner_name', '<>', 'demo.ac')
                                    ->where('producteurs.genre', 'femme')
                                    ->where('producteurs.nom_section', $owner_nameSection)
                                    ->where('producteurs.campagne_coton', '24-25')
                                   ->count();
                                   $producteursTotalcount_24_25 = $producteursHcount_24_25 + $producteursFcount_24_25;
                                   
                                   $total_int_pro = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                   ->count();
                                   
                                   $total_int_pro_23_24 = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.campagne_coton', '23-24')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                   ->count();
                                   
                                   $total_int_pro_24_25 = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.campagne_coton', '24-25')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                   ->count();
                                   
                                   $total_int_scoop = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                    //->groupBy('intrant_equipements.nom_scoop')
                                    ->distinct()
                                    ->count('intrant_equipements.nom_scoop');

                                   $total_int_scoop_23_24 = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.campagne_coton', '23-24')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                    //->groupBy('intrant_equipements.nom_scoop')
                                    ->distinct()
                                    ->count('intrant_equipements.nom_scoop');
                                   
                                   $total_int_scoop_24_25 = DB::table('intrant_equipements')
                                    ->select('intrant_equipements.*')
                                    ->where('intrant_equipements.closed', 'false')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo')
                                    ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
                                    ->where('intrant_equipements.campagne_coton', '24-25')
                                    ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
                                    ->where('intrant_equipements.nom_section', $owner_nameSection)
                                    //->groupBy('intrant_equipements.nom_scoop')
                                    ->distinct()
                                    ->count('intrant_equipements.nom_scoop');
                                    
                                    $total_int_scoop_23_24s = DB::table('intrant_equipements')
                                    ->where('closed', 'false')
                                    ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('campagne_coton', '23-24')
                                    ->where('choix_formulaire_remplir', 'clc')
                                    ->where('nom_section', $owner_nameSection)
                                    ->distinct()
                                    ->pluck('nom_scoop');

                                    

                                   $total_int_scoop_24_25s = DB::table('intrant_equipements')
                                    ->where('closed', 'false')
                                    ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('campagne_coton', '24-25')
                                    ->where('choix_formulaire_remplir', 'clc')
                                    ->where('nom_section', $owner_nameSection)
                                    ->distinct()
                                    ->pluck('nom_scoop');
                                    $number1 = 1;
                                    $number2 = 1;
                                    
                                    
                                    $total_int_prevu_23_24 = DB::table('intrant_equipements')
                                    ->where('closed', 'false')
                                    ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('campagne_coton', '23-24')
                                    ->where('choix_formulaire_remplir', 'clc')
                                    ->where('nom_section', $owner_nameSection)
                                    ->sum('superficie_prevu_producteur');
                                    
                                    $total_int_prevu_24_25 = DB::table('intrant_equipements')
                                    ->where('closed', 'false')
                                    ->where('owner_name', '<>', 'demo')
                                    ->where('owner_name', '<>', 'demo.ac')
                                    ->where('campagne_coton', '24-25')
                                    ->where('choix_formulaire_remplir', 'clc')
                                    ->where('nom_section', $owner_nameSection)
                                    ->sum('superficie_prevu_producteur');
                                    
                        @endphp
                     <br>
                     
                    <div class="container"> 
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                            <li><a data-toggle="tab" href="#menu1">Liste Scoops 23-24</a></li>
                            <li><a data-toggle="tab" href="#menu2">Liste Scoops 24-25</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade">
                                  
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                    <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#Numéro</th>
                                                <th>Nom du Scoop</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($total_int_scoop_23_24s as $total_int_scoop_23_24ss)
                                                @if($total_int_scoop_23_24ss)
                                                <tr>
                                                    <td>{{$number1}}</td>
                                                    <td>{{ ($total_int_scoop_23_24ss) ? $total_int_scoop_23_24ss : '--' }}</td>
                                                </tr>
                                                @endif
                                                @php $number1++;  @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#Numéro</th>
                                                <th>Nom du Scoop</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($total_int_scoop_24_25s as $total_int_scoop_24_25ss)
                                                @if($total_int_scoop_24_25ss)
                                                <tr>
                                                    <td>{{$number2}}</td>
                                                    <td>{{ ($total_int_scoop_24_25ss) ? $total_int_scoop_24_25ss : '--' }}</td>
                                                </tr>
                                                @endif
                                                @php $number2++;  @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive text-nowrap">
                        <style>
                            .fun-box {
                                    background-color: #ffab00; /* Couleur de fond jaune vif */
                                    border-radius: 10px; /* Coins arrondis */
                                    padding: 20px; /* Espacement intérieur */
                                }
                            .fun-box2 {
                                    background-color: #007bff; /* Couleur de fond jaune vif */
                                    border-radius: 10px; /* Coins arrondis */
                                    padding: 20px; /* Espacement intérieur */
                                }
                            .fun-box3 {
                                    background-color: #28a745; /* Couleur de fond jaune vif */
                                    border-radius: 10px; /* Coins arrondis */
                                    padding: 20px; /* Espacement intérieur */
                                }
                                
                                .fun-text {
                                    color: #333; /* Couleur du texte */
                                    font-size: 18px; /* Taille de la police */
                                    font-weight: bold; /* Texte en gras */
                                }
                                
                                .fun-number {
                                    color: #fff; /* Couleur du nombre */
                                    font-size: 24px; /* Taille de la police */
                                    font-weight: bold; /* Texte en gras */
                                }
                                
                                .box-shadow {
                                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Ombre portée douce */
                                    transition: box-shadow 0.3s ease; /* Animation de transition */
                                }
                                
                                .box-shadow:hover {
                                    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Ombre portée plus prononcée au survol */
                                }

                        </style>
                          
                        
                        @if(Auth::user()->nom_role == 'ca')
                        <div id="start" style="display:flex; justify-content: space-between;">
                            <!--<div id="first" class="box-shadow fun-box">
                                <span class="fun-text">Total Producteur</span>
                                <h3 class="fun-number">{{ intVal($total_int_pro_23_24 + $total_int_pro_24_25) }}</h3>
                                <span class="fun-text">Valeur Total Scoop</span>
                                <h3 class="fun-number">{{ intVal($total_int_scoop_23_24 + $total_int_scoop_24_25) }}</h3>
                            </div>-->
                            <div id='second' class="box-shadow fun-box2" style="width: 350px;">
                                <span class="fun-text">Total Producteur 23-24</span>
                                <h3 class="fun-number">{{number_format($total_int_pro_23_24)}}</h3>
                                <span class="fun-text">Total Scoop 23-24</span>
                                <h3 class="fun-number">{{number_format($total_int_scoop_23_24)}}</h3>
                            </div>
                            <div id="first" class="box-shadow fun-box" style="width: 350px;">
                                <span class="fun-text">Superficies prévues (ha) 23-24</span>
                                <h3 class="fun-number">{{ number_format($total_int_prevu_23_24) }}</h3>
                                <span class="fun-text">Superficies prévues (ha) 24-25</span>
                                <h3 class="fun-number">{{ number_format($total_int_prevu_24_25) }}</h3>
                            </div>
                            <div id='thirty' class="box-shadow fun-box3" style="width: 350px;">
                                <span class="fun-text">Total Producteur 24-25</span>
                                <h3 class="fun-number">{{number_format($total_int_pro_24_25)}}</h3>
                                <span class="fun-text">Total Scoop 24-25</span>
                                <h3 class="fun-number">{{number_format($total_int_scoop_24_25)}}</h3>
                            </div>
                        </div>
                        @endif
                        <br>
                        <hr>
                        <table class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nom Zone</th>
                                    <th>Nom Section</th>
                                    <th>Nom et Prénom</th>
                                    <th>Code SCOOPS producteur</th>
                                    <th>Nom SCOOPS</th>
                                    <th>Campagne</th>
                                    <th>Atomiseurs</th>
                                    <th>Appareils à Dos</th>
                                    <th>Appareils à Pile</th>
                                    <th>EPI</th>
                                    <th>Herbicides Post-levée</th>
                                    <th>Herbicides Pré-levée</th>
                                    <th>Herbicides Total</th>
                                    <th>Insecticides classiques Type 1</th>
                                    <th>Insecticides classiques Type 2</th>
                                    <th>Insecticides classiques Type 3</th>
                                    <th>Insecticides spécifiques Type 1</th>
                                    <th>Insecticides spécifiques Type 2</th>
                                    <th>Insecticides spécifiques Type 3</th>
                                    <th>Engrais NPK/FU (50 kg)</th>
                                    <th>Engrais Urée (50 kg)</th>
                                    <th>Total Engrais</th>
                                    <th>Total Semences</th>
                                    <th>Total Insecticides</th>
                                    <th>Total CLC </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="clcTableBody">
                                @foreach($clc as $clcs)
                                    <tr>
                                        <td>{{ $clcs->nom_zone }}</td>
                                        <td>{{ $clcs->nom_section }}</td>
                                        <td>{{ $clcs->nom_producteur }} {{ $clcs->prenom_producteur }}</td>
                                        <td>{{ $clcs->code_scoop_producteur }}</td>
                                        <td>{{ $clcs->nom_scoop }}</td>
                                        <td>{{ $clcs->campagne_coton }}</td>
                                        <td>{{ $clcs->nbre_appareil_atomiseur_piece }}</td>
                                        <td>{{ $clcs->nbre_appareil_dos_piece }}</td>
                                        <td>{{ $clcs->nbre_appareil_pile_piece }}</td>
                                        <td>{{ $clcs->nbre_epi_piece }}</td>
                                        <td>{{ $clcs->nbre_herbicides_post_levee }}</td>
                                        <td>{{ $clcs->nbre_herbicides_pre_levee }}</td>
                                        <td>{{ $clcs->nbre_herbicides_total }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_1_traitement }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_2_traitement }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_3_traitement }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_1_specifiques_traitement }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_2_specifiques_traitement }}</td>
                                        <td>{{ $clcs->nbre_insecticides_type_3_specifiques_traitement }}</td>
                                        <td>{{ $clcs->nbre_sac_engrais_npk_fu_50kg }}</td>
                                        <td>{{ $clcs->nbre_sac_engrais_uree_50kg }}</td>
                                        <td>{{ $clcs->total_engrais }}</td>
                                        <td>{{ $clcs->total_semence }}</td>
                                        <td>{{ $clcs->total_insecticide }}</td>
                                        <td>{{ $clcs->total_montant_intrants }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

                <!-- Overlay -->
                <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <!-- / Layout wrapper -->



            <!-- Core JS -->
            <!-- build:js assets/vendor/js/core.js -->
            <script
                src="{{ asset('MobiagriDashboard/assets/vendor/libs/jquery/jquery.js') }}">
            </script>
            <script
                src="{{ asset('MobiagriDashboard/assets/vendor/libs/popper/popper.js') }}">
            </script>
            <script src="{{ asset('MobiagriDashboard/assets/vendor/js/bootstrap.js') }}">
            </script>
            <script
                src="{{ asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}">
            </script>

            <script src="{{ asset('MobiagriDashboard/assets/vendor/js/menu.js') }}"></script>
            <!-- endbuild -->

            <!-- Vendors JS -->
            <script
                src="{{ asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apexcharts.js') }}">
            </script>


            <!-- Main JS -->
            <script src="{{ asset('MobiagriDashboard/assets/js/main.js') }}"></script>

            <!-- Page JS -->
            <script src="{{ asset('MobiagriDashboard/assets/js/dashboards-analytics.js') }}">
            </script>

            <!-- Place this tag in your head or just before your close body tag. -->
            <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
            <script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

    <script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: true,
				buttons: [ 'copy', 'excel', 'pdf', 'print'],
                language: {
                search: "Recherche :",
            },
			} );

			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>

            {{-- <script>

                $(document).ready(function () {
                    // Filtre par campagne
                    $('#campagneclc').change(function() {
                        var selectedCampagne = $(this).val();
                        updateMiseEnPlaceTable(selectedCampagne);
                    });
            
                    // Filtre par zone
                    $('#selectZoneClc').change(function() {
                        var selectedZone = $(this).val();
                        updateMiseEnPlaceTable(undefined, selectedZone);
                    });
            
                    // Filtre par section
                    $('#sectionFilter').change(function() {
                        var selectedSection = $(this).val();
                        updateMiseEnPlaceTable(undefined, undefined, selectedSection);
                    });
            
                    document.getElementById('selectZoneClc').addEventListener('change', function() {
                        var selectedZone = this.value;
                        updateSectionQuery(selectedZone);
                    });
            
                    function updateSectionQuery(selectedZone) {
                        fetch('/api/getSectionsByClc?by_zone=' + selectedZone)
                            .then(response => response.json())
                            .then(data => {
                                updateSectionDropdown(data);
                            })
                            .catch(error => console.error('Erreur lors de la récupération des sections:', error));
                    }
            
                    function updateCampagnSum(campSum) {
                        var campagnValue = document.getElementById('campagnValue');
                        campagnValue.innerHTML = '<div>' + campSum + '</div>';
                    }
            
                    function updateSectionDropdown(sections) {
                        var sectionDropdown = document.getElementById('sectionFilter');
                        sectionDropdown.innerHTML = '<option value="" selected>sélectionner la section...</option>';
            
                        sections.forEach(function(section) {
                            var option = document.createElement('option');
                            option.value = section.nom_section;
                            option.text = section.nom_section;
                            sectionDropdown.appendChild(option);
                        });
                    }
            
                    function updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection) {
                        var tableRows = $('#clcTableBody tr');
                        tableRows.each(function() {
                            var rowCampagne = $(this).find('td:nth-child(6)').text().trim();
                            var rowZone = $(this).find('td:first-child').text().trim();
                            var rowSection = $(this).find('td:nth-child(2)').text().trim();
            
                            var showRow = true;
            
                            if (selectedCampagne && rowCampagne !== selectedCampagne) {
                                showRow = false;
                            }
                            if (selectedZone && rowZone !== selectedZone) {
                                showRow = false;
                            }
                            if (selectedSection && rowSection !== selectedSection) {
                                showRow = false;
                            }
            
                            if (showRow) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                });
            
            </script> --}}

            <script>
                $(document).ready(function () {
                    // Filtre par campagne
                    $('#campagneclc').change(function() {
                        var selectedCampagne = $(this).val();
                        var selectedZone = $('#selectZoneClc').val();
                        var selectedSection = $('#sectionFilter').val();
                        updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection);
                    });

                    // Filtre par zone
                    $('#selectZoneClc').change(function() {
                        var selectedZone = $(this).val();
                        var selectedCampagne = $('#campagneclc').val();
                        var selectedSection = $('#sectionFilter').val();
                        updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection);
                    });

                    // Filtre par section
                    $('#sectionFilter').change(function() {
                        var selectedSection = $(this).val();
                        var selectedCampagne = $('#campagneclc').val();
                        var selectedZone = $('#selectZoneClc').val();
                        updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection);
                    });

                    document.getElementById('selectZoneClc').addEventListener('change', function() {
                        var selectedZone = this.value;
                        updateSectionQuery(selectedZone);
                    });
            
                    function updateSectionQuery(selectedZone) {
                        fetch('/api/getSectionsByClc?by_zone=' + selectedZone)
                            .then(response => response.json())
                            .then(data => {
                                updateSectionDropdown(data);
                            })
                            .catch(error => console.error('Erreur lors de la récupération des sections:', error));
                    }

                    function updateCampagnSum(campSum) {
                        var campagnValue = document.getElementById('campagnValue');
                        campagnValue.innerHTML = '<div>' + campSum + '</div>';
                    }
            
                    function updateSectionDropdown(sections) {
                        var sectionDropdown = document.getElementById('sectionFilter');
                        sectionDropdown.innerHTML = '<option value="" selected>sélectionner la section...</option>';
            
                        sections.forEach(function(section) {
                            var option = document.createElement('option');
                            option.value = section.nom_section;
                            option.text = section.nom_section;
                            sectionDropdown.appendChild(option);
                        });
                    }

                    function updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection) {
                        var tableRows = $('#clcTableBody tr');
                        tableRows.each(function() {
                            var rowCampagne = $(this).find('td:nth-child(6)').text().trim();
                            var rowZone = $(this).find('td:first-child').text().trim();
                            var rowSection = $(this).find('td:nth-child(2)').text().trim();

                            var showRow = true;

                            if (selectedCampagne && rowCampagne !== selectedCampagne) {
                                showRow = false;
                            }
                            if (selectedZone && rowZone !== selectedZone) {
                                showRow = false;
                            }
                            if (selectedSection && rowSection !== selectedSection) {
                                showRow = false;
                            }

                            if (showRow) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });

                         // Calculer et mettre à jour la valeur totale
                        var total = calculateTotal(selectedCampagne, selectedZone, selectedSection);
                        updateCampagnSum(total);
                    }

                                            
                        // Fonction pour calculer la valeur totale
                        function calculateTotal(selectedCampagne, selectedZone, selectedSection) {
                            var total = 0;
                            $('#clcTableBody tr:visible').each(function () {
                                var rowCampagne = $(this).find('td:nth-child(6)').text().trim();
                                var rowZone = $(this).find('td:first-child').text().trim();
                                var rowSection = $(this).find('td:nth-child(2)').text().trim();

                                if ((!selectedCampagne || rowCampagne === selectedCampagne) &&
                                    (!selectedZone || rowZone === selectedZone) &&
                                    (!selectedSection || rowSection === selectedSection)) {
                                    var rowTotalText = $(this).find('td:nth-child(25)').text().trim();
                                    
                                    // Vérifier si la cellule n'est pas vide et si elle contient un nombre valide
                                    if (rowTotalText !== "" && !isNaN(rowTotalText)) {
                                        var rowTotal = parseFloat(rowTotalText);
                                        total += rowTotal;
                                    }
                                }
                            });
                            return total;
                        }




                    // Fonction pour mettre à jour la valeur dans la div campagnValue
                    // function updateCampagnSum(total) {
                    //     var campagnValueElement = document.getElementById('campagnValue');
                    //     campagnValueElement.textContent = total;
                    // }

                    function updateCampagnSum(total) {
              var campagnValueElement = document.getElementById('campagnValue');
              campagnValueElement.textContent = total.toLocaleString('fr-FR', { style: 'currency', currency: 'XOF' });
          }

                    // Initialiser la somme totale au chargement de la page
                    updateMiseEnPlaceTable();

                });

            </script>
</body>

</html>
