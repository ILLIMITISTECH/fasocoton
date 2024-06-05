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
                <div class="col-12 col-xl-12 mb-4 mb-xl-0">
                <h5 class="font-weight-bold">Bienvenue sur votre espace de visualisation des collectes cotonnières</h3><hr>
                <div class="mt-4"></div>
                <small class="text-primary text-muted">Producteurs et groupements</small>
                    <form action="{{route('filtreProdGrpmt_ca')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner la campagne</label>
                                    <select class="form-select" name="campagne" aria-label="Default select example" required>
                                        <option selected disabled>Sélectionner la campagne</option>
                                        @foreach ($campagnes as $campagne)
                                            <option >{{$campagne->campagne_coton}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner une option</label>
                                    <select class="form-select" name="option" aria-label="Default select example" required>
                                        <option selected disabled>Options</option>
                                        <option value="1">Nombre de groupements</option>
                                        <option value="2">Nombre total de producteurs</option>
                                        <option value="3">Nombre de producteurs (Hommes)</option>
                                        <option value="4">Nombre de producteurs (Femmes)</option>
                                        <option value="5">Nombre de producteurs individuels</option>
                                        <option value="6">Nombre de producteurs non-membres</option>
                                        <option value="7">Nombre de producteurs scolarisés</option>
                                        <option value="8">Nombre de producteurs Alphabétisés</option>
                                        <option value="9">Nombre de producteurs manuels (N)</option>
                                        <option value="10">Nombre de producteurs en cours d’équipement (A)</option>
                                        <option value="11">Nombre de producteurs avec équipements complets (E)</option>
                                        <option value="12">Nombre de producteurs motorisés (ET)</option>
                                    </select>
                                </div>
                            </div>
                        </div><hr>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" style="float: right;" class="btn btn-primary"> Filtrer <i class="fa fa-save" aria-hidden="true"></i></button>
                            </div>
                        </div><br>
                    </form>
                <div class="row m-5 mb-5">
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

