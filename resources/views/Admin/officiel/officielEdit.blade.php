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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier les informations d'un organisateur</h4>
          </div>
            <div class="col-12 grid-margin stretch-card"style="margin-top:-40px">
                <div class="card">
                        @if (session('messagess'))
                        <div class="alert alert-success" role="alert">
                        {{ session('messagess') }}
                        </div>  
                        @endif
                  <div class="card-body">
                    
                    <p class="card-description">Remplissez ce formulaire pour modifier les informations de l'officiel</p>
                    <form class="forms-sample"  action="{{route('officiels.update', $officiel->id)}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom </label>
                        <input type="text" class="form-control" value="{{$officiel->nom}}" name="nom" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénom</label>
                        <input type="text" name="prenom" value="{{$officiel->prenom}}" class="form-control" id="website" placeholder="Site Web">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email </label>
                        <input type="text" class="form-control" value="{{$officiel->email}}" name="email" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Fonction</label>
                        <input type="text" name="fonction" value="{{$officiel->fonction}}" class="form-control" id="website" placeholder="Site Web">
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