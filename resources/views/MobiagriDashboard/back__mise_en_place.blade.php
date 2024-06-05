<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('MobiagriDashboard/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Faso Coton | MobiAgri</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('MobiagriDashboard/assets/img/logo_fasocoton.jpeg') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('MobiagriDashboard/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('MobiagriDashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('MobiagriDashboard/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('MobiagriDashboard/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
            <!-- Menu -->
              @include('MobiagriDashboard.sidebar')
              <!-- / Menu -->

              <!-- Layout container -->
              <div class="layout-page">
                  <!-- Navbar -->
                    @include('MobiagriDashboard.header')
                  <!-- / Navbar -->
                
                  <!-- Content wrapper -->
                    <div class="content-wrapper container mt-4">
                        <div class="my-auto">
                            <div class="row">
                                <div class="col-4">
                                    <label for="campagne" class="form-label">Campagne Coton :</label>
                                    <select class="form-select form-control" name="search_campagne_mep" id="campagne" aria-label="Default select example" required>
                                        <option value="" selected>Sélectionner la campagne</option>
                                        <option value="22-23">22-23</option>
                                        <option value="23-24">23-24</option>
                                        <option value="24-25">24-25</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="exampleFormControlSelect1" class="form-label">Zone :</label>
                                    <select class="form-select" name="by_zone" id="exampleFormControlSelect1">
                                        <option class="form-option" value="" selected>Selectionné une zone ...</option>
                                        @foreach ($zone_by_mise_en_place as $item)
                                            <option class="form-option" value="{{ $item->nom_zone }}">
                                                {{ $item->nom_zone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="exampleFormControlSelect1" class="form-label">Section :</label>
                                    <select class="form-select form-control" name="search_section_mise_en_place" id="sectionFilter">
                                        <option value="" selected>sélectionner la section...</option>
                                        {{-- valeur charger dynamiquement ici --}}
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @php
                        $segment = request()->input('search_zone_mep');
                        //echo $segment; // article
                        $campa = request()->input('search_campagne_mep');
                    @endphp
                    <div class="container flex-grow-1 container-p-y">
                      : Campagne : <strong class="text-primary">23-24</strong>
                      @if($segment) : <strong class="text-primary">{{ $segment }}</strong> @else <strong></strong> @endif : {{ number_format($mise_en_place_count) }}</h4>
                        <h4 class="text-primary">Mise en place 
                            @if($segment) : Zone : 
                                <strong class="text-primary">{{ $segment }} </strong> 
                            @if($campa) : Campagne : 
                                <strong class="text-primary">{{ $campa }}</strong>
                            @endif 
                            @else <strong></strong> 
                            @endif : <=> :
                                <strong>
                                    {{ number_format($mise_en_place_count) }} 
                                </strong>
                        </h4>

                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Section </th>
                                        <th>Zone </th>
                                        <th>Prénom et Nom </th>
                                        <th>Code SCOOPS producteur</th>
                                        <th>Nom SCOOPS</th>
                                        <th>Campagne</th>
                                        <th>Atomiseurs</th>
                                        <th>Appareils à Dos</th>
                                        <th>Appareils à Pile</th>
                                        <th>EPI</th>
                                        <th>Herbicides Post-levée</th>
                                        <th>Herbicides Pré-levée</th>
                                        <th>Herbicides Total</th>
                                        <th>Insecticides classiques Type 1</th>
                                        <th>Insecticides classiques Type 2</th>
                                        <th>Insecticides classiques Type 3</th>
                                        <th>Insecticides spécifiques Type 1</th>
                                        <th>Insecticides spécifiques Type 2</th>
                                        <th>Insecticides spécifiques Type 3</th>
                                        <th>Engrais NPK/FU (50 kg)</th>
                                        <th>Engrais Urée (50 kg)</th>
                                        <th>Total Engrais</th>
                                        <th>Total Semences</th>
                                        <th>Total Insecticides</th>
                                        <th>Total Mise en place </th>
                                    </tr>
                                </thead>
                                {{-- @dd($mise_en_place->where('nom_zone','PO')) --}}
                                <tbody class="table-border-bottom-0" id="miseEnPlaceTableBody">
                                    @foreach($mise_en_place as $mise_en_places)
                                        <tr>
                                            <td> {{ $mise_en_places->nom_section }} </td>
                                            <td> {{ $mise_en_places->nom_zone }} </td>
                                            <td>{{ $mise_en_places->prenom_producteur }}
                                                {{ $mise_en_places->nom_producteur }}</td>
                                            <td>{{ $mise_en_places->code_scoop_producteur }}</td>
                                            <td>{{ $mise_en_places->nom_scoop }}</td>
                                            <td>{{ $mise_en_places->campagne_coton }}</td>
                                            <td>{{ $mise_en_places->nbre_appareil_atomiseur_piece }}</td>
                                            <td>{{ $mise_en_places->nbre_appareil_dos_piece }}</td>
                                            <td>{{ $mise_en_places->nbre_appareil_pile_piece }}</td>
                                            <td>{{ $mise_en_places->nbre_epi_piece }}</td>
                                            <td>{{ $mise_en_places->nbre_herbicides_post_levee }}</td>
                                            <td>{{ $mise_en_places->nbre_herbicides_pre_levee }}</td>
                                            <td>{{ $mise_en_places->nbre_herbicides_total }}</td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_1_traitement }}</td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_2_traitement }}</td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_3_traitement }}</td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_1_specifiques_traitement }}
                                            </td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_2_specifiques_traitement }}
                                            </td>
                                            <td>{{ $mise_en_places->nbre_insecticides_type_3_specifiques_traitement }}
                                            </td>
                                            <td>{{ $mise_en_places->nbre_sac_engrais_npk_fu_50kg }}</td>
                                            <td>{{ $mise_en_places->nbre_sac_engrais_uree_50kg }}</td>
                                            <td>{{ $mise_en_places->total_engrais }}</td>
                                            <td>{{ $mise_en_places->total_semence }}</td>
                                            <td>{{ $mise_en_places->total_insecticide }}</td>
                                            <td>{{ $mise_en_places->total_montant_intrants }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script src="{{ asset('MobiagriDashboard/assets/vendor/libs/jquery/jquery.js') }}">
    </script>
    <script src="{{ asset('MobiagriDashboard/assets/vendor/libs/popper/popper.js') }}">
    </script>
    <script src="{{ asset('MobiagriDashboard/assets/vendor/js/bootstrap.js') }}"></script>
    <script
        src="{{ asset('MobiagriDashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}">
    </script>

    <script src="{{ asset('MobiagriDashboard/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script
        src="{{ asset('MobiagriDashboard/assets/vendor/libs/apex-charts/apexcharts.js') }}">
    </script>

    <!-- Main JS -->
    <script src="{{ asset('MobiagriDashboard/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('MobiagriDashboard/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

    <script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: true,
				buttons: [ 'copy', 'excel', 'pdf', 'print'],
                language: {
                search: "Recherche :",
            },
			} );

			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>


    <script>
        $(document).ready(function () {

            document.getElementById('campagne').addEventListener('change', function() {
                var selectedCampagne = this.value;
                updateMiseEnPlaceTable(selectedCampagne);
            });

            function updateMiseEnPlaceTable(selectedCampagne) {
                var tableRows = document.querySelectorAll('#miseEnPlaceTableBody tr');

                tableRows.forEach(function(row) {
                    var rowCampagne = row.querySelector('td:nth-child(6)').textContent.trim(); // Assurez-vous d'ajuster l'indice selon la position de la colonne 'campagne_coton' dans votre table
                    if (rowCampagne !== selectedCampagne && selectedCampagne !== '') {
                        row.style.display = 'none';
                    } else {
                        row.style.display = '';
                    }
                });
            }


            document.getElementById('sectionFilter').addEventListener('change', function() {
                var selectedSection = this.value;
                var tableRows = document.querySelectorAll('#miseEnPlaceTableBody tr');

                tableRows.forEach(function(row) {
                    if (row.querySelector('td:first-child').textContent.trim() !== selectedSection && selectedSection !== '') {
                    row.style.display = 'none';
                    } else {
                    row.style.display = '';
                    }
                });
            });

            document.getElementById('exampleFormControlSelect1').addEventListener('change', function() {
                var selectedZone = this.value;
                var tableRows = document.querySelectorAll('#miseEnPlaceTableBody tr');

                tableRows.forEach(function(row) {
                    if (row.querySelector('td:nth-child(2)').textContent.trim() !== selectedZone && selectedZone !== '') {
                    row.style.display = 'none';
                    } else {
                    row.style.display = '';
                    }
                });
            });


            document.getElementById('exampleFormControlSelect1').addEventListener('change', function() {
                var selectedZone = this.value;
                updateSectionQuery(selectedZone);
            });

            function updateSectionQuery(selectedZone) {
                fetch('/api/sections?zone=' + selectedZone)
                    .then(response => response.json())
                    .then(data => {
                        updateSectionDropdown(data);
                    })
                    .catch(error => console.error('Erreur lors de la récupération des sections:', error));
            }

            function updateSectionDropdown(sections) {
                var sectionDropdown = document.getElementById('sectionFilter');
                sectionDropdown.innerHTML = '<option value="" selected>sélectionner la section...</option>';

                sections.forEach(function(section) {
                    var option = document.createElement('option');
                    option.value = section.nom_section;
                    option.text = section.nom_section;
                    sectionDropdown.appendChild(option);
                });
            }
           
        });







        // filtre dynamique 

        $(document).ready(function () {
                    // Filtre par campagne
                    $('#campagneclc').change(function() {
                        var selectedCampagne = $(this).val();
                        var selectedZone = $('#selectZoneClc').val();
                        updateMiseEnPlaceTable(selectedCampagne, selectedZone);
                    });

                    // Filtre par zone
                    $('#selectZoneClc').change(function() {
                        var selectedCampagne = $('#campagneclc').val();
                        var selectedZone = $(this).val();
                        updateMiseEnPlaceTable(selectedCampagne, selectedZone);
                    });

                    function updateMiseEnPlaceTable(selectedCampagne, selectedZone) {
                        var tableRows = $('#clcTableBody tr');
                        tableRows.each(function() {
                            var rowCampagne = $(this).find('td:nth-child(6)').text().trim();
                            var rowZone = $(this).find('td:first-child').text().trim();
                            if ((rowCampagne !== selectedCampagne && selectedCampagne !== '') || 
                                (rowZone !== selectedZone && selectedZone !== '')) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });
                    }
                });





                // code qui fonctionne tres bien pour les 3 filtre et individuel 

                $(document).ready(function () {
                    // Filtre par campagne
                    $('#campagneclc').change(function() {
                        var selectedCampagne = $(this).val();
                        updateMiseEnPlaceTable(selectedCampagne);
                    });

                    // Filtre par zone
                    $('#selectZoneClc').change(function() {
                        var selectedZone = $(this).val();
                        updateMiseEnPlaceTable(undefined, selectedZone);
                    });

                    // Filtre par section
                    $('#sectionFilter').change(function() {
                        var selectedSection = $(this).val();
                        updateMiseEnPlaceTable(undefined, undefined, selectedSection);
                    });

                    document.getElementById('selectZoneClc').addEventListener('change', function() {
                        var selectedZone = this.value;
                        updateSectionQuery(selectedZone);
                    });

                    function updateSectionQuery(selectedZone) {
                        fetch('/api/getSectionsByClc?by_zone=' + selectedZone)
                            .then(response => response.json())
                            .then(data => {
                                updateSectionDropdown(data);
                            })
                            .catch(error => console.error('Erreur lors de la récupération des sections:', error));
                    }

                    function updateSectionDropdown(sections) {
                        var sectionDropdown = document.getElementById('sectionFilter');
                        sectionDropdown.innerHTML = '<option value="" selected>sélectionner la section...</option>';

                        sections.forEach(function(section) {
                            var option = document.createElement('option');
                            option.value = section.nom_section;
                            option.text = section.nom_section;
                            sectionDropdown.appendChild(option);
                        });
                    }

                    function updateMiseEnPlaceTable(selectedCampagne, selectedZone, selectedSection) {
                        var tableRows = $('#clcTableBody tr');
                        tableRows.each(function() {
                            var rowCampagne = $(this).find('td:nth-child(6)').text().trim();
                            var rowZone = $(this).find('td:first-child').text().trim();
                            var rowSection = $(this).find('td:nth-child(2)').text().trim();

                            var showRow = true;

                            if (selectedCampagne && rowCampagne !== selectedCampagne) {
                                showRow = false;
                            }
                            if (selectedZone && rowZone !== selectedZone) {
                                showRow = false;
                            }
                            if (selectedSection && rowSection !== selectedSection) {
                                showRow = false;
                            }

                            if (showRow) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                });


    </script>
    
</body>

</html>
