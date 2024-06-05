@include('User/head')
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside bg-white" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
					<!--begin::Brand-->
					<div class="aside-logo flex-column-auto pt-9 pb-7 px-9" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="/home">
								<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-default" style="max-width : 60%"/>
							<img alt="Logo" src="{{asset('User/assets/media/logos/logo-optievent.png')}}" class="max-h-50px logo-minimize" style="max-width :  60%"/>
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
	                @include('User/sidebar3')
					<!--end::Aside menu-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
								<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-2 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								
								<!--end::Heading-->
								<!--begin::Breadcrumb-->
								<ul class="breadcrumb fw-bold fs-base mb-1">
									<li class="breadcrumb-item text-muted">
										<a href="index.html" class="text-muted text-hover-primary"></a>
									</li>
								</ul>
								<!--end::Breadcrumb-->
							</div>
							<!--end::Page title=-->
							<!--begin::Logo bar-->
					@include('User/headUser')
					<!--end::Header-->
					<!--begin::Content-->
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
			
                    <div class="content d-flex flex-column flex-column-fluid fs-6" id="kt_content">
                        <div class="container mt-3" id="kt_content_container">
							<!--begin::FAQ-->
							<div class="card">
                                <div class="card-header"style="background:#390c6e;width:300px;">
                                    <h4 class="mt-2"style="color:white;margin-left:30px;font-family:Lucida Console,Courier New,monospace;">Liste des Hotels</h4>
                                    <br>
                                    <br>
                                </div>
                               
								<!--begin::Card body-->
								<div class="card-body">
                                    <div class="table-responsive">
                                        <table style ="width: 100%;" class="table table-hover ">
                                            
                                           
                                            <tbody>
                                              <div class="table table-hover table-striped border gy-7 gs-7">
                                                <th><b>Nom de l'hotel</b></th>
                                                <th><b>Type</b></th>
                                                <th><b>Telephone</b></th>
                                                <th><b>Nombre de chambre</b></th>
                                                <th><b>Nombre de place</b></th>
                                               </div> 
                                            <?php $hotels = DB::table('hotels')->get();  ?>
                                            @foreach($hotels as $hotel)
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                    <th>{{$hotel->nom_hotel}} </th>
                                                    <th>{{$hotel->type_hotel}}</th>
                                                     <th>{{$hotel->tel_hotel}}</th>
                                                    <th><center>{{$hotel->details_hotel}}</center></th>
                                                    <th><center>{{$hotel->site_hotel}}</center></th>
                                                   
                                                    <th></th>
                                                    
                                                </tr>
                                                
                                                <?php $chambres = DB::table('chambres')->where('hotel_id', $hotel->id)->get();  ?>
                                                      @foreach($chambres as $chambre)
                                                     <tr>
                                                        <td></td>
                                                         <td></td>
                                                          
                                                            <td>
                                                               {{$chambre->nom_chambre}}
                                                            </td>
                                                            
                                                           
                                                            <td></td>
                                                             <td>{{$chambre->prix}}</td>
                                                            <td>        
                                                            <form method="POST" action=" ">
                                                                <input type="submit" id="p1" style="background: #480099; color:white; margin-top:-10px;" class="btn btn-default" value="Reserver" ></button>
                                                             </form>
                
                                                                    </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                           
                                            
                                        </table>
                                            </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
								
                                    
						