  							<div class="d-flex align-items-stretch flex-shrink-0">
        								<!--begin::Search-->
        								<div class="d-flex align-items-stretch ms-1 ms-lg-3">
        									<!--begin::Search-->
        									<div id="kt_header_search" class="d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
        										
        										<!--begin::Menu-->
        										<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
        											<!--begin::Wrapper-->
        											<div data-kt-search-element="wrapper">
        												
        												<!--begin::Separator-->
        												<div class="separator border-gray-200 mb-6"></div>
        												<!--end::Separator-->
        												<!--begin::Recently viewed-->
        												
        												<!--end::Recently viewed-->
        												<!--begin::Recently viewed-->
        										
        												<!--end::Recently viewed-->
        												<!--begin::Empty-->
        											
        												<!--end::Empty-->
        											</div>
        											<!--end::Wrapper-->
        											
        										</div>
        										<!--end::Menu-->
        									</div>
        									<!--end::Search-->
        								</div>
        								<!--end::Search-->
        								<!--begin::Activities-->
        							
        								<!--begin::User-->
        								<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
        									<!--begin::Menu wrapper-->
        									<div class="cursor-pointer symbol symbol-circle symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
													 @if(Auth::user()->photo)
													<img alt="Pic" src="{{url('image', Auth::user()->photo)}}" />
													@else
													<img alt="Pic" src="{{url('image', 'placeholder.png')}}" />
													@endif
        									</div>
        									<!--begin::Menu-->
        									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
        										<!--begin::Menu item-->
        										<div class="menu-item px-3">
        											<div class="menu-content d-flex align-items-center px-3">
        												<!--begin::Avatar-->
        											
        												<!--begin::Username-->
        												<div class="d-flex flex-column">
        													<div class="fw-bolder d-flex align-items-center fs-5">{{Auth::user()->prenom}} {{Auth::user()->nom}}
        													
                                                            </div>
        													<a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{Auth::user()->email}}</a>
        												</div>
        												<!--end::Username-->
        											</div>
        										</div>
        										<!--end::Menu item-->
        										<!--begin::Menu separator-->
        										<div class="separator my-2"></div>
        										<!--end::Menu separator-->
        										<!--begin::Menu item-->
        									
        										<!--end::Menu item-->
                                                <!--begin::Menu item-->
        										
        										<!--end::Menu item-->
        										<!--begin::Menu item-->
        										
        										<!--end::Menu item-->
        									
        									
        									
        										<!--begin::Menu separator-->
        										<div class="separator my-2"></div>
        										<!--end::Menu separator-->
        										
        										<!--begin::Menu item-->
        										<!--<div class="menu-item px-5 my-1">-->
        										<!--	<a href="#" class="menu-link px-5">Paramètres du compte-->
                  <!--                                  </a>-->
        										<!--</div>-->
        										<!--end::Menu item-->
        										<!--begin::Menu item-->
        										<div class="menu-item px-5">
        											<a href="{{ url('/logout') }}" class="nav-link"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Déconnexion
                                                    </a>
                                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    </form>
        										</div>
        										<!--end::Menu item-->
        									</div>
        									<!--end::Menu-->
        									<!--end::Menu wrapper-->
        								</div>
        								<!--end::User -->
        							</div>
        							
        							<!--end::Toolbar wrapper-->
        						</div>
        						<!--end::Container-->
      </div>
        		