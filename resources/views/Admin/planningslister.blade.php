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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des plannings</h4>
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Entreprise </th>
                              <th> Entreprise RV </th>
                              <th class="text-center"> Heure </th>
                              <th class="text-center"> Salle</th>
                              <th class="text-center"> URL </th>
                              <th class="text-center"> Date RV </th>
                              <th class="text-center"> Duration</th>
                            </tr>
                          </thead>
                          <tbody>
                           @foreach($planing as $planings)
                           @if($planings)
                            <tr>
                                
                                <?php 
                                        $entreprise = DB::table('entreprise_rvs')->where('id', '=', $planning->entreprise_id)->first();
                                        $entreprise_rv = DB::table('entreprise_rvs')->where('id', '=', $planning->entreprise_rv_id)->first();
                                        $salles = DB::table('salles')->where('id', $planning->sale_id)->first();
                                        $user = DB::table('users')->where('id', '=', $entreprise->user_id)->first()
                                ?>
                              @if($entreprise)
                              @if($entreprise_rv)
                              @if($salles)
                              @if($user)
                                <td>
                                
                              {{(($entreprise->nom_entreprise) ? $entreprise->nom_entreprise : '--'}}
                                
                              </td>
                              <td>
                             
                              {{($entreprise_rv->nom_entreprise) ? $entreprise_rv->nom_entreprise : '--'}}
                             
                              </td>
                              <td class="text-center">
                              {{$planings->heure_deb}} /  {{$planings->heure_fin}}
                              </td>
                                <td>
                           
                              {{($salles->libelle) ? $salles->libelle : '--'}}
                            
                              </td>
                              <td class="text-center"> 
                                 <a href="{{$planings->join_url}}" class="btn  btn-sm"style="background:#0D71EB;color:white">Join</a>
                              </td>
                              <td class="text-center">
                              {{$planings->date_rv}}
                              </td>
                             
                              <td class="text-center">
                              {{$planings->duration}}H
                              </td>
                            </tr>
                            @endif
                            @endif
                            @endif
                            @endif
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
    <script>
        function copyToClipboard(id) {
            document.getElementById(id).select();
            document.execCommand('copy');
        }
    </script>
    @include('Admin/Dashboard.js')
    
  </body>
</html>