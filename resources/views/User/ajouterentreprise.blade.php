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
       <!--             <div class="form-head mt-5">-->
       <!--                 <div class="text-center">-->
							<!--<div class="progress-container">-->
							<!--	<ul class="progress-progressbar">-->
							<!--		<li>Détails participant</li>-->
							<!--		<li class="active">Détails entreprise</li>-->
							<!--		<li>Centres d’intérêts</li>-->
									<!--<li>Finaliser l'inscription<br></li>-->
							<!--	</ul>-->
							<!--</div>-->
       <!--                 </div>-->
       <!--             </div>-->

					<!--<div class="step-header text-left">-->
					<!--	<p>Remplissez ce formulaire pour ajouter une entreprise.-->
     <!--                   </p>-->
					<!--</div>-->
					<div class="details-participant-box">		
						<form class="row g-3" action="/entrepriseajoutD" method="post">
                        {{ csrf_field() }}
                            <div class="col-md-8">
                              <label for="inputEmail4" class="form-label required">{{__('Company name')}} : </label>
                              <input type="text" name="nom_entreprise" class="form-control" id="inputEmail4">
                            </div>
                    
                            <div class="col-md-4">
                                <label for="inputState" class="form-label required">{{__('Country')}} :</label>
                                <select class="form-select" name="pays" id="stade_entreprise">
                                  <option value="">{{__('Select')}}</option>
                                        @foreach($pays as $pay)  
                                        <option value="{{$pay->libelle_fr}}">{{$pay->libelle_fr}}</option>
                                        @endforeach
                                </select>                               
                            </div>
                            		 <div class="col-md-12">
                                        <label for="inputEmail4" class="form-label ">{{__('What is your position ?')}} </label>
                                        <input type="text" class="form-control" name="fonction" id="inputEmail4" placeholder="Entrer la fonction">
                                     </div>
                                <br>

                              <label for="inputState" class="form-label">{{__('Company Sectors of activity')}} :</label>
                              <div class="col-md-4">
                                 <label class="form-label ">{{__('Sector 1')}}  :  </label>
                                <select name="secteur_a" class="form-select" id="stade_entreprise">
                                <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                             <div class="col-md-4">
                                <label class="form-label ">{{__('Sector 2')}} :  </label>
                                <select name="secteur_b" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                             
                              </div>
                              <div class="col-md-4">
                                <label class="form-label ">{{__('Sector 3')}} :  </label>
                                <select name="secteur_c" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                    </select>
                             
                              </div>
                              <br>
                              
                              
                              <label for="inputState" class="form-label">{{__('Company Profile')}} :</label>
                              
                              <div class="col-md-4">
                                   <label class="form-label ">{{__('Profile 1')}} :  </label>
                                  <select name="profile_entreprise_a" class="form-select" id="stade_entreprise">
                                  <option value="">{{__('Select')}}</option>      
                                  @foreach($profil as $profilss)  
                                        <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-4">
                                   <label class="form-label ">{{__('Profile 2')}} :  </label>
                                  <select name="profile_entreprise_b" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <div class="col-md-4">
                                   <label class="form-label ">{{__('Profile 3')}} :  </label>
                                  <select name="profile_entreprise_c" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                 </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              
                           
                              <hr>
                                        <!--<div class="col-md-12 mt-4">
                                        <label for="inputEmail4" class="form-label required">{{__('Check this box if you would like to have a meeting B2B')}}</label>
                                          <div class="form-check form-switch form-check-custom form-check-solid">
        
                                            <select name="rendez_vous" class="form-select" id="stade_entreprise" required>
                                              <option value="">{{__('Select')}}</option>      
                                              <option value="1">{{__('Yes')}}</option>   
                                              <option value="0">{{__('No')}}</option>   
                                             </select>
                                          </div>                              
                                        </div>-->
                             <br>
                             <label for="inputState" class="form-label required">{{__('Sectors of activity sought')}} :</label>
                              <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label "> {{__('Sector 1')}} :  </label>
                                     <select name="partenaire_rencontrer_a" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                               <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label ">{{__('Sector 2')}} :  </label>
                                     <select name="partenaire_rencontrer_b" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                               <div class="col-md-4">
                              <!--<multi-input>-->
                              <!--    <input list="speaker" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="secteur_activite_rechercher" id="stade_entreprise">
                                    <datalist id="speaker" value ="">-->
                                    <label class="form-label "> {{__('Sector 3')}} :  </label>
                                     <select name="partenaire_rencontrer_c" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                     </select>
                                <!--      </datalist>-->
                                <!--</multi-input>-->
                              </div>
                              <br><br><br><br><br><br>
                              <label for="inputState" class="form-label required">{{__('Company profile sought')}}: </label>
                             <div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label ">{{__('Pofile 1')}}:  </label>
                                  <select name="profile_partenaire_rechercher_a" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              <div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label "> {{__('Pofile 2')}} :  </label>
                                  <select name="profile_partenaire_rechercher_b" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div><div class="col-md-4"><multi-input>
                                  <!--<input list="ba" placeholder="Sélectionner /Choose ..." style ="min-width : 500px;"class="form-select" name="profile_entreprise_rechercher" id="stade_entreprise">-->
                                  <!-- <datalist id="ba" value ="">-->
                                   <label class="form-label "> {{__('Pofile 3')}} :  </label>
                                  <select name="profile_partenaire_rechercher_c" class="form-select" id="stade_entreprise">
                              <option value="">{{__('Select')}}</option>      
                              @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                    </select>
                              <!--</datalist>-->
                              <!--  </multi-input>-->
                              </div>
                              
                              <div class="col-md-12">
                                <label for="inputEmail4" class="form-label required">{{__('More details on the type of partners sought')}} :</label>
                                <textarea class="form-control" name="partenaire_rechercher" id="details-partenaires"rows="3"></textarea> 
                              </div>
                              <hr>
                           <div class="col-md-12 mt-4">
                                <label for="inputEmail4" class="form-label">{{__('Add more participants for this company')}} </label>
                                <br>  <br>
                               <!--  <div class="fg" style="display:flex;">
                                     
                                <div  style="margin-top:5px;" class="form-check form-switch form-check-custom form-check-solid" id="g">
                                    <p><b>OUI</b></p>
                                    <input style="margin-top:5px;" class="form-check-input" name="autre_participant" type="radio" value="1" id="show"/>  
                                </div>  
                                
                                <div  style="margin-top:5px; margin-left:10px;" class="form-check form-switch form-check-custom form-check-solid" id="f">
                                    <p><b>NON</b></p>
                                    <input style="margin-top:5px;" class="form-check-input" name="autre_participant" type="radio" value="1" id="hide"/>  
                                </div> 
                                
                              </div>   -->
                                
                                
                             </div>
                             
        
                          <!-- Ajouter plusieurs participants -->
                          
                            <div class="row" id="formulairess">
                                <div class="card col-lg-12">
                                    <div class="card-body">
                                        <div id="inputFormRow">
                                            <div class="input-group row mb-3">
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">{{__('First name')}} : </label>
                                                    <input type="text" name="prenom[]" class="form-control" id="inputEmail4" required>
                                                </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">{{__('Last name')}} : </label>
                                                    <input type="text" name="nom[]" class="form-control" id="inputEmail4" required>
                                                </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">{{__('E-mail')}} : </label>
                                                    <br><br>
                                                    <input type="email" name="email[]"  class="form-control" id="inputEmail4" required>
                                                </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">{{__('Country')}} : </label>
                                                    <br><br>
                                                        <select class="form-select" name="pays_id[]" id="stade_entreprise">
                                                          <option value="">{{__('Select')}}</option>
                                                                @foreach($pays as $pay)  
                                                                <option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>
                                                                @endforeach
                                                        </select>       
                                                        </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" style="width:200px;" class="form-label required">{{__('Will you be present')}} <br>{{__('on site')}} ? </label>
                                                     <select name="presence[]" class="form-select" id="stade_entreprise" required>
                                                      <option value="">{{__('Select')}}</option>      
                                                            <option value="1">{{__('Yes')}}</option>
                                                            <option value="0">{{__('Yes')}}</option>
                                                            </select>
                                                     <input type="hidden" style="width:20px;" name="profil[]" value="1" class="form-check-input" id="inputEmail4">
                                                </div>
                                                <div class="col-md-2 pt-7">                
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
                            <button type="submit" class="btn btn-violet">{{__('Continue')}} </button>
                            <!--<a href="/inscriptionstep0"><button type="button" class="btn btn-danger">Quitter</button></a>-->
                        </div>
						</form>
                      

                
                      
            </div>
        </div>

                
                </div>

		<!--begin::Javascript-->
        <script type="text/javascript">
            // add row
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group row mb-3">';
                html += ' <div class="col-md-3">';
                html += '<label for="inputEmail4" class="form-label ">Prénom / First Name : <span style="color:red">*</span></label>';
                html += '<input type="text" name="prenom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += ' <div class="col-md-3">';
                html += '<label for="inputEmail4" class="form-label ">Nom / First Name : <span style="color:red">*</span></label>';
                html += '<input type="text" name="nom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += '<div class="col-md-3">'
                    html += ' <label for="inputEmail4" class="form-label ">Email : <span style="color:red">*</span></label><br><br>';
                    html += '<input type="email" name="email[]"  class="form-control" id="inputEmail4">';
                    html += ' </div> ';
                    html += '<div class="col-md-3">';
                    html += '<label for="inputEmail4" class="form-label ">Pays : <span style="color:red">*</span></label>';
                        html += '<select class="form-select" name="pays_id" id="stade_entreprise">';
                        html += '<option value="">selectionner</option>';
                        html += '@foreach($pays as $pay)';
                        html += '<option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>';
                        html += '@endforeach';
                        html += '</select>';
                    html += '</div>';
                html += '<div class="col-md-3">'
                    html += ' <label for="inputEmail4" style="width:200px;" class="form-label ">Serez vous présent <br> sur place ? <span style="color:red">*</span></label>';
                    html += '<select name="presence[]" class="form-select" id="stade_entreprise">';
                                                      html += '<option value="">selectionner</option>';  
                                                            html += '<option value="1">OUI</option>';
                                                            html += '<option value="0">NON</option>';
                                                            html += '</select>';
                      html += '<input type="hidden" name="profil[]" value="0" class="form-check-input" id="inputEmail4">';
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
		    //$flexSwitchDefault
		    $("#formulaire").hide();
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