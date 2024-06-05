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
                    <h4 class="card-title">Modifier  l'évènement</h4>
                    <p class="card-description">Remplissez ce formulaire pour Modifier l'èvènement</p>
                    <form action="{{route('secteuractivites.update', $secteur_activites->id)}}" enctype="multipart/form-data" method='post'>
        {{ csrf_field() }}
        @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Libelle (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" value="{{$secteur_activites->libelle}}" name="libelle" placeholder="Name">
                      </div>
                      
                      <!-- <div class="form-group">
                        <label for="exampleSelectGender">Quel est le format de l'évènement ? (<span class="red">*</span>)</label>
                        <select class="form-control" id="exampleSelectGender">
                          <option>En ligne</option>
                          <option>Hors ligne</option>
                        </select>
                      </div> -->
                      

                    
                    
                      <button type="submit" class="btn btn-gradient-primary mr-2">Valider</button>
                      <button class="btn btn-danger">Quitter</button>
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