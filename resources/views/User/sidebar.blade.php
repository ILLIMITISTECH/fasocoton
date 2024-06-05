					<?php $event = DB::table('events')->where('status', '=', 1)->first() ?>
					
					@if($event->phase == 1)
					<div class="aside-menu flex-column-fluid px-3 px-lg-6">
						<!--begin::Aside Menu-->
						<!--begin::Menu-->
						<div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
							<div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
								<div class="menu-item mb-1">
									<a class="menu-link active" href="/home">
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
								    <a href="/monprofils"  aria-controls="mon_profil">
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
								            <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/voirmesparticipants"  aria-controls="participants">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                              </svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('My participants')}}</span>  
									
									</span>
										</a>
								</div>
								         
							   <!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">

                                 	<a href="/qrcode"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="{{ __('Your badge will be available soon !') }}">
        									<span class="menu-link">
        										<span class="menu-icon">
        									
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                       <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                     <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                   </svg>
        											
        			                       </span>
        										<span class="menu-title">{{ __('My Badge') }}</span> 
    									</span>
									</a>
								</div> -->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mesdemandesb2b"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                              </svg>
										</span>
										<span class="menu-title">{{ __('Interests') }}</span>  
									
									</span>
										</a>
								</div>
							<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mademandeb2g"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                              </svg>
										</span>
										<span class="menu-title">{{ __('My B2G appointments') }}</span>  
									
									</span>
										</a>
								</div>-->
									<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/suivi_demandeb2g"  aria-controls="suivi_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                              </svg>
										</span>
										<span class="menu-title">{{ __('B2G status') }}</span>  
									
									</span>
										</a>
								</div>-->
								
								<?php $heber = DB::table('participants')->where('user_id', Auth::user()->id)->first(); ?>
								@if($heber)
								@if($heber->hebergement == 1)
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">

                                    	<!--<a href="/listehotels"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="{{ __('Your Hosting page will be available soon !') }}">
        									<span class="menu-link"  style="color:#D0D0D0">
        										<span class="menu-icon">
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        			                                </span>
        										<span class="menu-title" style="color:#D0D0D0">{{ __('Hosting') }}</span> 
    										</span>
										</a>-->
								</div>
								
								@else
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="#"  aria-controls="mon_profil">
        									
										</a>
								</div>
								@endif
								@else
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="#"  aria-controls="mon_profil">
        									
										</a>
								</div>
								@endif
								
									<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                    
                                                   
                                                  </div>
                                                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="margin-left :-5%">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden">{{ __('Previous') }}</span>
                                                  </button>
                                                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="margin-right :15%">
                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden" style="margin-left :80%">{{ __('Next') }}</span>
                                                  </button>
                                            </div>
						                </div>
							</div>
						</div>
						<!--end::Menu-->
					
					</div>
					@elseif($event->phase == 2)
					<div class="aside-menu flex-column-fluid px-3 px-lg-6">
					    <div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
							<div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
								<div class="menu-item mb-1">
									<a class="menu-link active" href="/home">
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
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
											<span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-dots" viewBox="0 0 16 16">
                                                        <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                    </svg>
										    </span>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('My Appointments') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<div class="menu-sub menu-sub-accordion">
										<div class="menu-item">
											<a class="menu-link" href="/listeSuggestions">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Mes suggestions</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="/demandesFaites">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Mes demandes faites</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="/demandesRecues">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Mes demandes reçues</span>
											</a>
										</div>
									
										<div class="menu-item">
											<a class="menu-link" href="/messuggestions" data-kt-page="pro">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Recapitulatif
											
											</a>
										</div>
									</div>
								</div>
							
								
								
								
								
								
								
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    <a class="" href="/homecatalogues">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16">
                                                    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1
                                                    10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7
                                                    10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5
                                                    1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                                                  </svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('Catalog') }}</span>  
										
									</span>
									</a>
								
								</div>
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                <a href="/monprofils"  aria-controls="mon_profil">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
											
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('My Profile') }}</span>  
										
									</span>
							    </a>
								
								</div>
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/monentreprises"  aria-controls="mon_entreprises">
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
								   <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/voirmesparticipants"  aria-controls="participants">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                              <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                              <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                            </svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('See my participants')}}</span>  
									
									</span>
										</a>
								</div>
								<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->
        <!--                            	<a href="/qrcode"  aria-controls="mon_profil">-->
        <!--									<span class="menu-link">-->
        <!--										<span class="menu-icon">-->
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        <!--											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">-->
        <!--                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>-->
        <!--                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>-->
        <!--                                              </svg>-->
        											<!--end::Svg Icon-->
        <!--			</span>-->
        <!--										<span class="menu-title">QR Code</span> -->
    				<!--						</span>-->
								<!--		</a>-->
								<!--</div>	-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mesdemandesb2b"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                              <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                            </svg>
										</span>
										<span class="menu-title">{{ __('Interests') }}</span>  
									
									</span>
										</a>
								</div>
								 <!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mademandeb2g"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                            										
										</span>
										<span class="menu-title">{{ __('My B2G appointments') }}</span>  
									
									</span>
										</a>
								</div>
									 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/suivi_demandeb2g"  aria-controls="suivi_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
										
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                                          <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                        </svg>
										
										</span>
										<span class="menu-title">{{ __('B2G status') }}</span>  
								
									</span>
										</a>
								</div>-->
								<?php $heber = DB::table('participants')->where('user_id', Auth::user()->id)->first(); ?>
								@if($heber)
								@if($heber->hebergement == 1)
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">

                                    	<a href="/listehotels"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="{{ __('Your Hosting page will be available soon !') }}">
        									<span class="menu-link"  style="color:#D0D0D0">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title" style="color:#D0D0D0">{{ __('Hosting') }}</span> 
    										</span>
										</a>
								</div>
								
								@else
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="#"  aria-controls="mon_profil">
        									
										</a>
								</div>
								@endif
								@else
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="#"  aria-controls="mon_profil">
        									
										</a>
								</div>
								@endif
								
										<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
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
				    @elseif($event->phase == 3)	
				    <div class="aside-menu flex-column-fluid px-3 px-lg-6">
    					<div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
    							<div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
    								<div class="menu-item mb-1">
    									<a class="menu-link active" href="/home">
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
                                        <a class="" href="/confirmations">
    									<span class="menu-link">
    										<span class="menu-icon">
    											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
    											<span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-dots" viewBox="0 0 16 16">
                                                        <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                      </svg>
    											</span>
    											<!--end::Svg Icon-->
    										</span>
    										<span class="menu-title">{{ __('Appointment confirmations') }}</span>  
    										
    									</span>
    									</a>
    								
    								</div>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                        <a class="" href="/homecatalogues">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<span class="svg-icon svg-icon-2">
        												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16">
                                                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                                                          </svg>
        											</span>
        											<!--end::Svg Icon-->
        										</span>
        										<span class="menu-title">{{ __('Catalog') }}</span>  
        										
        									</span>
    									</a>
    								
    								</div>
    							
    								
    								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
    								<a href="/monprofils"  aria-controls="mon_profil">
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
    										<span class="menu-title">{{ __('My Profil') }}</span>  
    									
    									</span>
    										</a>
    								
    								</div>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                        <a href="/monentreprises"  aria-controls="mon_entreprises">
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
    								   <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/voirmesparticipants"  aria-controls="participants">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                              </svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('See my participants')}}</span>  
									
									</span>
										</a>
								</div>
    								<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="/qrcode"  aria-controls="mon_profil">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon
        			</span>
        										<span class="menu-title">QR Code</span> 
    										</span>
										</a>
								</div>	-->
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mesdemandesb2b"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                              <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                              <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                            </svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('Interests') }}</span>  
									
									</span>
										</a>
								</div>
								<!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mademandeb2g"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
										
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                            										
										</span>
										<span class="menu-title">{{ __('My B2G appointments') }}</span>  
									
									</span>
										</a>
								</div>
									 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/suivi_demandeb2g"  aria-controls="suivi_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                                          <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                        </svg>
											
										</span>
										<span class="menu-title">{{ __('B2G status') }}</span>  
									
									</span>
										</a>
								</div>-->
    									<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/adspace-1.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/adspace-1.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/adspace-1.png')}}">
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
					@elseif($event->phase == 4)
					<div class="aside-menu flex-column-fluid px-3 px-lg-6">
                        <!--begin::Aside Menu-->
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
                            <div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
                                <div class="menu-item mb-1">
                                <a class="menu-link active" href="/home">
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
                                    <a href="/monprofils"  aria-controls="mon_profil">
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
                              <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/voirmesparticipants"  aria-controls="participants">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                              <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                              <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                            </svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">{{ __('See my participants')}}</span>  
									
									</span>
										</a>
								</div>
        <!--                      <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->
        <!--                            	<a href="/qrcode"  aria-controls="mon_profil">-->
        <!--									<span class="menu-link">-->
        <!--										<span class="menu-icon">-->
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        <!--											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">-->
        <!--                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>-->
        <!--                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>-->
        <!--                                              </svg>-->
        											<!--end::Svg Icon-->
        <!--			</span>-->
        <!--										<span class="menu-title">QR Code</span> -->
    				<!--						</span>-->
								<!--		</a>-->
								<!--</div>	-->
								<!--	<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->
								<!--	<a href="/mesdemandesb2b"  aria-controls="ma_demandeb2g">-->
								<!--	<span class="menu-link">-->
								<!--		<span class="menu-icon">-->
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
								<!--			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">-->
        <!--                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>-->
        <!--                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>-->
        <!--                                      </svg>-->
											<!--end::Svg Icon-->
								<!--		</span>-->
								<!--		<span class="menu-title">{{ __('My B2B meetings') }}</span>  -->
									
								<!--	</span>-->
								<!--		</a>-->
								<!--</div>-->
								 <!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/suivi_demandeb2g"  aria-controls="suivi_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                                                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                                            </svg>
											
										</span>
										<span class="menu-title">{{ __('B2G status') }}</span>  
									
									</span>
										</a>
								</div>
								 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
									<a href="/mademandeb2g"  aria-controls="ma_demandeb2g">
									<span class="menu-link">
										<span class="menu-icon">
											
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
											
										</span>
										<span class="menu-title">{{ __('My B2G appointments') }}</span>  
									
									</span>
										</a>
								</div>-->
							
								<!-- <?php $heber = DB::table('participants')->where('user_id', Auth::user()->id)->first(); ?> -->
								<!--@if($heber)-->
								<!--@if($heber->hebergement == 1)-->
								<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->

        <!--                            	<a href="/listehotels"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="{{ __('Your Hosting page will be available soon !') }}">-->
        <!--									<span class="menu-link"  style="color:#D0D0D0">-->
        <!--										<span class="menu-icon">-->
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        <!--											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">-->
        <!--                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>-->
        <!--                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>-->
        <!--                                              </svg>-->
        											<!--end::Svg Icon-->
        <!--			</span>-->
        <!--										<span class="menu-title" style="color:#D0D0D0">{{ __('Hosting') }}</span> -->
    				<!--						</span>-->
								<!--		</a>-->
								<!--</div>-->
								
								<!--@else-->
								<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->
        <!--                            	<a href="#"  aria-controls="mon_profil">-->
        									
								<!--		</a>-->
								<!--</div>-->
								<!--@endif-->
								<!--@else-->
								<!--	<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">-->
        <!--                            	<a href="#"  aria-controls="mon_profil">-->
        									
								<!--		</a>-->
								<!--</div>-->
								<!--@endif-->
								
								
                             	<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('sicot/logo.jpeg')}}">
                                                    </div>
                                               
                                                   
                                                  </div>
                                                  
                                                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="margin-left :-5%">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden">{{ __('Previous') }}</span>
                                                  </button>
                                                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="margin-right :15%">
                                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color : black"></span>
                                                    <span class="visually-hidden" style="margin-left :80%">{{ __('Next') }}</span>
                                                  </button>
                                            </div>
						                </div>
						                
                            </div>
                        </div>
                    <!--end::Menu-->
                    </div>

                    @endif