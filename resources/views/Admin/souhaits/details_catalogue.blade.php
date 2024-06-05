@include('layout.adminlayout.template')


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
<div class="container"><br><br>
<td><a class="btn btn-fill"  style="color:white;background-color:#f49e31;border-radius:3px" href="/catalogues">Retour</a></td>

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
                      <h5 style="color:#4b2e99; margin-top:20px;">Détails de l'entreprise</h5>
    <div class="card-header" style="font-size:13px;"></b></div>
    <div class="card-body"> 

            <div class="row">

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Nom de l'entreprise:</strong>

        {{ $entreprise->nom_entreprise }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Pays de l'entreprise:</strong>

{{ $entreprise->pays }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Description de l'entreprise:</strong>

        {{ $entreprise->description }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos Secteurs d'activités 1:</strong>

        {{ $entreprise->secteur_a }}

</div>

<div class="form-group">

<strong>Vos Secteurs d'activités 2:</strong>

        {{ $entreprise->secteur_b }}

</div>

<div class="form-group">

<strong>Vos Secteurs d'activités 2:</strong>

        {{ $entreprise->secteur_c }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Profile Entreprise 1:</strong>

        {{ $entreprise->profile_entreprise_a }}

</div>

<div class="form-group">

<strong>Profile Entreprise 2:</strong>

        {{ $entreprise->profile_entreprise_b }}

</div>

<div class="form-group">

<strong>Profile Entreprise 3:</strong>

        {{ $entreprise->profile_entreprise_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos recherches de partenaires:</strong>

        {{ $entreprise->partenaire_rechercher }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 1 :</strong>

        {{ $entreprise->partenaire_rencontrer_a }}

</div>

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 2 :</strong>

        {{ $entreprise->partenaire_rencontrer_b }}

</div>

<div class="form-group">

<strong>Vous souhaitez rencontrer des partenaires dans
                 les secteurs d’activité 3 :</strong>

        {{ $entreprise->partenaire_rencontrer_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 1:</strong>

        {{ $entreprise->profile_partenaire_rechercher_a }}

</div>

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 2:</strong>

        {{ $entreprise->profile_partenaire_rechercher_b }}

</div>

<div class="form-group">

<strong>Profil(s) des partenaires recherchés 3:</strong>

        {{ $entreprise->profile_partenaire_rechercher_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Zones géographiques ciblées recherchés:</strong>

        {{ $entreprise->zone_geographie }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Alliances recherchées:</strong>

        {{ $entreprise->alliance_rechercher }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Je souhaite partciper au SICOT avec un planning de rendez-vous B 2 B:</strong>

{{ $entreprise->rendez_vous }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Langue Principale:</strong>

{{ $entreprise->langue_ent_2 }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Les événements auxquels vous souhaitez participer:</strong>

{{ $entreprise->evenement }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Adresse de l'entreprise:</strong>

        {{ $entreprise->adresse }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Téléphone de l'entreprise:</strong>

        {{ $entreprise->tel_entreprise }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Fax de l'entreprise:</strong>

{{ $entreprise->fax }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Email de l'entreprise:</strong>

        {{ $entreprise->email_entreprise }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Site de l'entreprise:</strong>

        {{ $entreprise->site }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Chiffre d'affaires(en F CFA) de l'entreprise:</strong>

        {{ $entreprise->chiffre_affaire }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Pourcentage de votre
chiffre d’affaires à l’export:</strong>

        {{ $entreprise->pourcentage }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Date de création de l'entreprise:</strong>

        {{ $entreprise->date_creation }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Nombre de salariés::</strong>

        {{ $entreprise->nombre_salaire }}

    </div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Vos principaux
produits, services,
savoir-faire,
marques, certifications…:</strong>

        {{ $entreprise->principaux_produit }}

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

</div>


   


