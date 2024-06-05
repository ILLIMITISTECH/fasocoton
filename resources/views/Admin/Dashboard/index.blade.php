<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OptiEvent | Administration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">">
 
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->



      @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        


      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('Admin/Dashboard.sideBarUser')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon  mr-2" style="background:#F49800; color:white">
                  <i class="mdi mdi-home"></i>
                </span> 
                  Tableau de Bord administrateur
              </h3>
            </div>
            <div class="row">
              <div class="col-md-8 stretch-card grid-margin">
                <div class="card  card-img-holder ">
                  <div class="card-body card-phase">
                    <!-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
                    <h3 class="font-weight-normal mb-3 phase-title">
                        <div>
                             <?php 
                                $even = DB::table('events')->where('status', '=', 1)->first();
                                if($even){
                                    
                             ?>
                                    @if($even->phase == 0)
                                    <b style="color:grey">Phases terminées&nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:#4b2e99">Inscriptions en cours <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:#4b2e99">Suggestions en cours <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:#4b2e99">Confirmation des souhaits <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:#4b2e99">Planning en cours <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                            <?php 
                                }else {
                                    echo "No even so far 😅";
                                }
                            ?>
                        </div>    
                    </h3>
                    <p>La phase finale est enclenchée ! A ce stade les participants devraient avoir reçu leur planning de rendez-vous</p>
                    <div class="spinner-border phase" role="status">
                      <span class="visually-hidden"></span>
                    </div>
                    
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card  card-img-holder ">
                  <div class="card-body">
                     <!--<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
                     <?php $event = DB::table('events')->where('status', '=', 1)->first()?>
                    <h4 class="font-weight-normal mb-3">Nombre de participants <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> <h2 class="mb-5"><?php $participants = DB::table('participants')->where('event_id', '=', $event->id)->count()?> {{$participants}}</h2></h2>
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card  card-img-holder ">
                  <div class="card-body">
                     <!--<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
                    <h4 class="font-weight-normal mb-3">Nombre d'entreprises <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php $entreprises = DB::table('entreprises')->where('event_id', '=', $event->id)->count()?> {{$entreprises}}</h2>
                    <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card  card-img-holder ">
                  <div class="card-body">
                    <!--<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
                    <h4 class="font-weight-normal mb-3">Nombre de rendez-vous générés <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php $rendez_vous = DB::table('plannings')->count()?> {{$rendez_vous}}</h2>
                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">OptiEvent © Concu avec passion et enthousiasme par <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">ILLIMITIS</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('Admin/Dashboard.js')
    <!-- End custom js for this page -->
  </body>
</html>