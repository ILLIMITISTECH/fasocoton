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
            <h4 class="card-title"style="margin-left:30px;"> <br>Creation crenaux</h4>
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
                    <p class="card-description">Remplissez ce formulaire pour créer un crenaux</p>
                    <form action="{{route('creneaux.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}   
                      <div class="form-group">
                        <label for="website">Table</label>
                        <select class="form-control" name="table_id" id="table_id">
                            @foreach($table as $tables)  
                            <option value="table_id">{{$tables->libelle}}</option>
                            @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Salle (<span class="red">*</span>)</label>
                        <select class="form-control" name="salle_id" id="stade_entreprise">
                            @foreach($salle as $salles)  
                            <option value="salle_id">{{$salles->libelle}}</option>
                            @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="date" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Heure de début: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="heure_debut" placeholder="Name">
                      </div><div class="form-group">
                        <label for="exampleInputName1">Heure de fin: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="heure_fin" placeholder="Name">
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