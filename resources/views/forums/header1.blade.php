<!Doctype Html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SBPME 2023</title>
    <meta name="description" content="SBPME 2023">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{asset('template_admin/css/bootstrap.min.css')}}">
    <script src="https://kit.fontawesome.com/2def424b14.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('template_admin/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('template_admin/css/owl.theme.default.min.css')}}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('template_admin/css/templatemo-style.css')}}">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <style>
        body {
         font-family: 'Nunito', sans-serif;
        }
        
        .sidenav {
          height: 100%;
          width: 225px;
          position: fixed;
          z-index: 1;
          top: 25;
          left: 0;
          background-color: white;
          overflow-x: hidden;
          padding-top: 45px;
          -webkit-box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
          -moz-box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
          box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
        }
        
         .paginate_button.active a{
          background-color: #4b2e99;    
        }
        
        .sidenav a {
          padding: 6px 8px 6px 16px;
          text-decoration: none;
          font-size: 13px;
          color: black;
          display: block;
        }
        
        .sidenav a:hover {
          color: white;
          background: #4b2e99;
          padding: 20px;
        }
        
        .main {
          margin-left: 160px; /* Same as the width of the sidenav */
          font-size: 28px; /* Increased text to enable scrolling */
          padding: 0px 10px;
        }
        
        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 13px;}
          .sidenav a {font-size: 15px;}
        }
    </style>
</head>

<body >
    
    <!-- PRE LOADER -->
    <section class="preloader">
      <div class="spinner">
           <span class="spinner-rotate"></span>
      </div>
    </section>
    
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header" style="padding-bottom:20px">
                    
                    @foreach(DB::table('events')->where('status','=', 1)->get() as $event)
                    <!-- lOGO TEXT HERE -->
                     @if(Auth::user()->admin == "Administrateur")
                              <img style="margin-left:-530px;margin-top:10px;" src="{{asset('images/logo_optievent_v0.png')}}" width="102" height="50" alt="Logo OPTIEVENT v0"><a style="margin-left:65px;width:400px" href="/administrateur" class="navbar-brand">{{$event->nom_event}}</a>
                          @else
                              <img  style="margin-left:-530px;margin-top:10px" src="{{asset('images/logo_optievent_v0.png')}}"  width="102" height="50" alt="Logo OPTIEVENT v0"><a style="margin-left:65px;width:400px" href="/messages" class="navbar-brand">{{$event->nom_event}}</a>
                          @endif
                    @endforeach
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse" >
                    <ul class="nav navbar-nav navbar-right" style="font-size:14px;padding-top:3px;">
                        
                        <li class="smoothScroll dropdown show" >
                          <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fa fa-plug"></i> <b style="color:black;">{{Auth::user()->prenom}}</b>
                          </a>
                        
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @if(Auth::user()->admin == "Administrateur")
                             <a class="dropdown-item" target="blank" href="https://demo-script.optievent.com">
                                <b style="font-size:13px;">Scripts</b>
                             </a>
                             @endif
                             
                             <a class="dropdown-item"  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <b style="font-size:13px;">Déconnexion</b>
                             </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form> 
                          </div>
                        </li>
                        
                    </ul>
               </div>
          </div>
     </section>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @if(Auth::user()->admin == "Administrateur")
    <div class="sidenav">
          
        
          <h4 style="color:#4b2e99;padding-top:20px">&nbsp;&nbsp;MENU | ADMIN </h4>
          <br>
         
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-calendar">&nbsp;&nbsp;</i> EVENEMENTS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a style="color:black;" class="dropdown-item" href="/lister_event"><i class="fa fa-map"></i> Voir</a>
              <a style="color:black;" class="dropdown-item" href="/ajouter_event"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
           
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-user">&nbsp;&nbsp;</i> UTILISATEURS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_user"><i class="fa fa-map"></i> Lister</a>
              <!--<a class="dropdown-item" href="/ajouter_user"><i class="fa fa-plus"></i> Ajouter</a>-->
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-tasks">&nbsp;&nbsp;</i> ACTIVITES&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_activite"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_activite"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
          
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-puzzle-piece">&nbsp;&nbsp;</i> SECTEURS D'ACTIVITES&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_sect_activite"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_sect_activite"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-briefcase">&nbsp;&nbsp;</i> ENTREPRISES&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_entreprises"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_entreprises"><i class="fa fa-plus"></i> Ajouter</a>
              
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-users">&nbsp;&nbsp;</i> PARTICIPANTS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_participant"><i class="fa fa-map"></i> Voir tous</a>
              
            </div>
          </li>
          <br>
          
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-phone">&nbsp;&nbsp;</i> CRENEAUX&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_creneau"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_creneau"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-globe">&nbsp;&nbsp;</i> PAYS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
               <a class="dropdown-item" href="/lister_pay"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_pay"><i class="fa fa-plus"></i> Ajouter</a>
              
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-id-card">&nbsp;&nbsp;</i> PROFILS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_profil"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_profil"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
          
          <li class="smoothScroll dropdown show" >
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-sitemap">&nbsp;&nbsp;</i> ORGANISATEURS&nbsp;<i class="fa fa-caret-down"></i>
            </a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="/lister_organisateur"><i class="fa fa-map"></i> Lister</a>
              <a class="dropdown-item" href="/ajouter_organisateur"><i class="fa fa-plus"></i> Ajouter</a>
            </div>
          </li>
          <br>
          
           <li class="smoothScroll show" >
            <a class="dropdown-toggle" href="/plannings" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <a href="/plannings"><i class="fas fa-road"></i>&nbsp;&nbsp;PLANNINGS</a></li>
            </a>
          </li>
          
           <!--<li class="smoothScroll show" >
            <a class="dropdown-toggle" href="/plannings" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <a href="#"><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;MAILING</a></li>
            </a>
          </li>
          
          <li class="smoothScroll show" >
            <a class="dropdown-toggle" href="/plannings" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <a href="#"><i class="fas fa-bug"></i>&nbsp;&nbsp;REPORTING</a></li>
            </a>
          </li>-->
        </li> 
  </div>
  @endif

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

   <!-- SCRIPTS -->
    <script src="{{asset('template_admin/js/jquery.js')}}"></script>
    <script src="{{asset('template_admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('template_admin/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('template_admin/js/smoothscroll.js')}}"></script>
    <script src="{{asset('template_admin/js/custom.js')}}"></script>
</body>

</html>
