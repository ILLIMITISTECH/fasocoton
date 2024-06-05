<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OPTIEVENT</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('public3/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('public3/css/style.css')}}">
</head>
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
                    <form method="POST" id="signup-form" class="signup-form">
<div class="container"  style="width:80%;margin-top:30px">
<td><a class="btn btn-fill"  style="color:white;background-color:#f49e31;border-radius:3px" href="/messages">Retour</a></td>

<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px" href="/suggesstion">Liste des suggestions</a></td>
<td><a class="btn btn-fill"  style="color:white;background-color:#4b2e99;border-radius:3px"  href="/catalogues">Liste des participants</a></td>

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
                    
    
                        <h2 class="form-title" style="color: #4b2E99;"><b>Mes souhaits de rendez-vous confirmés</b></h2>
                        Vos souhaits de rendez-vous confirmés à ce jour sont listés ci-dessous. Vous pouvez toujours annuler certains souhaits.<br>
                        Vous pouvez accéder à tout moment au catalogue pour voir toutes les entreprises inscrites.
                        <h5>Vous avez <b style="color:red;">{{ count($souhaitss) + count($souhaites) }}</b> souhaits de rendez-vous confirmés</h5><br>
                        <h3 style="text-align: center;color: #4b2E99;">Souhaits suggerés automatiquement </h3>
                        
                        <center>
                    <table class="table ">
                        <thead>
                             <tr>
                                  <th>Entreprise</th>
                                  <th>Etat du rendez-vous</th>
                            </tr>
                            @foreach($souhaitss as $souhait)
                         </thead>
                        <tbody>
                            <tr>
                                <td scope="row"><b>{{$souhait->nom_entreprise}}</b><br>
                                    <b style="color:black;">{{$souhait->pays}}</b><br></td>
                                <td >@if($souhait->status==0)
                  <div style="color:#c63f50;text-shadow: 1px 1px 2px #c63f50;">Non confirmé</div>
                  @else
                  <div style="color:#4b2e99; text-shadow: 1px 1px 2px #4b2e99;">confirmé</div>
                  @endif
                  </td>
                  
                                <!--<td style="color: orange;"><b>En attente de confirmation</b></td>-->
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                        </center>
                        <h3 style="text-align: center;color: #4b2E99;">Souhaits ajoutés par moi même </h3>
                        
                        <center>
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>Entreprise</th>
                                <th>Etat du rendez-vous</th>
                  
                            </tr>  
                                @foreach($souhaites as $souhait)
                         </thead>
                        <tbody>
                            <tr>
                                 <td style="font-size:15px; color:#4b2e99;"><b>{{$souhait->nom_entreprise}}</b><br>
                  <b style="color:black;">{{$souhait->pays}}</b><br></td>
                 <td>@if($souhait->status==0)
                  <div style="color:#c63f50;text-shadow: 1px 1px 2px #c63f50;">Non confirmé</div>
                  @else
                  <div style="color:#4b2e99; text-shadow: 1px 1px 2px #4b2e99;">En attente de confirmation</div>
                  @endif
                  </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                        </center>
                    </form>
                </div>
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

@foreach($souhaitss as $souhait)


$("#loginnStatus{{$souhait->id}}").change(function(){  
var status = $("#loginnStatus{{$souhait->id}}").val();
var souhaitID = $("#souhaitID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait_confirmer")}}',
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
$(document).ready(function(){

@foreach($souhaites as $souhait)


$("#loginneStatus{{$souhait->id}}").change(function(){  
var status = $("#loginneStatus{{$souhait->id}}").val();
var souhaiteID = $("#souhaiteID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait_confirme")}}',
data: 'status=' + status + '&souhaiteID=' + souhaiteID,
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
   
</div>


   


