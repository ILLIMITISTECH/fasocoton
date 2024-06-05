@extends('layout.adminlayout.template')
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
    <br><br>

 <td><a class="btn btn-fill" style="color:white;background-color:#f49e31;border-radius:3px" href="/messages">Retour</a></td>
  <!-- <td><a class="btn btn-primary" href="/">Accueil</a></td> -->

<td><a class="btn btn-fill" style="color:white;background-color:#4b2e99;border-radius:3px" href="/suggesstion">Mes suggestions de rendez-vous</a></td> 
<td><a class="btn btn-fill" style="color:white;background-color:#4b2e99;border-radius:3px" href="/souhait_confirmer">Voir mes souhaits confirmés</a></td>

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
                      <h5 style="color:#4b2e99; margin-top:20px;">Catalogue des participants ayant demandé des B 2 B/Catalog of participants who requested B 2 B</h5>
    <div class="card-header" style="font-size:13px;"></b>
    <tr><td>
   
                  <h6>Découvrez ci-dessous la liste de toutes les entreprises inscrites au SICOT. Vous pouvez filtrer la liste par secteurs d'activités ou par pays,
                  et ajouter une entreprise qui vous interesse dans votre liste de souhaits
                  </h6>
                   <h6 style="color:brown;">Discover below the list of all the companies registered with SICOT. You can filter the list by business sector or by country,
                  and add a company you are interested in to your wishlist
                  </h6>
    <form action="/search" method="get">
        <select name="search" required>
            <option value="" disabled selected>Par secteurs d'activités: </option>
                @foreach($secteur_activites as $secteur_activite)
                <option value="{{$secteur_activite->nom}}">{{$secteur_activite->nom}}</option>  
                @endforeach
        </select>
            <button class="btn btn-fill" type="submit" style="font-size:12px;background-color:#4b2e99;color:white">Filtrer</button>

        </form> 
        </td>

        <!--<td>
            <form action="/search" method="get" style="margin-top:5px;">
            <select name="search" required>
                <option value="" disabled selected>Pays de l'entreprise</option>
                @foreach($pays as $pay)
                <option value="{{$pay->nom}}">{{$pay->nom}}</option>
                @endforeach
            </select>
                <button class="btn btn-primary" type="submit">Filtrer</button>

            </form>                      
        </td>-->
        
        <!--<td>
            <form action="/search" method="get" style="margin-top:5px;">
        <input type="text" name="search" placeholder="Rechercher par nom de l'entreprise" style="width:500px;">
                <button class="btn btn-primary" type="submit" style="font-size:12px;">Filtrer</button>

            </form>                      
        </td> -->
        
        </tr>                
    </div>
    <div class="card-body"> 

    <table id="datatable-buttons" class="table table-striped table-bordered">

    <thead>
        <tr>


    <th style="font-size:12px;">L'entreprise</th>
    <th style="font-size:12px;">Pays</th>
    <th style="font-size:12px;">Description</th>
    <th style="font-size:12px;">Secteurs d'activités</th>
    <th style="font-size:12px;">Partenariats recherchés</th>
   <!-- <th style="font-size:12px; width:50px;">Actions</th>-->



    <th style="font-size:12px;" width="250px">Options</th>
      
</tr>
</thead>
@if(count($souhaites) > 4 )
<div id="alert success" class="btn btn-success" style="font-size:25px;"> Vous ne pouvez ajouter que 5 souhaits ! Merci</div>
@else
@foreach ($entreprises as $entreprise)
@foreach ($souhaits as $souhait)


<tr>

<form action="/save_souhait" method="post">
<input type="hidden" value="{{csrf_token()}}" name="_token"/>

    <td style="font-size:12px; width:50px;"><a class="btns" style="color:#4b2e99;" href="{{route('entreprisecata.show', $entreprise->id)}}">{{ $entreprise->nom_entreprise }}</a> <br> Profil: {{ $entreprise->profile_entreprise_a }}
    <br><a class="btn btn-fill" href="{{route('entreprisecata.show', $entreprise->id)}}" style="font-size:12px;background-color:#4b2e99;color:white">Plus d'infos</a></td>
    <td style="font-size:12px;width:50px;">{{ $entreprise->pays }}</td>
    <td style="font-size:12px; width:100px;">{{ substr($entreprise->description,0,185) }}</td>
    <td style="font-size:12px; width:50px;"><b>{{ $entreprise->secteur_a }}</b>
    <br>{{ $entreprise->secteur_b }} <br>{{ $entreprise->secteur_c }}</td>
    <td style="font-size:12px;width:50px;">{{ $entreprise->partenaire_rechercher }}</td>
    <input type="hidden" name="entreprise_id" value="{{$souhait->id}}">
    <input type="hidden" name="entreprise_rv_id" value="{{$entreprise->id}}">
    <input type="hidden" name="priorite" value="2">
    <input type="hidden" name="status" value="1">
    <input type="hidden" name="langue_ent_1" value="{{$souhait->langue}}">
    <input type="hidden" name="langue_ent_2" value="{{$entreprise->langue}}">



    <td>
      @if($entreprise->rendez_vous != 'AVEC un planning B 2 B')
      <p><b>B 2 B non demandé</b></p>
      @else
        <button type="submit" class="btn btn-fill" style="font-size:12px;background-color:white;color:black;box-shadow: 2px 3px 4px #4b2e99">Ajouter à mes souhaits</button>
    @endif
    </td> 
    </form>
</tr>
@endforeach

@endforeach
@endif
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
$(document).ready(function(){

@foreach($entreprises as $entreprise)

$("#loginStatus{{$entreprise->id}}").change(function(){  
var status = $("#loginStatus{{$entreprise->id}}").val();
var entrepriseID = $("#entrepriseID{{$entreprise->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banentreprise")}}',
data: 'status=' + status + '&entrepriseID=' + entrepriseID,
type: 'get',
success:function(response){
console.log(response);
}
});
}

});

$("#loginnStatus{{$entreprise->id}}").change(function(){  
var status = $("#loginnStatus{{$entreprise->id}}").val();
var entrepriseID = $("#entrepriseID{{$entreprise->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banentreprise")}}',
data: 'status=' + status + '&entrepriseID=' + entrepriseID,
type: 'get',
success:function(response){
console.log(response);
}
});
}

});
@endforeach
});
</script>

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
   
   
</div>


   


