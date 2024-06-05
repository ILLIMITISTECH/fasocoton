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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier les informations d'une entreprise</h4>
          </div>
          <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                  <h6> 
                        @if (session('messagee'))
                        <div class="alert alert-success" role="alert">
                        {{ session('messagee') }}
                        </div>  
                        @endif
                    </h6>
                    
                    <p class="card-description">Remplissez ce formulaire pour modifier les informations d'une entreprise</p>
                    <form action="{{route('entreprises.update', $entreprises->id)}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}
                         @method('put')
                     <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label">Nom Entreprise :</label>
                                                <input type="text" name="nom_entreprise" value="{{$entreprises->nom_entreprise}}" class="form-control form-control-solid" placeholder="Nonguierma"/>
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label">Site web :</label>
                                                <input type="text" name="site" value="{{$entreprises->site}}" class="form-control form-control-solid" placeholder="Votre site web"/>
                                            </div>
                                             <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label">Slogan :</label>
                                                <input type="text" name="slogan" value="{{$entreprises->slogan}}" class="form-control form-control-solid" placeholder="Votre slogan"/>
                                            </div>
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class=" form-label">Numéro de Téléphone :</label>
                                                <input type="text" name="tel_entreprise" value="{{$entreprises->tel_entreprise}}" class="form-control form-control-solid" placeholder="00221 782967825"/>
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