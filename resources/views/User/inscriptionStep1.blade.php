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
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
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
                    <div class="form-head mt-5">
                        <div class="text-center">
							<div class="progress-container">
								<ul class="progress-progressbar">
									<li class="active">Détails participant</li>
									<li>Détails entreprise</li>
									<li>Centres d’intérêts</li>
									<li>Finaliser l'inscription<br></li>
								</ul>
							</div>
                        </div>
                    </div>

					<div class="step-header text-left">
						<h3>Hello {{Auth::user()->prenom}}</h3>
						<p>Nous aimerions en savoir plus sur vous !</p>
					</div>
					 <div class="details-participant-box">
						
						<div class="mb-10">
							Serez vous présent sur place  au Rebarnding Africa Forum ?
							<br><br><br>
							<?php 
								$participants = DB::table('participants')->where('user_id', Auth::user()->id)->paginate(1);
							?>
							@foreach($participants as $participant)
							<form action="{{route('presence.participant', $participant->id)}}" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-6">
									<a href="#" class="btn btn-flex btn-success px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
											<input class="fs-3 fw-bolder" value="1" name="presence" type="radio">Oui
											<p class="fs-7">Je serai présent sur place </p>
										</span>
									</a>
								</div>
								<div class="col-6">
									<a href="#" class="btn btn-flex btn-orange px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
										<input class="fs-3 fw-bolder" value="0" name="presence" type="radio">Non
											
											<p class="fs-7">Je participerai en ligne </p>
										</span>
									</a>
								</div>
							
							</div>
							<div class="mt-5 col-12">
                            <button type="submit" class="btn btn-violet">Continuer </button>
                            <a href="/inscriptionstep0"><button type="button" class="btn btn-danger">Quitter</button></a>
                        </div>
						
						</form>
						@endforeach

                        </div>
						

</div>
                        
                </div>
                <div class="col-7 right-part">
                    <div class="adspace-head mt-5">
                        <div class="text-center">
                            <img  class ="logo-client" src="{{asset('User/assets/media/logos/logo-raf.png')}}" alt="">
                        </div>
                        <div class="adspace-body">
                            <img class ="publicite" src="{{asset('User/assets/media/publicite/image-pub-1.jpeg')}}" alt="pub">
                            <img class ="publicite" src="{{asset('User/assets/media/publicite/image-pub-2.jpeg')}}" alt="">
                            <img class ="publicite" src="{{asset('User/assets/media/publicite/image-pub-3.jpeg')}}" alt="">
                        </div>
                        <div class="adspace-footer">

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