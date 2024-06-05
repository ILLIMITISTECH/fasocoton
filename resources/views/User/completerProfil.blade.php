<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>OptiEvent| Inscription</title>
		<meta name="description" content="Organiser un évènement n'aura jamais été aussi simple !" />
		<meta name="keywords" content="" />
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('User/assets/media/optieventFavIcon.png')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('User/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
			     @include('User/sideInscription')
                <div class="col-6 left-part">
                 
                    <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <div class="form-part" style ="margin-top : -5%;">
                        
                       <form action="{{route('completermonprofil.update', $parti->id)}}" method=post>
                       {{ csrf_field() }}
              
              
                                <div class="col-md-7">
                                    <label for="inputState" class="form-label required">{{__('Will you be present at the International Cotton Show?')}} </label>
                                    <select name="presence" class="form-select" id="stade_entreprise" required>
                                        <option value="">{{__('Select')}}</option>      
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-7">
                                    <label for="inputState" class="form-label required">{{__('Do you want to book your accommodation?')}}</label>
                                    <select name="hebergement" class="form-select" id="stade_entreprise" required>
                                             <option value="">{{__('Select')}}</option>      
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                </div>
                                 <div class="col-md-5">
                                    <label for="inputState" class="form-label required">{{__('Would you like to have a visa')}} ? </label>
                                    <select name="visa" class="form-select" id="stade_entreprise" required>
                                        <select name="presence" class="form-select" id="stade_entreprise" required>
                                        <option value="">{{__('Select')}}</option>      
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                </div>  
                                
                                <hr>
                         
                           
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label required">{{__('Are you interested in a special accompaniment kit containing welcome, transportation and accommodation in Ouagadougou and Koudougou?)}} </label>
                                    <select name="kit" class="form-select" id="" required>
                                        <option value="">{{__('Select')}}</option>      
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                </div>
                                <br>
                                
                                   <div class="col-md-12">
                                    <label for="inputState" class="form-label required">{{__('Are you interested in a booth?')}} </label>
                                    <select name="stand" class="form-select" id="" required>
                                        <option value="">{{__('Select')}}</option>      
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                </div>
                             
                        <br>
                        <br>
                        <button type="submit" class="btn btn-violet">{{__('Approve')}}</button>
                       </form>
                      
                      
                    </div>        
                </div>
                  
                </div>
			</div>
		</div>
		

		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>