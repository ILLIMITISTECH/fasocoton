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
              <form action="{{route('search_dashboard')}}" method="get">
               <div class="row" style="display:flex;">
                   
                <div class="mb-3 col-4" style="margin-top:7px;">
                  <label for="exampleFormControlSelect1" >Campagne :</label>
                  <select class="form-select form-control" name="search_dashboard" id="myselection" aria-label="Default select example">
                    <option value="">sélectionner la campagne...</option>
                    <option value="2020-2021">20-21</option>
                    <option value="2021-2022">21-22</option>
                    <option value="2022-2023">22-23</option>
                  </select>
                </div>
                

   
                <div class="mb-3 col-3">
                  <label for="exampleFormControlSelect1" class="form-label">Section :</label>
                  <select class="form-select form-control" name="searchS" id="exampleFormControlSelect1" aria-label="Default select example" >
                    @php $scoop_groups = DB::table('scoops')->where('closed', 'false')->where('zone', Auth::user()->nom_role)->get(); @endphp
                    <option value="">sélectionner la section</option>
                    @foreach($scoop_groups as $scoop_group)
                     <option value="{{$scoop_group->section}}">{{$scoop_group->section}}</option>
                     @endforeach
                  
                  </select>
                </div>
                        <div class="mb-3 col-2" style="margin-top:30px;">
                            <button class="btn btn-primary" style="color:white;" type="submit">Filtrer</button>
                        </div>
                </div>
                 </form>
                
              

              
            </div>

             <!--Afficher les filtres selectionnés -->
             
                @php
                    $segment = request()->input('search_dashboard');
                    $segmentZ = request()->input('searchZ');
                    $segmentS = request()->input('searchS');
                       
                            //echo $segment; // article
                                              
                    @endphp

            <div class="container-xxl flex-grow-1 container-p-y">
                
                <h5 class="text-primary">{{$segment}}</h5>
                <h5 class="text-primary">{{$segmentZ}}</h5>
                <h5 class="text-primary">{{$segmentS}}</h5>
                
              <h5 class="text-primary">Infos Producteurs et Groupements</h5>
              <div class="row">
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/farmer.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Producteurs Hommes</span>
                      <h3 class="card-title mb-2">{{number_format(count($producteursH))}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/farmerFemal.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Producteurs Femmes</span>
                      <h3 class="card-title mb-2">{{number_format(count($producteursF))}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Total Producteurs</span>
                      <h3 class="card-title mb-2">{{number_format($producteursTotal)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-primary mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class="">Nbre de Groupements</span>
                      <h3 class="card-title mb-2">{{number_format($nombre_scoops)}}</h3>
                   
                    </div>
                  </div>
                </div>
              </div>
              <h5 class="text-warning">Infos sur les superficies</h5>
              <div class="row">
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficiePrevue.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> Superficies prévues (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_prevue)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficieDeclare.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Superficies déclarées (ha)<span>
                      <h3 class="card-title mb-2">{{number_format($superficie_declarer)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficieMesure.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> Superficies mésurées (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_mesuree)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficieRealise.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Superficies realisées (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_realise)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficieCorrige.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Superficies corrigées (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_corrige)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficiePerdue.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Superficies perdues (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_perdue)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-warning mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/superficieProd.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Superficies productives (ha)</span>
                      <h3 class="card-title mb-2">{{number_format($superficie_productive)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
              </div>
              <h5 class="color : text-success">Infos sur crédits</h5>
              <div class="row">
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-success mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/CDC.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> CLC (FCFA)</span>
                      <h3 class="card-title mb-2">{{number_format($clc)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-success mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/CLC.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">CDC (FCFA)</span>
                      <h3 class="card-title mb-2">{{number_format($cdc)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-success mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/misePlace.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> Mises en place (FCFA)</span>
                      <h3 class="card-title mb-2">{{number_format($mise_en_place)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-success mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/besoinComplementaire.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Besoins complémetaires (FCFA)</span>
                      <h3 class="card-title mb-2">{{number_format($besoin_complementaire)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                
              </div>
              <h5 class="color : text-info">Infos sur la production (FCFA)</h5>
              <div class="row">
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/rendement_moyen.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> Rendement moyen scoops</span>
                      <h3 class="card-title mb-2"> {{number_format($rendement_moyen_scoops)}}</h3>
                   
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/production_valorise.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Production valorisée (FCFA) </span>
                      <h3 class="card-title mb-2">{{number_format($production_valorisee)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/production_en_tonne.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" ">Production en tonne </span>
                      <h3 class="card-title mb-2">{{number_format($production_tonnes)}}</h3>
                   
                    </div>
                   
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-info mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/prevision_de_production.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <!--<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">-->
                          <!--  <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>-->
                          <!--</div>-->
                        </div>
                      </div>
                      <span class=" "> Prevision de production en tonne</span>
                      <h3 class="card-title mb-2">{{number_format($prevision_de_production)}}</h3>
                   
                    </div>
                  </div>
                </div>
                
                
              </div>
              <h5>Autres indicateurs</h5>
              <div class="row">
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-dark mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/rendement.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>
                          </div>
                        </div>
                      </div>
                      <span class=" "> Rendement </span>
                      <h3 class="card-title mb-2">{{number_format($rendement)}}</h3>
                   
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-4 order-0">
                  <div class="card shadow-none bg-transparent border border-dark mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/MARI.png')}}" alt="chart success" class="rounded"/>
                        </div>
                        <div class="dropdown">
                           <button class="btn p-0" type="button" id="cardOpt3"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:void(0);">Plus de Détails</a>
                          </div>
                        </div>
                      </div>
                      <span class=" ">MARI (FCFA)</span>
                      <h3 class="card-title mb-2">{{number_format($mari)}}</h3>
                   
                    </div>
                  </div>
                </div>
                
              </div>
          
            </div>
            <!-- / Content -->

           

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
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
  </body>
</html>
