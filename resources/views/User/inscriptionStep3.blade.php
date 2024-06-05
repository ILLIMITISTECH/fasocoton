<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>OptiEvent| Détails participant</title>
		<meta name="description" content="Rider admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="keywords" content="Rider, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('User/assets/media/optieventFavIcon.png')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('User/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
			     @include('User/sideInscription')
                <div class="col-6 left-part">
                    <div class="form-head mt-5">
                        <div class="text-center">
							<div class="progress-container">
								<ul class="progress-progressbar">
                                    <li>{{ __('Participant details') }}</li></a>
									<li>{{ __('Company details') }}</li></a>
									<li class="active">{{ __('Interests') }}</li>
									<!--<li>Finaliser l'inscription<br></li>-->
								</ul>
							</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="step-header text-left">
                            <h4>{{ __('What kind of partners are you looking for?') }} </h4>
                            <p>{{ __('In order to suggest relevant meetings, we need more information about your information about your company and the type of partners you are looking for.') }}
                            
                            </p>
                        </div>

                    </div>
				
					 <div class="details-participant-box">		
                     <?php 
								$entreprises = DB::table('entreprises')->where('user_id', Auth::user()->id)->paginate(1);
							?>
							@foreach($entreprises as $entreprise)				
						<form class="row g-3" action="{{route('secteur.profil', $entreprise->id)}}" method="post">
                            {{ csrf_field() }}
                              <label for="inputState" class="form-label required">{{ __('Sectors of activity sought') }}:</label>
                              <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label "> {{ __('Sector 1') }}:  </label>
                                     <select name="partenaire_rencontrer_a" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                               <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label ">{{ __('Sector 2') }} :  </label>
                                     <select name="partenaire_rencontrer_b" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                               <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label "> {{ __('Sector 3') }} : </label>
                                     <select name="partenaire_rencontrer_c" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                              <br><br><br><br><br><br>
                              <label for="inputState" class="form-label required">{{ __('Company profile sought') }} : </label>
                             <div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label "> {{ __('Profil 1') }} : </label>
                                  <select name="profile_partenaire_rechercher_a" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label "> {{ __('Profil 2') }} :</label>
                                  <select name="profile_partenaire_rechercher_b" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label ">{{ __('Profil 3') }} : </label>
                                  <select name="profile_partenaire_rechercher_c" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              
                              <div class="col-md-12">
                                <label for="inputEmail4" class="form-label required">{{ __('More details on the type of partners sought') }}</label>
                                <textarea class="form-control" name="partenaire_rechercher" id="details-partenaires"rows="3"></textarea> 
                              </div>
                              
                                 <hr>
                              <div class="col-12">
                                <button type="submit" class="btn btn-violet">{{ __('Continue') }} </button>
                                <!--<a href="/inscriptionstep0"><button type="button" class="btn btn-danger">Quitter</button></a>-->
                            </div>
                            @endforeach
                          </form>

                    </div>
                        
                </div>
               
			</div>
		</div>
		

		<!--begin::Javascript-->
        <script type="text/javascript">
            // add row
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group row mb-3">';
                html += ' <div class="col-md-5">';
                html += '<label for="inputEmail4" class="form-label required">Prénom / First Name : </label>';
                html += '<input type="email" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += '<div class="col-md-5">'
                    html += ' <label for="inputEmail4" class="form-label required">Email : </label>';
                    html += '<input type="email" class="form-control" id="inputEmail4">';
                    html += ' </div> ';
   
                    html += ' <div class="col-md-2 pt-7">';            
                        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash"></i> </button>';
                        html += ' </div> ';
                        html += ' </div> ';
                        html += ' </div> ';
        
                $('#newRow').append(html);
            });
        
            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
        </script>

        <script src="assets/js/multi-input-script.js"></script>
        <script src="assets/js/multi-input.js"></script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>