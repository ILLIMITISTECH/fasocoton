@include('forums.header1')


    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>
  
            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach
         
            </ul>

        </div>

    @endif



    
    
  
<center>@if ($message = Session::get('success'))

<div class="alert alert-success">

    <p>{{ $message }}</p>

</div></center>

@endif
<div class="container"><br>
<p><a class="btn btn-default" href="/suggesstion">Retour</a></p>

<h6> @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messagesss'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messagesss') }}
                        </div>
                    @endif</h6>

                    <h6> @if (session('messages'))
                        <div class="alert alert-success" role="alert">
                            {{ session('messages') }}
                        </div>
                    @endif</h6>
                      <div class="card">
                      <h3 style="color:#4b2e99; margin-top:20px;">Détails de l'entreprise</h3>
    <div class="card-header" style="font-size:13px;"></b></div>
    <div class="card-body"> 

            <div class="row">

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Nom de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->nom_entreprise }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Pays de l'entreprise:</strong>

{{ $souhait->entreprise_rv->pays }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Description de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->description }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos Secteurs d'activités 1:</strong>

        {{ $souhait->entreprise_rv->secteur_a }}

</div>

<div class="form-group">

<strong>Vos Secteurs d'activités 2:</strong>

        {{ $souhait->entreprise_rv->secteur_b }}

</div>

<div class="form-group">

<strong>Vos Secteurs d'activités 2:</strong>

        {{ $souhait->entreprise_rv->secteur_c }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Profile Entreprise 1:</strong>

        {{ $souhait->entreprise_rv->profile_entreprise_a }}

</div>

<div class="form-group">

<strong>Profile Entreprise 2:</strong>

        {{ $souhait->entreprise_rv->profile_entreprise_b }}

</div>

<div class="form-group">

<strong>Profile Entreprise 3:</strong>

        {{ $souhait->entreprise_rv->profile_entreprise_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos recherches de partenaires:</strong>

        {{ $souhait->entreprise_rv->partenaire_rechercher }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 1 :</strong>

        {{ $souhait->entreprise_rv->partenaire_rencontrer_a }}

</div>

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 2 :</strong>

        {{ $souhait->entreprise_rv->partenaire_rencontrer_b }}

</div>

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 3 :</strong>

        {{ $souhait->entreprise_rv->partenaire_rencontrer_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 1:</strong>

        {{ $souhait->entreprise_rv->profile_partenaire_rechercher_a }}

</div>

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 2:</strong>

        {{ $souhait->entreprise_rv->profile_partenaire_rechercher_b }}

</div>

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 3:</strong>

        {{ $souhait->entreprise_rv->profile_partenaire_rechercher_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Zones géographiques ciblées recherchés:</strong>

        {{ $souhait->entreprise_rv->zone_geographie }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Alliances recherchées:</strong>

        {{ $souhait->entreprise_rv->alliance_rechercher }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Je souhaite partciper au SICOT avec un planning de rendez-vous B 2 B:</strong>

{{ $souhait->entreprise_rv->rendez_vous }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Langue Principale:</strong>

{{ $souhait->entreprise_rv->langue_ent_2 }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Les événements auxquels vous souhaitez participer:</strong>

{{ $souhait->entreprise_rv->evenement }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Adresse de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->adresse }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Téléphone de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->tel_entreprise }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Fax de l'entreprise:</strong>

{{ $souhait->entreprise_rv->fax }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Email de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->email_entreprise }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Site de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->site }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Chiffre d'affaires(en F CFA) de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->chiffre_affaire }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Pourcentage de votre
chiffre d’affaires à l’export:</strong>

        {{ $souhait->entreprise_rv->pourcentage }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Date de création de l'entreprise:</strong>

        {{ $souhait->entreprise_rv->date_creation }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Nombre de salariés::</strong>

        {{ $souhait->entreprise_rv->nombre_salaire }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos principaux
produits, services,
savoir-faire,
marques, certifications…:</strong>

        {{ $souhait->entreprise_rv->principaux_produit }}

</div>

</div>


    <div class="card-footer"></div>
  </div>
  <script src="{{asset('build/js/intlTelInput.js')}}"></script>
  <script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      utilsScript: "build/js/utils.js",
    });
  </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>
$(document).ready(function(){

@foreach($souhaits as $souhait)

$("#loginStatus{{$souhait->id}}").change(function(){  
var status = $("#loginStatus{{$souhait->id}}").val();
var souhaitID = $("#souhaitID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait")}}',
data: 'status=' + status + '&souhaitID=' + souhaitID,
type: 'get',
success:function(response){
console.log(response);
}
});
}

});

$("#loginnStatus{{$souhait->id}}").change(function(){  
var status = $("#loginnStatus{{$souhait->id}}").val();
var souhaitID = $("#souhaitID{{$souhait->id}}").val()
if(status==""){
alert("please select an option");
}else{
$.ajax({
url: '{{url("/admin/banSouhait")}}',
data: 'status=' + status + '&souhaitID=' + souhaitID,
type: 'get',
success:function(response){
console.log(response);
}
});
}

});
@endforeach
});
</script>
   
</div>


   


