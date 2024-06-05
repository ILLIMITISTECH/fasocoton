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
                    
                    <p class="card-description">Remplissez ce formulaire pour modifier les informations de la chambre</p>
                    <form class="forms-sample"  action="{{route('chambres.update', $chambre->id)}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de la chambre</label>
                        <input type="text" class="form-control" value="{{$chambre->nom_chambre}}" name="nom_chambre" id="exampleInputName1" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="website">Prénom</label>
                        <input type="text" name="prix" value="{{$chambre->prix}}" class="form-control" id="website" placeholder="Site Web">
                      </div>
                     
                      <div class="form-group ">
                            <label for="exampleInputPassword1">hotel : </label>
                            <select class="form-control" name="hotel_id" id="stade_entreprise">
                                <?php $hotels = DB::table('hotels')->where('id', $chambre->hotel_id)->first(); ?>
                                @if($hotels)
                            <option value="{{$chambre->hotel_id}}">{{$hotels->nom_hotel}}</option>
                            @else
                            <option value="{{$chambre->hotel_id}}">Séléctionner </option>
                            @endif
                            @foreach($hotel as $hotelss)  
                            <option value="{{$hotelss->id}}">{{$hotelss->nom_hotel}}</option>
                            @endforeach
                            </select>
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