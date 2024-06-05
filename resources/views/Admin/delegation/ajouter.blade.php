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
            <h4 class="card-title"style="margin-left:30px;"> <br>Ajouter un chef de délégation</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                 <div class="card">
                  <div class="card-body">
                        <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                   
                       <form action="{{route('chefdelegations.store')}}" method=post>
                       {{ csrf_field() }}
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Prénom / First Name : </label>
                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" placeholder="Entrer le nom"/>
                        </div
                        <br><br>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Nom / Last Name : </label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" placeholder="Entrer le nom"/>
                        </div>
                        <br><br>
                        <div class="mb-10">
                            
                            <label for="exampleFormControlInput1" class="required form-label">Adresse Email  / Email Address : </label>
                            <input id="email" placeholder="Entrer l'adresse mail"/ type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                             @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <h6 style="margin-top: 5px;"> 
                                @if (session('messages'))
                                <div class="alert alert-danger" role="alert">
                                {{ session('messages') }}
                                </div>  
                                @endif
                            </h6>
                        </div>
                        
                        <br><br>
                        <div class="form-group">
                        <label for="website">Pays</label>
                        <select class="form-control" name="pays_id" id="stade_entreprise">
                            @foreach($pays as $pay)  
                            <option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>
                            @endforeach
                            </select>
                      </div>
                        
                        <br><br>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Langue : (<span class="red">*</span>)</label>
                            <select class="form-control" name="langue_id" id="stade_entreprise" placeholder="Langue">>
                            @foreach($langue as $langues)  
                                <option value="{{$langues->id}}">{{$langues->libelle_eng}}</option>
                            @endforeach  
                            </select>
                          </div>
                        <br><br>
              <input type="hidden" name="password" class="form-control" value="123456" placeholder="Mot de passe"/>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="form-label">Numéro de téléphone / Phone number : </label>
                            <input type="text" class="form-control @error('portable') is-invalid @enderror" name="portable" value="{{ old('portable') }}" required autocomplete="portable" placeholder="Entrer le nom"/>
                        </div>
                        <!--<div class="mb-10">-->
                        <!--    <label for="exampleFormControlInput1" class="form-label">Mots de pass / Password : </label>-->
                        <!--    <input type="password" name="password" class="form-control" placeholder="Mots de pass"/>-->
                        <!--</div>-->
                        <!--<div class="mb-10">-->
                        <!--    <label for="exampleFormControlInput1" class="form-label">Mots de pass / Password : </label>-->
                        <!--    <input id="password-confirm" type="password" class="form-control" style="font-size: -->
                        <!--    150%;  width:100%" name="password_confirmation" placeholder="confirmation mot de passe" required autocomplete="new-password">-->
                        <!--</div>-->
                        </div></div></div>
                        <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                     <a href="/chefdelegations"class="btn " style="background:#C92C2B; color:white">Quitter</a>
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