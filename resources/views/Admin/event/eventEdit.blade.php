<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OptiEvent | Administration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('Admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('Admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('Admin/https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css')}}">
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('Admin/Dashboard.sideBarUser')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <h4 class="card-title">Modifier  l'évènement</h4>
                    <p class="card-description">Remplissez ce formulaire pour Modifier l'èvènement</p>
                    <form action="{{route('events.update', $even->id)}}" enctype="multipart/form-data" method='post'>
        {{ csrf_field() }}
        @method('put')
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'évènement en Français: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" value="{{$even->nom_event_fr}}" name="nom_event_fr" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'évènement en Anglais: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_event_en" value="{{$even->nom_event_en}}" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="website">Site Web : (Optionnel)</label>
                        <input type="link" class="form-control" name="site" value="{{$even->site}}" placeholder="Site Web">
                      </div>
                      <!-- <div class="form-group">
                        <label for="exampleSelectGender">Quel est le format de l'évènement ? (<span class="red">*</span>)</label>
                        <select class="form-control" id="exampleSelectGender">
                          <option>En ligne</option>
                          <option>Hors ligne</option>
                        </select>
                      </div> -->
                      <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Date de début : (<span class="red">*</span>)</label>
                            <div class="">
                            <input type="date" class="form-control" value="{{$even->date_debut}}" name="date_debut" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Date de fin : (<span class="red">*</span>)</label>
                            <div class="">
                            <input type="date" class="form-control" value="{{$even->date_debut}}" name="date_fin" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                    </div>

                    
                    
                      <button type="submit" class="btn btn-gradient-primary mr-2">Valider</button>
                      <button class="btn btn-danger">Quitter</button>
                    </form>
                  </div>
                </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">OptiEvent © Concu avec passion et enthousiasme par <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">ILLIMITIS</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('Admin/Dashboard.js')
  </body>
</html>