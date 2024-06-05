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
          <div class="bd">
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des Hotels </h4>
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Nom de l'hotel</th>
                              <th class="text-center">Email </th>
                              <th class="text-center"> Type </th>
                              <th class="text-center"> Telephone </th>
                              <th class="text-center"> Nombre de chambre </th>
                              <th class="text-center"> Nombre de place </th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                           @foreach($hotels as $hotel)
                            <tr>
                              <td>
                                  {{$hotel->nom_hotel}}
                              </td>
                              <td>
                              {{$hotel->email_hotel}}
                              </td>
                              <td>
                              {{$hotel->type_hotel}}
                              </td>
                              <td>
                              {{$hotel->tel_hotel}}
                              </td>
                              <td>
                              {{$hotel->site_hotel}}
                              </td>
                              <td>
                              {{$hotel->details_hotel}}
                              </td>
                              <td class="text-center"> 
                              <div class ="option-column">
                               <a href="{{route('hotels.edit', $hotel->id)}}">
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                            </a>
                                <form action="{{route('hotels.destroy', $hotel->id)}}" method="post">
                                  {{ csrf_field() }}
                                  @method('DELETE')
                                <button type="submit" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
                                </form> 
                                 
                            </div>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
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
    <script>
        function copyToClipboard(id) {
            document.getElementById(id).select();
            document.execCommand('copy');
        }
    </script>
    @include('Admin/Dashboard.js')
    
  </body>
</html>