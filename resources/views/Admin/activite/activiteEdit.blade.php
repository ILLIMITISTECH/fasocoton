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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier une activité</h4>
          </div>
            <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                    <p class="card-description">Remplissez ce formulaire pour modifier une activité</p>
                    <form class="dropzone dropzone-custom needsclick add-professors forms-sample" id="demo1-upload" enctype="multipart/form-data" method="post" action="{{route('activites.update', $activite->id)}}">
                    {{ csrf_field() }}
                    @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'activité : (<span class="red">*</span>)</label>
                        <input type="text" name="libelle" value="{{$activite->libelle}}" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                    
                      <div class="form-group">
                        <label for="exampleSelectGender">Date  (<span class="red">*</span>)</label>
                        <!--<select class="form-control" id="exampleSelectGender">
                          <option>En ligne</option>
                          <option>Hors ligne</option>
                        </select> -->
                        <div class="">
                            <input type="date" name="date" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                      </div>
                      <?php
                            //M.A.X B.I.R.D was here

                            $traducteurs = DB::table('traducteurs')->get();
                            
                            $stakeholders = DB::table('intervenants')->get();
                            
                            if($traducteurs){  
                                
                       ?>
                       <div class="form-group">
                           <p class=""><b>Avez-vous besoin de traducteur ?</b></p>
                            
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
                                        {{$traductor->prenom}} {{$traductor->nom}} : 🎤 {{$langue}} <input style="width:20px" class="form-control checkmark checkbox" type="checkbox" id = "" name="traductors[]" value="{{$traductor->id}}">&nbsp;
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
                           <p class=""><b>Des intervennants à votre activité  ?</b></p>
                           
                            
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
                                        {{$stakeholder->prenom}} {{$stakeholder->nom}} : 👤 {{$typo}} <input style="width:20px" class="form-control checkmark checkbox" type="checkbox" id = "" name="stakeholders[]" value="{{$stakeholder->id}}">&nbsp;
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
                            <input type="text" name="heure_debut" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                      </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Heure de fin : (<span class="red">*</span>)</label>
                            <div class="">
                                <input type="text" name="heure_fin" class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white">Quitter</button>
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