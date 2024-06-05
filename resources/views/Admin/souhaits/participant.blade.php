@include('forums.header2')


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
<!-- <td><a class="btn btn-primary" href="/messages">Retour</a></td>
 -->
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
                    <a href="/generate-pdf">PDF</a>

                      <div class="card">
                      <h5 style="color:green; margin-top:20px;">Le Catalogue</h5>
    <div class="card-header" style="font-size:13px;"></b></div>
    <div class="card-body"> 
    <a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a>

       <div class="card-body">
       <table class="table table-bordered" style="margin-top:50px;">

        <tr>


            <th style="font-size:12px;">Civilité du participant</th>
            <th style="font-size:12px;">Nom du participant</th>
            <th style="font-size:12px;">Prenom du participant</th>
            <th style="font-size:12px;">Fonction du participant</th>
            <th style="font-size:12px;">Email du participant</th>
            <th style="font-size:12px;">Téléphone Portable du participant</th>

            <th style="font-size:12px;" width="250px;">Action</th>

        </tr>

        @foreach ($participants as $participant)

        <tr>


            <td style="font-size:12px;">{{ $participant->identite }}</td>

            <td style="font-size:12px;">{{ $participant->nom }}</td>
            <td style="font-size:12px;">{{ $participant->prenom }}</td>
            <td style="font-size:12px;">{{ $participant->function }}</td>
            <td style="font-size:12px;">{{ $participant->email }}</td>
            <td style="font-size:12px;">{{ $participant->tel }}</td>


            <td>
            <a class="btn btn-info" href="{{ route('generate.pdf',$participant->id) }}">Détails</a>

                <!-- <form action="{{ route('participants.destroy',$participant->id) }}" method="POST">



                    <a class="btn btn-info" href="{{ route('participants.show',$participant->id) }}">Détails</a>

                    <a class="btn btn-primary" href="{{ route('participants.edit',$participant->id) }}">Modifier</a>



                    @csrf

                    @method('DELETE')


   

                    <button type="submit" class="btn btn-danger">Supprimer</button>

                </form> -->

            </td>

        </tr>

        @endforeach

    </table>
 
    </div> 
    <div class="card-footer"></div>
  </div>
  {!! $participants->links() !!}

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

@foreach($participants as $participant)

$("#loginStatus{{$participant->id}}").change(function(){  
var status = $("#loginStatus{{$participant->id}}").val();
var participantID = $("#participantID{{$participant->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banparticipant")}}',
data: 'status=' + status + '&participantID=' + participantID,
type: 'get',
success:function(response){
console.log(response);
}
});
}

});

$("#loginnStatus{{$participant->id}}").change(function(){  
var status = $("#loginnStatus{{$participant->id}}").val();
var participantID = $("#participantID{{$participant->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banparticipant")}}',
data: 'status=' + status + '&participantID=' + participantID,
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


   


