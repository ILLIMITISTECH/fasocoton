<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>OptiEvent | Processus d'inscription</title>
		<meta name="description" content="Rider admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="keywords" content="Rider, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="" />
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
                <div class="col-5 left-part">
                   

					<div class="step-header text-left">
						<h3>Hello {{Auth::user()->prenom}} </h3>
						
					</div>
					 <div class="details-participant-box">
					
						<div class="mb-10">
							<h4>{{ __('Are you interested in business networking?') }}</h4>
					
							<div class="row">
						    	<div class="col-6" >
									<form action="/userparticipants" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-violet px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
											<h4 class="fs-3 fw-bolder">{{ __('Yes') }}Oui</h4>
											<p class="fs-7">{{ __('I am interested') }} </p>
											
										</span>
									</button>
									</form>
								</div>
								<div class="col-6">
								<form action="/userparticipants" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-orange px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
											<h4 class="fs-3 fw-bolder">{{ __('No') }}</h4>
											<p class="fs-7">{{ __('I am not interested!') }}</p>
											
										</span>
									</a>
								</div>
							
							</div>
							
							
      
                        </div>
						
</div>
                </div>
                <div class="col-7 right-part">
                    <div class="adspace-head mt-5">
                        <div class="text-center">
                            <img  class ="logo-client" src="{{asset('User/assets/media/sicot-white.png')}}" alt="">
                        </div>
                        <div class="adspace-body">
                            <img class ="publicite" src="{{asset('User/assets/media/sicot-pub-1.png')}}" alt="pub">
                              <!--<img class ="publicite" src="{{asset('User/assets/media/sicot-pub-2.png')}}" alt="">
                            <img class ="publicite" src="{{asset('User/assets/media/sicot-pub-3.png')}}" alt="">-->
                        </div>
                         <div class="adspace-footer">
                            <div class="row">
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/sofitex.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/afp.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/filsah.png')}}" alt="pub"></div>
                            </div>
                             <div class="row">
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/cci.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/Abi.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/apex.png')}}" alt="pub"></div>
                            </div>
                              <div class="row">
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/sofitex.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/afp.png')}}" alt="pub"></div>
                                 <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/filsah.png')}}" alt="pub"></div>
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
	</body>
	<!--end::Body-->
</html>