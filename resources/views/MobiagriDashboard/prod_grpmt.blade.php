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
                <h5 class="font-weight-bold">Bienvenue sur votre espace de visualisation des collectes cotonnières</h3><hr>

            
             
                    @if ($title == 'Nombre total de producteurs')   
                        @php $pth = 'adminFiltreProducteur'; @endphp
                        @include('MobiagriDashboard._navRerchProducteur')
                    @endif
                 
                 
                  <div class="col-12 col-xl-12 mb-4 mb-xl-0">
                <div class="mt-4"></div>
                <small class="text-primary text-muted">Producteurs et groupements</small>
                    <form action="{{route('filtreProdGrpmt')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" style="display:none;">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner la campagne</label>
                                    <select class="form-select" name="campagne" aria-label="Default select example" required>
                                        <option selected disabled>Sélectionner la campagne</option>
                                        @foreach ($campagnes as $campagne)
                                            @if($campagne->campagne_coton == "23-24" OR $campagne->campagne_coton == "24-25")
                                            <option >{{$campagne->campagne_coton}}</option>
                                            @endif
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
                                        <option value="6">Nombre de producteurs ni alphabétisés ni scolarisés</option>
                                        <option value="7">Nombre de producteurs scolarisés</option>
                                        <option value="8">Nombre de producteurs alphabétisés</option>
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
               
            </div>
                <div class="row">
                    
                    @if(request()->input('zone') !='' || request()->input('scoop') !='')
                    @php 
                        $nomScoop;
                        $zone;
                    @endphp
                    @foreach ($datas as $data)
                        @php
                          $nomScoop = $data->nom_scoop; 
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
                             <b>Zone : {{request()->input('zone')}} @if(request()->input('section') !='') / Section : {{request()->input('section')}} @endif @if(request()->input('scoop') !='') / Scoop : {{request()->input('scoop')}} - {{$nomScoop}} ({{$zone}}) @endif</b><hr>
                            @elseif(request()->input('section') !='') 
                             <b>Section : {{request()->input('section')}}</b><hr>
                            @elseif(request()->input('scoop') !='') 
                             <b>@if(request()->input('zoneScoop') !='') Zone : {{request()->input('zoneScoop')}} /@endif Scoop : {{request()->input('scoop')}} - {{$nomScoop}} ({{$zone}}) </b><hr>
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
                            $('select[name="scoop"]').append('<option value="'+ value.code_scoop +'">' +value.code_scoop+' / '+ value.nom_scoop +' ('+ value.zone +')'+  '</option>');
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
                $('select[name="scoop"]').append('<option value="'+ value.code_scoop +'">' +value.code_scoop+' / '+ value.nom_scoop +' ('+ value.zone +')'+  '</option>');
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

