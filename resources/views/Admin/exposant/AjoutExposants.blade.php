@include('Admin/Dashboard.head')
  <body>
    <div class="container-scroller">
   
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
     
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bdc">
            <h4 class="card-title"style="margin-left:30px;"> <br>Inscription Exposant</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                <div class="card">
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                        
                        
                  <div class="card-body">
                    
                    <p class="card-description">Remplissez ce formulaire pour ajouter un exposant </p>
                    <form class="forms-sample"  action="{{route('StoreExposants')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom  (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénoms (<span class="red">*</span>)</label>
                        <input type="text" name="prenom" class="form-control" id="website" placeholder="Prénoms">
                      </div>
                      
                      <div class="form-group" hidden>
                        <label for="website">Email (<span class="red">*</span>)</label>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="exposant@gmail.com"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                      </div>
                      
                      <div class="form-group">
                        <label for="website">Entreprise</label>
                        <input type="text" name="entreprise" class="form-control" id="website" placeholder="Entreprise">
                      </div>
                         
                       
        
                           <div class="form-group col-md-6">
                            <label for="exampleSelectGender">Téléphone du Exposant</label>
                            <input type="text" name="phone" class="form-control" id="777....." placeholder="Numéro de Téléphone">
                          </div>
                           <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                        <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      
                    </form>
                  </div>
                </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        
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