
@extends('templates.master')
 <link rel="stylesheet" href="{{asset('public3/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('public3/css/style.css')}}">
<body>
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
 <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
<div class="container" style="width:80%;margin-top:20px">
<td><a class="btn btn-fill"  style="color:white;background-color:#f49e31;border-radius:3px";"width:100%;margin-top:20px" href="/messages">Retour</a></td>
<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px";"width:100%;margin-top:20px" href="/catalogues">Catalogue des participants</a></td>
<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px";"width:100%;margin-top:20px"  href="/souhait_confirmer">Voir mes souhaits confirmés</a></td>

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
                    
                    <h5> @if (session('message_sugg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message_sugg') }}
                        </div>
                    @endif</h5>
                    
                     <h5> @if (session('message_suggs'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('message_suggs') }}
                        </div>
                    @endif</h5>
                    
                    
    
    
   
                 
                        <h2 class="form-title" style="color: #4b2E99;"><b>Valider mes suggestions des rendez-vous</b></h2>
                        
                         <h6>Notre système vous suggere des rendez-vous prioritaires en fonction des informations que vous avez saisies. Merci de confirmer les rendez-vous qui vous
           interessent et de cliquer à chaque fois sur le bouton valider</h6>
           <h6>Vous pouvez accéder à tout moment au catalogue pour voir toutes les entreprises inscrites.</h6>
            <h6 style="color:brown;">Our system suggests priority appointments based on the information you have entered. Please confirm the appointments that you
           interested and each time click on the validate button</h6>
           <h6 style="color:brown;">You can access the catalog at any time to see all the companies registered.</h6>
            @if(count($souhaites) > 2 )
                  <div id="alert success" class="btn btn-success" style="font-size:25px;">Vous ne pouvez valider que 3 souhaits ! Merci </div>
            @else
                        <center>
                             <div class="card">
                      
                                <div class="card-body"> 
                                
                        <table id="datatable-buttons" class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                
                                <th scope="col">Entreprise</th>
                                <th scope="col">Description de l'entreprise</th>
                                <th scope="col">Partenariat rechercher</th>
                                <th scope="col">Etat des rendez-vous</th>
                                <th scope="col">Option</th>
                            </tr>
                         </thead>
                          @foreach($souhaits as $souhait)
                        <tbody>
                            <tr>
                                <td scope="row"><a class="" href="{{route('souhaits.show', $souhait->id)}}"><b  style="color:#4b2e99;">{{$souhait->nom_entreprise}}</b></a>
                  <br><b style="color:black;">{{$souhait->pays}}</b><br><a class="btn btn-fill" style="color:white;background-color:#4b2e99;"  href="{{route('souhaits.show', $souhait->id)}}">Details</a></td></td>
                                
                                <td>{{ substr($souhait->description,0,185) }}</td>
                                
                                <td>{{$souhait->partenaire_rechercher}}</td>
                                
                                <td>@if($souhait->status==0)
                                      <div style="color:Red;">Non confirmé</div>
                                      @else
                                      <div style="color:Green;">Confirmé</div>
                                      @endif</td>
                                      
                                                <td>  <div style="display : flex;">
                                          {!! Form::open(['method'=>'post', 'route'=>['status.actif_sugg', $souhait->id]]) !!}   
                                            <button type="submit" 
                                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-plus-fill" viewBox="0 0 16 16">
                                                <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
                                            </svg>
                                    </button>
                                             {!! Form::close() !!}
                                             
                                             {!! Form::open(['method'=>'post', 'route'=>['status.desactif_sugg', $souhait->id]]) !!}   
                                             <button type="submit" 
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>   
                                    </button>
                                             {!! Form::close() !!}
                                         </div></td>
                                         
                               
                        </tbody>
                  @endforeach
                  
                     </table>
                                          @endif
                                        </div>
                                                                                 

                                          </div>
                        </center>
    
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

@foreach($souhaits as $souhait)

$("#loginStatus{{$souhait->id}}").change(function(){  
var status = $("#loginStatus{{$souhait->id}}").val();
var souhaitID = $("#souhaitID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait")}}',
data: 'status=' + status + '&souhaitID=' + souhaitID,
type: 'get',
success:function(response){
console.log(response);  
}
});
}

});

$("#loginnStatus{{$souhait->id}}").change(function(){  
var status = $("#loginnStatus{{$souhait->id}}").val();
var souhaitID = $("#souhaitID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait")}}',  
data: 'status=' + status + '&souhaitID=' + souhaitID,
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