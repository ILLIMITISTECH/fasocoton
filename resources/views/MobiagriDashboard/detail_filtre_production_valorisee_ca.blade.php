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
                <div class="row">
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card shadow-none bg-transparent border border-primary mb-3">
                          <div class="card-body">
                            @if (request()->input('campagne') !='')
                              <b>Campagne : {{request()->input('campagne')}}, Option : {{$title}}</b><hr>
                            @else
                              <b>Option : {{$title}}</b><hr>
                            @endif
                            @if ($title == 'Production totale')

                              <div class="row">
                              <div class="col-md-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Production totale 1re choix (kg)</span>
                                  <h2 class="card-title mb-2">{{number_format($value1)}}</h2>
                                </div>
                              </div>
                               <div class="col-md-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Production totale 2e choix (kg)</span>
                                  <h2 class="card-title mb-2">{{number_format($value2)}}</h2>
                                </div>
                              </div>
                              </div>
                            </div>
                            <hr>
                            <div class="container">
                              <table id="example" class="table table-striped table-bordered" style="width:100%">
                               <label for="" @class(['text-muted', 'font-bold' => true])><b><u>Liste Producteurs : Production totale 1re choix</u></b></label><br><br>
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Nom et prénom producteur </th>
                                    <th>Nom scoop </th>
                                    <th>Code SCOOPS</th>
                                    <th>Zone</th>
                                    <th>Quantité 1re choix</th>
                                  </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php $n=1; @endphp
                                  @foreach($datas as $data)
                                      <tr>
                                        <td>{{$n++}} </td>
                                        <td>{{$data->nom_producteur.' '.$data->prenom_producteur}}</td>
                                        <td>{{$data->nom_scoop}}</td>
                                        <td>{{$data->code_scoop_producteur}}</td>
                                        <td>{{$data->nom_zone}}</td>
                                        <td>{{$data->qte_1er_choix}}</td>
                                      </tr>   
                                  @endforeach
                                </tbody>
                              </table><hr>
                              <table id="example2" class="table table-striped table-bordered" style="width:100%">
                               <label for="" @class(['text-muted', 'font-bold' => true])><b><u>Liste Producteurs : Production totale 2e choix</u></b></label><br><br>
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Nom et prénom producteur </th>
                                    <th>Nom scoop </th>
                                    <th>Code SCOOPS</th>
                                    <th>Zone</th>
                                    <th>Quantité 2e choix</th>
                                  </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php $n=1; @endphp
                                  @foreach($datas2 as $data2choix)
                                      <tr>
                                        <td>{{$n++}} </td>
                                        <td>{{$data2choix->nom_producteur.' '.$data2choix->prenom_producteur}}</td>
                                        <td>{{$data2choix->nom_scoop}}</td>
                                        <td>{{$data2choix->code_scoop_producteur}}</td>
                                        <td>{{$data2choix->nom_zone}}</td>
                                        <td>{{$data2choix->qte_2eme_choix}}</td>
                                      </tr>   
                                  @endforeach
                                </tbody>
                              </table><br>
                            </div>
                            @endif
                            @if ($title == 'Prix du coton')

                              <div class="row">
                              <div class="col-md-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Prix 1re choix</span>
                                  <h2 class="card-title mb-2">@if($value1){{number_format($value1->prix_coton_1er_choix)}} @else @endif</h2>
                                </div>
                              </div>
                               <div class="col-md-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Prix 2e choix</span>
                                  <h2 class="card-title mb-2">@if($value2){{number_format($value2->prix_coton_2eme_choix)}} @else @endif</h2>
                                </div>
                              </div>
                              </div>
                            </div>
                                
                            @endif
                             @if ($title == 'Production valorisée')

                              <div class="row">
                              <div class="col-md-4">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Production valorisée 1re choix</span>
                                  <h2 class="card-title mb-2">{{number_format($value1)}}</h2>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Production valorisée 2e choix</span>
                                  <h2 class="card-title mb-2">{{number_format($value2)}}</h2>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                      <img src="{{asset($img)}}" alt="chart success" class="rounded"/>
                                    </div>
                                </div>
                                <div>
                                  <span class="text-center">Total production valorisée</span>
                                  <h2 class="card-title mb-2">{{number_format($total)}}</h2>
                                </div>
                              </div>
                              </div>
                            </div>
                                
                            @endif
                        </div>
                    </div>
                </div>
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
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#example, #example2').DataTable({
        
              "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/fr-FR.json"
              },  
              "paging":   true,                  
            //   "lengthMenu": false,            
            //   "bLengthChange": false,
              "scrollX": true
        
            });   
        
        });
    </script>

  </body>
</html>

