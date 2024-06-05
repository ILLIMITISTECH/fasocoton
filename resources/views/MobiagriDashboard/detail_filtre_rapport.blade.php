<!DOCTYPE html>


<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('MobiagriDashboard/assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Faso Coton | MobiAgri</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('MobiagriDashboard/assets/img/logo_fasocoton.jpeg')}}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('MobiagriDashboard/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('MobiagriDashboard/assets/js/config.js')}}"></script>
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

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container flex-grow-1 container-p-y">
                <div class="col-12 col-xl-12 mb-4 mb-xl-0">
                <h5 class="font-weight-bold">Bienvenue sur votre espace de visualisation des collectes cotonnières</h3><hr>
                <div class="mt-4"></div>

                 <div id="infoAlert"> 
            
                    <div class="alert alert-dark" role="alert">
                      Nous souhaitons vous informer que le chargement des données est en cours. Veuillez patienter pendant quelques instants, car les données sont volumineuses et peuvent prendre un certain temps à se charger complètement.
                    </div>
                    <br>
                </div>

                @switch($title)
                    @case('Nombre total de producteurs')
                        @php $pth = 'adminFiltreProducteur'; @endphp
                        @include('MobiagriDashboard._navRerchProducteur')
                        @break
                    @case('Nombre de Groupements')
                        @php $pth = 'adminFiltreGroupement'; @endphp
                        @include('MobiagriDashboard._navRerchGroupement')
                        @break
                    @default
                        
                @endswitch
                <div class="row">
                    @php  $zone = " "; @endphp
                    @if(request()->input('zone') !='' || request()->input('scoop') !='')
                    @php 
                        
                        $zone;
                    @endphp
                    @foreach ($datas as $data)
                        @php
                         
                          
                          $zone = $data->zone;
                        @endphp
                    
                    @endforeach
                    @endif
                    
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card shadow-none bg-transparent border border-primary mb-3">
                            <div class="card-body">
                            @if (request()->input('campagne') !='')
                              <b>Campagne : {{request()->input('campagne')}}@if(request()->input('zone') !='') / Zone : {{request()->input('zone')}} @endif @if(request()->input('section') !='') / Section : {{request()->input('section')}} @endif </b><hr>
                            @elseif(request()->input('zone') !='') 
                             <b>Zone : {{request()->input('zone')}} @if(request()->input('section') !='') / Section : {{request()->input('section')}} @endif @if(request()->input('scoop') !='') / Scoop : {{request()->input('scoop')}} - ({{$zone}}) @endif</b><hr>
                            @elseif(request()->input('section') !='') 
                             <b>Section : {{request()->input('section')}}</b><hr>
                            @elseif(request()->input('scoop') !='') 
                             <b>@if(request()->input('zoneScoop') !='') Zone : {{request()->input('zoneScoop')}} /@endif Scoop : {{request()->input('scoop')}} - ({{$zone}}) </b><hr>
                            @else
                              <b>Option : {{$title}}</b><hr>
                            @endif
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                </div>
                                <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                </div>
                            </div>
                            <span class="text-center">{{$title}} </span>
                            <h2 class="card-title mb-2">{{number_format($dataCount)}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($title == 'Nombre de Groupements')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Code SCOOPS</th>
                          <th>Section</th>
                          <th>Zone</th>
                          {{-- <th>Province</th> --}}
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->code_scoop ? $data->code_scoop : '--'}}</td>
                              <td>{{$data->nom_section ? $data->section : '--'}}</td>
                              <td>{{$data->nom_zone ? $data->zone : '--'}}</td>
                              {{-- <td>{{$data->province ? $data->province : '--'}}</td> --}}
                              <td>{{$data->village ? $data->village : '--'}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre total de producteurs')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Zone</th>
                          <th>Section</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->nom_zone}}</td>
                              <td>{{$data->nom_section}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs (Hommes)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Zone</th>
                          <th>Section</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->nom_zone}}</td>
                              <td>{{$data->nom_section}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs (Femmes)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Zone</th>
                          <th>Section</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->nom_zone}}</td>
                              <td>{{$data->nom_section}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs individuels')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->village_origine}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs manuels (N)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs en cours d’équipement (A)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs avec équipements complets (E)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Nombre de producteurs motorisés (ET)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nom et prénom</th>
                          <th>Code producteur</th>
                          <th>Code SCOOPS</th>
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->nom_producteur}} {{$data->prenom_producteur}} </td>
                              <td>{{$data->code_producteur}}</td>
                              <td>{{$data->code_scoop_producteur}}</td>
                              <td>{{$data->village}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                @if ($title == 'Superficies prévues (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Campagne </th>
                          <th>Nom producteur</th>
                          <th>Prénom du producteur</th>
                          <th>Code scoop producteur</th>
                          <th>Zone</th>
                          <th>Superficies prévues</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_producteur}} </td>
                              <td>{{$data->prenom_producteur}} </td>
                              <td>{{$data->code_scoop_producteur}} </td>
                              <td>{{$data->nom_zone}} </td>
                              <td>{{$data->superficie_prevu_producteur}} </td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies déclarées (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                           <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                           <!--<th>Code scoop producteur</th>-->
                          <th>Superficies déclarées</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                              <td>{{$data->supercifie_declaree}} </td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies mesurées (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                           <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                          <th>Superficies mesurées</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            @if(number_format(doubleval($data->superficie_mesuree_ha) - doubleval($data->mesure_saisie)) != 0 )
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                              <td>{{number_format(doubleval($data->superficie_mesuree_ha) - doubleval($data->mesure_saisie))}} </td>
                            </tr> 
                             @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies non-contrôlées (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                           <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                           <th>Superficies non-contrôlées</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            @if(number_format(doubleval($data->supercifie_declaree) - doubleval($data->superficie_mesuree_ha)) != 0 )
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                              <td>{{number_format(doubleval($data->supercifie_declaree) - doubleval($data->superficie_mesuree_ha))}} </td>
                            </tr>  
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies perdues (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                           <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                          <th>Superficies perdues</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            @if(number_format(doubleval($data->superficie_perdue)) != 0 )
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                              <td>{{number_format(doubleval($data->superficie_perdue))}} </td>
                            </tr>   
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies corrigées (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies réalisées (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Campagne </th>
                          <th>Nom producteur</th>
                          <th>Prénom du producteur</th>
                          <th>Code scoop producteur</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_producteur}} </td>
                              <td>{{$data->prenom_producteur}} </td>
                              <td>{{$data->code_scoop_producteur}} </td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <!--<hr> -->
                <!--<div class="row">-->
                <!--    <div class="col-sm-12 text-right">-->
                <!--        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>-->
                <!--    </div>-->
                <!--</div>-->
                
                  @if ($title == 'Superficies productives (Ha)')                
                <div class="table-responsive text-nowrap">
                    <!--<table class="table">-->
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Campagne </th>
                          <th>Nom &  Prénom</th>
                          <th>Superficies productives</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                          @php $n=1; @endphp
                        @foreach($datas as $data)
                            @if(number_format(doubleval($data->superficie_mesuree) - doubleval($data->superficie_perdue)) != 0 )
                            <tr>
                              <td>{{$n++}} </td>
                              <td>{{$data->campagne_coton}} </td>
                              <td>{{$data->nom_prenom_producteur}} </td>
                              <td>{{number_format(doubleval($data->superficie_mesuree) - doubleval($data->superficie_perdue))}} </td>
                            </tr>  
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <hr> 
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="{{route($route)}}" style="float: right; color:white;" class="btn btn-danger"> Retour <i class="fa fa-save" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('MobiagriDashboard/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('MobiagriDashboard/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('MobiagriDashboard/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('MobiagriDashboard/assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('MobiagriDashboard/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('MobiagriDashboard/assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <!--<script async defer src="https://buttons.github.io/buttons.js')}}"></script>-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
      
      $(document).ready(function(){

        const myTimeout = setTimeout(alertInfos, 5000);

        function alertInfos() {
            document.getElementById("infoAlert").style.display='none';
        }
      
        $('#example').DataTable({
    
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/fr-FR.json"
          },  
          "paging":   true,                  
        //   "lengthMenu": false,            
        //   "bLengthChange": false,
          "scrollX": true
    
        });  
        
        //   $.ajax({
        //     url: "{{URL::to('selectCampagneProducteur')}}",
        //     type:'GET',
        //     dataType:'json',
        //     success:function(reponse){
        //         $('select[name="campagne"]').empty();
        //         $('select[name="campagne"]').append('<option selected disabled>Sélectionner la campagne </option>');
        //         $.each(reponse, function(key, value) {
        //             // console.log(value);
        //             $('select[name="campagne"]').append('<option value="'+ value.campagne_coton +'">'+ value.campagne_coton +'</option>');
        //         });
                
        //     }
        // })

    });

    function btnRadio() {
      var check = document.getElementById("optRadio").checked;
  
      const radioBtns = document.querySelectorAll('input[name="optRadio"]');
      for (const radioBtn of radioBtns) {
          if (radioBtn.checked) {
            switch(radioBtn.value) {
              case 'campagne':
                document.getElementById('campagneSearch').style.display='block';
                document.getElementById('campagneRegionSearch').style.display='none';
                document.getElementById('allSearch').style.display='none';
                document.getElementById('scoopSearch').style.display='none';

                $.ajax({
                  url: "{{URL::to('selectCampagneProducteur')}}",
                  type:'GET',
                  dataType:'json',
                  success:function(reponse){
                      $('select[name="campagne"]').empty();
                      $('select[name="campagne"]').append('<option selected disabled>Sélectionner la campagne </option>');
                      $.each(reponse, function(key, value) {
                          $('select[name="campagne"]').append('<option value="'+ value.campagne_coton +'">'+ value.campagne_coton +'</option>');
                      });
                      
                    }
                })
                break;
              case 'zone':
                //   document.getElementById('campagneSearch').style.display='none';
                  document.getElementById('campagneRegionSearch').style.display='block';
                  document.getElementById('allSearch').style.display='none';
                //   document.getElementById('scoopSearch').style.display='none';
                  
                //   console.log(radioBtn.value);

                  $.ajax({
                  url: "{{URL::to('selectCampagneProducteur')}}",
                  type:'GET',
                  dataType:'json',
                  success:function(reponse){
                      $('select[name="campagne"]').empty();
                      $('select[name="campagne"]').append('<option selected disabled>Sélectionner la campagne </option>');
                      $.each(reponse, function(key, value) {
                          $('select[name="campagne"]').append('<option value="'+ value.campagne_coton +'">'+ value.campagne_coton +'</option>');
                      });
                      
                    }
                })
                
                 $.ajax({
                    url: "{{URL::to('selectZoneProducteur')}}",
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="zone"]').empty();
                        $('select[name="zone"]').append('<option selected disabled>Sélectionner la zone </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="zone"]').append('<option value="'+ value.zone +'">'+ value.zone +'</option>');
                        });
                        
                    }
                })

                break;
              case 'section':
                document.getElementById('campagneSearch').style.display='none';
                document.getElementById('campagneRegionSearch').style.display='none';
                // document.getElementById('scoopSearch').style.display='none';
                document.getElementById('allSearch').style.display='block';

                
                $.ajax({
                    url: "{{URL::to('selectCampagneProducteur')}}",
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="campagne"]').empty();
                        $('select[name="campagne"]').append('<option selected disabled>Sélectionner la campagne </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="campagne"]').append('<option value="'+ value.campagne_coton +'">'+ value.campagne_coton +'</option>');
                        });
                        
                    }
                })

                $.ajax({
                    url: "{{URL::to('selectZoneProducteur')}}",
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="zone"]').empty();
                        $('select[name="zone"]').append('<option selected disabled>Sélectionner la zone </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="zone"]').append('<option value="'+ value.zone +'">'+ value.zone +'</option>');
                        });
                        
                    }
                });

                break;
              case 'scoop':
                document.getElementById('campagneSearch').style.display='none';
                document.getElementById('campagneRegionSearch').style.display='none';
                document.getElementById('allSearch').style.display='none';
                document.getElementById('scoopSearch').style.display='block';
                

                $.ajax({
                    url: "{{URL::to('selectZoneProducteur')}}",
                    type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="zoneScoop"]').empty();
                        $('select[name="zoneScoop"]').append('<option selected disabled>Sélectionner la zone </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="zoneScoop"]').append('<option value="'+ value.zone +'">'+ value.zone +'</option>');
                        });
                        
                    }
                });

                $.ajax({
                    url: "{{URL::to('selectScoop')}}",
                      type:'GET',
                    dataType:'json',
                    success:function(reponse){
                        $('select[name="scoop"]').empty();
                        $('select[name="scoop"]').append('<option selected disabled>Sélectionner la scoop </option>');
                        $.each(reponse, function(key, value) {
                            $('select[name="scoop"]').append('<option value="'+ value.code_scoop +'">' +value.code_scoop+' / ('+ value.zone +')'+  '</option>');
                        });
                        
                    }
                });

                // $.ajax({
                //     url: "{{URL::to('selectAllScoop')}}",
                //     type:'GET',
                //     dataType:'json',
                //     success:function(reponse){
                //                                 console.log(reponse);

                //         $('select[name="scoop"]').empty();
                //         $('select[name="scoop"]').append('<option selected disabled>Sélectionner la scoop </option>');
                //         $.each(reponse, function(key, value) {
                //           // console.log(value);
                //             // $('select[name="scoop"]').append('<option value="'+ value.zone +'">'+ value.zone +'</option>');
                //         });
                        
                //     }
                // })

                break;
            }

          }
          
      }

    } 

    $('select[name="zoneScoop"]').on('change', function() { 
      var zone = this.value;
      // console.log(zoneScoop);

        $.ajax({
          url: "{{URL::to('selectZoneScoop')}}/"+zone,
          type:'GET',
          dataType:'json',
          success:function(reponse){
              $('select[name="scoop"]').empty();
              $('select[name="scoop"]').append('<option selected disabled>Sélectionner la scoop </option>');
              $.each(reponse, function(key, value) {
                $('select[name="scoop"]').append('<option value="'+ value.code_scoop +'">' +value.code_scoop+' / ('+ value.zone +')'+  '</option>');
              });
              
            }
        });
    });

    $('select[name="zone"]').on('change', function() { 
      var zone = this.value;
        $.ajax({
          url: "{{URL::to('selectSection')}}/"+zone,
          type:'GET',
          dataType:'json',
          success:function(reponse){
              $('select[name="section"]').empty();
              $('select[name="section"]').append('<option selected disabled>Sélectionner la section </option>');
              $.each(reponse, function(key, value) {
                  $('select[name="section"]').append('<option value="'+ value.section +'">'+ value.section +'</option>');
              });
              
            }
        });
      
    });


    // document.getElementById('zone').addEventListener('change', function() {
    //   var zone = this.value;
    //   $.ajax({
    //     url: "{{URL::to('selectSection')}}/"+zone,
    //     type:'GET',
    //     dataType:'json',
    //     success:function(reponse){
    //         $('select[name="section"]').empty();
    //         $('select[name="section"]').append('<option selected disabled>Sélectionner la section </option>');
    //         console.log('value');
    //         $.each(reponse, function(key, value) {
    //             $('select[name="section"]').append('<option value="'+ value.section +'">'+ value.section +'</option>');
    //         });
            
    //       }
    //   })
    
    // });

   
    </script>

  </body>
</html>

