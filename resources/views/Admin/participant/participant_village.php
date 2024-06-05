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
             <h4 class="card-title"style="margin-left:30px;"> <br>Liste des participants inscrites au {{$even->nom_event_fr}} </h4>
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
                              <th> Nom</th>
                              <th> Prénom</th>
                              <th> Entreprise</th>
                              <th> Fonction</th>
                              <th> Email</th>
                              <th> Pays</th>
                              <th> Téléphone</th>
                              <th> Langue</th>
                              <th>Presence</th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($participant as $participants)
                            <tr> 
                                <td>{{$participants->nom}}</td>
                                <td>{{$participants->prenom}}</td>
                                <?php $entre = DB::table('entreprises')->where('id', $participants->entreprise_id)->first() ?>
                                <td>{{ ($entre) ? $entre->nom_entreprise : '--'}}</td>
                                @if($participants->fonction)
                                <td>{{$participants->fonction}}</td>
                                @else
                                 <td>--</td>
                                @endif
                                <td>{{$participants->email}}</td>
                                 <?php $pays = DB::table('pays')->where('id', $participants->pays_id)->first() ?>
                                <td>{{ ($pays) ? $pays->libelle_fr : '--'}}</td>
                                <td>{{$participants->tel_part}}</td>
                                 <?php $lang = DB::table('langues')->where('id', $participants->langue_id)->first() ?>
                                <td>{{ ($lang) ? $lang->libelle_eng : '--'}}</td>
                                @if($participants->presence == 1)
                                <td>En présentiel</td>
                                @elseif($participants->presence == 2)
                                 <td>En ligne</td>
                                 @else
                                 <td>--</td>
                                @endif
                                <td class="text-center"> 
                                
                                <a href="{{route('participants.edit', $participants->id)}}">
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                              </a><br><br>
                                
                                <form action="{{route('participants.destroy', $participants->id)}}" method="post">
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
    <!-- End custom js for this page -->
  </body>
</html>