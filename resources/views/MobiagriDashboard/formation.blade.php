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
             {{-- <form action="" method="get">
               <div class="row" style="display:flex;">
                <div class="mb-3 col-4" style="margin-top:7px;">
                  <label for="exampleFormControlSelect1" >Campagne :</label>
                  <select class="form-select form-control" name="search_campagne" id="myselection" aria-label="Default select example">
                    <option selected>Sélectionner la campagne...</option>
                    <option value="20-21">20-21</option>
                    <option value="21-22">21-22</option>
                    <option value="22-23">22-23</option>
                    <option value="23-24">23-24</option>
                    <option value="24-25">24-25</option>
                  </select>
                </div>
                <div class="mb-3 col-3">
                  <label for="exampleFormControlSelect1" class="form-label">Zone :</label>
                  <select class="form-select form-control" name="search_decade" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>Sélectionner la décade</option>
                    <option value="decade_1">1ere décade</option>
                    <option value="decade_2">2e décade</option>
                    <option value="decade_3">3e décade</option>
                  </select>
                </div>
                        <div class="mb-3 col-2" style="margin-top:30px;">
                            <button class="btn btn-primary" style="color:white;" type="submit">Filtrer</button>
                        </div>
                    </div>
                  </form> --}}
                 
                <h4 class="text-primary">Liste des formations </h4>
                 <div class="table-responsive text-nowrap">
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Choix Campagne</th>
                          <th>Nom & Prénom</th>
                          <th>Formations</th>
                          <th>Scoop</th>
                          <th>Code Scoop</th>
                          <th>Zone</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach($formations as $formation)
                            <tr>
                              <td>{{$formation->campagne_coton}}</td>
                              <td>{{$formation->nom_prenom_formation}}</td>
                              <td><textarea id="txtid" name="txtname" rows="4" cols="50" disabled>{{$formation->liste_formation}}</textarea></td>
                              <td>{{$formation->nom_scoop}}</td>
                              <td>{{$formation->code_scoop}}</td>
                              <td>{{$formation->zone}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                    <span class="float-right">
                      {{ $formations->render("pagination::bootstrap-4") }}
                    </span>
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

