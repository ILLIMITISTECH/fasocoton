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
                  @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif

                  <div class="card-body">
                    <h4 class="card-title">Ajouter un profil </h4>
                    <p class="card-description">Remplissez ce formulaire pour créer un profil d'entreprise</p>
                    <form class="forms-sample"  action="{{route('profils.store')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Libellé du profil : (<span class="red">*</span>)</label>
                        <input type="text" name="libelle" class="form-control" id="exampleInputName1" placeholder="Libellé du secteur d'activité">
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
    <!-- End custom js for this page -->
  </body>
</html>