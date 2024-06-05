
@include('Admin/Dashboard.head')
  <body>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OptiEvent | Administration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">   
        <!-- partial:partials/_sidebar.html -->
        @include('Admin/Dashboard.sideBarUser')
        <!-- partial -->
        
        <div class="main-panel">
            
          <div class="content-wrapper">
          <div class="bdc">
            <h4 class="card-title"> <br>Configurer un évènement</h4>
          </div>
          <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                    <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <h4 class="card-title">Programmez les différentes phases de votre évènement !</h4>
                    <br>
                   
                     <center>
                      
                                    <div>
                                    @if($even->phase == 0)
                                    <b style="color:grey; margin-left:70px">Phases terminées&nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:#4b2e99">Inscriptions en cours <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:#4b2e99">Suggestions en cours <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:#4b2e99">Confirmation des souhaits <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:#4b2e99">Planning en cours <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                                    </div>
                                    
                                </center>
                        
                        <br>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Phase d’inscription des participants</label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                        @if($even->status == 1)
                                    @if($even->phase == 1)
                                    <form method="POST" action="{{route('phase_1.event', $even->id)}}">
                                        {{ csrf_field() }}
                                         <button type="submit" id="p1"  class="btn btn-dark" style="background:#480099" disabled>Inscriptions</button>
                                    </form>
                                    @else
                                     <form method="POST" action="{{route('phase_1.event', $even->id)}}">
                                         {{ csrf_field() }}
                                         <button type="submit" id="p1"  class="btn btn-dark"style="background:#480099">Inscriptions</button>
                                    </form>
                                    @endif
                    
                        </div>
                      </div>
                      <br><br><br>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Phase suggestions et d’ajout de rendez-vous</label>
                        
                        </div>
                        
                                
                        <div class="row col-md-3 align-items-center">
                       @if($even->phase == 2)
                                    <form method="POST" action="{{route('phase_2.event', $even->id)}}">
                                        {{ csrf_field() }}
                                         <button type="submit" id="p2"  class="btn btn-dark"style="background:#480099" disabled>Suggestion</button>
                                    </form>
                                    @else
                                     <form method="POST" action="{{route('phase_2.event', $even->id)}}">
                                         {{ csrf_field() }}
                                         <button type="submit" id="p2" class="btn btn-dark"style="background:#480099">Suggestion</button>
                                    </form>
                                    @endif
                      </div>
                      </div>
                      
                      <!--<div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label" style=margin-left:20px><br>Phase de confirmation des rendez-vous</label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                          @if($even->phase == 3)
                                    <form method="POST" action="{{route('phase_3.event', $even->id)}}">
                                        {{ csrf_field() }}
                                         <button type="submit" id="p3"  class="btn btn-dark"style="background:#480099" disabled>Confirmation</button>
                                    </form>
                                    @else
                                     <form method="POST" action="{{route('phase_3.event', $even->id)}}">
                                         {{ csrf_field() }}
                                         <button type="submit" id="p3"  class="btn btn-dark" style="background:#480099">Confirmation</button>
                                    </form>
                                    @endif
                    
                      </div>-->

                      <br><br><br>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label" style=margin-left:40px><br>Génération des plannings </label>
                        
                        </div>
                         @if($even->phase == 4)
                                    <form method="POST" action="{{route('phase_4.event', $even->id)}}">
                                        {{ csrf_field() }}
                                         <button type="submit" id="p4"  class="btn btn-dark"style=background:#480099 disabled>Plannings</button>
                                    </form>
                                    @else
                                     <form method="POST" action="{{route('phase_4.event', $even->id)}}">
                                         {{ csrf_field() }}
                                         <button type="submit" id="p4" class="btn btn-dark"style="background:#480099;padding: 14px 45px">Plannings</button>
                                         
                                    </form>
                                    @endif

                      </div>
                      
                      <br><br><br>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label" style=margin-left:40px><br>Génération des plannings </label>
                        
                        </div>
                         @if($even->phase_rvs == 5)
                                    <form method="POST" action="{{route('phase_5_rvs.event', $even->id)}}">
                                        {{ csrf_field() }}
                                         <button type="submit" id="p4"  class="btn btn-dark"style=background:#480099 disabled>Last Plannings</button>
                                    </form>
                                    @else
                                     <form method="POST" action="{{route('phase_5_rvs.event', $even->id)}}">
                                         {{ csrf_field() }}
                                         <button type="submit" id="p4" class="btn btn-dark"style="background:#480099;padding: 14px 45px">Last Plannings</button>
                                         
                                    </form>
                                    @endif

                      </div>
                      <br><br><br>
                                    <div class="row">
                        <div class="row col-md-6 align-items-start"> 
                        </div>         
                        <div class="row col-md-3 align-items-center">
                    
                        <form method="POST" action="{{route('phase_des.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p4" class="btn btn-dark"  style="padding: 14px 50px">Terminer</button>
                            </form>   
                      </div>
                      </div>
                                 
                        
                        
                        @else
                            <form method="POST" action="{{route('phase_1.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p1" class="btn btn-dark"disabled>Inscriptions</button>
                             </form>
                            
                            <form method="POST" action="{{route('phase_2.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p2" class="btn btn-success" disabled>Suggestions</button>
                             </form>
                            
                             <form method="POST" action="{{route('phase_3.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p3" class="btn btn-dark"disabled>Confirmation</button>
                             </form>
                            
                              <form method="POST" action="{{route('phase_4.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p3" class="btn btn-success" disabled>Planning</button>
                             </form>
                            
                            <div class="terminer">
                             <form method="POST" action="{{route('phase_des.event', $even->id)}}">
                                 {{ csrf_field() }}
                                <button type="submit" id="p4"  class="btn btn-danger" disabled>Terminer</button>
                                 </form>
                            </div>    
                      
                           
                        </div>
                     
                         @endif
                         <br><br><br>
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white;">Quitter</button>
                    </form>
                  </div>
                </div>
            </div>
          </div>

          
            <div class="content-wrapper" >
              
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <h3 class="card-title"><b>Tarification de l’évènement</b> </h3>
                    <br>
                    <div class="row">
                      <div class="row col-md-6 align-items-start">
                        <h6 class="card-title"><br>Votre èvènement est-il gratuit ?  </h6>
                      </div>
                      <div>
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                      </div>
                    </div>
                    <br><br>
                      <div class="row row-cols-lg-4" style="justify-content: space-between; width:1000px;">
                        <div class="row col-md-4 border border-danger" style="margin-left:10px;border-radius: 7px; ">
                          <p><b>PASS #1</b></p>
                          <label for="col-form-label"><br>Sélectionner les activités qui composent ce pass :</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie d’ouverture 
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agricole
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agro-sylvo-pastorale
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie de cloture
                              </label>
                          </div>
                          <div class="mb-3 row">
                            <label for="inputPass" class="col-sm-7 col-form-label"style="margin-left:-15px">Prix du pass:</label>
                              <div class="col-sm-6"style="margin-left:-20px">
                                <input type="text" class="form-control" id="inputPass">
                              </div>
                          </div>
                        </div>
                        
                        <div class="row col-md-4  border border-danger" style="margin-rifht:40px;border-radius: 7px;">
                          <p><b>PASS #2</b></p>
                          <label for="col-form-label"><br>Sélectionner les activités qui composent ce pass :</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie d’ouverture 
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agricole
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agro-sylvo-pastorale
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie de cloture
                              </label>
                          </div>
                          <div class="mb-3 row">
                            <label for="inputPass" class="col-sm-7 col-form-label"style="margin-left:-15px">Prix du pass:</label>
                              <div class="col-sm-6"style="margin-left:-20px">
                                <input type="text" class="form-control" id="inputPass">
                              </div>
                          </div>
                        </div>
                        <div class="row col-md-4  border border-danger"style="margin-right:75px;border-radius: 7px;">
                          <p><b>PASS #3</b></p>
                          <label for="col-form-label"><br>Sélectionner les activités qui composent ce pass :</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie d’ouverture 
                              </label>
                          </div>
                          <div class="form-check" >
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agricole
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Panel sur l’investissement Agro-sylvo-pastorale
                              </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                              Cérémonie de cloture
                              </label>
                          </div>
                          <div class="mb-3 row">
                            <label for="inputPass" class="col-sm-7 col-form-label"style="margin-left:-15px">Prix du pass:</label>
                              <div class="col-sm-6"style="margin-left:-20px">
                                <input type="text" class="form-control" id="inputPass">
                              </div>
                          </div>
                        </div>
                      </div>
                      
                      
                    <br><br>
                    
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white">Quitter</button>
                   
                  </div>
                </div>
              </div>
            </div>
          
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- partial -->
          </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('Admin/Dashboard.js')
  </body>
</html>

