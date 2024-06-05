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
                  <?php if(Auth::user()->nom_role == 'admin'): ?>
                    | <?php echo e(Auth::user()->nom); ?>

                  <?php elseif(Auth::user()->nom_role == 'helpdesk'): ?>
                    | <?php echo e(Auth::user()->nom_role); ?>

                  <?php elseif(Auth::user()->nom_role == 'ca'): ?>
                    | CA
                  <?php else: ?>
                    | Zone : <?php echo e(Auth::user()->nom_role); ?>

                  <?php endif; ?>
                  
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
                      <img src="<?php echo e(asset('MobiagriDashboard/assets/img/icons/unicons/farmer.png')); ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo e(asset('MobiagriDashboard/assets/img/icons/unicons/farmer.png')); ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo e(Auth::user()->prenom); ?></span>
                            <small class="text-muted"><?php echo e(Auth::user()->nom); ?></small>
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
                       <a class="dropdown-item"  href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <b style="font-size:13px;">Déconnexion</b>
                             </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                            </form> 
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar --><?php /**PATH /home/c1735160c/public_html/fasocoton/resources/views/MobiagriDashboard/header.blade.php ENDPATH**/ ?>