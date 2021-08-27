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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des rendez-vous B2G générés</h4>
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
                              
                              <th>Date </th>
                              <th>Heure</th>
                              <th>Salle</th>
                              <th>Table</th>
                              <th>Institution</th>
                              <th>Entreprise 2</th>
                              <th>Lien zoom</th>
                              <th>Traducteur </th>
                              <th class="text-center"> Options </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            
                              <td>
                                12/02/2022
                              </td>
                              <td>
                                10h - 10h30
                              </td>
                              <td>
                                Salle 1
                              </td>
                              <td>
                               Numero 10
                              </td>
                              <td>
                                Ministere du commerce
                              </td>
                              <td>
                              YELKAYE SARL
                              </td>
                              <td>
                                www.com
                              </td>
                              <td>
                              Fallou Gueye
                              </td>
                              <td class="text-center"> 
                                <button type="button" class="btn btn-sm "style="background:#F49800;color:white" ><i class="bi bi-gear-fill"></i></i></button>
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
  </body>
</html>