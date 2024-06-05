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
            <h4 class="card-title"style="margin-left:30px;"> <br>Créer un hotel</h4>
          </div>
            <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                    <p class="card-description">Remplissez ce formulaire pour créer un hotel</p>
                    <form class="dropzone dropzone-custom needsclick add-professors forms-sample" id="demo1-upload" enctype="multipart/form-data" method="post" action="{{route('hotels.store')}}">
                    {{ csrf_field() }}

                      <div class="form-group">
                        <label for="text">Nom de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="nom_hotel" class="form-control" id="text" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="email_hotel" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                       <div class="form-group">
                        <label for="text">Type de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="type_hotel" class="form-control" id="text" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="text">Telephone de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="tel_hotel" class="form-control" id="text" placeholder="Name">
                      </div>
                       <div class="form-group">
                        <label for="text">Site web de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="site_hotel" class="form-control" id="text" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="text">Details de l'hotel : (<span class="red">*</span>)</label>
                        <input type="text" name="details_hotel" class="form-control" id="text" placeholder="Name">
                      </div>
                      <div class="row">
                      
                         <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                    </div>

                    <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <a href="/hotels" class="btn " style="background:#C92C2B; color:white">Quitter</a>
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