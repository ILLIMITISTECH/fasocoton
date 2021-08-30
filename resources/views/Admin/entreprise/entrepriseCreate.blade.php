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
            <h4 class="card-title"style="margin-left:30px;"> <br>Créer une entreprise</h4>
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
                    <p class="card-description">Remplissez ce formulaire pour créer une entreprise</p>
                    <form action="{{route('entreprises.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'entreprise: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_entreprise" placeholder="Name">
                      </div>
                     
                      <div class="form-group">
                        <label for="website">Pays</label>
                        <select class="form-control" name="pays_id" id="stade_entreprise">
                            @foreach($pays as $pay)  
                            <option value="pays_id">{{$pay->libelle_fr}} {{$pay->libelle_en}}</option>
                            @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Secteur d'activité : (<span class="red">*</span>)</label>
                        <select class="form-control" name="secteur_activite_id" id="stade_entreprise">
                            @foreach($secteur as $secteurs)  
                            <option value="secteur_activite_id">{{$secteurs->libelle}}</option>
                            @endforeach
                            </select>
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Profil : (<span class="red">*</span>)</label>
                        <select class="form-control" name="profil_id" id="stade_entreprise">
                            @foreach($profil as $profils)  
                            <option value="profil_id">{{$profils->libelle}}</option>
                            @endforeach
                            </select>
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