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
          <div class="bdc">
            <h4 class="card-title"style="margin-left:30px;"> <br>Créer une activité</h4>
          </div>
            <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                    <p class="card-description">Remplissez ce formulaire pour créer une activité</p>
                    <form class="dropzone dropzone-custom needsclick add-professors forms-sample" id="demo1-upload" enctype="multipart/form-data" method="post" action="{{route('activites.store')}}">
                    {{ csrf_field() }}

                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'activité : (<span class="red">*</span>)</label>
                        <input type="text" name="libelle" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <!--<label for="exampleInputName1">Format de l'activité : (<span class="red">*</span>)</label>
                        <input type="text" name="libelle" class="form-control" id="exampleInputName1" placeholder="Name">-->
                        <label for="exampleInputName1">Sujet : (<span class="red">*</span>)</label>
                        <input type="text" name="topic" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Date  (<span class="red">*</span>)</label>
                    
                        <div class="">
                            <input type="date" name="start_time" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                      </div>

                      <div class="form-group">
                        <label for="exampleSelectGender">Duration  (<span class="red">*</span>)</label>
  
                        <div class="">
                            <input type="number" name="duration" class="form-control" placeholder="Duration" />
                        </div>
                      </div>
                      <?php
                            //M.A.X B.I.R.D was here

                            $traducteurs = DB::table('traducteurs')->get();
                            
                            $stakeholders = DB::table('intervenants')->get();
                            
                            $participants = DB::table('participants')->where('paneliste', '=', 1)->get();
                            
                            if($traducteurs){  
                                
                       ?>
                       
                       <div class="form-group">
                           <p class="">Avez-vous besoin de traducteur ?</p>
                            
                            <?php 
                            foreach($traducteurs as $traductor){
                                $langue = '';
                                foreach($languages as $language)
                                    if($traductor->langue_id == $language->id)
                                        $langue = $language->libelle_eng;
                            ?> 
                                <br>
                                <div class="">
                                   <label class="">
                                        {{$traductor->prenom}} {{$traductor->nom}} : 🎤 {{$langue}} <input class="form-control checkmark checkbox" type="checkbox" id = "" name="traductors[]" value="{{$traductor->id}}">&nbsp;
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                       </div>
                      <?php
                      
                         }
                         
                         if($participants){
                      ?>
                       
                       <div class="form-group">
                           <p class="">Des intervennants à votre activité : Entreprise  ?</p>
                           
                            
                            <?php 
                            foreach($participants as $participant){
                                $langue = '';
                               foreach($languages as $language)
                                    if($participant->langue_id == $language->id)
                                        $langue = $language->libelle_eng;
                            ?> 
                                <br>
                                <div class="">
                                   <label class="">
                                        {{$participant->prenom}} {{$participant->nom}} : 👤 {{$langue}} <input class="form-control checkmark checkbox" type="checkbox" id = "" name="participants[]" value="{{$participant->id}}">&nbsp;
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                       </div>
                       
                       <?php
                      
                         }
                         
                         if($stakeholders){
                      ?>
                       
                       <div class="form-group">
                           <p class="">Des intervennants à votre activité  ?</p>
                           
                            
                            <?php 
                            foreach($stakeholders as $stakeholder){
                                $langue = '';
                                foreach($types as $type)
                                    if($stakeholder->type_id == $type->id)
                                        $typo = $type->libelle;
                            ?> 
                                <br>
                                <div class="">
                                   <label class="">
                                        {{$stakeholder->prenom}} {{$stakeholder->nom}} : 👤 {{$typo}} <input class="form-control checkmark checkbox" type="checkbox" id = "" name="stakeholders[]" value="{{$stakeholder->id}}">&nbsp;
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                       </div>
                      <?php
                            }
                      ?>

                      <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Heure de début : (<span class="red">*</span>)</label>
                            <div class="">
                            <input type="time" name="heure_debut" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                         <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Heure de fin : (<span class="red">*</span>)</label>
                            <div class="">
                            <input type="time" name="heure_fin" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <a href="/activites" class="btn " style="background:#C92C2B; color:white">Quitter</a>
                    </form>
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