@include('Admin/Dashboard.head')
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
            <h4 class="card-title"style="margin-left:30px;"> <br>Ajouter un participant</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                <div class="card">
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                  <div class="card-body">
                    
                    <p class="card-description">Remplissez ce formulaire pour ajouter un participant</p>
                    <form class="forms-sample"  action="{{route('participants.store')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom  (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénoms (<span class="red">*</span>)</label>
                        <input type="text" name="prenom" class="form-control" id="website" placeholder="Site Web">
                      </div>
                      <div class="form-group">
                        <label for="website">Email (<span class="red">*</span>)</label>
                        <input type="email" name="email" class="form-control" id="website" placeholder="example@...">
                      </div>
                    
                          <div class="row">
                              <div class="form-group col-md-6">
                                  <label for="exampleSelectGender">Entreprise du Participant</label>
                                  <select class="form-control" name="entreprise_id" id="stade_entreprise">
                                 
                                  </select>
                            </div>
                              <div class="form-group col-md-6">
                                <label for="exampleSelectGender">Fonction du participant</label>
                                <input type="text" name="fonction" class="form-control" id="fonction" placeholder="fonction du participant">
                              </div>
                          
                           <div class="form-group col-md-6">
                            <label for="exampleSelectGender">Téléphone du participant</label>
                            <input type="text" name="tel_part" class="form-control" id="777....." placeholder="téléphone du participant">
                          </div>


                          <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Langue : (<span class="red">*</span>)</label>
                            <select class="form-control" name="langue_id" id="stade_entreprise" placeholder="Langue">>
                           
                            </select>
                          </div>

                         <div class="form-group col-md-6">
                            <label for="exampleInputConfirmPassword1">Pays : (<span class="red">*</span>)</label>
                            <select class="form-control" name="pays_id" id="stade_entreprise"placeholder="Pays">>
                            
                            </select><br><br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputConfirmPassword1">Presence : (<span class="red">*</span>)</label>
                            <input type="tinyint" name="presence" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                        </div>
                        </div>  
                        <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white">Quitter</button>
                    </form>
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
  </body>
</html>