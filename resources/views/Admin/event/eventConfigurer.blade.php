
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
            <h4 class="card-title"style="margin-left:30px;"> <br>Configurer un évènement</h4>
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
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Phase d’inscription des participants</label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                        <label class="col-form-label"><b>Date de début :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="row col-md-3 align-items-end">
                          <label class="col-form-label"><b>Date de fin :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_fin" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Phase suggestions et d’ajout de rendez-vous</label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                        <label class="col-form-label"><b>Date de début :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="row col-md-3 align-items-end">
                        <label class="col-form-label"><b>Date de fin :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_fin" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Phase de confirmation des rendez-vous</label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                            <label class="col-form-label"><b>Date de début :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="row col-md-3 align-items-end">
                        <label class="col-form-label"><b>Date de fin :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_fin" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="row col-md-6 align-items-start">
                          <label for="col-form-label"><br>Génération des plannings </label>
                        
                        </div>
                        <div class="row col-md-3 align-items-center">
                        <label class="col-form-label"><b>Date de début :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="row col-md-3 align-items-end">
                        <label class="col-form-label"><b>Date de fin :</b></label>
                            <div class="">
                            <input type="date" class="form-control" name="date_fin" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                      </div>
                    
                    
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white">Quitter</button>
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

