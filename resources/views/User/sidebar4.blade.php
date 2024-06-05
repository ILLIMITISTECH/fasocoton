					<?php $event = DB::table('events')->where('status', '=', 1)->first() ?>
					
					@if($event->phase == 1)
					<div class="aside-menu flex-column-fluid px-3 px-lg-6">
						<!--begin::Aside Menu-->
						<!--begin::Menu-->
						<div class="menu menu-column menu-pill menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-arrow-gray-500 menu-active-bg-primary fw-bold fs-5 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
							<div class="hover-scroll-y me-n3 pe-3" id="kt_aside_menu_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="20px">
								<div class="menu-item mb-1">
									<a class="menu-link active" href="/homepreinscrits">
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
										<span class="menu-title">Tableau de Bord</span>
									</a>
								</div>
						
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
								    <a href="/monprofil4"  aria-controls="mon_profil">
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
										
										<span class="menu-title">Mon Profil</span>  
											
									</span>
									</a>
								
								</div>
                                	<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">

                                    	<a href="#"  aria-controls="mon_profil" data-toggle="tooltip" data-placement="top" title="Votre badge sera bientot disponible !">
        									<span class="menu-link"  style="color:#D0D0D0">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title" style="color:#D0D0D0">Mon badge</span> 
    										</span>
										</a>
								</div>
								
								
									<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
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
					@elseif($event->phase == 2)
					<div class="aside-menu flex-column-fluid px-3 px-lg-6">
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
										<span class="menu-title">Tableau de Bord</span>
									</a>
								</div>
                                
								<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                <a href="/monprofil3"  aria-controls="mon_profil">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg
											
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
											
											end::Svg Icon
										</span>
										<span class="menu-title">Mon Profil</span>  
										
									</span>
							    </a>
								
								</div>-->
                                
								 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="/badge_participant"  aria-controls="mon_profil">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title">QR Code</span> 
    										</span>
										</a>
								</div>	
										<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
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
    										<span class="menu-title">Tableau de Bord</span>
    									</a>
    								</div>
    								<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
    								<a href="/monprofil3"  aria-controls="mon_profil">
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
    										<span class="menu-title">Mon Profil</span>  
    									
    									</span>
    										</a>
    								
    								</div>
                                    
    								 <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="/badge_participant"  aria-controls="mon_profil">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title">QR Code</span> 
    										</span>
										</a>
								</div>	
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
                                <span class="menu-title">Tableau de Bord</span>
                                </a>
                                </div>
                               <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    <a href="/monprofil3"  aria-controls="mon_profil">
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
                                        <span class="menu-title">Mon Profil</span>  
                                    
                                        </span>
                                        </a>
        
                                </div>
                                
                              <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                                    	<a href="/badge_participant"  aria-controls="mon_profil">
        									<span class="menu-link">
        										<span class="menu-icon">
        											<!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
        											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                      </svg>
        											<!--end::Svg Icon-->
        			</span>
        										<span class="menu-title">QR Code</span> 
    										</span>
										</a>
								</div>	
                             	<div class="sidebar-pub">
    									    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
                                                    </div>
                                                     <div class="carousel-item active">
                                                        <img class="pub-image" src="{{asset('User/assets/media/sicot.png')}}">
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

                    @endif