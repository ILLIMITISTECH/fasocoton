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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste de vos Creneaux</h4>
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
                              <th> Table </th>
                              <th class="text-center">Salle</th>
                              <th>Date</th>
                              <th>Date de debut</th>
                              <th>Date de fin</th>
                              <th class="text-center"> Options </th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($crenaux as $creneaux)
                          <tr>
                              <td>{{$creneaux->libelle_t}}</td>
                              <?php $salles = DB::table('salles')->where('id', $creneaux->sale_id)->get() ?>
                              @foreach($salles as $salle)
                              <td>{{$salle->libelle}}</td>
                              
                              @endforeach
                              <td>
                              {{$creneaux->date_c}}
                              </td>
                              <td>
                              {{$creneaux->heure_deb}}
                              </td>
                              <td>
                              {{$creneaux->heure_fin}}
                              </td>
                              <td class="text-center"> 
                              <a href="{{route('creneaux.edit', $creneaux->id)}}">
                                <button type="button" class="btn btn-sm "style="background:#F49800;color:white" ><i class="bi bi-gear-fill"></i></i></button>
                              </a>
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                                <form action="{{route('creneaux.destroy', $creneaux->id)}}" method="post">
                                  {{ csrf_field() }}
                                  @method('DELETE')
                                <button type="button" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
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
    @include('Admin/Dashboard.js')
  </body>
  </html>