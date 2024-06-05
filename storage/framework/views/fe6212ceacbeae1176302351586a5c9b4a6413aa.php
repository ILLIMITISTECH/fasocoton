<!DOCTYPE html>


<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?php echo e(asset('MobiagriDashboard/assets/')); ?>"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Faso Coton | MobiAgri</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('MobiagriDashboard/assets/img/logo_fasocoton.jpeg')); ?>" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet"> 

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/vendor/fonts/boxicons.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/vendor/css/core.css')); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/vendor/css/theme-default.css')); ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/css/demo.css')); ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apex-charts.css')); ?>" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/js/helpers.js')); ?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/js/config.js')); ?>"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
            <?php echo $__env->make('MobiagriDashboard.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
            <?php echo $__env->make('MobiagriDashboard.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container flex-grow-1 container-p-y">
                <div class="col-12 col-xl-12 mb-4 mb-xl-0">
                <h5 class="font-weight-bold">Bienvenue sur votre espace de visualisation des collectes cotonnières</h3><hr>
                <div class="mt-4"></div>
                <small class="text-primary text-muted">Production réalisée</small>
                    <form action="<?php echo e(route('filtreProductionRealisee')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4" >
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner la campagne</label>
                                    <select class="form-select" name="campagne" aria-label="Default select example" required>
                                        <option value="">Sélectionner la campagne</option>
                                        <?php $__currentLoopData = $campagnes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campagne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option ><?php echo e($campagne->campagne_coton); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                             <?php if(Auth::user()->nom_role == 'admin'): ?>
                            <div class="col-md-4" >
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner la zone</label>
                                    <select class="form-select" name="codeScoop" aria-label="Default select example" onchange="updateSections(this.value)" required>
                                        <option value="" selected disabled>Sélectionner la zone</option>
                                        <?php $__currentLoopData = $scoops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scoop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($scoop->zone); ?>"><?php echo e(($scoop->zone) ? $scoop->zone : '--'); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner une section</label>
                                    <select class="form-select" name="section" aria-label="Default select example" required>
                                        <option value="" selected disabled data-zone="">Sélectionner la section</option>
                                        <?php $__currentLoopData = $scoopsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scoopsec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($scoopsec->section); ?>" data-zone="<?php echo e($scoopsec->zone); ?>"><?php echo e($scoopsec->section); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php elseif(Auth::user()->nom_role == 'ca'): ?>
                            <p></p>
                            <?php else: ?>
                            <div class="col-md-4" >
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner la zone</label>
                                    <select class="form-select" name="codeScoop" aria-label="Default select example" onchange="updateSections(this.value)" required>
                                        <option value="" selected disabled>Sélectionner la zone</option>
                                         <option value="<?php echo e(Auth::user()->nom_role); ?>"><?php echo e((Auth::user()->nom_role) ? Auth::user()->nom_role : '--'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner une section</label>
                                    <select class="form-select" name="section" aria-label="Default select example" required>
                                        <option value="" selected disabled data-zone="">Sélectionner la section</option>
                                        <?php $__currentLoopData = $scoopsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scoopsec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($scoopsec->section); ?>" data-zone="<?php echo e($scoopsec->zone); ?>"><?php echo e($scoopsec->section); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="col-md-4">
                                <div class="form-group"><br>
                                    <label for="exampleFormControlSelect1">Sélectionner l'option </label>
                                    <select class="form-select" name="option" id="option1" aria-label="Default select example" required>
                                        <option value="">Options</option>
                                        <option value="1">MAG</option>
                                        <option value="2">CD</option>
                                        <option value="3">Production Total en KG</option>
                                        <option value="4">Entrées usines MAG</option>
                                        <option value="5">Entrées usines CD</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div><hr>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" style="float: right;" class="btn btn-primary"> Filtrer <i class="fa fa-save" aria-hidden="true"></i></button>
                            </div>
                        </div><br>
                    </form>
                <div class="row m-5 mb-5">
              </div>
            </div>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/popper/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>

    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/js/menu.js')); ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apexcharts.js')); ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/js/main.js')); ?>"></script>

    <!-- Page JS -->
    <script src="<?php echo e(asset('MobiagriDashboard/assets/js/dashboards-analytics.js')); ?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
    
     <script>
    function updateSections(selectedZone) {
        // Récupérer toutes les options du deuxième menu déroulant
        var sectionOptions = document.querySelectorAll('[name="section"] option');

        // Parcourir toutes les options et masquer celles qui ne correspondent pas à la zone sélectionnée
        sectionOptions.forEach(function(option) {
            if (option.dataset.zone === selectedZone || option.dataset.zone === '') {
                option.style.display = 'block'; // Afficher les options correspondantes
            } else {
                option.style.display = 'none'; // Masquer les options non correspondantes
            }
        });
    }
</script>

    <script>

      // $("#option1").on("change",function() {
      //   var optionValue = $(this).val();
      //   switch(optionValue) {
      //     case '1':
      //       var tableauDonnees = ["Septembre : Prévision de production", "Octobre : Prévision de production"];
      //       $('select[name="option2"]').empty();
      //       $('select[name="option2"]').append('<option selected disabled>Sélectionner l\'options interviews </option>');
      //       for (var i = 0; i < tableauDonnees.length; i++) {
      //         $('select[name="option2"]').append('<option value="'+ tableauDonnees[i] +'">'+ tableauDonnees[i] +'</option>');
      //       }
      //       break;
      //     case '2':
      //       var tableauDonnees = ["Rendement moyen", "Prévision de production"];
      //       $('select[name="option2"]').empty();
      //       $('select[name="option2"]').append('<option selected disabled>Sélectionner l\'option comptage </option>');
      //       for (var i = 0; i < tableauDonnees.length; i++) {
      //         $('select[name="option2"]').append('<option value="'+ tableauDonnees[i] +'">'+ tableauDonnees[i] +'</option>');
      //       }
      //       break;
      //     default:
      //       // code block
      //   }
        // Tableau de données

      
        // $.ajax({
            
        //     url: "<?php echo e(URL::to('selectRegionDpc')); ?>/"+capmagneValue,
        //     type:'GET',
        //     dataType:'json',
        //     success:function(reponse){
        //         $('select[name="filtreR"]').empty();
        //         $('select[name="filtreR"]').append('<option selected disabled>Sélectionner la région </option>');
        //         $.each(reponse, function(key, value) {
        //             // console.log(value.region.toUpperCase());
        //             $('select[name="filtreR"]').append('<option value="'+ value.region +'">'+ value.region +'</option>');
        //             // if(capmagneValue == ''){
                        
        //             // }else{
        //             //  $('select[name="filtreR"]').append('<option value="'+ value.region +'">'+ value.region.toUpperCase() +'</option>');   
        //             // }
        //         });
                
        //     }
        // })
        
      }).trigger("change");

    </script>
  </body>
</html>

<?php /**PATH /home/c1735160c/public_html/fasocoton/resources/views/MobiagriDashboard/production_realisee.blade.php ENDPATH**/ ?>