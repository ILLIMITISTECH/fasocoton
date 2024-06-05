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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier les informations d'un intervenant</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                <div class="card">
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                  <div class="card-body">
                    
                    <p class="card-description">Remplissez ce formulaire pour modifier les informations d'un intervenant</p>
                    <form class="forms-sample"  action="{{route('intervenants.update', $intervenant->id)}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom </label>
                        <input type="text" class="form-control" value="{{$intervenant->nom}}" name="nom" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénom</label>
                        <input type="text" name="prenom" value="{{$intervenant->prenom}}" class="form-control" id="website" placeholder="Site Web">
                      </div>
                      <div class="form-group">
                        <label for="website">Type</label>
                         <select class="form-control" name="type_id" id="stade_entreprise">
                           <?php $typess = DB::table('types')->where('id', $intervenant->type_id)->first(); ?>
                                @if($typess)
                                 <option value="{{$intervenant->type_id}}">{{$typess->libelle}}</option>
                                @else
                            <option value="{{$intervenant->type_id}}">Selectionner un type</option>
                            @endif
                            <?php $type_inter = DB::table('types')->whereIn('libelle', ['Modérateur', 'Maître de cérémonie', 'Panéliste'])->get() ?>
                            @foreach($type_inter as $typ)  
                            <option value="{{$typ->id}}">{{$typ->libelle}}</option>
                            @endforeach  
                            </select>
                            </div>
                      <div class="form-group ">
                            <label for="exampleInputPassword1">Langue : </label>
                            <select class="form-control" name="langue_id" id="stade_entreprise">
                                <?php $languess = DB::table('langues')->where('id', $intervenant->langue_id)->first(); ?>
                                @if($languess)
                                 <option value="{{$intervenant->langue_id}}">{{$languess->libelle_eng}}</option>
                                @else
                            <option value="{{$intervenant->langue_id}}">Selectionner une langue</option>
                            @endif
                            @foreach($langue as $langu)  
                            <option value="{{$langu->id}}">{{$langu->libelle_eng}}</option>
                            @endforeach
                            </select>
                          </div>
                      <div class="form-group">
                        <label for="website">Email</label>
                        <input type="email" name="email" value="{{$intervenant->email}}" class="form-control" id="website" placeholder="example@...">
                      </div>
                           <div class="form-group col-md-6">
                            <label for="exampleSelectGender">Téléphone </label>
                            <input type="text" name="phone" class="form-control" value="{{$intervenant->phone}}" id="777....." placeholder="Site Web">
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