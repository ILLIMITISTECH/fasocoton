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
          <div class="bd">
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des profils d'entreprises de l'évènement "Event_Name"</h4>
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                  <h3>
                    @if(session('message'))
                      <div class= "alerte alerte-success" role="alerte">
                        {{session('message')}}
                      </div>
                    @endif
                  </h3>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Libellé </th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($profils as $profil)
                            <tr>
                            <td>{{ $profil->libelle}}</td>
                              <td class="text-center"> 
                              <form action="{{ route('profils.destroy',$profil->id) }}" method="POST">
                                <a class="btn btn-fill" style="background:#23B40B;color:white" href="{{ route('profils.edit',$profil->id) }}"><i class="bi bi-pen-fill"></i></a>
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit"  style="background:#C92C2B;color:white" onclick="return confirm('Etês-vous sûr / Are you sure?')" style="padding:0px 20px" class="btn btn-default"><i class="bi bi-trash-fill"></i></button>
                              </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
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
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>