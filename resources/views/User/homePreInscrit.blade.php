@include('User/head')
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside bg-white" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
					<!--begin::Brand-->
					<div class="aside-logo flex-column-auto pt-9 pb-7 px-9" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="/home">
							<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-default" style="max-width : 60%"/>
							<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-minimize" style="max-width :  60%"/>
						</a>
	<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
                @include('User/sidebar3')
					<!--end::Aside menu-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
	<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							
							
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder mt-1 mb-1 fs-2">{{ __('Dashboard') }}
								<small class="text-muted fs-6 fw-normal ms-1"></small></h1>
								<!--end::Heading-->
								<!--begin::Breadcrumb-->
								<ul class="breadcrumb fw-bold fs-base mb-1">
									<li class="breadcrumb-item text-muted">
										<a href="/homeinscriptions" class="text-muted text-hover-primary"></a>
									</li>
								</ul>
								<!--end::Breadcrumb-->
							</div>
							
							<!--end::Page title=-->
							<!--begin::Logo bar-->
							<div class="d-flex d-lg-none align-items-center flex-grow-1">
								<!--begin::Aside Toggle-->
								<div class="btn btn-icon btn-circle btn-active-light-primary ms-n2 me-1" id="kt_aside_toggle">
									<!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
									<span class="svg-icon svg-icon-2x">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
												<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
											</g>
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Aside Toggle-->
								<!--begin::Logo-->
								<a href="index.html" class="d-lg-none">
									<img alt="Logo" src="assets/media/logos/logo-compact.svg" class="max-h-40px" />
								</a>
								<!--end::Logo-->
							</div>
							<!--end::Logo bar-->
							 @include('User/headUser')
							<!--begin::Toolbar wrapper-->
                           
      			        <!--end::Header-->
        					<!--begin::Content-->
        					<div class="content d-flex flex-column flex-column-fluid fs-6" id="kt_content">
        						<!--begin::Container-->
        						<div class="container" id="kt_content_container">
        							<!--begin::FAQ-->
        							<div class="card bg-primary">
        								<!--begin::Card body-->
        								<div class="card-body p-lg-20">
        									<!--begin::Intro-->
        									<div class="mb-5">
        										<!--begin::Title-->
        										<h1 class="fs-2x text-light w-bolder mb-6">{{ __('Welcome') }} {{ucfirst(Auth::user()->prenom)}}&nbsp; !</h1>
        										<!--end::Title-->
        										<!--begin::Text-->
        										<p class="fw-bold text-light fs-4 mb-2">
                                                    <span class="text-light"> {{ __('Thank you for registering with SBPME') }}.{{ __('We invite you to complete your profile') }}, {{ __('and to add a company if you are registering as a company and wish to have B2B meetings. to participate if you have not already done so!') }}
                                                </p>
                                                
        
        										<!--end::Text-->
        									</div>
        									<?php $participants = DB::table('participants')->where('user_id', Auth::user()->id)->paginate(1);?>
        									@foreach($participants as $parti)
        									@if($parti)
        									<div class="card-title m-0" >
        									    <form action="{{route('presence.participant', $parti->id)}}" method="post">
                									{{ csrf_field() }}
                									<button type="submit" class="btn btn-white" style="position :absolute; left :5%; color:black">

                    											{{ __('Completer mon profil') }}
                                                        </button>
                									</form>	
											    <!--<a href="{{route('completermonprofil', $parti->id)}}" class="btn btn-white" style="position :absolute; left :5%; color:black">Completer mon profil</a>-->
												
											</div>
											@else
											<div class="card-title m-0" >
											   <form action="{{route('presence.participant', $parti->id)}}" method="post">
                									{{ csrf_field() }}
                									<button type="submit" class="btn btn-white" style="position :absolute; left :5%; color:black">

                    											{{ __('Completer mon profil') }}
                                                        </button>
                									</form>	
												
											</div>
											@endif
											
											<!--	<div class="card-title m-0" >
											    <a href="{{route('inscriptionStep2')}}" class="btn btn-white" style="position :absolute; left :25%; color:black">{{ __('Add a company') }}</a>
											    
												
										     	</div>-->
										    @endforeach
        								</div>
        								<!--end::Card body-->
        							</div>
        							<!--end::FAQ-->
        						</div>
        						   	<div class="row">
                	    <div class="container mt-10">
                	        <div class="card">
                	            <div class="card-header">
                	                <h3 class="text-center"> {{ __('Partners area') }}</h3>
                	            </div>
                	            <!--<div class="card-body">
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
                	                
                	            </div>-->
                	        </div>
                	        
                	    </div>
            	`</div>    	
                   	
                   	
                   	
                   	
                    	          <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                    <!--begin::Copyright-->
                     <div class="text-dark order-2 order-md-1">
                    <span class="text-gray-400 fw-bold me-1">Made With Love By </span>
                    <a href="https://illimitis.com/" target="_blank" class="text-muted text-hover-primary fw-bold me-2 fs-6">ILLIMITIS</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Menu-->
                    <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
                    <li class="menu-item">
                    Partenaire : SALON DES BANQUES ET DES PME DE L'UEMOA
                    </li>
                    
                    </ul>
                    <!--end::Menu-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
        						<!--end::Container-->
                                <!--begin::Container-->
        						<div class="container mt-10" id="kt_content_container">
        							<!--begin::FAQ-->
        							<div class="card">
        							
        							</div>
        							<!--end::FAQ-->
        						</div>
        						<!--end::Container-->
                             </div>
        				</div>
        				</div>
				</div>