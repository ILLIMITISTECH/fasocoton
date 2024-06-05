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
            <h4 class="card-title"style="margin-left:30px;"> <br>Modifier un Sponsor</h4>
          </div>
            <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                    <p class="card-description">Remplissez ce formulaire pour modifier un Sponsor</p>
                    <form class="dropzone dropzone-custom needsclick add-professors forms-sample" id="demo1-upload" enctype="multipart/form-data" method="post" action="{{route('sponsors.update', $sponsor->id)}}">
                    {{ csrf_field() }}
                    @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom du Sponsor : (<span class="red">*</span>)</label>
                        <input type="text" name="nom_sponsor" value="{{$sponsor->nom_sponsor}}" class="form-control" id="exampleInputName1" placeholder="Nom du sponsor">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Logo : (<span class="red">*</span>)</label>
                        <input type="file" name="logo1" value="{{$sponsor->logo1}}" class="form-control" id="exampleInputName1" placeholder="Logo">
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Ordre  (<span class="red">*</span>)</label>
                        <div class="">
                            <input type="number" name="ordre" value="{{$sponsor->ordre}}" class="form-control" placeholder="Ordre" />
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