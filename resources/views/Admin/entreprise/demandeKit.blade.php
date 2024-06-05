@include('Admin/Dashboard.head')
  <body>
    <div class="container-scroller">
       <!-- partial:partials/_navbar.html -->
       @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
       
        <!-- partial -->
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bd">
               <?php
                        $entreprises = DB::table('entreprises')->get(); 
                        $participants = DB::table('participants')->where('kit' , '=', 1)->get();
                        $evens = DB::table('events')->get();
                        ?>
                        @foreach($evens as $even)
                        @if($even->status == 1)
             <h4 class="card-title"style="margin-left:30px;"> <br>Liste des participants inscrits à {{$even->nom_event_fr}} : {{count($participants)}}</h4>
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
                              <th> Nom & Prénom</th>
                              <th> Contacts</th>
                              <th> Fonction</th>
                              <th> Nom de l'entreprise</th>
                             
                              <th> Pays</th>
                              <th> Secteur d'activités</th>
                              <th> Profil</th>
                              <!--<th> Participants</th>-->
                             
                             
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($participants as $participant)
                          <?php  $entreprise = DB::table('entreprises')->where('id', $participant->entreprise_id)->first();  ?>
                            <tr>
                                <td>{{ ($participant) ? $participant->prenom : '--'}} {{ ($participant) ? $participant->nom : '--'}}</td>
                                <td>{{ ($participant) ? $participant->email : '--'}} <br> <br> {{ ($participant) ? $participant->tel_part : '--'}}</td>
                                <td>{{ ($participant) ? $participant->fonction : '--'}}</td>
                                <td>{{ ($entreprise) ? $entreprise->nom_entreprise : '--'}}</td>
                                <td>{{ ($entreprise) ? $entreprise->pays : '--'}}</td>
                                <td>{{ ($entreprise) ? $entreprise->secteur_a : '--'}} - {{ ($entreprise) ? $entreprise->secteur_b : '--'}} - {{ ($entreprise) ? $entreprise->secteur_c : '--'}}</td>
                                <td>{{ ($entreprise) ? $entreprise->profile_entreprise_a : '--' }} - {{ ($entreprise) ? $entreprise->profile_entreprise_b : '--'}} - {{ ($entreprise) ? $entreprise->profile_entreprise_c : '--'}}</td>
                                
                                <td> </td>

                               
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