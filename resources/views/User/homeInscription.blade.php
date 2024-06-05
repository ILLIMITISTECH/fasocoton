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
                @include('User/sidebar')
					<!--end::Aside menu-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
		<?php $event = DB::table('events')->where('status', '=', 1)->first() ?>
			@if($event->phase == 1)
        		<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							
							
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder mt-1 mb-1 fs-2">{{ __('Dashboard') }}
									<h3 class="font-weight-normal mb-3 phase-title">
                        <div>
                             <?php 
                                $even = DB::table('events')->where('status', '=', 1)->first();
                                if($even){
                                    
                             ?>
                                    @if($even->phase == 0)
                                    <b style="color:gray" disabled>{{ __('Completed phases') }} &nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:gray" disabled>{{ __('Register in progress') }} <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:gray" disabled>{{ __('Suggestions in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:gray" disabled>{{ __('') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:gray" disabled>{{ __('Planning in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                            <?php 
                                }else {
                                    echo "No even so far ðŸ˜…";
                                }
                            ?>
                        </div>    
                    </h3>
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
							 <h6> 
                        @if (session('alerte'))
                        <div class="alert alert-success" role="alert">
                        {{ session('alerte') }}
                        </div>  
                        @endif
                    </h6>
                    
               
							<!--end::Page title=-->
							<!--begin::Logo bar-->
							<div class="d-flex d-lg-none align-items-center flex-grow-1">
								<!--begin::Aside Toggle-->
					     <!--========================= Menu Hamburger   =========================-->
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
								
					 <!--========================= Menu Hamburger   =========================-->
								<!--end::Aside Toggle-->
								<!--begin::Logo-->
								<a href="index.html" class="d-lg-none">
									<img alt="Logo" src="assets/media/logos/logo-optievent.png" style="max-width : 60%"/>
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
                                                    <span class="text-light">{{ __('The SBPME 2023 registration phase is underway. It will close on October 22, 2023. The organizing committee invites you to complete your profile.') }} </span>. 
                                                   
                                                </p>
                                                
        
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
                	                <h3 class="text-center">{{ __('Partners area') }}</h3>
                	            </div>
                	            <div class="card-body">
            	                    <div class="adspace-footer">
                                        <div class="row" style="display:flex;">
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/apbef.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/beceao.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/fagace.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/uemoa.jpeg')}}" alt="pub"></div>
                                           <!-- <?php $sponsors = DB::table('sponsors')->orderBy('ordre','asc')->get();  ?>
                                            @foreach($sponsors as $sponsor)
                                                 <div class="col-4 "><img class ="sponsors" src="{{url('sponsor', $sponsor->logo1)}}" alt="pub"></div>
                                             @endforeach-->
                                            <!-- <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/afp.png')}}" alt="pub"></div>
                                             <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/filsah.png')}}" alt="pub"></div>-->
                                        </div>
                                    </div>
                	                
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
			@elseif($event->phase == 2)
    			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    				<!--begin::Header-->
        				<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        					<!--begin::Container-->
        					<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
        						<!--begin::Page title-->
        						<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
        							<!--begin::Heading-->
        							<h1 class="text-dark fw-bolder mt-1 mb-1 fs-2">{{ __('Dashboard') }}
        			<h3 class="font-weight-normal mb-3 phase-title">
                        <div>
                             <?php 
                                $even = DB::table('events')->where('status', '=', 1)->first();
                                if($even){
                                    
                             ?>
                                    @if($even->phase == 0)
                                    <b style="color:gray" disabled>{{ __('Completed phases') }} &nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:gray" disabled>{{ __('Register in progress') }} <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:gray" disabled>{{ __('Suggestions in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:gray" disabled>{{ __('') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:gray" disabled>{{ __('Planning in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                            <?php 
                                }else {
                                    echo "No even so far ðŸ˜…";
                                }
                            ?>
                        </div>    
                    </h3>
        							<small class="text-muted fs-6 fw-normal ms-1"></small></h1>
        							<!--end::Heading-->
        							<!--begin::Breadcrumb-->
        							<ul class="breadcrumb fw-bold fs-base mb-1">
        								<li class="breadcrumb-item text-muted">
        									<a href="index.html" class="text-muted text-hover-primary"></a>
        								</li>
        							</ul>
        							<!--end::Breadcrumb-->
        						</div>
        						<!--end::Page title=-->
        						<!--begin::Logo bar-->
        						 @include('User/headUser')
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
                    									<h1 class="fs-2x text-light w-bolder tex-light mb-6">{{ __('Welcome') }} {{ucfirst(Auth::user()->prenom)}}&nbsp; !</h1>
                    									<!--end::Title-->
                    									<!--begin::Text-->
                    									<p class="fw-bold text-light fs-4 mb-2">
                                                            {{ __('The phase of') }} <span class="text-light">{{ __('suggesting and adding appointments of') }}</span> {{$event->nom_event_fr}} {{ __('Forum is still in progress') }}.
                                                            <br>{{ __('It will end on October 30th.') }}                                    
                                                         </p>
                                                         <p class="fw-bold  text-light fs-4 mb-2">
                                                            {{ __('The organizing committee invites you to ') }} 
                                                            <ul>
                                                                <li class="fw-bold  text-light fs-4 mb-2">{{ __('Validate appointment suggestions') }}</span> {{ __('that interest you!') }} </li>
                                                                <li class="fw-bold  text-light fs-4 mb-2">{{ __('Browse the catalog of participating companies and add appointment requests') }} </li>
                                                            </ul>
                                                          
                                                         </p>
                                                         
                    
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
                	                    <div class="adspace-footer">
                	                    
                                        <div class="row" style="display:flex;">
                                            <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/apbef.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/beceao.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/fagace.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/uemoa.jpeg')}}" alt="pub"></div>
                                            <?php $sponsors = DB::table('sponsors')->orderBy('ordre','asc')->get();  ?>
                                            <!--@foreach($sponsors as $sponsor)
                                                 <div class="col-4 "><img class ="sponsors" src="{{url('sponsor', $sponsor->logo1)}}" alt="pub"></div>
                                             @endforeach-->
                                            <!-- <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/afp.png')}}" alt="pub"></div>
                                             <div class="col-4"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/filsah.png')}}" alt="pub"></div>-->
                                        </div>
                                         
                                 
                                       
                                    </div>
                	                
                	            </div>
                	        </div>
                	        
                	    </div>
            	`</div> 
            	                        </div>  
                    					<!--end::Container-->
                                        <!--begin::Container-->
                    					
                    					<!--end::Container-->
                                </div>
                                <!--end::Content-->
            			</div>
        			</div>
    			</div>
		        
    			
			@elseif($event->phase == 3)
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        					<!--begin::Header-->
        					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        						<!--begin::Container-->
        						<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
        							<!--begin::Page title-->
        							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
        								<!--begin::Heading-->
        								<h1 class="text-dark fw-bolder mt-1 mb-1 fs-2">{{ __('Dashboard') }}
        									<h3 class="font-weight-normal mb-3 phase-title">
                        <div>
                             <?php 
                                $even = DB::table('events')->where('status', '=', 1)->first();
                                if($even){
                                    
                             ?>
                                    @if($even->phase == 0)
                                    <b style="color:gray" disabled>{{ __('Completed phases') }} &nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:gray" disabled>{{ __('Register in progress') }} <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:gray" disabled>{{ __('Suggestions in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:gray" disabled>{{ __('') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:gray" disabled>{{ __('Planning in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                            <?php 
                                }else {
                                    echo "No even so far ðŸ˜…";
                                }
                            ?>
                        </div>    
                    </h3>
        								<small class="text-muted fs-6 fw-normal ms-1"></small></h1>
        								<!--end::Heading-->
        								<!--begin::Breadcrumb-->
        								<ul class="breadcrumb fw-bold fs-base mb-1">
        									<li class="breadcrumb-item text-muted">
        										<a href="index.html" class="text-muted text-hover-primary"></a>
        									</li>
        								</ul>
        								<!--end::Breadcrumb-->
        							</div>
        							<!--end::Page title=-->
        							<!--begin::Logo bar-->
        						 @include('User/headUser')
        					<!--end::Header-->
        					<!--begin::Content-->
        					<div class="content d-flex flex-column flex-column-fluid fs-6" id="kt_content">
        						<!--begin::Container-->
        						<div class="container" id="kt_content_container">
        							<!--begin::FAQ-->
        							<div class="card bg-primary">
        								<!--begin::Card body-->
        								<div class="card-primary p-lg-20">
        									<!--begin::Intro-->
        									<div class="mb-5">
        										<!--begin::Title-->
        										<h1 class="fs-2x text-light w-bolder mb-6">Bienvenue {{ucfirst(Auth::user()->prenom)}}&nbsp; !</h1>
        										<!--end::Title-->
        										<!--begin::Text-->
        										<p class="fw-bold text-light fs-4 mb-2">
                                                    La phase de <b>confirmation de rendez-vous </b> du {{$event->nom_event_fr}} est toujours en cours.
                                                    <br>Elle prendra fin le <span class="text-light">01 Novembre  </span> .                                    
                                                 </p>
                                                 <p class="fw-bold fs-4 mb-2">
                                                    Le comité d’organisation t’invite à  : 
                                                    <ul>
                                                        <li><span class="text-light">Confirmer les rendez-vous </span> auxquels tu pourras participer</li>
                                                        <li>Parcourir le catalogue des entreprises participantes et ajouter de nouveaux  <span class="text-light">souhaits de rendez-vous</span> </li>
                                                    </ul>
                                                  
                                                 </p>
                                                 
        
        										<!--end::Text-->
        									</div>
        									
        								</div>
        								<!--end::Card body-->
        							</div>
        							<!--end::FAQ-->
        						</div>
        						
        						<!--end::Container-->
        	  	<div class="row">
                	    <div class="container mt-10">
                	        <div class="card">
                	            <div class="card-header">
                	                <!--<h3 class="text-center"> Espace partenaires</h3>-->
                	            </div>
                	            <div class="card-body">
                	                <div class="adspace-footer">
                	                    
                                        <!--<div class="row" style="display:flex;">
                                            <?php $sponsors = DB::table('sponsors')->orderBy('ordre','asc')->get();  ?>
                                            @foreach($sponsors as $sponsor)
                                                 <div class="col-4 "><img class ="sponsors" src="{{url('sponsor', $sponsor->logo1)}}" alt="pub"></div>
                                             @endforeach
                                         
                                        </div>-->
                                         
                                 
                                       
                                    </div>
                	                
                	            </div>
                	        </div>
                	        
                	    </div>
            	`</div>  
        					</div>
        				</div>
        				    </div>
				</div>
    		@elseif($event->phase == 4)
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
                            	<h3 class="font-weight-normal mb-3 phase-title">
                        <div>
                             <?php 
                                $even = DB::table('events')->where('status', '=', 1)->first();
                                if($even){
                                    
                             ?>
                                    @if($even->phase == 0)
                                    <b style="color:gray" disabled>{{ __('Completed phases') }} &nbsp;<i class="fa fa-flag"></i></b>
                                    @elseif($even->phase == 1)
                                    <b style="color:gray" disabled>{{ __('Register in progress') }} <i class="fas fa-cog fa-spin"></i></i></b>
                                    @elseif($even->phase == 2)
                                    <b style="color:gray" disabled>{{ __('Suggestions in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @elseif($even->phase == 3)
                                    <b style="color:gray" disabled>{{ __('') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @else
                                    <b style="color:gray" disabled>{{ __('Planning in progress') }} <i class="fas fa-cog fa-spin"></i></b>
                                    @endif
                            <?php 
                                }else {
                                    echo "No even so far ðŸ˜…";
                                }
                            ?>
                        </div>    
                    </h3>
                            <small class="text-muted fs-6 fw-normal ms-1"></small></h1>
                            <!--end::Heading-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb fw-bold fs-base mb-1">
                            <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary"></a>
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
                        <!--begin::Toolbar wrapper-->
                         @include('User/headUser')
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
                            <h1 class="fs-2x text-light w-bolder mb-6">{{ __('Welcome') }} <span class="text-light">{{ucfirst(Auth::user()->prenom)}}&nbsp;</span>!</h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <p class=" text-light fw-bold fs-4 mb-2">
                                 <?php  $evens = DB::table('events')->get();?>
                                    @foreach($evens as $even)
                                         @if($even->status == 1)
                                        <p class=" fw-bold" style=" color:white">
                                            {{ __('We are in the home stretch before the start of the') }} {{$event->nom_event_fr}} <br>
                                            {{ __('Your') }} <span class=" fw-bold"> {{ __('appointment schedule and your calendar of activities') }} </span> {{ __('are available') }}.<br>
                                            {{ __("Take the time to organize your calendar accordingly so you don't miss any activities or appointments !") }}

                                        </p>
                                       
                                        <p class="tex-light fw-bold" style=" color:white">
                                            {{ __('Have a good time at') }}
                                            {{ $even->nom_event_fr }} !
                                        </p>
                              
                                        @else
                                            <p></p>
                                        @endif
            
                                  @endforeach
                                 </p>
                            <!--end::Text-->
                            </div>
                            
                            </div>
                            <!--end::Card body-->
                            </div>
                            <!--end::FAQ-->
                            </div>
                            <!--end::Container-->
                                                    <!--begin::Container-->
                            
                            <!--end::Container-->
                            
                            <div class="container mt-10" id="kt_content_container">
                            <!--begin::FAQ-->
                            <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="mt-2">{{ __('My Upcoming Appointments') }} </h4>
                                                            </div>
                                                             <!--<?php $ev = DB::table('events')->where('status', '=', 1)->first(); ?>-->
                                                             <!--            @if((count($plannings)) < 5)-->
                                                             <!--               <p>{{ __('Click on the button if you do not have an appointment or if you want to have more appointments') }}</p>-->
                                                                            
                                                                            
                                                                                
                                                             <!--                        <form method="POST" action="{{route('alerter.suggestion_rvs', $ev->id)}}">-->
                                                             <!--                           {{ csrf_field() }}-->
                                                             <!--                               <input class="btn btn-primary" type="submit" id="p1"  value="{{ __('Alert the SBPME team')}}">-->

                                                             <!--                       </form>-->
                                                                                   
                                                                                 
                                                             <!--                @elseif(count($plannings) <= 0)-->
                                                             <!--               <p>{{ __('Click on the button if you do not have an appointment or if you want to have more appointments') }}</p>-->
                                                             <!--                     <td class="options-td">-->
                                                             <!--                           <a  href="#" target ="__blank" class="btn btn-primary">{{ __('Alert the SBPME team')}}</a>-->
                                                             <!--                         <form method="POST" action="{{route('alerter.suggestion_rvs',  $ev->id)}}">-->
                                                             <!--                               {{ csrf_field() }}-->
                                                                                           
                                                             <!--                                   <input type="submit" id="p1" class="btn btn-primary" value="{{ __('Alert the SBPME team')}}"/>-->
                                                                                              
                                                             <!--                           </form>-->
                                                             <!--                       </td>-->
                                                             <!--                       @else-->
                                                             <!--                       <p></p>-->
                                                             <!--                @endif-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                 <a class="btn btn-primary" href="{{ URL::to('/mon_planning/pdf') }}">Télécharger mon planning</a> <br>
                                                                <div class="table-responsive">
                                                                <div class="table-responsive">
                                                                   
                                                                              

                                                                             
                                                                    <table style ="width: 100%;" class="table table-hover table-striped border gy-7 gs-7">
                                                                        <thead>
                                                                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                                <th>{{ __('Person met') }}</th>
                                                                                <th>{{ __('Enterprise') }}</th>
                                                                                <th>{{ __('Room') }}</th>
                                                                                <th>{{ __('Table') }}</th>
                                                                                <th>{{ __('Date') }}</th>
                                                                                <th>{{ __('Hour') }}</th>
                                                                                <th>{{ __('Code') }}</th>
                                                                                <th>{{ __('Options') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                           
                                                                            @foreach($plannings as $planning)
                                                                          
                                                                                <tr>
                                                                                    <?php 
                                                                                     $entreprise = DB::table('entreprises')->where('id', '=', $planning->entreprise_id)->first();
                                                                                     $user = DB::table('users')->where('id', '=', $entreprise->user_id)->first()
                                                                                     ?>
                                
                                                                                    <td>
                                                                                        @if($user)
                                                                                            <a href="#">{{$user->prenom}} {{$user->nom}}</a>  <br>  
                                                                                             <a href="#">Tel : {{$user->portable}}</a> <br> 
                                                                                             <a href="#">Email : {{$user->email}}</a>
                                                                                            </td>
                                                                                        @else
                                                                                            <a href="#">~ ~</a></td>
                                                                                        @endif
                                                                                    
                            
                                                                                    <td><a href="#">{{$entreprise->nom_entreprise}}</a></td>
                                                                                    <?php $cre = DB::table('salles')->where('id', $planning->sale_id)->first(); ?>
                                                                                     <td>{{($cre->libelle) ? $cre->libelle : '--'}}</td>
                                                                                      <td>{{$planning->libelle_t}}</td>
                                                                                    <td>{{$planning->date_rv}}</td>
                                                                                    <td>{{$planning->heure_deb}} - {{$planning->heure_fin}}</td>
                                                                                    
                                                                                    @php $sal = DB::table('salles')->where('id', $planning->sale_id)->first(); @endphp
                                                                                  
                                                                                    
                                                                                    <td>
                                                                                        <input style="width:50px; border:none; background:#F8FAFB; cursor:pointer;" type="text" id="copy_{{$planning->id}}" onclick="copyToClipboard('copy_{{$planning->id}}')" value="{{$planning->password}}">
                                                                                    </td>
                            
                                                                                    
                                                                                    <td data-toggle="tooltip" data-placement="top" title="cliquer pour rejoindre le rendez-vous en ligne" >
                                                                                        <a href="{{$planning->join_url}}" target ="__blank" class="btn btn-violet"  style="color:white;">Rejoindre</a>
                                                                                    </td>
                                                  
                                                                                
                                                                                </tr>
                                                                               
                                                                                 @endforeach
                                                                                 
                                                                                  @foreach($plannings_rvs as $planningrv)
                                                                          
                                                                                <tr>
                                                                                    <?php 
                                                                                     $entreprise = DB::table('entreprises')->where('id', '=', $planningrv->entreprise_id)->first();
                                                                                     $user = DB::table('users')->where('id', '=', $planningrv->user_id)->first()
                                                                                     ?>
                                
                                                                                    <td>
                                                                                        @if($user)
                                                                                            <a href="#">{{$user->prenom}} {{$user->nom}}</a></td>
                                                                                        @else
                                                                                            <a href="#">~ ~</a></td>
                                                                                        @endif
                                                                                    
                            
                                                                                    <td><a href="#">{{$entreprise->nom_entreprise}}</a></td>
                                                                                    <?php $cre = DB::table('salles')->where('id', $planningrv->sale_id)->first() ?>
                                                                                     <td>{{$cre->libelle}}</td>
                                                                                      <td>{{$planningrv->libelle_t}}</td>
                                                                                    <td>{{$planningrv->date_rv}}</td>
                                                                                    <td>{{$planningrv->heure_deb}} - {{$planningrv->heure_fin}}</td>
                                                                                    
                                                                                    
                                                                                    <td>
                                                                                        <input style="width:50px; border:none; background:#F8FAFB; cursor:pointer;" type="text" id="copy_{{$planningrv->id}}" onclick="copyToClipboard('copy_{{$planningrv->id}}')" value="{{$planningrv->password}}">
                                                                                    </td>
                            
                                                                                    
                                                                                        <td data-toggle="tooltip" data-placement="top" title="cliquer pour rejoindre le rendez-vous en ligne" >
                                                                                            <a href="{{$planningrv->join_url}}" target ="__blank" class="btn btn-violet"  style="color:white;">{{__('Join')}}</a>
                                                                                        
                                                                                        </td>
                                         

                                                                                </tr>
                                                                               
                                                                                 @endforeach
                                                                           
                                                                        </tbody>
                                                                    </table>
                                                                         
                                                                          
                                                                </div>
                            </div>
                            <!--end::Card body-->
                            </div>
                            <!--end::FAQ-->
                       <div class="container mt-10" id="kt_content_container">
                            <!--begin::FAQ-->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mt-2">{{ __('My upcoming activities')}} </h4>
                                </div>
                                <!--begin::Card body-->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table style ="width: 100%;" class="table table-hover table-striped border gy-7 gs-7">
                                                <thead>
                                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th>{{ __('Name of activity')}}</th>
                                                        <th>{{ __('Date')}}</th>
                                                        <th>{{ __('Hour')}}</th>
                                                        <th>{{ __('Code')}}</th>
                                                        <th>{{ __('Options')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activites as $activite )
                                                    @php
                                                        $time_start = 36000;
                                                        $timestamp_date = strtotime($activite->date .''. $activite->heure_debut.':00');
                                                        $timestamp_now = strtotime(now());
                                                        $timestamp = $timestamp_date - $timestamp_now;
                                                        
                                                    @endphp
                                                    <tr>
                                                        @if(App::isLocale('en'))
                                                        <td>{{$activite->libelle_en}}</td>
                                                        @else
                                                        <td>{{$activite->libelle}}</td>
                                                        @endif
                                                        <td>{{$activite->date}}</td>
                                                        <td>{{$activite->heure_debut}} - {{$activite->heure_fin}}</td>
                                                        <td><input style="width:50px; border:none; background: #F8FAFB; cursor:pointer;" type="text" id="copy_{{$activite->id}}" onclick="copyToClipboard('copy_{{$activite->id}}')" value="{{$activite->password}}"></td>  
                                                        @if($time_start > $timestamp)
                                                            <td data-toggle="tooltip" data-placement="top" title="{{ __('Join the activity')}}" ><a href="{{$activite->join_url}}" target ="__blank" class="btn btn-violet"  style="color:white;">{{ __('Join')}}</a></td>
                                                        @else
                                                            <td data-toggle="tooltip" data-placement="top" title="{{ __('This activity has not started yet, you can join only after 10 minutes before the start') }}"><a href="#" class="btn btn-default"  style="background:#E8E8ED; color:white;">{{ __('Join')}}</a></td>
                                                        @endif
                                                    </tr>
                                                   @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::FAQ-->
                      </div>
                            </div>
                              	<div class="row">
                	    <div class="container mt-10">
                	        <div class="card">
                	            <div class="card-header">
                	                <h3 class="text-center"> {{__('Partners area')}}</h3>
                	            </div>
                	            <div class="card-body">
                	                <div class="adspace-footer">
                	                    <div class="row" style="display:flex;">
                	                        <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/apbef.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/beceao.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/fagace.jpeg')}}" alt="pub"></div>
                                                     <div class="col-3"><img class ="sponsors" src="{{asset('User/assets/media/logo-sponsors/uemoa.jpeg')}}" alt="pub"></div>
                	                    <!--<?php $sponsors = DB::table('sponsors')->orderBy('ordre','asc')->get();  ?>
                                            @foreach($sponsors as $sponsor)
                                             <div class="col-4 "><img class ="sponsors" src="{{url('sponsor', $sponsor->logo1)}}" alt="pub"></div>
                                            
                                     @endforeach
                                            </div>-->
                                    </div>
                	                
                	            </div>
                	        </div>
                	        
                	    </div>
            	`</div> 
                        </div>
                        <!--end::Content-->
              
                        </div>
                        <!--end::Wrapper-->
                        
                        @endif
                            
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