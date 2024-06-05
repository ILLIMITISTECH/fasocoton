<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>OptiEvent| Détails participant</title>
		<meta name="description" content="Rider admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="keywords" content="Rider, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
		<link rel="canonical" href="Https://preview.keenthemes.com/rider-free" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('User/assets/media/optieventFavIcon.png')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('User/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
                    <div class="form-head mt-5">
                        <div class="text-center">
							<div class="progress-container">
								<ul class="progress-progressbar">
									<li>{{ __('Participant details') }}</li>
									<li class="active">{{ __('Company details') }}</li>
									<li>{{ __('Interests') }}</li>
									<!--<li>Finaliser l'inscription<br></li>-->
								</ul>
							</div>
                        </div>
                    </div>

					<div class="step-header text-left">
						<p>
						    {{ __('In order to suggest relevant meetings, we need more information about your information about your company and the type of partners you are looking for.') }}
						   
                        </p>
					</div>
					<div class="details-participant-box">	
					   <!-- <h3>Êtes-vous intréssée par les rendez-vous B2B<br> Check this box if you would like to have a meeting B2B  ?</h3> -->
                    <?php 
								$participants = DB::table('participants')->where('user_id', Auth::user()->id)->paginate(1);
							?>
							@foreach($participants as $participant)
							
							<!--<div class="row">
								    <div class="col-6">
								<form action="" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-violet px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
										        Oui
    											
    											<p class="fs-7">Je suis intéréssé</p>
    										</span>
                                        </button>
									</form>								</div>
								<div class="col-6">
									<form action="" method="post">
									{{ csrf_field() }}
									<button type="submit" class="btn btn-flex btn-orange px-6 button-response">
										<span class="d-flex flex-column align-items-start ms-2">
    									Non
    									<p class="fs-7">Je ne suis pas intéréssé</p>
    										</span>
									</button>
									</form>
								</div>
						    </div> -->
						    

						<form class="row g-3" action="{{route('fonction.participant', $participant->id)}}" method="post">
                        {{ csrf_field() }}
                        
                            
                              <div class="col-md-12 mt-4">
                                <label for="inputEmail4" class="form-label required"> <h5>{{ __('Would you like to have a B2B meeting?')}}</h5> <!--Êtes-vous intréssée par les rendez-vous B2B<br> Check this box if you would like to have a meeting B2B-->  </label>
                               <!-- <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="rendez_vous" type="checkbox" value="AVEC un planning B 2 B" id="flexSwitchDefault"/>  
                                </div> -->  
                                <select name="rendez_vous" class="form-select"  required>
                                        <option value="">{{ __('Select') }}</option>      
                                        <option  value="AVEC un planning B 2 B">{{ __('Yes') }}</option>
                                        <option value="SANS un planning B 2 B">{{ __('No') }}</option>
                                    </select>
                            
                     
                           
                             </div>
                             
                            <div class="col-md-8">
                              <label for="inputText" class="form-label required">Nom de l'Entreprise /Company name : </label>
                              <input type="text" name="nom_entreprise" class="form-control" id="inputText">
                            </div>
                    
                            <div class="col-md-4">
                                <label for="inputState" class="form-label required">{{ __('Country') }}:</label>
                                <select class="form-select" name="pays" id="stade_entreprise">
                                  <option value="">{{ __('Select') }}</option>
                                        @foreach($pays as $pay)  
                                        <option value="{{$pay->libelle_fr}}">{{$pay->libelle_fr}}</option>
                                        @endforeach
                                </select>                               
                            </div>
                            		 <div class="col-md-12">
                                        <label for="inputText" class="form-label ">{{ __('What is your position ?') }}:  </label>
                                        <input type="text" class="form-control" name="fonction" id="inputText" placeholder="Entrer la fonction">
                                     </div>
                                <br>

                              <label for="inputState" class="form-label required">{{ __('Company Sectors of activity') }}:</label>
                              <div class="col-md-4">
                                 <label for="inputState" class="form-label required"> {{ __('Sector 1') }}:  </label>
                                <select name="secteur_a" class="form-select" id="stade_entreprise" required>
                                <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                             <div class="col-md-4">
                                <label class="form-label "> {{ __('Sector 2') }} :  </label>
                                <select name="secteur_b" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                             
                              </div>
                              <div class="col-md-4">
                                <label class="form-label "> {{ __('Sector 3') }} :  </label>
                                <select name="secteur_c" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                             
                              </div>
                              <br>
                              
                              
                              <label for="inputState" class="form-label required">{{ __('Company Profile') }}:</label>
                              
                              <div class="col-md-4">
                                   <label for="inputState" class="form-label required"> {{ __('Profil 1') }} :  </label>
                                  <select name="profile_entreprise_a" class="form-select" id="stade_entreprise" required>
                                  <option value="">{{ __('Select') }}</option>      
                                  @foreach($profil as $profilss)  
                                        <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-4">
                                   <label class="form-label ">{{ __('Profil 2') }} :  </label>
                                  <select name="profile_entreprise_b" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <div class="col-md-4">
                                   <label class="form-label "> {{ __('Profil 3') }} :  </label>
                                  <select name="profile_entreprise_c" class="form-select" id="stade_entreprise">
                              <option value="">{{ __('Select') }}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <hr>
                              <br>
                               <div class="col-md-12">
                                    <label for="inputState" class="form-label required">« {{ __("Would you like to benefit from the Accommodation Pack for 500 euros which includes: reception and transport under security escort (arrival and departure) from Ouagadougou international airport to the hotel and vice versa; one night's accommodation in Ouagadougou and two nights in Koudougou; as well as breakfast for three days and lunch for two days?") }} O/N </label>
                                    <select name="kit" class="form-select" id="kit" required>
                                        <option value="">{{ __('Select') }}</option>      
                                        <option value="1">{{ __('Yes') }}</option>
                                        <option value="0">{{ __('No') }}</option>
                                    </select>
                                </div>
                            <div class="col-md-7" id="hebergement">
                                    <label for="inputState" class="form-label ">{{ __('Do you want to book your accommodation?') }}  </label>
                                    <select name="hebergement" class="form-select" id="stade_entreprise" >
                                        <option value="">{{ __('Select') }}</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                                 <div class="col-md-5">
                                    <label for="inputState" class="form-label required">{{ __('Would you like to have a visa?') }} </label>
                                    <select name="visa" class="form-select" id="stade_entreprise" required>
                                        <option value="">{{ __('Select') }}</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>  
                                
                                <hr>
                         
                             <br>
                             <br>
                                
                                   <div class="col-md-12" >
                                    <label for="inputState" class="form-label required">{{ __('Are you interested in a stand?') }} </label>
                                    <select name="stand" class="form-select" id="standid" required>
                                        <option value="">{{ __('Select') }}</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                             
                             
                             
                             
<fieldset id="stand">
  <legend>  {{ __('Choose a type of stand') }} :</legend>

  

  <div>
    <input type="radio"  name="stand_type" value="Stand Professionnel" />
    <label for="inputState" class="form-label " for="dewey">Stand Professionnel</label><br>{{ __('Date: Professional exhibition from January 26 to 27, 2024 Characteristics: 9 m2, air-conditioned, equipped with 1 TV, 1 table, 2 chairs Included: Exhibitor badge + 1 accompanying person, access to lunch Cost: 1,000,000 FCFA (€1,525)') }}
  </div>
  <br>
  <div>
    <input type="radio"  name="stand_type" value="Stand Foire Internationale" />
    <label for="dewey">Stand Foire Internationale</label><br>{{ __('Date: International fair from January 24 to 28, 2024 Characteristics: 9 m2, including 1 table, 1 chair Included: 2 exhibitor badges Cost: 50,000 FCFA (76 €)') }}
  </div>

</fieldset>
<style>
    p,
label {
  font:
    1rem 'Fira Sans',
    sans-serif;
}

input {
  margin: 0.4rem;
}
</style>
                            
                             
                              <hr>
                              
                               <br>
                             <br>
                             
                           <div class="col-md-12 mt-4">
                                <label for="inputEmail4" class="form-label required">Souhaitez-vous ajouter d’autres participants pour votre entreprise  / Do you want to add more participants for your company </label>
                                
                                 <select name="autre_participant" class="form-select" id="parti" required>
                                        <option value=""id="show">{{ __('Select') }}</option>      
                                        <option id="show" value="1">OUI</option>
                                        <option id="hide" value="0">NON</option>
                                    </select>
                        
                             </div>
                             
        <br>
                          <!-- Ajouter plusieurs participants -->
                          
                            <div class="row" id="formulaire">
                                <div class="card col-lg-12 mt-4 mb-10">
                                    <div class="card-body">
                                        <div id="inputFormRow">
                                            <div class="input-group row mb-3">
                                                <div class="col-md-8">
                                                    <label for="inputEmail4" class="form-label ">{{__('First name')}} </label>
                                                    <input type="text" name="prenom[]" class="form-control" id="inputEmail4">
                                                </div> 
                                                <div class="col-md-8">
                                                    <label for="inputEmail4" class="form-label ">{{__('Last name')}} </label>
                                                    <input type="text" name="nom[]" class="form-control" id="inputEmail4">
                                                </div> 
                                                <div class="col-md-8">
                                                    <label for="inputEmail4" class="form-label ">{{__('Email')}} : </label>
                                                    <input type="email" name="email[]" placeholder="example@gmail.com" class="form-control" id="inputEmail4">
                                                </div> 
                                                <div class="col-md-2 mt-10">                
                                                    <button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="newRow"></div>
                                        <button id="addRow" type="button" class="btn btn-info mt-5">{{__('Add more')}}</button>
                                    </div>
                                </div>
                            </div>
                            
						<div class="mt-5 col-12">
                            <button type="submit" class="btn btn-violet">{{__('Save and continue')}}</button>
                            @php
                                $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
                
                                if(!$entreprise)
                                    if(Auth::user()->need)
                                        echo "<a href='/homepreinscrits' class='btn btn-danger pull-left'>Quitter</a>";
                                    else
                                        echo "<a href='/' class='btn btn-danger pull-left'>Quitter</a>";

                            @endphp
                        </div>
						</form>
                          @endforeach

                
              </div>   
        </div>

                 

		<!--begin::Javascript-->
        <script type="text/javascript">
            // add row
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group row mb-3">';
                html += ' <div class="col-md-8">';
                html += '<label for="inputEmail4" class="form-label ">Prénom / First Name : </label>';
                html += '<input type="text" name="prenom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += ' <div class="col-md-8">';
                html += '<label for="inputEmail4" class="form-label ">Nom / First Name : </label>';
                html += '<input type="text" name="nom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += '<div class="col-md-8">'
                    html += ' <label for="inputEmail4" class="form-label ">Email : </label>';
                    html += '<input type="email" name="email[]" class="form-control" id="inputEmail4">';
                    html += ' </div> ';
   
                    html += ' <div class="col-md-2 pt-7">';            
                        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-trash"></i> </button>';
                        html += ' </div> ';
                        html += ' </div> ';
                        html += ' </div> ';
        
                $('#newRow').append(html);
            });
        
            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
        </script>
        <!--Multiselector Script-->
        <script>
        const getButton = document.getElementById('get');
        const multiInput = document.querySelector('multi-input'); 
        const values = document.querySelector('#values'); 
        
        getButton.onclick = () => {
          if (multiInput.getValues().length > 0) {
            values.textContent = `Got ${multiInput.getValues().join(' and ')}!`;
          } else {
            values.textContent = 'Got noone  :`^(.'; 
          }
        }
        
        document.querySelector('input').focus();

        </script>
        <!--Multiselector Script-->
        <script>
        class MultiInput extends HTMLElement {
  constructor() {
    super();
    // This is a hack :^(.
    // ::slotted(input)::-webkit-calendar-picker-indicator doesn't work in any browser.
    // ::slotted() with ::after doesn't work in Safari.
    this.innerHTML +=
    `<style>
    multi-input input::-webkit-calendar-picker-indicator {
      display: none;
    }
    /* NB use of pointer-events to only allow events from the × icon */
    multi-input div.item::after {
      color: black;
      content: '×';
      cursor: pointer;
      font-size: 18px;
      pointer-events: auto;
      position: absolute;
      right: 5px;
      top: -1px;
    }

    </style>`;
    this._shadowRoot = this.attachShadow({mode: 'open'});
    this._shadowRoot.innerHTML =
    `<style>
    :host {
      border: var(--multi-input-border, 1px solid #ddd);
      display: block;
      overflow: hidden;
      padding: 5px;
    }
    /* NB use of pointer-events to only allow events from the × icon */
    ::slotted(div.item) {
      background-color: var(--multi-input-item-bg-color, #dedede);
      border: var(--multi-input-item-border, 1px solid #ccc);
      border-radius: 2px;
      color: #222;
      display: inline-block;
      font-size: var(--multi-input-item-font-size, 14px);
      margin: 5px;
      padding: 2px 25px 2px 5px;
      pointer-events: none;
      position: relative;
      top: -1px;
    }
    /* NB pointer-events: none above */
    ::slotted(div.item:hover) {
      background-color: #eee;
      color: black;
    }
    ::slotted(input) {
      border: none;
      font-size: var(--multi-input-input-font-size, 14px);
      outline: none;
      padding: 10px 10px 10px 5px; 
    }
    </style>
    <slot></slot>`;

    this._datalist = this.querySelector('datalist');
    this._allowedValues = [];
    for (const option of this._datalist.options) {
      this._allowedValues.push(option.value);
    }

    this._input = this.querySelector('input');
    this._input.onblur = this._handleBlur.bind(this);
    this._input.oninput = this._handleInput.bind(this);
    this._input.onkeydown = (event) => {
      this._handleKeydown(event);
    };

    this._allowDuplicates = this.hasAttribute('allow-duplicates');
  }

  // Called by _handleKeydown() when the value of the input is an allowed value.
  _addItem(value) {
    this._input.value = '';
    const item = document.createElement('div');
    item.classList.add('item');
    item.textContent = value;
    this.insertBefore(item, this._input);
    item.onclick = () => {
      this._deleteItem(item);
    };

    // Remove value from datalist options and from _allowedValues array.
    // Value is added back if an item is deleted (see _deleteItem()).
    if (!this._allowDuplicates) {
      for (const option of this._datalist.options) {
        if (option.value === value) {
          option.remove();
        };
      }
      this._allowedValues =
      this._allowedValues.filter((item) => item !== value);
    }
  }

  // Called when the × icon is tapped/clicked or
  // by _handleKeydown() when Backspace is entered.
  _deleteItem(item) {
    const value = item.textContent;
    item.remove();
    // If duplicates aren't allowed, value is removed (in _addItem())
    // as a datalist option and from the _allowedValues array.
    // So — need to add it back here.
    if (!this._allowDuplicates) {
      const option = document.createElement('option');
      option.value = value;
      // Insert as first option seems reasonable...
      this._datalist.insertBefore(option, this._datalist.firstChild);
      this._allowedValues.push(value);
    }
  }

  // Avoid stray text remaining in the input element that's not in a div.item.
  _handleBlur() {
    this._input.value = '';
  }

  // Called when input text changes,
  // either by entering text or selecting a datalist option.
  _handleInput() {
    // Add a div.item, but only if the current value
    // of the input is an allowed value
    const value = this._input.value;
    if (this._allowedValues.includes(value)) {
      this._addItem(value);
    }
  }

  // Called when text is entered or keys pressed in the input element.
  _handleKeydown(event) {
    const itemToDelete = event.target.previousElementSibling;
    const value = this._input.value;
    // On Backspace, delete the div.item to the left of the input
    if (value ==='' && event.key === 'Backspace' && itemToDelete) {
      this._deleteItem(itemToDelete);
    // Add a div.item, but only if the current value
    // of the input is an allowed value
    } else if (this._allowedValues.includes(value)) {
      this._addItem(value);
    }
  }

  // Public method for getting item values as an array.
  getValues() {
    const values = [];
    const items = this.querySelectorAll('.item');
    for (const item of items) {
      values.push(item.textContent);
    }
    return values;
  }
}

window.customElements.define('multi-input', MultiInput);

            
        </script>

     
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		
		<script>
		    
                $(document).ready(function(){
                    $('#parti').on('change', function() {
                      if ( this.value == '1')
                      {
                        $("#formulaire").show();
                      }
                      else
                      {
                        $("#formulaire").hide();
                      }
                    });
                });
		</script>
		
			<script>
		    
                $(document).ready(function(){
                    $('#kit').on('change', function() {
                      if ( this.value == '0')
                      {
                        $("#hebergement").show();
                      }
                      else
                      {
                        $("#hebergement").hide();
                      }
                    });
                });
		</script>
		
		<script>
		    
                $(document).ready(function(){
                    $('#standid').on('change', function() {
                      if ( this.value == '0')
                      {
                        $("#stand").hide();
                      }
                      else
                      {
                        $("#stand").show();
                      }
                    });
                });
		</script>
		
		<script>
		    
                $(document).ready(function(){
                    $('#partib2g').on('change', function() {
                      if ( this.value == '1')
                      {
                        $("#officiel").show();
                      }
                      else
                      {
                        $("#officiel").hide();
                      }
                    });
                });
		</script>
		
		<script>
		    //$flexSwitchDefault
		    $("#formulaire").hide();
		    $("#hebergement").hide();
		    $("#stand").hide();
		    $("#officiel").hide();
		    //$(".form-check-input").hide();
		     $("#show").click(function(){
		         $("#formulaire").show();
		     });
		     
		     $("#hide").click(function(){
		         
		         $("#formulaire").hide();
		     });
		    
		</script>
	</body>
	<!--end::Body-->
</html>