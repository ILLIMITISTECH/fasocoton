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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des chefs de délégation : {{count($delegation)}}</h4>
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Nom </th>
                              <th> Prenom </th>
                              <th class="text-center"> Mail </th>
                              <!--<th class="text-center"> Delegation</th>
                              <th class="text-center"> Lien zoom</th>-->
                              <!--<th class="text-center"> Duration </th>-->
                              <th class="text-center"> Nombres de membres</th>
                              <th class="text-center"> Options</th>
                            </tr>
                          </thead>
                          <tbody>
                           @foreach($delegation as $delegations)
                              
                            <tr>
                              <td>{{$delegations->nom}}</td>
                              <td>
                              {{$delegations->prenom}}
                              </td>
                             <td>{{$delegations->email}}</td>
                             @php $membres = DB::table('membres')->where('delegation_id', $delegations->id)->count(); @endphp
                            <td>{{ $membres }}</td>
                              
                              <td class="text-center"> 
                              <div class ="option-column">
                               <a href="{{route('chefdelegations.edit', $delegations->id)}}">
                                <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                            </a>
                                <form action="{{route('chefdelegations.destroy', $delegations->id)}}" method="post">
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