<!Doctype Html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OptiEvent | Organiser un évènement n'a jamais été aussi simple !</title>
    <meta name="description" content="SICOT 2020">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{asset('template_admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('template_admin/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('template_admin/css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
   
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('template_admin/css/templatemo-style.css')}}">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <style>
        body {
         font-family: 'Nunito', sans-serif;
        }
        
        a:hover {
            color: #4b2e99;  
        }
        
        input{
            color:white;
        }
        
         input:focus{
            color:white;
        }
        
        .form-control{
            color:white;
        }
        
        .main {
          margin-left: 160px; /* Same as the width of the sidenav */
          font-size: 28px; /* Increased text to enable scrolling */
          padding: 0px 10px;
        }
        
        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 15px;}
          .sidenav a {font-size: 18px;}
        }
    </style>
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
    
    <!-- PRE LOADER -->
    <section class="preloader">
      <div class="spinner">
           <span class="spinner-rotate"></span>
      </div>
    </section>
    
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>
                    <a style="padding-bottom:74px" href="#" class="navbar-brand"><img src="{{asset('User/assets/media/logos/logo_optievent_v0.png')}}" width="125" height="67" alt="Logo OPTIEVENT v0"></a>
               </div>

              
          </div>
     </section>
     
      <h6> 
        @if (session('messages'))
            <div class="alert alert-success" role="alert">
                {{ session('messages') }}
            </div>   
        @endif
      </h6>
       
      <h6> 
        @if ($status = Session::get('status'))
            <div class="alert alert-success" role="alert">
                {{ $status }}
            </div>   
        @endif
      </h6>
      
    <div class="col-sm-offset-3 col-sm-12">
        
        <div class="entry-form" style="width:630px;height:600px;padding-top:110px; margin-top:50px;">
           <h2><b>Connexion / Login</b></h2>
           <!--<center>-->
           <!--    <div class="card-header" style="color:black;"><b style="font-size:18px;">Connectez vous si vous disposez deja d'un compte SICOT, sinon créer votre nouveau compte <br>-->
           <!--    <span style="color:brown;">Log in if you already have a SICOT account, otherwise create your new account</span></b></div>-->
           <!-- </center>-->   
            <div class="card-body" style="">
                
                <form method="post" action="{{route('SaveConnexion')}}">
                    @csrf

                   <!-- <div class ="credentials">
                        <ul>
                            <li class ="cred"> <i class="fas fa-user"></i>  nom d'utilisateur :  admin@gmail.com </li>
                            <li class ="cred"><i class="fas fa-lock"></i>  Mot de passe : admin123</li>
                        </ul>
                     </div> -->

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="email" type="email"  placeholder="Votre Adresse Email / Your email address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Votre mot de passe / Your password" class="form-control @error('password') is-invalid @enderror" name="password" >
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 offset-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>   <span style="color:white; width:50px;">Remember Me / Se souvenir de moi</spanr>
                                </label>
                            </div>
                            <button type="submit" class="submit-btn form-control" style="font-size:13px; background-color:#f49800; width:180px; color:white;">
                                Me connecter / Log-in 
                            </button>
                            
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="color:#419688;">
                                <b style="font-size:13px; text-decoration:underline;color:white">Mot de passe oublié / Forgot  Password</b> 
                            </a>
                           <!-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size:13px; color:white;">
                            Forgot Your Password? / Mot de passe oublié?
                            </a>
                            @endif-->
                            <a class="btn btn-link" href="/choice" style="color:#419688;">
                                <b style="font-size:13px; text-decoration:underline;color:white">Inscrivez-vous maintenant / Sign-in</b> 
                            </a>
<br>
<!--<b style="font-size:13px; color:black"> Vous n'avez pas de compte ?</b>-->
<!--<a  class="orange-link" href="/inscriptions">-->
<!--    <b style="font-size:16px; text-decoration:underline;color:white">Inscrivez-vous maintenant !</b></a>-->
                            <!-- <a class="btn btn-link" href="/ajouter_inviter" style="color:#419688;">-->
                            <!--    <b style="font-size:13px; text-decoration:underline;color:white">Créer mon compte en tant qu'inviter / <br> Create my account as a invitee</b> -->
                            <!--</a> -->
                        </div>
                    </div>   
                </form>
            </div>
        </div>
    </div>

<style>


    .cred {
        text-align : left;
        color : white; 
        text-decoration : none;
    }

</style>
           

 <!-- SCRIPTS -->
     <script src="{{asset('template_admin/js/jquery.js')}}"></script>
     <script src="{{asset('template_admin/js/bootstrap.min.js')}}"></script>
     <script src="{{asset('template_admin/js/owl.carousel.min.js')}}"></script>
     <script src="{{asset('template_admin/js/smoothscroll.js')}}"></script>
     <script src="{{asset('template_admin/js/custom.js')}}"></script>
     
</body>

