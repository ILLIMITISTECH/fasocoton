<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>Optievent | Tableau de Bord</title>
		
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('User/assets/media/optieventFavIcon.png')}}"/>
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<link rel="stylesheet" href="sweetalert.css"/>
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('User/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('User/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	@php
	$read_qr = true;
	    if(!$read_qr){
        	$langue_id = Auth::user()->langue_id;
        	if($langue_id){
        	    $language = DB::table('langues')
        	                ->select('langues.libelle_eng')
        	                ->where('langues.id',$langue_id)
        	                ->first();
        	    $language = $language->libelle_eng;
        	   if($language == "Francais" || $language == "Anglais" ){
        	       
        	       if($language == "Francais")
        	           $langue = 'fr';
        	       else
        	           $langue = 'en'; 
        	           
                   App::setLocale($langue); 
               }
        	}
        }
	@endphp