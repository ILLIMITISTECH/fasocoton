
        @include('Admin/Dashboard.head')
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('Admin/Dashboard.headUser')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">   
        <!-- partial:partials/_sidebar.html -->
        @include('Admin/Dashboard.sideBarUser')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="bdc">
            <h4 class="card-title"style="margin-left:30px;"> <br>Créer une entreprise</h4>
          </div>
          <div class="col-12 grid-margin stretch-card" style="margin-top:-40px">
                <div class="card">
                  <div class="card-body">
                  <h6> 
                        @if (session('message'))
                        <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        </div>  
                        @endif
                    </h6>
                    <p class="card-description">Remplissez ce formulaire pour créer une entreprise</p>
                    <form action="{{route('entreprises.store')}}" method="post" class="forms-sample" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          
                          <div class="col-md-12 mt-4">
                                <label for="inputEmail4" class="form-label required"> <h5>Êtes-vous intréssée par les rendez-vous B2B<br> Check this box if you would like to have a meeting B2B  ?</h5> <!--Êtes-vous intréssée par les rendez-vous B2B<br> Check this box if you would like to have a meeting B2B-->  </label>
                               <!-- <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="rendez_vous" type="checkbox" value="AVEC un planning B 2 B" id="flexSwitchDefault"/>  
                                </div> -->  
                                <select name="rendez_vous" class="form-select" id="stade_entreprise" required>
                                        <option value="">séléctionner</option>      
                                        <option value="AVEC un planning B 2 B">OUI</option>
                                        <option value="SANS un planning B 2 B">NON</option>
                                    </select>
                             </div>
                             
                             <div class="col-md-12 mt-4">
                                <label for="inputEmail4" class="form-label required"> <h5>Êtes-vous intréssée par les rendez-vous B2G
<br> Check this box if you would like to have a meeting B2G(Business to Governement)
  ?</h5> <!--Êtes-vous intréssée par les rendez-vous B2B<br> Check this box if you would like to have a meeting B2B-->  </label>
                               <!-- <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="rendez_vous" type="checkbox" value="AVEC un planning B 2 B" id="flexSwitchDefault"/>  
                                </div> -->  
                                <select name="b2g" class="form-select" id="stade_entreprise" required>
                                        <option value="">séléctionner</option>      
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                             </div>
                             
                      <div class="form-group">
                        <label for="exampleInputName1">Nom de l'entreprise: (<span class="red">*</span>)</label>
                        <input type="text" class="form-control" name="nom_entreprise" placeholder="Name">
                      </div>
                     
                      <div class="form-group">
                                <label for="inputState" class="form-label required">Pays / Country :</label>
                                <select class="form-select" name="pays" id="stade_entreprise">
                                  <option value="">selectionner</option>
                                        @foreach($pays as $pay)  
                                        <option value="{{$pay->libelle_fr}}">{{$pay->libelle_fr}}</option>
                                        @endforeach
                                </select>                               
                            </div>
                            <br>
                            		 <div class="form-group">
                                        <label for="exampleInputName1" class="form-label required">Quel est votre fonction ? / What is your position ? </label>
                                        <input type="text" class="form-control" name="fonction" placeholder="Entrer la fonction">
                                     </div>
                                <br><br><br>
                                
                                                        <div class="row">
                              <div class="form-group col-md-6">
                                    <label>Secteurs d’activité de l’Entreprises / Company Sectors of activity :</label>
                                  <label for="exampleSelectGender">Secteur 1 : </label>
                                  <select name="secteur_a" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach  
                                  </select>

                                  <label for="exampleSelectGender">Secteur 2 : </label>
                                  <select name="secteur_b" class="form-control" id="stade_entreprise">
                                 
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach  
                                  </select>

                                  <label for="exampleSelectGender">Secteur 3 : </label>
                                  <select name="secteur_c" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach  
                                  </select>
                            </div>
                             <div class="form-group col-md-6">
                                    <label>Profil de l’Entreprise / Company Profile :</label>
                                   
                                  <label for="exampleSelectGender">Profil 1 : </label>
                                  <select name="profile_entreprise_a" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($profil as $profilss)  
                                        <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                  </select>

                                  <label for="exampleSelectGender">Profil  2 : </label>
                                  <select name="profile_entreprise_b" class="form-control" id="stade_entreprise">
                                 
                                  @foreach($profil as $profilss)  
                                        <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach  
                                  </select>

                                  <label for="exampleSelectGender">Profil  3 : </label>
                                  <select name="profile_entreprise_c" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($profil as $profilss)  
                                        <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach  
                                  </select>
                            </div>
                             
                          

                        </div> 

                             <hr>
                             <br><br><br>
                              <!--<div class="form-group">
                                <label for="inputEmail4" class="form-label required">Cochez cette case si vous souhaitez avoir un rendez-vous B2B / Check this box if you would like to have a meeting B2B  </label>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="rendez_vous" type="checkbox" value="AVEC un planning B 2 B" id="flexSwitchDefault"/>  
                                </div>                              
                             </div>-->
                             <br><br><br><br>
                                                    <div class="row">
                              <div class="form-group col-md-6">
                                    <label>Secteurs d’activité recherché :  / Sectors of activity sought  :</label>
                                  <label for="exampleSelectGender">Secteur 1 : </label>
                                  <select name="partenaire_rencontrer_a" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach
                                  </select>

                                  <label for="exampleSelectGender">Secteur 2 : </label>
                                  <select name="partenaire_rencontrer_b" class="form-control" id="stade_entreprise">
                                 
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach  
                                  </select>

                                  <label for="exampleSelectGender">Secteur 3 : </label>
                                  <select name="partenaire_rencontrer_c" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($secteur as $secteurs)  
                                    <option value="{{$secteurs->libelle}}">{{$secteurs->libelle}}</option>
                                    @endforeach  
                                  </select>
                            </div>


                            <div class="form-group col-md-6">
                                    <label>Profil  d’Entreprise recherché  / Company profile sought : :</label>
                                  <label for="exampleSelectGender">Profil 1 : </label>
                                  <select name="profile_partenaire_rechercher_a" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach
                                  </select>

                                  <label for="exampleSelectGender">Profil 2 : </label>
                                  <select name="profile_partenaire_rechercher_b" class="form-control" id="stade_entreprise">
                                 
                                  @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach 
                                  </select>

                                  <label for="exampleSelectGender">Profil 3 : </label>
                                  <select name="profile_partenaire_rechercher_c" class="form-control" id="stade_entreprise">
                                  
                                  @foreach($profil as $profilss)  
                                    <option value="{{$profilss->libelle}}">{{$profilss->libelle}}</option>
                                    @endforeach  
                                  </select>
                            </div>
                             
                          

                        </div> 
                        <br><br><br><br>
                              
                              <div class="form-group">
                                <label for="inputEmail4" class="form-label required">Plus de détails sur le type de partenaires recherché / More details on the type of partners sought :</label>
                                <textarea class="form-control" name="partenaire_rechercher" id="details-partenaires"rows="3"></textarea> 
                              </div>
                              <hr>
                           <div class="form-group">
                                <label for="inputEmail4" class="form-label">Ajouter des participants pour cette entreprise  / Add more participants for this company </label>
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
                                                    <label for="inputEmail4" class="form-label required">Prénom / First Name :</label>
                                                    <input type="text" name="prenom[]" class="form-control" id="inputEmail4">
                                                </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">Nom / Last Name : </label>
                                                    <input type="text" name="nom[]" class="form-control" id="inputEmail4" >
                                                </div> 
                                                <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">Email :  </label>
                                                    
                                                    <input type="email" name="email[]" class="form-control" id="inputEmail4" >
                                                </div> 
                                               
                                                     <div class="col-md-3">
                                                    <label for="inputEmail4" class="form-label required">Pays : </label>
                                                  
                                                        <select class="form-select" name="pays_id[]" id="stade_entreprise">
                                                          <option value="">selectionner</option>
                                                                @foreach($pays as $pay)  
                                                                <option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>
                                                                @endforeach
                                                        </select>       
                                                        </div>
                                                
                                                </div><br><br><br>
                                                <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" style="width:200px;" class="form-label required">Serez vous présent <br> sur place ? </label>
                                                     <select name="presence[]" class="form-select" id="stade_entreprise" required>
                                                      <option value="">selectionner</option>      
                                                            <option value="1">OUI</option>
                                                            <option value="0">NON</option>
                                                            </select>
                                                     <input type="hidden" style="width:20px;" name="profil[]" value="1" class="form-check-input" id="inputEmail4">
                                                </div> 
                                                 <div class="form-group col-md-2">
                                                     <button id="removeRow" type="button" class="btn" style="background:#808080; color:white" ><i class="bi bi-trash"></i> </button>
                                                </div>
                                                 </div>
                                                               
                                                    
                                            
                                            </div>
                                       
                                        <div id="newRow"></div>
                                        <button id="addRow" type="button" class="btn" style="background:#808080; color:white">Ajouter plus / Add more</button>
                                    </div>
                                </div>
                            </div>
                             <hr><br><br><br>
                            
                       <?php 
                            $even = DB::table('events')->where('status', '=', 1)->first();
                       ?>
                       <input class="form-control" value="{{$even->id}}" type="hidden" style="width:100%; height:50px; " name="event_id" placeholder="event">
                  
                      <button type="submit" class="btn mr-2"style="background:#F49800; color:white">Valider</button>
                      <a href="/entreprises" class="btn " style="background:#C92C2B; color:white">Quitter</a>
                    </form>
                  </div>
                </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
     <script type="text/javascript">
            // add row
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="input-group row mb-3">';
                html += ' <div class="col-md-3">';
                html += '<label for="inputEmail4" class="form-label ">Prénom / First Name :</label>';
                html += '<input type="text" name="prenom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += ' <div class="col-md-3">';
                html += '<label for="inputEmail4" class="form-label ">Prénom / First Name : </label>';
                html += '<input type="text" name="nom[]" class="form-control" id="inputEmail4">';
                html += ' </div> ';
                html += '<div class="col-md-3">'
                    html += ' <label for="inputEmail4" class="form-label ">Email : <</label>';
                    html += '<input type="email" name="email[]" class="form-control" id="inputEmail4">';
                    html += ' </div> ';
                     html += '<div class="col-md-3">'
                  html += '<label for="inputEmail4" class="form-label ">Pays : </label>';
                        html += '<select class="form-select" name="pays_id[]" id="stade_entreprise">';
                        html += '<option value="">selectionner</option>';
                        html += '@foreach($pays as $pay)';
                        html += '<option value="{{$pay->id}}">{{$pay->libelle_fr}}</option>';
                        html += '@endforeach';
                        html += '</select>';
                    html += '</div>';
                    html += '</div><br><br><br>';
                html += '<div class="row">'
                    html += '<div class="form-group col-md-6">';
                    html += '<label for="inputEmail4" style="width:200px;" class="form-label required">Serez vous présent <br> sur place ? </label>';
                                                      html += '<select name="presence[]" class="form-select" id="stade_entreprise" required>';  
                                                            html += '<option value="">selectionner</option>';
                                                            html += '<option value="1">OUI</option>';
                                                            html += '<option value="0">NON</option>';
                      html += '</select>';
                    html += '<input type="hidden" style="width:20px;" name="profil[]" value="1" class="form-check-input" id="inputEmail4"> </div> ';
                     
   
                    html += '</div>';            
                        html += '<div class="form-group col-md-2">';
                        html += ' <button id="removeRow" type="button" class="btn" style="background:#808080; color:white" ><i class="bi bi-trash"></i> </button>';
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
    @include('Admin/Dashboard.js')
  </body>
</html>