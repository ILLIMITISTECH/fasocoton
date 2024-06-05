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
            <h4 class="card-title"style="margin-left:30px;"> <br>Liste de vos évènements</h4>
          </div>
            <div class="row"style="margin-top:-40px;">
                <div class="col-12 grid-margin">
                  <div class="card">
                  <h3>@if(session('message'))
                    <div class= "alerte alerte-success" role="alerte">
                        {{session('message')}}
                    </div>
                    @endif
                  </h3>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>   
                              <th> Libellé </th>
                              <th class="text-center"> Activer / Désactiver </th>
                              <th>Date de debut</th>
                              <th>Date de fin</th>
                              <th class="text-center">Organisateur</th>
                              <th class="text-center"> Options </th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($even as $evens)
                          <tr>
                              <td> {{$evens->nom_event_fr}} {{$evens->nom_event_en}} <br><br> Max de rendez_vous: {{$evens->max}}</td>
                              <td class="text-center">
                                  <!-- Rounded switch -->
                                 <center>
                                    <div class="act">
                                        @if($evens->status == 0)
                                            <b >Evènement désactivé&nbsp;<i class="fas fa-pause"></i></b>
                                            @else
                                            <b style="color:#4b2e99">En cours&nbsp;<i class="fas fa-circle-notch fa-spin"></i></b>
                                            @endif
                                    </div>
                                    </center>
                                <label class="switch">
                                    
                                    <center>
                                    <div class="liv" style="display:flex; margin-top:5px; margin-left:20px;">
                                       @if($evens->status == 1)
                                       
                                          <div class="livs">
                                        <form method="post" action="{{route('desactiver.event', $evens->id)}}">
                                            {{ csrf_field()}}
                                                <button type="submit" style="margin-left:5px;background:#4b2e99;color:white" id="e1" class="btn  slider round"></button>
                                        </form>
                                         </div>
                                        @else
                                        <div class="liv">
                                         <form method="post" action="{{route('activer.event', $evens->id)}}">
                                            {{ csrf_field()}}
                                                <button type="submit" style="background:#F9F9F9;color:white" id="e1" class="btn btn-default slider round"></button>
                                        </form>
                                         </div>
                                        
                                        
                                        @endif  
                                        
                                        </div>
                                 </center>
                                </label>
                              </td>
                              <td>
                              {{$evens->date_debut}}
                              </td>
                              <td>
                              {{$evens->date_fin}}
                              </td>
                              
                               <?php $orga = DB::table('organisateurs')->where('id', $evens->organisateur_id)->first(); ?> 
                              @if($orga)
                             <td>
                              {{$orga->prenom}} {{$orga->nom}}
                              </td>
                              @else
                              <td>
                              -- --
                              </td>
                              @endif
                              <td class="text-center option-column"> 
                                     
                                        <button type="button" class="btn btn-sm "style="background:#F49800;color:white" ><i class="bi bi-gear-fill"></i></i></button>
                                     
                                       <a href="{{route('events.edit', $evens->id)}}">
                                    <button type="button" class="btn  btn-sm"style="background:#23B40B;color:white"><i class="bi bi-pen-fill"></i></i></button>
                                    </a>
                                    <form action="{{route('events.destroy', $evens->id)}}" method="post">
                                      {{ csrf_field() }}
                                      @method('DELETE')
                                    <button type="submit" class="btn  btn-sm"style="background:#C92C2B;color:white"><i class="bi bi-trash-fill"></i></button>  
                                    </form>
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
    @include('Admin/Dashboard.js')
  </body>
  </html>