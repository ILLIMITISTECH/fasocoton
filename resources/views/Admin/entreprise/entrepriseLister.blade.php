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
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bd">
               <?php
                         
                        $evens = DB::table('events')->get();
                        ?>
                        @foreach($evens as $even)
                        @if($even->status == 1)
             <h4 class="card-title"style="margin-left:30px;"> <br>Liste des entreprises inscrites à {{$even->nom_event_fr}} : {{count($entreprises)}}</h4>
                      @else
                      
                      <p></p>
                                            @endif

                      @endforeach
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
                          
                              <th> Nom de l'entreprise</th>
                              <th> Pays</th>
                              <th> Secteur d'activités</th>
                              <th> Profil</th>
                              <!--<th> Participants</th>-->
                              <th> Point focal</th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($entreprises as $entreprise)
                            <tr>
                                
                                <td>{{$entreprise->nom_entreprise}}</td>
                                <td>{{$entreprise->pays}}</td>
                                <td>{{$entreprise->secteur_a}} - {{$entreprise->secteur_b}} - {{$entreprise->secteur_c}}</td>
                                <td>{{$entreprise->profile_entreprise_a}} - {{$entreprise->profile_entreprise_b}} - {{$entreprise->profile_entreprise_c}}</td>
                                
                                <td> </td>

                                <td class="text-center option-column"> 
                                
                              <a href="{{route('entreprises.edit', $entreprise->id)}}">
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                            </a>
                                <form action="{{route('entreprises.destroy', $entreprise->id)}}" method="post">
                                  {{ csrf_field() }}
                                  @method('DELETE')
                                <button type="submit" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
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