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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier les informations d'une entreprise</h4>
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
                    
                    <p class="card-description">Remplissez ce formulaire pour mpdifier les informations d'une entreprise</p>
                    <form action="{{route('events.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'entreprise: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_event_fr" placeholder="Name">
                      </div>
                     
                      <div class="form-group">
                        <label for="website">Pays</label>
                        <input type="link" class="form-control" id="website" placeholder="Pays">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Secteur d'activité : (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="libelle" id="exampleInputName1" placeholder="Libellé du secteur d'activité">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Profil : (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Libellé du profil">
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