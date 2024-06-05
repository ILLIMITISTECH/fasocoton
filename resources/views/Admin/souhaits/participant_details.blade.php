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

                      <div class="card">
                      <h5 style="color:green; margin-top:20px;">Le Catalogue</h5>
    <div class="card-header" style="font-size:13px;"></b></div>
    <div class="card-body"> 

       <div class="card-body">
       <table class="table table-bordered" style="margin-top:50px;">

        

        <tr>


            dhjjkbjjknb
            
        </tr>

       

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
   
</div>


   


