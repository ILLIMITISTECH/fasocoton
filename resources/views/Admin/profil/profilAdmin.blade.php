<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OptiEvent | Administration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html"><img src="/assets/images/logo-optievent.png"></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="/assets/images/logo-min.png"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">       
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>       
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                    <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                    <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-link-variant"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                    <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <h6 class="p-3 mb-0 text-center">See all notifications</h6>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="assets/images/faces/face1.jpg" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">Axel Nonguierma</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-cached mr-2 text-success"></i> Mon profil </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-logout mr-2 text-primary"></i> Déconnexion</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <span class="menu-title">Tabeau de bord</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#evenements" aria-expanded="false" aria-controls="evenements">
                    <span class="menu-title">Évènements</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-calendar menu-icon"></i>
                </a>
                <div class="collapse" id="evenements">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#actives" aria-expanded="false" aria-controls="actives">
                    <span class="menu-title">Activités</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-ballot-recount menu-icon"></i>
                </a>
                <div class="collapse" id="actives">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#secteurs-activites" aria-expanded="false" aria-controls="secteurs-activites">
                    <span class="menu-title">Secteurs d'activités</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-google-circles-group menu-icon"></i>
                </a>
                <div class="collapse" id="secteurs-activites">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#profils" aria-expanded="false" aria-controls="profils">
                    <span class="menu-title">Profils</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account-box menu-icon"></i>
                </a>
                <div class="collapse" id="profils">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#"> </i> </i></i></i></i></i></i></i></i></i></i>Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#entreprises" aria-expanded="false" aria-controls="entreprises">
                    <span class="menu-title">Entreprises</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-home-account menu-icon"></i>
                </a>
                <div class="collapse" id="entreprises">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#participants" aria-expanded="false" aria-controls="participants">
                    <span class="menu-title">Participants</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account menu-icon"></i>
                </a>
                <div class="collapse" id="participants">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#organisateurs" aria-expanded="false" aria-controls="organisateurs">
                    <span class="menu-title">Organisateurs</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account-circle menu-icon"></i>
                </a>
                <div class="collapse" id="organisateurs">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">  Lister</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Ajouter</a></li>
                    </ul>
                </div>
                </li>
        
            </ul>
            </nav>
            <div class="container">
                <div class="row gutters-sm">
                <div class="col-md-4 d-none d-md-block">
                    <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column nav-pills nav-gap-y-1">
                        <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>Informations du profil
                        </a>
                        <a href="#photo" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>Photo de profil
                        </a>
                        <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>Sécurité
                        </a>
                        </nav>
                    </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                        <li class="nav-item">
                            <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="#photo" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                        </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="profil">
                        <h6>Informations de votre profil</h6>
                        <hr>
                        <form>
                            <div class="form-group">
                            <label for="fullName">Nom et prénom :</label>
                            <input type="text" class="form-control" id="fullName" aria-describedby="fullNameHelp" placeholder="Enter your fullname" value="Kenneth Valdez">
                            <small id="fullNameHelp" class="form-text text-muted">Your name may appear around here where you are mentioned. You can change or remove it at any time.</small>
                            </div>
                         
                            <button type="button" class="btn btn-primary">Mettre à jour le profil</button>
                            <button type="reset" class="btn btn-light">Quitter</button>
                        </form>
                        </div>
                        <div class="tab-pane" id="photo">
                            <h6>Changer de photo de profil</h6>
                     
                        <form>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="img[]" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                                  </span>
                                </div>
                              </div>
                        </form>
                        <hr>
                       
                        <button type="button" class="btn btn-primary">Mettre à jour le profil</button>
                        <button type="reset" class="btn btn-light">Quitter</button>
                    </div>
                        <div class="tab-pane" id="security">
                        <h6>Sécurité</h6>
                        <hr>
                        <form>
                            <div class="form-group">
                            <label class="d-block">Nouveau mot de passe : </label>
                            <input type="text" class="form-control mt-1" placeholder="New password">
                            </div>
                            <div class="form-group">
                                <label class="d-block">Confirmer le mot de passe : </label>
                                <input type="text" class="form-control mt-1" placeholder="New password">
                                </div>
                        </form>
                        <hr>
                        <button type="button" class="btn btn-primary">Mettre à jour le profil</button>
                        <button type="reset" class="btn btn-light">Quitter</button>
                     
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        
            <!-- main-panel ends -->
        </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>