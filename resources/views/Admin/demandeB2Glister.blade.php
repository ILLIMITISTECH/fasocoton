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
               <h6> @if(session('message'))
            <div class="alert alert-success" role="alert">
            {{ session('message') }}
            </div> 
            </h6>
            @endif
          <div class="bd">
                       
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste des demandes de rendez-vous B2G</h4> 
          
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Demandeur </th>
                              <th> Entreprise </th>
                              <th class="text-center"> Poste </th>
                              <th class="text-center"> Secteur d'activité </th>
                               <th class="text-center"> Profil </th>
                                <th class="text-center"> Options </th>
                            </tr>
                          </thead>
                          <tbody>
                       @foreach($demandeur as $demandeurs)
                            <tr>
                            <td class="">{{$demandeurs->prenom}} {{$demandeurs->nom}}</td>
                            <td class="text-center">{{$demandeurs->nom_entreprise}}</td>
                            <td class="text-center">{{$demandeurs->fonction}}</td>
                            <td class="text-center">{{$demandeurs->secteur_a}}</td>
                            <td class="text-center">{{$demandeurs->profile_entreprise_a}}</td>
                         <td class="text-center">
                             
                             <div style="display:flex; justify-content:space-between;">
          <div id="detail">
             <a type="button" href="{{route('detaildemandeur.b2g', $demandeurs->id)}}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-square" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg></a>
          </div>
         
        <!--  <div id="accepter">
            <form action="{{route('accepter', $demandeurs->id)}}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success" style="background-color:lime;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
              </svg></button>
            </form>
          </div>
          <div id="refuser">
            <form action="{{route('refuser', $demandeurs->id)}}" method="post">
              {{ csrf_field() }}
              <button type="submit"  style="width=100px;height=5px;" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg></button>
            </form>
          </div>-->

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