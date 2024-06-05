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
              <?php
                         
                        $evens = DB::table('events')->get();
                        ?>
                        @foreach($evens as $even)
                        @if($even->status == 1)
             <h4 class="card-title"style="margin-left:30px;"> <br>Liste des facilitateurs inscrites à {{$even->nom_event_fr}} : {{count($facilitateur)}}</h4>
                      @else
                      
                      <p></p>
                                            @endif

                      @endforeach
          </div>
            <div class="row"style="margin-top:-40px;">
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
                              <th> Nom</th>
                              <th> Prénom</th>
                              <th> Type</th>
                              <th> Email</th>
                              <th> Téléphone</th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                          @foreach ($facilitateur as $facilitateurs)
                            <tr>
                                
                                <td>{{$facilitateurs->nom}}</td>
                                <td>{{$facilitateurs->prenom}}</td>
                                @php $type = DB::table('types')->where('id', $facilitateurs->type_id)->first(); @endphp
                                <td>{{ ($type) ? $type->libelle : '--'}}</td>
                                <td>{{$facilitateurs->email}}</td>
                                <td>{{$facilitateurs->phone}}</td>
                                <div class ="option-column">
                                <td class="text-center"> 
                                
                                <a href="{{route('facilitateurs.edit', $facilitateurs->id)}}">
                                 <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                                 </a>
                                <form action="{{route('facilitateurs.destroy', $facilitateurs->id)}}" method="post">
                                  {{ csrf_field() }}
                                  @method('DELETE')
                                <button type="submit" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
                                </form>
                                
                              </td>
                              </div>
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
    <!-- End custom js for this page -->
  </body>
</html>