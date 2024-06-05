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
						<a href="/homeInscriptionSansEnt">
							<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-default" style="max-width : 60%"/>
							<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-minimize" style="max-width :  60%"/>
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
               	<div class="aside-menu flex-column-fluid px-3 px-lg-6">
						<!--begin::Aside Menu-->
						<!--begin::Menu-->
						<div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
							<div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
								<div class="menu-item mb-1">
									<a class="menu-link active" href="/homeInscriptionSansEnt">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
														<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('Dashboard') }}</span>
									</a>
								</div>
						
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
								    <a href="/myprofil"  aria-controls="mon_profil">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										
										<span class="menu-title">{{ __('My Profile') }}</span>  
											
									</span>
									</a>
								
								</div>
								
								 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="/monentreprises"  aria-controls="mon_profil">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title">{{ __('My Company') }}</span> 
    										</span>
										</a>
								</div>	
                                	<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">

                                    	<a href="badge_Psansentr"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="Votre badge sera bientot disponible !">
        									<span class="menu-link"  style="color:#D0D0D0">
        										<span class="menu-icon">
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        		                           	</span>
        										<span class="menu-title">{{ __('My Badge') }}</span> 
    										</span>
										</a>
								</div>-->
								
								
									<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sbpme/logo-salon-9em.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sbpme/logo-salon-9em.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sbpme/logo-salon-9em.png')}}">
                                                    </div>
                                                    
                                                   
                                                  </div>
                                                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="margin-left :-5%">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                  </button>
                                                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="margin-right :15%">
                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden" style="margin-left :80%">Next</span>
                                                  </button>
                                            </div>
						                </div>
							</div>
						</div>
						<!--end::Menu-->
					
					</div>
					<!--end::Aside menu-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
		<?php $event = DB::table('events')->where('status', '=', 1)->first() ?>
		
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
								<a href="/" class="d-lg-none">
									<img alt="Logo" src="assets/media/logos/logo-compact.svg" class="max-h-40px" />
								</a>
								<!--end::Logo-->
							</div>
							<!--end::Logo bar-->
							 @include('User/headUser2')
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
                                                    <span class="text-light">{{ __('The SBPME 2023 registration phase is underway. It will close on October 22, 2023. The organizing committee invites you to complete your profile.') }}
                                                    
                                                </p>
                                                
                                                <br>
                                                 <div class="card-title m-0" >
        									    
											    <a href="/inscriptionstep2visit" class="btn btn-white" style="position :absolute; left :5%; color:black">Completer mon profil</a>
												
											</div>
        										<!--end::Text-->
        									</div>
        									
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
                	            <div class="card-body">
                	               <!-- <div class="adspace-footer">
                	                    <?php $sponsors = DB::table('sponsors')->orderBy('ordre','asc')->get();  ?>
                                            @foreach($sponsors as $sponsor)
                                        <div class="row" style="display:flex;">
                                             <div class="col-4 "><img class ="sponsors" src="{{url('sponsor', $sponsor->logo1)}}" alt="pub"></div>
                                        </div>
                                         
                                     @endforeach
                                       
                                    </div>-->
                	                
                	            </div>
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
                    Partenaire : Salon des Banques et PME de l’UEMOA
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
		
                  </div>
               	</div>
               	
               	
               	
               	
               	
               	
               		
                   	
                
           
            		<!--end::Main-->
            		<!--begin::Drawers-->
            		<!--begin::Activities drawer-->
            	</div>
          
              
                		
        </div>  
        </div>
                		
                		

		<script> 
		    function copyToClipboard(id) {
                document.getElementById(id).select();
                document.execCommand('copy');
                alert('copié ✔️');
            }
        </script>
		<div id="kt_scrolltop" class="scrolltop rounded-circle" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		
		<script src="{{asset('User/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('User/assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('User/assets/js/custom/widgets.js')}}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>