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
             <!-- <form action="{{route('search_clc')}}" method="get">
               <div class="row" style="display:flex;">
                <div class="mb-3 col-4" style="margin-top:7px;">
                  <label for="exampleFormControlSelect1" >Campagne :</label>
                  <select class="form-select form-control" name="search_clc" id="myselection" aria-label="Default select example">
                    <option selected>sélectionner la campagne...</option>
                    <option value="2020-2021">20-21</option>
                    <option value="2021-2022">21-22</option>
                    <option value="2022-2023">22-23</option>
                  </select>
                </div>
                <div class="mb-3 col-3">
                  <label for="exampleFormControlSelect1" class="form-label">Zone :</label>
                  <select class="form-select form-control" name="search_clcZ" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>sélectionner la zone...</option>
                    <option value="ZORGHO">Zorgho</option>
                    <option value="TENKODOGO">Tenkodogo</option>
                    <option value="MANGA">Manga</option>
                    <option value="PO">Pô</option>
                    <option value="KOMBISSIRI">Kombissiri</option>
                  </select>
                </div>
                <div class="mb-3 col-3">
                  <label for="exampleFormControlSelect1" class="form-label">Section :</label>
                  <select class="form-select form-control" name="search_clcS" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option selected>sélectionner la section</option>
                    <!-- section zo1 zorgho 
                    <option disabled>section zo1 zorgho</option>
                    <option value="BOENA">Boena</option>
                    <option value="MANKARGA">Mankarga</option>
                    <option value="WAYALGUI">Wayalgui</option>
                    <option value="WAYALGUI A">Wayalgui A</option>
                    <option value="WAYALGUI B">Wayalgui B</option>
                    <option value="BOMBORE">Bomboré</option>
                    <option value="MOGTEDO">Mogtedo</option>
                    <option value="RAPADAMA">Rapadama</option>
                    <option value="ZORGHO">Zorgho</option>
                    <option value="ZOUNGOU">Zoungou</option>
                    <option value="LINOGHIN">Linoghin</option>
                     <!-- section zo1 Tenkodogo
                    <option disabled>section zo1 Tenkodogo</option>
                    <option value="BITTOU">Bittou</option>
                    <option value="SAWINGA">Sawinga</option>
                    <option value="OUADA">Ouada</option>
                    <option value="OUADA A">Ouada A</option>
                    <option value="OUADA B">Ouada B</option>
                    <option value="BANTOUGRI">Bantougri</option>
                    <option value="BANTOUGRI A">Bantougri A</option>
                    <option value="BANTOUGRI B">Bantougri B</option>
                    <option value="BAGRE">Bagré</option>
                    <option value="BISSIGA">Bissiga</option>
                    <option value="BISSIGA A">Bissiga A</option>
                    <option value="BISSIGA B">Bissiga B</option>
                    <option value="MOAGA">Moaga</option>
                    <option value="MOAGA A">Moaga A</option>
                    <option value="MOAGA B">Moaga B</option>
                    <option value="TENKODOGO">TENKODOGO</option>
                    <option value="TENKODOGO A">Tenkodogo A</option>
                    <option value="TENKODOGO B">Tenkodogo B</option>
                    <option value="TENKODOGO C">Tenkodogo C</option>
                    <option value="TENSOBTENGA">Tensobtenga</option>
                    <option value="DIALGAYE">Dialgaye</option>
                    <!-- section zo1 Manga 
                    <option disabled>section zo1 Manga</option>
                    <option value="BERE">Béré</option>
                    <option value="BINDE">Binde</option>
                    <option value="BION">Bion</option>
                    <option value="GOGO">Gogo</option>
                    <option value="GUIBA">Guiba</option>
                    <option value="KAÏBO">Kaïbo</option>
                    <option value="KALENGA">Kalenga</option>
                    <option value="KOPELIN">Kopelin</option>
                    <option value="MANGA">Manga</option>
                    <option value="MANGA EST">Manga Est</option>
                    <option value="MAZOARA">Mazoara</option>
                    <option value="NOBERE">Nobéré</option>
                    <option value="THIOUGOU">Thiougou</option>
                    <!-- section zo1 Pô 
                    <option disabled>section zo1 Pô</option>
                    <option value="GUIARO">Guiaro</option>
                    <option value="GUIARO 1">Guiaro 1</option>
                    <option value="GUIARO 2">Guiaro 2</option>
                    <option value="GUIARO 3">Guiaro 3</option>
                    <option value="GUIARO 4">Guiaro 4</option>
                    <option value="GUIARO 5">Guiaro 5</option>
                    <option value="PO">Pô</option>
                    <option value="PO 1">Pô 1</option>
                    <option value="PO 2">Pô 2</option>
                    <option value="TIAKANE">Tiakané</option>
                    <!-- section zo1 Kombissiri 
                    <option disabled>section zo1 Kombissiri</option>
                    <option value="Gaongho">Gaongho</option>
                    <option value="KAYAO">Kayao</option>
                    <option value="KAYAO A">Kayao A</option>
                    <option value="KAYAO B">Kayao B</option>
                    <option value="KOMBISSIRI">Kombissiri</option>
                    <option value="KONGOUSSI">Kongoussi</option>
                    <option value="SAPONE">Saponé</option>
                    <option value="TOECE">Toécé</option>
                    <option value="POSTE D'OBS">Poste d'Obs</option>
                   
                  </select>
                </div>
                        <div class="mb-3 col-2" style="margin-top:30px;">
                            <button class="btn btn-primary" style="color:white;" type="submit">Filtrer</button>
                        </div>
                    </div>
                  </form>-->

              <div class="row m-5 mb-5">
                <h4 class="text-primary">CLC</h4>
                <div class="card">
                 <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
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
                      <tbody class="table-border-bottom-0">
                        @foreach($clc as $clcs)
                            <tr>
                              <td>{{$clcs->nom_producteur}} {{$clcs->prenom_producteur}}</td>
                              <td>{{$clcs->code_scoop_producteur}}</td>
                              <td>{{$clcs->nom_scoop}}</td>
                              <td>{{$clcs->campagne_coton}}</td>
                              <td>{{$clcs->nbre_appareil_atomiseur_piece}}</td>
                              <td>{{$clcs->nbre_appareil_dos_piece}}</td>
                              <td>{{$clcs->nbre_appareil_pile_piece}}</td>
                              <td>{{$clcs->nbre_epi_piece}}</td>
                              <td>{{$clcs->nbre_herbicides_post_levee}}</td>
                              <td>{{$clcs->nbre_herbicides_pre_levee}}</td>
                              <td>{{$clcs->nbre_herbicides_total}}</td>
                              <td>{{$clcs->nbre_insecticides_type_1_traitement}}</td>
                              <td>{{$clcs->nbre_insecticides_type_2_traitement}}</td>
                              <td>{{$clcs->nbre_insecticides_type_3_traitement}}</td>
                              <td>{{$clcs->nbre_insecticides_type_1_specifiques_traitement}}</td>
                              <td>{{$clcs->nbre_insecticides_type_2_specifiques_traitement}}</td>
                              <td>{{$clcs->nbre_insecticides_type_3_specifiques_traitement}}</td>
                              <td>{{$clcs->nbre_sac_engrais_npk_fu_50kg}}</td>
                              <td>{{$clcs->nbre_sac_engrais_uree_50kg}}</td>
                              <td>{{$clcs->total_engrais_clc}}</td>
                              <td>{{$clcs->total_semence_clc}}</td>
                              <td>{{$clcs->total_insecticide_clc}}</td>
                              <td>{{$clcs->total_clc}}</td>
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
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

