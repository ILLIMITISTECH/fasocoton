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
             <h4 class="card-title"style="margin-left:30px;"> <br>Liste des participants inscrits au {{$even->nom_event_fr}} avec Badge</h4><br><br><br>
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
                  <br><br>
                    <div class="card-body">
                     
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Prénom/Nom</th>
                              <th> Entreprise</th>
                              <th> Fonction</th>
                              <th> Email</th>
                              <th> Pays</th>
                              <th> Téléphone</th>
                              <th> Langue</th>
                              <th>Presence</th>
                              <th>Badge</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($participant as $participants)
                            @php $badge = DB::table('badges')->where('id', $participants->badge_id)->first(); @endphp
                            @if($badge)
                            <tr> 
                                <td>{{$participants->prenom}} {{$participants->nom}}</td>
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
                                <td>{{$badge->libelle}}</td>
                                
                               
                            </tr>
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
    @include('Admin/Dashboard.js')
    <!-- End custom js for this page -->
  </body>
</html>