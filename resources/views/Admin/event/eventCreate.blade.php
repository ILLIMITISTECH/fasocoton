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
            <h4 class="card-title"style="margin-left:30px;"> <br>Créer un évènement</h4>
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
                    <h4 class="card-title">Créer un évènement</h4>
                    <p class="card-description">Remplissez ce formulaire pour créer un èvènement</p>
                    <form action="{{route('events.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'évènement en Français: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_event_fr" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'évènement en Anglais: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_event_en" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="website">Site Web : (Optionnel)</label>
                        <input type="link" class="form-control" name="site" placeholder="Site Web">
                      </div>
                      <!-- <div class="form-group">
                        <label for="exampleSelectGender">Quel est le format de l'évènement ? (<span class="red">*</span>)</label>
                        <select class="form-control" id="exampleSelectGender">
                          <option>En ligne</option>
                          <option>Hors ligne</option>
                          <option>Hybride</option>
                        </select>
                      </div> -->
                      
                      <div class="form-group">
                        <label for="website">Lieu de l'évènement</label>
                        <input type="link" class="form-control" id="website" placeholder="Site Web">
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Date de début : (<span class="red">*</span>)</label>
                            <div class="">
                            <input type="date" class="form-control" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Date de fin : (<span class="red">*</span>)</label>
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