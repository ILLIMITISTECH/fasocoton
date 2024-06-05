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
          <div class="bdc" style="width:600px;">
            <h4 class="card-title"style="margin-left:30px;"> <br>Envoyer un mail aux participants de l’évènement</h4>
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
                    
                    
                    <form class="forms-sample" action="{{route('newletters.messages')}}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputName1">Object : (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="objet" id="exampleInputName1" placeholder="L'Objet du message">
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Contennu du mail : (<span class="red">*</span>)</label>
                        <textarea class="form-control" name="contenu" id="exampleFormControlTextarea1" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Piece jointe</label>
                        <input class="form-control" name="piece" type="file" id="formFileMultiple" multiple>
                    </div>
                    <br><br>
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <a href="/homes" class="btn " style="background:#C92C2B; color:white">Quitter</a>
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