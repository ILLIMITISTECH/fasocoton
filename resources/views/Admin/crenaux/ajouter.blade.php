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
            <h4 class="card-title"style="margin-left:30px;"> <br>Creation crenaux</h4>
          </div>
          <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                  <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <p class="card-description">Remplissez ce formulaire pour créer un crenaux</p>
                    <form action="{{route('creneaux.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}   
                          
                    <div class="form-group">
                        <label for="exampleInputName1">Salle (<span class="red">*</span>)</label>
                        <select class="form-control" name="sale_id" id="stade_entreprise">
                            @foreach($salles as $salle)  
                            <option value="{{$salle->id}}">{{$salle->libelle}}</option>
                            @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label for="website">Table</label>
                        <select class="form-control" name="libelle_t" id="table_id">
                            @foreach($tables as $table)  
                            <option value="{{$table->libelle}}">{{$table->libelle}}</option>
                            @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Sujet : (<span class="red">*</span>)</label>
                        <input type="text" name="topic" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                     
                      <!--<div class="form-group">
                        <label for="exampleInputName1">Date: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="date_c" placeholder="Name">
                      </div> -->
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
                      <div class="form-group">
                        <label for="exampleInputName1">Heure de début: (<span class="red">*</span>)</label>
                        <input type="time" class="form-control" name="heure_deb" placeholder="Name">
                      </div><div class="form-group">
                        <label for="exampleInputName1">Heure de fin: (<span class="red">*</span>)</label>
                        <input type="time" class="form-control" name="heure_fin" placeholder="Name">
                      </div>
                       <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <button class="btn " style="background:#C92C2B; color:white">Quitter</button>
                    </form>
                  </div>
                </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
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