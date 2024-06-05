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
             <!-- <div class="row">
                <div class="mb-3 col-4">
                  <label for="exampleFormControlSelect1" class="form-label">Campagne :</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>sélectionner la campagne...</option>
                    <option value="1">20-21</option>
                    <option value="2">21-22</option>
                    <option value="3">22-23</option>
                  </select>
                </div>
                <div class="mb-3 col-4">
                  <label for="exampleFormControlSelect1" class="form-label">Zone :</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>sélectionner la zone...</option>
                    <option value="1">Z01</option>
                    <option value="2">Z02</option>
                    <option value="3">Z03</option>
                    <option value="3">Z04</option>
                    <option value="3">Z05</option>
                  </select>
                </div>
                <div class="col-4">
                  <label for="exampleFormControlSelect1" class="form-label">Section :</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>sélectionner la section</option>
                    <option value="1">S01</option>
                    <option value="2">S02</option>
                    <option value="3">S03</option>
                    <option value="4">S04</option>
                  </select>
                </div>
              </div> -->

              <!--<div class="row m-5 mb-5">-->
                <h4 class="text-primary">Liste des travaux agricoles</h4>
                <!--<div class="card">-->
                 <div class="table-responsive text-nowrap">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>% Semis</th>
                          <th>% Herbicidage</th>
                          <th>% 1er Sarclage</th>
                          <th>% 2e Sarclage</th>
                          <th>% 3e Sarclage</th>
                          <th>% Buttage</th>
                          <th>% Application NPK</th>
                          <th>% Application Urée</th>
                          <th>% Application NPK + Urée</th>
                          <th>% 1er Traitement</th>
                          <th>% 2e Traitement</th>
                          <th>% 3e Traitement</th>
                          <th>% 4e Traitement</th>
                          <th>% 5e Traitement</th>
                          <th>% 6e Traitement</th>
                          <th>% 7e Traitement</th>
                          <th>% 9e Traitement</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach($detail_scoops as $detail_scoop)
                            <tr>
                              <td>{{$detail_scoop->pourcentage_semis_fra}}</td>
                              <td>{{$detail_scoop->pourcentage_herbicidage_fra ? $detail_scoop->pourcentage_herbicidage_fra : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_1er_sarclage ? $detail_scoop->pourcentage_1er_sarclage : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_2e_sarclage ? $detail_scoop->pourcentage_2e_sarclage : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_3e_sarclage ? $detail_scoop->pourcentage_3e_sarclage : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_buttage ? $detail_scoop->pourcentage_buttage : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_npk ? $detail_scoop->pourcentage_npk : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_npk_uree}}</td>
                              <td>{{$detail_scoop->pourcentage_uree ? $detail_scoop->pourcentage_uree : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_1er_traitement ? $detail_scoop->pourcentage_1er_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_2e_traitement ? $detail_scoop->pourcentage_2e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_3e_traitement ? $detail_scoop->pourcentage_3e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_4e_traitement ? $detail_scoop->pourcentage_4e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_5e_traitement ? $detail_scoop->pourcentage_5e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_6e_traitement ? $detail_scoop->pourcentage_6e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_7e_traitement ? $detail_scoop->pourcentage_7e_traitement : '--'}}</td>
                              <td>{{$detail_scoop->pourcentage_9e_traitement ? $detail_scoop->pourcentage_9e_traitement : '--'}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                     <span class="float-right">
                      {{ $detail_scoops->render("pagination::bootstrap-4") }}
                    </span>
                  </div>
                <!--</div>-->
              <!--</div>-->
          
           

       
             
              
          
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

        const myTimeout = setTimeout(alertInfos, 5000);

        function alertInfos() {
            document.getElementById("infoAlert").style.display='none';
        }
      
        $('#example').DataTable({
    
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/fr-FR.json"
          },  
          "paging":   false,                  
        //   "lengthMenu": false,            
        //   "bLengthChange": false,
          "scrollX": true
    
        });
    });
    </script>

  </body>
</html>

