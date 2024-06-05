	<div class="content d-flex flex-column flex-column-fluid fs-6" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Layout - Overview-->
							<div class="d-flex flex-column flex-xl-row">
								<!--begin::Sidebar-->
							
								<!--end::Sidebar-->
								<!--begin::Content-->
								<div class="flex-lg-row-fluid ms-lg-10">
									<!--begin::details View-->
									<div class="card mb-5 mb-xl-6" id="kt_profile_details_view">
										<!--begin::Card header-->
										<div class="card-header cursor-pointer" >
											<!--begin::Card title-->
											<div class="card-title m-0" >
												<h3 class="fw-bolder m-0"style="margin-left:30px;font-family:Lucida Console,Courier New,monospace;">Mon QR Code participant </h3>
											
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
										
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
										    <div class="badge-container">
										        <div class="badge-header">
										            <h4 class="fw-bolder m-0"> Badge SICOT 2022</h4>
										           
										        </div>
										        	<!--begin::Row-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold">Prénom :</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{ucfirst(Auth::user()->prenom)}}&nbsp;</span>
												</div>
												<!--end::Col-->
											</div>
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold ">Nom : </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{ucfirst(Auth::user()->nom)}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Input group-->
											
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold">Numéro de Téléphone :
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{ucfirst(Auth::user()->portable)}}</span>
													
												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
	
											<!--begin::Input group-->
										
											<!--end::Input group-->
											<label class="col-lg-4 fw-bold">Mon code participant : 
												<div class="fs-6 fw-bold mb-8" style="margin-top:20px;">
												    @php
												        $data = Crypt::encryptString(Auth::id());
												    @endphp
												    <center>
                                                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                                                                ->size(200)->errorCorrection('H')
                                                                                ->generate('https://optieventdemo.mobiagri.com/qrcode_parse/'.$data)) !!} ">
												    </center>
												    
												    
										            
									            </div>
										        
										    </div>
										    <style>
										        .badge-container {
										            padding : 5%;
										            border : 1px solid #480099;
										            border-radius : 10px;
										            width :600px;
										        }
										        .badge-header  {
										            background-color : #480099;
										            width : 500px;
										            height :50px;
										            padding :10%;
										            margin-bottom :10%;
										        }
										        .badge-header h4 { 
										            color : white;
										            text-align : center;
										        }
										    </style>
										
										
										</div>
										<!--end::Card body-->
									</div>
									<!--end::details View-->
									
							
								</div>
								<!--end::Content-->
							</div>
							<!--end::Layout - Overview-->
						</div>
						<!--end::Container-->
                       
					</div>