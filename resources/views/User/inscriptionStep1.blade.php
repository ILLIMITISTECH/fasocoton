
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
									<li class="active">{{ __('Participant details') }}</li>
									<li>{{ __('Company details') }}</li>
									<li>{{ __('Interests') }}</li>
									<!--<li>Finaliser l'inscription<br></li>-->
								</ul>
							</div>
                        </div>
                    </div>

					<div class="step-header text-left">
						<h3>Hello {{Auth::user()->prenom}}</h3>
						<p>{{ __("Welcome to the Salon of Banques and PME the l'UEMOA") }}</p>
						<p>{{ __('To better configure your profile, preferences and interests, we would like to know more about you!') }}
						</p>
					</div>
			
					 <div class="details-participant-box">
					     <h2>{{ __('Which participation mode do you prefer ?') }}</h2>
					     <?php 	$participants = DB::table('participants')->where('user_id', Auth::user()->id)->paginate(1);
							?>
							@foreach($participants as $participant)
						
									<br><br>
							<div class="row">
								<div class="col-6">
								<form action="{{route('presence.participant', $participant->id)}}" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-violet px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
    										
    											<p class="fs-7">{{ __('Presential') }} </p>
    										</span>
                                        </button>
									</form>								</div>
								<div class="col-6">
									<form action="{{route('presence.participantnon', $participant->id)}}" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-orange px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
    								
    									<p class="fs-7">{{ __('Online') }} </p>
    										</span>
									</button>
									</form>
								</div>
						
						    @endforeach

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
	</body>
	<!--end::Body-->
</html>