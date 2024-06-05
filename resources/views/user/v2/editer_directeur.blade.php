<!doctype html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="short icon" href="{{asset('collov2/assets/images/icon.png')}}">
    <title>Collaboratis | Profil </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
<link href="{{asset('v2/main.css')}}" rel="stylesheet">
<link href="your-project-dir/icon-font/lineicons.css" rel="stylesheet">




</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <!--header -->
            @include('v2.header_dg')
            <!-- end header -->

        <div class="app-main">
                <!-- side bar -->
                @include('v2.side_bar_dg')
      
                <!-- end side bar -->
                
                       <!-- perfo -->

                       <!-- end perfo --> 
                    
                        <!-- perfo de mes direc -->
                       

                         <!-- end perfo de mes direct -->
                        
                        <!-- section -->

                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="container">
                              <div class="row gutters-sm">
                                <div class="col-md-4 d-none d-md-block">
                                  <div class="card">
                                    <div class="card-body">
                                      <nav class="nav flex-column nav-pills nav-gap-y-1">
                                        <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                                          <i class="lni lni-user"></i> Modifier mon profil
                                        </a>
                                       
                                        <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                          <i class="lni lni-shield"></i> Sécurité de mon compte
                                        </a>
                                        
                                        <a href="#photo" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                          <i class="lni lni-camera"></i> Photo de profil
                                        </a>
                                      
                                      </nav>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-8">
                                  <div class="card">
                                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                                      <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                                        <li class="nav-item">
                                          <a href="#profile" data-toggle="tab" class="nav-link has-icon active"></a>
                                        </li>
                                       
                                        <li class="nav-item">
                                          <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                                        </li>
                                         <li class="nav-item">
                                          <a href="#photo" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                                        </li>
                                      
                                      </ul>
                                    </div>
                                    <div class="card-body tab-content">
                                      <div class="tab-pane active" id="profile">
                                        <h6>Mise à jour des informations du profil </h6>
                                        <hr>
                                        
                                        <!-- Info -->
                                        
                                        
                                                            
                                            <div class="tab-pane" id="tab1">
                                                       <form action="{{route('info.valider', $user->id)}}" method="post" id="target" class="form">
                                                            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                                  <fieldset>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Prénom</label>
                                                      <div class="controls">
                                                     
                                                      <input d="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{$user->prenom}}" required autocomplete="prenom" autofocus>
                                                            @error('prenom')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror                                                      </div>                      
                                                    </div>
                                                    <br>
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Nom</label>
                                                      <div class="controls">
                                                      
                                                      <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{$user->nom}}" required autocomplete="nom" autofocus>
                                                      <input id="nom" type="hidden" class="form-control @error('nom') is-invalid @enderror" name="nom_role" value="{{$user->nom_role}}" required autocomplete="nom" autofocus>

                                                        @error('nom')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror                                                        </div>                    
                                                    </div>
                                                    <br>
                                                   
                                                    <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Adresse Email</label>
                                                      <div class="controls">
                                                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror                                                      </div>
                                                      
                                                    </div>
                                                    <br>
                                                
                                                  </fieldset>
                                                  <hr>
                                                
                                            </div>

                                      
                                          <button type="submit"  class="btn btn-primary">Valider</button>
                                         </form>
                                        
                                      </div>
                                      
                                      <!-- End info -->
                                      
                                     <!-- Password --> 
                                      
                                                            
                                      <div class="tab-pane" id="security">
                                          <form action="{{route('passwords.valider', $user->id)}}" method="post" id="target" class="form">
                                                            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                        <h6>Paramètres de sécurité</h6>
                                        <hr>
                                        
                                            
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Nouveau mot de passe : </label>
                                          <div class="controls">
                                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{$user->password}}" required autocomplete="new-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                                                   
                                                </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Confirmer le mot de passe</label>
                                          <div class="controls">
                                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{$user->password}}" autocomplete="new-password">
                                            </div>
                                        </div>
                                     
                                        <p class="infos"> ! Attention au mot de passe que vous choisissez : il est personel et doit être facile à retenir</p>
                                        <hr>
                                        <button type="submit"  class="btn btn-primary">Valider</button>
                                        </form>
                                      </div>
                                      
                                      <!--End Password -->
                                      
                                      <!-- Profil -->
                                      
                                      
                                                            
                                      <div class="tab-pane" id="photo">
                                          
                                          <form action="{{route('image.valider', $user->id)}}" method="post" id="target" class="form" id="demo1-upload" enctype="multipart/form-data">
                                                            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                        <h6>Uploader votre nouvelle photo de profil</h6>
                                        <hr>
                                        
                                                <div class="control-group">
                                                      <label class="control-label" for="focusedInput">Photo de profil</label>
                                                      <div class="controls">
                                                      <input style="padding-bottom : 6%; padding-top : 1%;" id="photo" value="{{ url('images/', $user->photo) }}"  type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
                                                            <img src="{{ url('images/', $user->photo) }}" width="150">
                                                            @error('photo')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror                                                   
                                                            </div>
                                                            
                                                            <p class="infos"> Veuillez uploader une photo de profil d'un format carré "Ex: 500x500px" </p>
                                                    </div>
                                      
                                        <hr>
                                        
                                         <button type="submit"  class="btn btn-primary">Valider</button>
                                     </form>
                                     
                                      </div>
                                    <!-- End Profil -->  
                                      
                                 
                                    </div>
                                  </div>
                                </div>
                              </div>
                        
                            </div>
                        
                    </div>
                </div>
                    
                        <!-- end section -->

                <div class="app-wrapper-footer">
                                <div class="app-footer">
                                    <div class="app-footer__inner">
                                        <div class="app-footer-left">
                                            <ul class="nav">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>    
                    
                </div>
                <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
                <!-- choose one -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

        </div>
    </div>
<style>

body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}

.infos{
    margin-top : 2%;
    color : blue;
    font-weight : bold;
}

/*.nav-link {*/
/*    color: #4a5568;*/
/*}*/
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}

    
</style>




<script src="{{asset('v2/main.js')}}"></script>


<script>

jQuery(document).ready(function() {   
   FormValidation.init();
});


    $(function() {
        $(".datepicker").datepicker();
        $(".uniform_on").uniform();
        $(".chzn-select").chosen();
        $('.textarea').wysihtml5();

        $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('.bar').css({width:$percent+'%'});
            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }
        }});
        $('#rootwizard .finish').click(function() {
            alert('Finished!, Starting over!');
            $('#rootwizard').find("a[href*='tab1']").trigger('click');
        });
    });
    </script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
    
    $(function () {
   $( "#pourcent" ).change(function() {
      var max = parseInt($(this).attr('max'));
      var min = parseInt($(this).attr('min'));
      if ($(this).val() > max)
      {
          alert('Ne peut pas dépasser 100');
          //$(this).val(max);
      }
      else if ($(this).val() < min)
      {
        alert('Ne peut pas avoir une valeur negative');
          //$(this).val(min);
      }       
    }); 
});
    </script>
</body>
</html>
