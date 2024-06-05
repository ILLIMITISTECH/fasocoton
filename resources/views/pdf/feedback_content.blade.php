<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Feedback</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('v2/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('v2/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body>


 
                <!-- end side bar -->
                <main id="main" class="main">

        <section class="section" style = "margin-left : 100px">
      <div class="row">
        <div class="col-lg-10">
          <div class="card">
            <div class="card-body">
<br><br> <div class="row">
						
							
					     		<div align="left" valign="top:10px"><span style="font-family: 'MarkOffcPro-Book', arial; color: #1561a2;; font-size: 38px; line-height: 24px; margin-left:10px;  margin-top:20px;">
                                <span class="outlookFallback">{{Auth::user()->prenom}}&nbsp;{{Auth::user()->nom}}</span></span>
                               
						    </div>
					     	</div><br>
						<!--<div  align="left" class="row align-items-left">
                        <div class="col-md-12 col-12 align-self-left">
                            <h2 class="page-title mb-0 p-0" style="text-align:center; font-family: 'MarkOffcPro-Book', arial; black;">Team Feedback Report - </h2>
                        </div>
                       </div>-->
                        <div class="row">
						
							
					     		<div align="left" valign="top:10px"><span style="font-family: 'MarkOffcPro-Book', arial; color: #1561a2;; font-size: 25px; line-height: 24px; margin-left:10px;  margin-top:20px;">
                                <span class="outlookFallback">Team Feedback Report</span></span>
                               
						    </div>
					     	</div>
                       <br><br>
                     <div class="row">
                     <div align="left" valign="top">
                         <span style="font-family: 'MarkOffcPro-Book', arial; black; font-size: 20px; line-height: 24px; margin-left:20px;">
                           <span class="outlookFallback" style="color:#1561a2;">Source :  <span style="font-size: 18px;"> @foreach($feedback as $feedbacks)
                                @php $source_nom = DB::table('source_feedbacks')->where('id', $feedbacks->source_id)->first(); @endphp
                                @endforeach
                                   </span></span> </span>@if(isset($source_nom))
                                        @if(($source_nom))
                                        {{$source_nom->nom_source}}
                                        @endif
                                    @endif<br><br>
						</div> 
                   
                  </div>  
				   
                        <div class="row align-items-center">
                          <div class="col-md-12 col-12 align-self-center">
                              <span style="font-family: 'MarkOffcPro-Book', arial; black; font-size: 20px; line-height: 24px; margin-left:20px;">
                           <span class="outlookFallback" style="color:#1561a2;"> Feedbacks Positifs : </span></span>
                            @foreach($feedback as $feedbacks)
                            @if($feedbacks)
                           <ol style="list-style-type: none;">
                             <li>{{ ($feedbacks->apprecier && $feedbacks->crypted) ? decrypt($feedbacks->apprecier) : ' '}}</li>
                             <!--<li>{{ ($feedbacks->apprecier_2 && $feedbacks->crypted) ? decrypt($feedbacks->apprecier_2) : ' '}}</li>
                             <li>{{ ($feedbacks->apprecier_3 && $feedbacks->crypted) ? decrypt($feedbacks->apprecier_3) : ' '}}</li>-->
                            </ol>
                            @endif
                            @endforeach
						   </div>
                    	</div>
                     
                     
      
                     <div class="row align-items-center">
                    <div class="col-md-12 col-12 align-self-center">
                        <span style="font-family: 'MarkOffcPro-Book', arial; color: black; font-size: 20px; line-height: 24px; margin-left:20px;">
                           <span class="outlookFallback" style="color:#1561a2;"> Feedbacks Constructifs : </span></span>
                     @foreach($feedback as $feedbacks)
                     @if($feedbacks)
                     <ol style="list-style-type: none;">
                     <li>{{ ($feedbacks->ameliorer && $feedbacks->crypted) ? decrypt($feedbacks->ameliorer)  : ' '}}</li>
                    <!-- <li>{{ ($feedbacks->ameliorer_2 && $feedbacks->crypted) ? decrypt($feedbacks->ameliorer_2)  : ' '}}</li>
                     <li>{{ ($feedbacks->ameliorer_3 && $feedbacks->crypted) ? decrypt($feedbacks->ameliorer_3)  : ' '}}</li>-->
                     </ol>
                     @endif
                    @endforeach
						</div>
						</div>
                 
   
                    </div>
                </div>
            </div>
        </div>
    </section>

                       <!-- end formulaire1 --> 
                       
                      

                            
                                       
                    
                    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        </main>
    </div>
 
 <style>
 
      .red{
            color :red;
            font-weight : bold;
        }
        .text-nice{
            font-family: 'poppins', sans-serif;
        }
        
        .btn-green {
            background-color : #43928E ;
            color : white;
        }
        .rounded-container{
            width: 586px;
            height: 526px;
            background: white;
            border-radius: 51px;
            margin-right : auto;
            text-align : center;
        }
</style>
 <script src="{{asset('assets/vendor/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
    
</body>
</html>

