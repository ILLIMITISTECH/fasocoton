<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>OptiEvent| Inscription</title>
		<meta name="description" content="Organiser un évènement n'aura jamais été aussi simple !" />
		<meta name="keywords" content="" />
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('User/assets/media/optieventFavIcon.png')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('User/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
			     @include('User/sideInscription')
                <div class="col-6 left-part">
                    <div class="form-head mt-3">
                        <div class="text-center">
                            <img  class ="logo-optievent" src="{{asset('User/assets/media/logos/logo_optievent_v0.png')}}" alt="">
                        </div>
                    </div>
                    <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <div class="form-part" style ="margin-top : -5%;">
                       <form action="{{route('inscription.SansEnt')}}" method=post>
                       {{ csrf_field() }}
                        <div class="mb-7">
                            <label for="exampleFormControlInput1" class="required form-label">{{ __('First name') }}: </label>
                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" placeholder="Entrer le prenom"/>
                        </div>
                        <div class="mb-7">
                            <label for="exampleFormControlInput1" class="required form-label">{{ __('Last name') }}: </label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" placeholder="Entrer le nom"/>
                            
                        <input type="hidden" class="form-control @error('presence') is-invalid @enderror" name="presence" value="2" autocomplete="presence" placeholder="Entrer le nom"/>
                        </div>
                        <div class="mb-7">
                            <label for="exampleFormControlInput1" class="required form-label">{{ __('Email') }}: </label>
                            <!--<input type="email" name="email" class="form-control" placeholder="Entrer l'adresse mail"/>-->
                            <input id="email-confirm" placeholder="Entrer l'adresse mail"/ type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            <h6 style="margin-top: 5px;"> 
                                @if (session('messages'))
                                <div class="alert alert-danger" role="alert">
                                {{ session('messages') }}
                                </div>  
                                @endif
                            </h6>
                            
                        </div>
                        
                        <div class="mb-7">
                            <label for="exampleFormControlInput1" class="required form-label">{{ __('Email Address Confirmation') }}:</label>
                            <!--<input type="email" name="email" class="form-control" placeholder="Entrer l'adresse mail"/>-->
                            <input id="email-confirm" placeholder="Entrer l'adresse mail"/ type="email" class="form-control @error('email_confirmation') is-invalid @enderror" name="email_confirmation" value="{{ old('email_confirmation') }}" required autocomplete="new-email">

                                @error('email_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                            <h6 style="margin-top: 5px;"> 
                                @if (session('messages'))
                                <div class="alert alert-danger" role="alert">
                                {{ session('messages') }}
                                </div>  
                                @endif
                            </h6>
                            
                        </div>
                        <div class="mb-7">
                            <label for="pays" class="required form-label">{{ __('Country') }}: </label>
                            <select class="form-select" name="pays_id" id="stade_entreprise" required>
                                        @foreach($pays as $pay)  
                                        <option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>
                                        @endforeach
                                </select> 
                        </div>
                        <div class="mb-7">
                            <label for="pays" class="required form-label">{{ __('Language') }} :</label>
                            <select class="form-select" name="langue_id" aria-label="Select example" required>
                                <option value="">selectionner</option>
                                        @foreach($langue as $langues)  
                                        <option value="{{$langues->id}}">{{$langues->libelle_eng}}</option>
                                        @endforeach
                            </select>
                        </div>
                        <!--<input type="hidden" name="password" class="form-control" value="123456" placeholder="Mot de passe"/>-->
                        <div class="mb-7">
                            <label for="exampleFormControlInput1" class="form-label">{{ __('Phone') }} : </label>
                            <input type="tel" id="portable" class="form-control @error('portable') is-invalid @enderror" name="portable" value="{{ old('portable') }}"  autocomplete="portable" placeholder="+xxxxxxx"/>
                        </div>
                        <div class="alert alert-info" style="display: none"></div>
                       <div class="alert alert-error" style="display: none"></div
                        <hr>
                        
                     <div class="col-md-7" hidden>
                                    <label for="inputState" class="form-label required">{{ __('Do you want to book your accommodation?') }} </label>
                                    <select name="hebergement" class="form-select" id="stade_entreprise" >
                                        <option value="">séléctionner</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                                 <div class="col-md-5" hidden>
                                    <label for="inputState" class="form-label required">{{ __('Would you like to have a visa?') }}</label>
                                    <select name="visa" class="form-select" id="stade_entreprise" >
                                        <option value="">séléctionner</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>  
                                
                                <hr>
                         
                           
                                <div class="col-md-12" hidden>
                                    <label for="inputState" class="form-label required">{{ __('Are you interested in a special accompaniment kit containing welcome, transportation and accommodation in Ouagadougou and Koudougou?') }} </label>
                                    <select name="kit" class="form-select" id="" >
                                        <option value="">séléctionner</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                                <br>
                                
                                   <div class="col-md-12" hidden>
                                    <label for="inputState" class="form-label required">{{ __('Are you interested in a stand?') }}</label>
                                    <select name="stand" class="form-select" id="" >
                                        <option value="">séléctionner</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                             
                        <br>
                        <br>
                        <button type="submit" class="btn btn-violet">{{ __('I sign up') }}</button>
                       </form>
                       <div class="text-center">
                        Vous avez déja un compte ? <a class="orange-link" href="/">{{ __('Connect now!') }}</a>
                        </div>
                    </div>        
                </div>
                  
                </div>
			</div>
		</div>
		

		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
		   
		    <script>
            const phoneInputField = document.querySelector("#portable");
            const phoneInput = window.intlTelInput(phoneInputField, {
              utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
        
            const info = document.querySelector(".alert-info");
            const error = document.querySelector(".alert-error");
        
            function process(event) {
              event.preventDefault();
        
              const phoneNumber = phoneInput.getNumber();
        
              if(info.style.display = ""){
              info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
              }
              else
              {
                 
              }
            }
          </script>
	</body>
	<!--end::Body-->
</html>