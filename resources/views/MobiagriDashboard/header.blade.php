  <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item mt-2 mb-2 ml-2 mr-auto" style=" position: absolute; left :100px;">
                  <h5 class="text-primary">Tableau de bord
                  @if (Auth::user()->nom_role == 'admin')
                    | {{Auth::user()->nom}}
                  @elseif (Auth::user()->nom_role == 'helpdesk')
                    | {{Auth::user()->nom_role}}
                  @elseif(Auth::user()->nom_role == 'ca')
                    | CA
                  @else
                    | Zone : {{Auth::user()->nom_role}}
                  @endif
                  {{-- @if(Auth::user()->nom_role == 'ZORGHO') | Zone: ZORGHO 
                  @elseif(Auth::user()->nom_role == 'TENKODOGO') | Zone: TENKODOGO
                  @elseif(Auth::user()->nom_role == 'MANGA') | Zone: MANGA
                  @elseif(Auth::user()->nom_role == 'PO') | Zone: PO
                  @elseif(Auth::user()->nom_role == 'KOMBISSIRI') | Zone: KOMBISSIRI
                  @else | DG
                  @endif --}}
                  </h5>
                </li>
               <!-- <li class="nav-item  mt-2 mb-2 ml-2 mr-2 ">
                    <h5  class="text-primary"><br>Chef de Zone</h5>
                    <h6 class="text-secondary">Z1 : MANGA </h6>
                </li>-->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/farmer.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{asset('MobiagriDashboard/assets/img/icons/unicons/farmer.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{Auth::user()->prenom}}</span>
                            <small class="text-muted">{{Auth::user()->nom}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                   <!-- <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Mon Profil</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Paramêtres</span>
                      </a>
                    </li>-->
                   <!-- <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li>-->
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                       <a class="dropdown-item"  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <b style="font-size:13px;">Déconnexion</b>
                             </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form> 
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->