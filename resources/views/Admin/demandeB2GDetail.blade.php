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
            <h4 class="card-title"style="margin-left:30px;"> <br>Détails des demandes de rendez-vous B2G</h4>
          </div>
            <div class="row"style="margin-top:-40px">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                       
                            <tr>
                            <td class=""><b>Difficulté 1 :</b><br><br> {{$demandeurs->dificulte1}}</td><br><br>
                            <td class="text-center"><b>Difficulté 2 :</b><br><br> {{$demandeurs->dificulte2}}</td><br><br>
                            <td class="text-center"><b>Difficulté 3 :</b><br><br> {{$demandeurs->dificulte3}}</td><br><br>
                            <td class="text-center"><b>Comment pensez-vous que l'Etat pourrais vous aider ?</b><br><br>{{$demandeurs->aide}}</td><br><br>
                            <td class="text-center"><b>Autres détails sur les Officiels recherchés (Qui souhaitez-vous rencontrer)</b><br><br>{{$demandeurs->details}}</td><br><br>
                         <td class="text-center">
                             
                             <div style="display:flex; justify-content:between;">
         
          <div id="accepter">
            <form action="{{route('accepter', $demandeurs->id)}}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success" style="background-color:lime;">Valider</button>
            </form>
          </div>
          <div id="refuser">
            <form action="{{route('refuser', $demandeurs->id)}}" method="post">
              {{ csrf_field() }}
              <button type="submit"  style="width=100px;height=5px;" class="btn btn-danger">Refuser</button>
            </form>
          </div>

</div>
                         </td>
                            
                            </tr>
                          
                        
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