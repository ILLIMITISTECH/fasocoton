@include('forums.header1')
@extends('templates.master')

<body style="background:white;height:100vh">

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
<div class="container" style="width:80%;margin-top:20px">
<td><a class="btn btn-fill"  style="color:white;background-color:#f49e31;border-radius:3px" href="/messages">Retour</a></td>
<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px" href="/catalogues">Catalogue des participants</a></td>
<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px"  href="/souhait_confirmer">Voir mes souhaits confirmés</a></td>

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
                    
                    
                    
  <div class="card">
                      <h5 style="color:#f49e31; margin-top:20px;">Mes Suggestions de rendez-vous</h5>
    <div class="card-header" style="font-size:13px;"></b></div>
       <div class="card-body"> 
           <h6>Notre système vous suggere des rendez-vous prioritaires en fonction des informations que vous avez saisies. Merci de confirmer les rendez-vous qui vous
           interessent et de cliquer à chaque fois sur le bouton valider</h6>
           <h6>Vous pouvez accéder à tout moment au catalogue pour voir toutes les entreprises inscrites.</h6>
            <h6 style="color:brown;">Our system suggests priority appointments based on the information you have entered. Please confirm the appointments that you
           interested and each time click on the validate button</h6>
           <h6 style="color:brown;">You can access the catalog at any time to see all the companies registered.</h6>
            @if(count($souhaites) > 2 )
                  <div id="alert success" class="btn btn-success" style="font-size:25px;">Vous ne pouvez valider que 3 souhaits ! Merci </div>
            @else
           <table id="datatable-buttons" class="table table-striped table-bordered">

                <thead>                <tr>
                  <th style="width:20px;">Entreprise</th>  
                  <th style="width:80px;">Description entreprise</th>
<!--                   <th>Secteur d'activités principal</th>
 -->                  <th style="width:20px;">Partenariat recherché</th>
<!--                   <th>Alliances recherchées</th>
 -->                   <th>Etat du rendez-vous</th>
                  <!--<th>Validez-vous ce rendez-vous?</th>
                  <th>Action</th> -->
                  <th>Options</th>
                </tr>
                </thead> 
            @foreach($souhaits as $souhait)
                    <tbody>
                    <tr>  

                  <td style="font-size:15px;"><a class="" href="{{route('souhaits.show', $souhait->id)}}"><b  style="color:#4b2e99;">{{$souhait->nom_entreprise}}</b></a>
                  <br><b style="color:black;">{{$souhait->pays}}</b><br><a class="btn btn-fill" style="color:white;background-color:#4b2e99;"  href="{{route('souhaits.show', $souhait->id)}}">Details</a></td>
                  <td style="font-size:15px;">{{ substr($souhait->description,0,185) }}</td>
<!--                   <td style="font-size:15px;">{{$souhait->secteur_a}}</td>
 -->                  <td style="font-size:15px;">{{$souhait->partenaire_rechercher}}</td>
                   <td>@if($souhait->status==0)
                  <div style="color:Red;">Non confirmé</div>
                  @else
                  <div style="color:Green;">Confirmé</div>
                  @endif
                  </td>
                            <!--<td>
                                  <div id="selectDiv{{$souhait->id}}">
                            <input type="hidden" id="souhaitID{{$souhait->id}}" value="{{$souhait->id}}">
                              <div class="check">                            
                                  <input id="loginStatus{{$souhait->id}}" type="radio" name="status" value="1">&nbsp;Oui
                                  <input id="loginnStatus{{$souhait->id}}" type="radio" name="status" value="0">&nbsp;Non

                              </div>
                           </div>   
                              </td>-->

                  <td>
                      <!--<a href="" style="color:black;box-shadow: 3px 3px 6px #4b2e99" class="btn btn-fill ">Valider</a>-->
                      
                      <div style="display : flex;">
                          {!! Form::open(['method'=>'post', 'route'=>['status.actif_sugg', $souhait->id]]) !!}   
                            <button type="submit" class="btn btn-success pull-left" style =" margin-right :8px;" ><i class="fas fa-check"></i></button>
                             {!! Form::close() !!}
                             
                             {!! Form::open(['method'=>'post', 'route'=>['status.desactif_sugg', $souhait->id]]) !!}   
                             <button type="submit" class="btn btn-danger pull-right" style =" margin-left :8px;"><i class="fas fa-times"></i></button>
                             {!! Form::close() !!}
                         </div>
                      
                      </td> 
                
                  


                    </tr>                          
                  </tbody>
                  @endforeach
                    </table>  
                     @endif
          </div>
 
    </div> 
    {!! $souhaits->links() !!}
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


   


