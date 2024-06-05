<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tableau de Bord | MobiAgri</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('mobidata/vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('mobidata/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('mobidata/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('mobidata/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('mobidata/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('mobidata/js/select.dataTables.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('mobidata/css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('mobidata/images/favIconSocoma.png')}}" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      
             
        <a class="navbar-brand brand-logo mr-5" href="/admin/dashboard">Faso Coton<!--<img src="{{asset('mobidata/images/logoSocoma.png')}}" class="mr-2" alt="logo"/>--></a>
        <a class="navbar-brand brand-logo-mini" href="/admin/dashboard">Faso Coton<!--<img src="{{asset('mobidata/images/logoSocoma.png')}}" alt="logo"/>--></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        
        <ul class="navbar-nav navbar-nav-right">

         
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="/admin/dashboard" data-toggle="dropdown" id="profileDropdown">
              <img src="{{asset('mobidata/images/faces/newFace.png')}}" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            
                 <a class="dropdown-item"  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <b style="font-size:13px;">Déconnexion</b>
                             </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form> 
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-flex">
            <h4 class="user-name">Admin</h4>
          </li>
        </ul>
         <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
         <div class="main-panel" style="margin-top:70px">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Tableau de Bord | Faso Coton</h3>
                </div>
              </div>
            </div>
          </div> 
          <div class="row">
        <form action="#" method="get" class="col-6 col-xl-6 mb-3 mb-xl-0">
            <label>Campagne</label>
            <select class="form-select" name='filtre' id="myselection" style = "width:300px; height:30px">
              <option>Sélectionner</option>
              <option value="2021-2022">2021-2022</option>
              <option value="2020-2021">2020-2021</option>
            </select>
          <button type="submit" id="button1" class="btn btn-outline-primary btn-sm">Filtrer</button>
          </form>
          
          <form action="#" id="VesDiameter" method="get" class="col-6 col-xl-6 mb-3 mb-xl-0">
            <label>Région</label>
            <select class="form-select" id="selectBox" onchange="changeFunc();" name='filtreR' style = "width:300px; height:30px">
                 <option value="" selected>Sélectionner</option>
              <option value="Fada">Fada</option>
              <option value="Diapaga">Diapaga</option>
           
            </select>
           <button type="submit" id="VesDiameter" class="btn btn-outline-primary btn-sm">Filtrer</button>
          </form>
          </div>
          <br><br>
          <div class="row">
                  <div class="col-md-12 grid-margin transparent">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                          <h4 class="font-weight-bold">Infos Producteurs et Groupements</h4>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-primary " id="sq">
                              <div class="card-body ">
                                  
                                <table>
                                  <tr>
                                                     
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($producteursTotal)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/farmers.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Total des producteurs</p>
                                
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-primary" id="sq">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format(count($producteursH))}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/man.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Producteurs Hommes</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-primary" id="sq">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format(count($producteursF))}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/woman.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Producteurs Femmes</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-primary" id="sq">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($nombre_scoops)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/scoops.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Nombre de SCOOPS</p>
                              </div>   
                            </div>
                          </div>
                        </div>
                        <!-- Fin de la 1ere ligne de KPIS -->
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                          <h4 class="font-weight-bold">Infos sur les superficies</h4>
                        </div>
                        <br>
                    <div class="row">
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq4">
                          <div class="card-body">
                            <table>
                              <tr>
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_prevue)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/prodcution.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie prévus(ha)</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq5">
                          <div class="card-body">
                            <table>
                              <tr> 
                                  <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_declarer)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/prodcution-cash.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title ">Superficie declarée(ha)</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq6">
                          <div class="card-body">
                            <table>
                              <tr>
                             
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_mesuree)}} </p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/rendement.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie mésurée</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq8">
                          <div class="card-body">
                            <table>
                              <tr>
                               
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_realise)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/mari.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie realisée</p>
                          </div>   
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq8">
                          <div class="card-body">
                            <table>
                              <tr>
                               
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_corrige)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/mari.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie corrigée</p>
                          </div>   
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq8">
                          <div class="card-body">
                            <table>
                              <tr>
                               
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_perdue)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/mari.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie perdue (ha)</p>
                          </div>   
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-info" id="sq8">
                          <div class="card-body">
                            <table>
                              <tr>
                               
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($superficie_productive)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/mari.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Superficie production</p>
                          </div>   
                        </div>
                    </div>
                  </div>
                    <!-- Fin info sur les superficies -->
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                          <h4 class="font-weight-bold">Infos sur les credits</h4>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-dark" id="sq">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($cdc)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/cdc.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">CDC (FCFA)</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-dark" id="sq1">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($clc)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/credit.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">CLC (FCFA)</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-dark" id="sq2">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($mise_en_place)}} </p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/superficieprevue.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Mise en place (FCFA)</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-dark" id="sq3">
                              <div class="card-body">
                                <table>
                                  <tr>
                                 
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($besoin_complementaire)}} </p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/superficierealisee.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table> 
                                <p class="kpi-title">Besoins complémentaire (FCFA)</p>
                              </div>   
                            </div>
                          </div>
                        </div>
                      
                  
                    <!-- Fin de 2E ligne de KPIS -->
                    
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                          <h4 class="font-weight-bold">Infos sur la production</h4>
                        </div>
                        <br>
                    <div class="row">
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-success" id="sq4">
                          <div class="card-body">
                            <table>
                              <tr>
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($rendement_moyen_scoops)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/prodcution.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Rendement moyen scoops</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-success" id="sq5">
                          <div class="card-body">
                            <table>
                              <tr> 
                                  <td class="kpi-elements"> <p class="kpi-number">{{number_format($prevision_de_production)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/prodcution-cash.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title ">Prévision de production</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-success" id="sq6">
                          <div class="card-body">
                            <table>
                              <tr>
                             
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($production_tonnes)}} </p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/rendement.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Production(kg)</p>
                          </div>   
                        </div>
                      </div>
                      <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale bg-success" id="sq8">
                          <div class="card-body">
                            <table>
                              <tr>
                               
                                <td class="kpi-elements"> <p class="kpi-number">{{number_format($production_valorisee)}}</p></td>
                                <td> </td>
                                <td> </td>
                                <td><img src="{{asset('mobidata/images/kpi-icons/mari.png')}}"  class ="kpi-icon" alt=""> </td>
                              </tr>
                            </table>
                            <p class="kpi-title">Production valorisé</p>
                          </div>   
                        </div>
                    </div>
                  </div>
                    <!-- Fin de 3e ligne de KPIS -->
                    
                     <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                          <h4 class="font-weight-bold">Autres indicateurs</h4>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-danger" id="sq">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($rendement)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/cdc.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Rendement</p>
                              </div>   
                            </div>
                          </div>
                          <div class="col-md-3 mb-4 stretch-card transparent">
                            <div class="card card-tale bg-danger" id="sq1">
                              <div class="card-body">
                                <table>
                                  <tr>
                                  
                                    <td class="kpi-elements"> <p class="kpi-number">{{number_format($mari)}}</p></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><img src="{{asset('mobidata/images/kpi-icons/credit.png')}}"  class ="kpi-icon" alt=""> </td>
                                  </tr>
                                </table>
                                <p class="kpi-title">Mari (FCFA)</p>
                              </div>   
                            </div>
                          </div>
                        </div>
                </div> 
                 <!-- Fin de 4e ligne de KPIS -->
            </div> 
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Partenaire : socoma </i></span>

            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">MobiData 2021 | Made With passion by <a href="https://www.illimitis.com/" target="_blank">ILLIMITIS</a></span>
          </div>
          
          
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<script>

      var color = ["#ff7f50", "#ffa502", "#5352ed", "#2ed573", "#70a1ff", "#e15f41", "#574b90", "#f19066","#303952" ];

    
      // dom ready
      document.addEventListener("DOMContentLoaded", function (event) {
          start()
      });
    
      function start() {
          document.getElementByClassName("card-tale").style.backgroundColor = color[Math.floor(Math.random() * color.length)];
                      }
            
 

</script>






  <!-- plugins:js -->
  <script src="{{asset('mobidata/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset('mobidata/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('mobidata/vendors/datatables.net/jquery.dataTables.js')}}"></script>
  <script src="{{asset('mobidata/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('mobidata/js/dataTables.select.min.js')}}"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('mobidata/js/off-canvas.js')}}"></script>
  <script src="{{asset('mobidata/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('mobidata/js/template.js')}}"></script>
  <script src="{{asset('mobidata/js/settings.js')}}"></script>
  <script src="{{asset('mobidata/js/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('mobidata/js/dashboard.js')}}"></script>
  <script src="{{asset('mobidata/js/Chart.roundedBarCharts.js')}}"></script>
  <!-- End custom js for this page-->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
      <script>
        
   </script>
  
  
</body>

</html>

