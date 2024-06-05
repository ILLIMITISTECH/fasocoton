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

              <div class="row m-5 mb-5">
                <h4 class="text-primary">Liste des scoops</h4>
                <div class="card">
                 <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Nom scoop </th>
                          <th>Code SCOOPS</th>
                          <th>Zone</th>
                          <th>Section</th>
                          <th>Province</th>
                          <!--<th>Département</th>-->
                          <th>Village</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach($scoops as $scoop)
                            <tr>
                              <td>{{$scoop->nom_scoop}}</td>
                              <td>{{$scoop->code_scoop ? $scoop->code_scoop : '--'}}</td>
                              <td>{{$scoop->zone ? $scoop->zone : '--'}}</td>
                              <td>{{$scoop->section ? $scoop->section : '--'}}</td>
                              <td>{{$scoop->province ? $scoop->province : '--'}}</td>
                              <!--<td>{{$scoop->departement ? $scoop->departement : '--'}}</td>-->
                              <td>{{$scoop->village ? $scoop->village : '--'}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                    {{ $scoops->render("pagination::bootstrap-4") }}
                  </div>
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
  </body>
</html>

