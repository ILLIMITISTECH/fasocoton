@include('Admin/Dashboard.head')
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
       @include('Admin/Dashboard.sidebarUser')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bd">
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des participants inscrites à "Event_Name"</h4>
          </div>
            <div class="row"style="margin-top:-40px;">
                <div class="col-12 grid-margin">
                  <div class="card">
                  <h3>@if(session('message'))
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
                              <th> Nom</th>
                              <th> Prénom</th>
                              <th> Entreprise</th>
                              <th> Fonction</th>
                              <th> Email</th>
                              <th> Pays</th>
                              <th> Téléphone</th>
                              <th> Langue</th>
                              <th> Pays</th>
                              <th>Presence</th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                            <tr>
                                
                                <td>Nonguierma</td>
                                <td>Axel</td>
                                <td>ILLIMITIS SAS</td>
                                <td>Digital Project Manager</td>
                                <td>axel.n@illimitis.com</td>
                                <td>+221782967825</td>
                                <td>Francais</td>
                                <td>Senegal</td>
                                <td>En ligne</td>
                                <td class="text-center"> 
                                
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                                <button type="button" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
                              </td>
                            </tr>
                            
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
    @include('Admin/Dashboard.js')
    <!-- End custom js for this page -->
  </body>
</html>