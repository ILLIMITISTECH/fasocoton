@include('Admin/Dashboard.head')
  <body>
    <div class="container-scroller">
   
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
     
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bdc">
            <h4 class="card-title"style="margin-left:30px;"> <br>Inscription Facilitateur</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                <div class="card">
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                        
                        
                  <div class="card-body">
                    
                    <p class="card-description">Remplissez ce formulaire pour ajouter un facilitateur </p>
                    <form class="forms-sample"  action="{{route('Storefacilitateurs')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Nom  (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénoms (<span class="red">*</span>)</label>
                        <input type="text" name="prenom" class="form-control" id="website" placeholder="Prénoms">
                      </div>
                      
                      <div class="form-group">
                        <label for="website">Email </label>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

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
                         <div class="form-group ">
                            <label for="exampleInputPassword1">Langue : (<span class="red">*</span>)</label>
                            <select  name="langue_id" id="stade_entreprise">
                                  <option value="">selectionner</option>
                                        @foreach($langue as $langu)  
                                        <option value="{{$langu->id}}">{{$langu->libelle_eng}}</option>
                                        @endforeach
                            </select>             
                        </div>
                        
                       <div class="form-group">
                        <label for="website">Type de facilitateur (<span class="red">*</span>)</label>
                        <select  name="type_id" id="stade_entreprise" required>
                                  <?php $type_faci = DB::table('types')->whereIn('libelle', ['Traducteurs','Hotesse', 'Presse', 'STAFF', 'Membre du CO', 'Sponsors', 'invités'])->get() ?>
                                  <option value="">selectionner</option>
                                        @foreach($type_faci as $typ)  
                                        <option value="{{$typ->id}}">{{$typ->libelle}}</option>
                                        @endforeach
                                </select>            
                                </select>             
                      </div>
        
                           <div class="form-group col-md-6">
                            <label for="exampleSelectGender">Téléphone du facilitateur</label>
                            <input type="text" name="phone" class="form-control" id="777....." placeholder="Numéro de Téléphone">
                          </div>
                           <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                        <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <a href="/facilitateurs" class="btn " style="background:#C92C2B; color:white">Quitter</a>
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