<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo mt-2 mb-2">
            <?php if(Auth::user()->nom_role == 'admin'): ?>
            <a href="/dashboard" class="app-brand-link">
            <?php elseif(Auth::user()->nom_role == 'helpdesk'): ?>
                <a href="/helpdesks" class="app-brand-link">
            <?php elseif(Auth::user()->nom_role == 'ca'): ?>
            <a href="/dashboard/ca" class="app-brand-link">
            <?php else: ?>
                <a href="/dashboard/zone" class="app-brand-link">
            <?php endif; ?>
              <span class="app-brand-logo demo">
                <img class ="logo_fasocoton"src="<?php echo e(asset('MobiagriDashboard/assets/img/logo_fasocoton.jpeg')); ?>" alt="">
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2"></span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <?php if(Auth::user()->nom_role == 'admin'): ?>
                <a href="/dashboard" class="menu-link">
              <?php elseif(Auth::user()->nom_role == 'helpdesk'): ?>
                <a href="/helpdesks" class="menu-link">
              <?php elseif(Auth::user()->nom_role == 'ca'): ?>
                <a href="/dashboard/ca" class="menu-link">
              <?php else: ?>
                <a href="/dashboard/zone" class="menu-link">
              <?php endif; ?>
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!--<li class="menu-header small text-uppercase">-->
            <!--  <span class="menu-header-text">Producteurs et Scoops</span>-->
            <!--</li>-->

            <!-- Layouts -->

            <!--<li class="menu-item">-->
            <!--  <a href="/producteurs" class="menu-link">-->
            <!--    <i class="menu-icon tf-icons bx bx-user"></i>-->
            <!--    <div data-i18n="Basic">Producteurs</div>-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li class="menu-item">-->
            <!--  <a href="/scoops" class="menu-link">-->
            <!--    <i class="menu-icon tf-icons bx bx-collection"></i>-->
            <!--    <div data-i18n="Basic">SCOOPS</div>-->
            <!--  </a>-->
            <!--</li>-->

             <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Rapports</span>
            </li>
            
             
            
           <!-- <li class="menu-item">
              <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Basic">Statistique</div>
              </a>
            </li>-->

            <li class="menu-item">
              <a href="<?php echo e(route('prodGrpmt')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Basic">Producteurs et groupements</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="<?php echo e(route('superficies')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-area"></i>
                <div data-i18n="Basic">Superficies</div>
              </a>
            </li>
            
            <li class="menu-item">
              <a href="<?php echo e(route('productionRealisee')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Basic">Production réalisée</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="<?php echo e(route('productionValorisee')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Basic">Production valorisée </div>
              </a>
            </li>
            <!--<li class="menu-item">-->
            <!--  <a href="<?php echo e(route('situationCredit')); ?>" class="menu-link">-->
            <!--    <i class="menu-icon tf-icons bx bx-calculator"></i>-->
            <!--    <div data-i18n="Basic">Situation du crédit</div>-->
            <!--  </a>-->
            <!--</li>-->
            
           <!-- <li class="menu-item">
              <a href="/physionomie" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Basic">Physionomie de la campagne</div>
              </a>
            </li>
            
            <li class="menu-item">
              <a href="/travau_agricoles" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Basic">Travaux agricoles</div>
              </a>
            </li>  -->

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Intrants et Production</span>
            </li>

            <li class="menu-item">
              <a href="/clc" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">CLC</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/cdc" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">CDC</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/besoin_complementaire" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Besoins complémentaires</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/mise_en_place" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Mise en place</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/production" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Production</div>
              </a>
            </li>
          
            <li class="menu-item">
              <a href="/pluviometrie" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Pluviométrie</div>
              </a>
            </li>
            
            <li class="menu-item">
              <a href="/formations" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Formations</div>
              </a>
            </li>
            
                  
              <li class="menu-item">
                <a href="<?php echo e(route('suiviParasitisme')); ?>" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-money"></i>
                  <div data-i18n="Basic">Suivi du parasitisme</div>
                </a>
              </li>
             
             
             <li class="menu-item">
              <a href="http://fasocoton-22-23.optievent.xyz/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Basic">Campagne : 22-23</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->
        
     <?php /**PATH /home/c1735160c/public_html/fasocoton/resources/views/MobiagriDashboard/sidebar.blade.php ENDPATH**/ ?>