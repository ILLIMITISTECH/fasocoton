	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				
				<!--end::Aside-->
				<!--begin::Wrapper-->
		<?php $event = DB::table('events')->where('status', '=', 1)->first() ?>
		
    		
			    	<!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <!--begin::Header-->
                    
                        <!--end::Page title=-->
                        <!--begin::Logo bar-->
                        
                        <!--end::Logo bar-->
                        <!--begin::Toolbar wrapper-->
                        <!--end::Header-->
                        <!--begin::Content-->
                        <div class="content d-flex flex-column flex-column-fluid fs-6" id="kt_content">
                            <!--begin::Container-->
                            <div class="container" id="kt_content_container">
                            <!--begin::FAQ-->
                            <div class="card bg-primary">
                            <!--begin::Card body-->
                            <div class="card-body p-lg-20">
                            <!--begin::Intro-->
                            <h1 class="fs-2x text-light w-bolder mb-6"><span class="text-light">Merci pour votre inscription à l'événement du SALON DES BANQUES ET PME DE L'UEMOA!</span>!</h1>
                            <div class="mb-5">
                            <!--begin::Title-->
                            <h3 class="fs-2x text-light w-bolder mb-6"><span class="text-light">{{ucfirst(Auth::user()->prenom)}} {{ucfirst(Auth::user()->nom)}}&nbsp;</span>!</h3>
                            <!--end::Title-->
                            <!--begin::Text-->
                           
                            <!--end::Text-->
                            </div>
                            
                            </div>
                            <!--end::Card body-->
                            </div>
                            <!--end::FAQ-->
                            </div>
                           
                            <div class="container mt-10" id="kt_content_container">
                            <!--begin::FAQ-->
                            <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="mt-2">Voici vos rendez-vous à venir</h4>
                                                            </div>

                            <!--begin::Card body-->
                            <div class="card-body">
                              
                                                                <div class="table-responsive">
                                                                   
                                                                              
                                     
                                                                             
                                                                    <table style ="width: 100%;" id="myTable" class="table table-bordered table-hover table-striped border gy-7 gs-7">
                                                                        <thead>
                                                                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                                <th>{{ __('Person met') }}</th>
                                                                                <th>{{ __('Enterprise') }}</th>
                                                                                <th>{{ __('Room') }}</th>
                                                                                <th>{{ __('Table') }}</th>
                                                                                <th>{{ __('Date') }}</th>
                                                                                <th>{{ __('Hour') }}</th>
                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                           
                                                                            @foreach($plannings as $planning)
                                                                          
                                                                                <tr>
                                                                                    <?php 
                                                                                     $entreprise = DB::table('entreprises')->where('id', '=', $planning->entreprise_id)->first();
                                                                                     $user = DB::table('users')->where('id', '=', $entreprise->user_id)->first()
                                                                                     ?>
                                
                                                                                    <td>
                                                                                        @if($user)
                                                                                            <a href="#">{{$user->prenom}} {{$user->nom}}</a>  <br>  
                                                                                             <a href="#">Tel : {{$user->portable}}</a> <br> 
                                                                                             <a href="#">Email : {{$user->email}}</a>
                                                                                            </td>
                                                                                        @else
                                                                                            <a href="#">~ ~</a></td>
                                                                                        @endif
                                                                                        
                                                                                   
                                                                                    
                            
                                                                                    <td><a href="#">{{$entreprise->nom_entreprise}}</a></td>
                                                                                    
                                                                                        
                                                                                    <?php $cre = DB::table('salles')->where('id', $planning->sale_id)->first() ?>
                                                                                     <td>{{$cre->libelle}}</td>
                                                                                      <td>{{$planning->libelle_t}}</td>
                                                                                    <td>{{$planning->date_rv}}</td>
                                                                                    <td>{{$planning->heure_deb}} - {{$planning->heure_fin}}</td>
                                                                                    
                                                                                    @php $sal = DB::table('salles')->where('id', $planning->sale_id)->first(); @endphp
                                                                                    
                                                                                    
                                                                                    
                                                  
                                                                                
                                                                                </tr>
                                                                               
                                                                                 @endforeach
                                                                                 
                                                                                
                                                                           
                                                                        </tbody>
                                                                    </table>
                                                                         
                                                                          
                                                                </div>
                            </div>
                            <!--end::Card body-->
                            </div>
                            <!--end::FAQ-->
                       
                            </div>
                              	<div class="row">
                	   
            	`</div> 
                        </div>
                        <!--end::Content-->
              
                        </div>
                        <!--end::Wrapper-->
                        
                    
                            
                  </div>
               	</div>
               	
               	
               	
               	
               	
               	
               		
                   	
                
           
            		<!--end::Main-->
            		<!--begin::Drawers-->
            		<!--begin::Activities drawer-->
            	</div>
          
              
                		
        </div>  
        </div>
                		
                		

		<script> 
		    function copyToClipboard(id) {
                document.getElementById(id).select();
                document.execCommand('copy');
                alert('copié ✔️');
            }
        </script>
		<div id="kt_scrolltop" class="scrolltop rounded-circle" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		
		<script src="{{asset('User/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('User/assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('User/assets/js/custom/widgets.js')}}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
    	</body>
	<!--end::Body-->
</html>