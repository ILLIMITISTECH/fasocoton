<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
     
  <title>SBPME 2023</title>
   
  <!-- Bootstrap core CSS -->  
  <link href="{{asset('forums/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="{{asset('forums/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
   
  <!-- Custom styles for this template -->
  <link href="{{asset('forums/css/agency.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('build/css/intlTelInput.css')}}">


</head>

<body>  
<!-- Navigation -->
<!--<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav" style="padding-top:20px; background-color:white; border:solid 1px lightgreen; font-family: Montserrat,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';" >
    <div class="container">
        <center>
            <h2 style="font-size:25px; color:green; margin-left: auto; margin-right: auto; width: 6em; font-size:20px;" class="logo-title  wow fadeInUp" data-wow-delay="0.8s" > 
                <a href="/">
                  <img src="https://sbpme2023.optievent.xyz/sbpme/logo-salon-9em.png" alt="" style="width:350px;">
                </a>
            </h2>
          </center>                              
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
         
          <li class="nav-item">
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form> 
          </li>
         
        </ul>
      </div>
    </div>
  </nav> -->

  <!-- Header -->

  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('forums/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('forums/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Plugin JavaScript -->
  <script src="{{asset('forums/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Contact form JavaScript -->
  <script src="{{asset('forums/js/jqBootstrapValidation.js')}}"></script>
  <script src="{{asset('forums/js/contact_me.js')}}"></script>

  <!-- Custom scripts for this template -->
  <script src="{{asset('forums/js/agency.min.js')}}"></script>

</body>

</html>
