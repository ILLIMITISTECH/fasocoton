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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste de vos évènements</h4>
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
                              <th> Libellé </th>
                              <th class="text-center"> Activer / Désactiver </th>
                              <th>Date de debut</th>
                              <th>Date de fin</th>
                              <th class="text-center"> Options </th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($even as $evens)
                          <tr>
                              <td> {{$evens->nom_event_fr}} {{$evens->nom_event_en}}</td>
                              <td class="text-center">
                                  <!-- Rounded switch -->
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                              </td>
                              <td>
                              {{$evens->date_debut}}
                              </td>
                              <td>
                              {{$evens->date_fin}}
                              </td>
                              <td class="text-center"> 
                              <a href="{{route('events.edit', $evens->id)}}">
                                <button type="button" class="btn btn-sm "style="background:#F49800;color:white" ><i class="bi bi-gear-fill"></i></i></button>
                              </a>
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                                <form action="{{route('events.destroy', $evens->id)}}" method="post">
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