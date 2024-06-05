@include('forums.header2')
@extends('templates.master')


    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>
  
            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach
         
            </ul>  
   
        </div>

    @endif



    
    
  
<center>@if ($message = Session::get('success'))

<div class="alert alert-success">

    <p>{{ $message }}</p>

</div></center>

@endif
<div class="container">

 <td><a class="btn btn-primary" href="/page_statistiques">Retour</a></td>
<h6> @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messagesss'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messagesss') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messages'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messages') }}
                        </div>
                    @endif</h6>
                      <div class="card">
                      <h5 style="color:green; margin-top:20px;">Liste des entreprises</h5>
    <div class="card-header" style="font-size:13px;"></b>
   
        <td>
            <form action="/search_a" method="get" style="margin-top:5px;">
            <select name="search_a" style="width:200px;" required>
                <option value="" disabled selected>Par pays</option>
                @foreach($pays as $pay)
                <option value="{{$pay->nom}}">{{$pay->nom}}</option>
                @endforeach
            </select>
                <button class="btn btn-success" style="color:green;" type="submit">Filtrer</button>

            </form>                      
        </td>
        
         <td>
            <form action="/search_a" method="get" style="margin-top:5px;">
            <select name="search_a" style="width:200px;" required>
                <option value="" disabled selected>Par secteur d'activité</option>
                @foreach($secteur_activites as $secteur_activite)
                <option value="{{$secteur_activite->nom}}">{{$secteur_activite->nom}}</option>
                @endforeach
            </select>
                <button class="btn btn-success" style="color:green;" type="submit">Filtrer</button>

            </form>                      
        </td>
        
      
            <form action="/search_a" method="get" style="margin-top:5px;">
        <input type="text" name="search_a" style="width:200px;" placeholder="Rechercher par nom de l'entreprise" style="width:500px;">
                <button class="btn btn-success" style="background-color:green;" type="submit" style="font-size:12px;">Filtrer</button>

            </form>                      
        </td>
        
        </tr>                
    </div>
    <div class="card-body"> 

       <table class="table table-bordered" style="margin-top:50px;">

<tr>

    <th style="font-size:12px;">Contacts</th>
    <th style="font-size:12px;">L'entreprise</th>
    <th style="font-size:12px;">Pays</th>
    <th style="font-size:12px;">Description</th>
    <th style="font-size:12px;">Secteurs d'activités</th>
    <th style="font-size:12px;">Partenariats recherchés</th>



<!--     <th style="font-size:12px;" width="250px">Action</th>
 -->
</tr>

@foreach ($entreprises as $entreprise)


<tr>

    <td style="font-size:12px;width:50px;">{{ $entreprise->nom }} {{ $entreprise->prenom }} <br>{{ $entreprise->email }}<br>Tel:{{ $entreprise->tel_enttreprise }} / {{ $entreprise->portable }} / {{ $entreprise->fax }}   </td>
    <td style="font-size:12px; width:50px;">{{ $entreprise->nom_entreprise }}</a> <br> Profil: {{ $entreprise->profile_entreprise_a }}</td>
    <td style="font-size:12px;width:50px;">{{ $entreprise->pays }}</td>
    <td style="font-size:12px; width:100px;">{{ $entreprise->description }}</td>
    <td style="font-size:12px; width:50px;"><b>{{ $entreprise->secteur_a }}</b>
    <td style="font-size:12px;width:50px;">{{ $entreprise->partenaire_rechercher }}<br><a class="btn btn-success" href="{{route('catalogues.details',$entreprise->id)}}">Voir plus</a></td>

</tr>

@endforeach

</table>

 
    </div> 
    <div class="card-footer"></div>
  </div>

  <script src="{{asset('build/js/intlTelInput.js')}}"></script>
  <script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      utilsScript: "build/js/utils.js",
    });
  </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>
   var resizefunc = [];
   </script>
   
   <!-- jQuery  -->
   <script src="{{asset('assetspdf/js/jquery.min.js')}}"></script>
   <script src="{{asset('assetspdf/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/js/detect.js')}}"></script>
   <script src="{{asset('assetspdf/js/fastclick.js')}}"></script>
   <script src="{{asset('assetspdf/js/jquery.blockUI.js')}}"></script>
   <script src="{{asset('assetspdf/js/waves.js')}}"></script>
   <script src="{{asset('assetspdf/js/wow.min.js')}}"></script>
   
   <!-- Datatables-->
   <script src="{{asset('assetspdf/plugins/datatables/jquery.dataTables.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.bootstrap.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.buttons.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/jszip.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/pdfmake.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/vfs_fonts.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.html5.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.print.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.fixedHeader.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.keyTable.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.responsive.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/responsive.bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.scroller.min.js')}}"></script>
   
   <!-- Datatable init js -->
   <script src="{{asset('assetspdf/pages/datatables.init.js')}}"></script>
   
   <script src="{{asset('assetspdf/js/jquery.app.js')}}"></script>
   
   <script type="text/javascript">
   $(document).ready(function() {
       $('#datatable').dataTable();
       $('#datatable-keytable').DataTable( { keys: true } );
       $('#datatable-responsive').DataTable();
       $('#datatable-scroller').DataTable( { ajax: "{{asset('assetspdf/plugins/datatables/json/scroller-demo.json')}}", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
       var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
   } );
   TableManageButtons.init();
   </script>


/div>


   


