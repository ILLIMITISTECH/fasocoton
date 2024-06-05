@include('forums.header2')

  
    <div class="row">

        <div class="col-lg-12 margin-tb">


            <div class="pull-right">

                <a class="btn btn-primary" href="/my_catalogues"> Retour</a>

            </div>

            <div class="pull-right" style="margin-top:20px;">


</div>

        </div>

    </div>

<div class="container">
            <center><h2 style="font-size:13px;">L'information de l'entreprise</h2></center>
                <div class="card">
                                    <div class="card-header" style="font-size:13px;"><b>Code Manifestation</b>  : <b style="color:green;">{{ $entreprise->code }}</b></div>

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

                <strong>Adresse de l'entreprise:</strong>

                {{ $entreprise->adresse }}

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

    <strong>Description de l'entreprise:</strong>

                {{ $entreprise->description }}

</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Vos Secteurs d'activités principal:</strong>

                {{ $entreprise->secteur_a }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Vos Secteurs d'activités secondaire:</strong>

                {{ $entreprise->secteur_b }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Vos Secteurs d'activités tertiaire:</strong>

                {{ $entreprise->secteur_c }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profile Entreprise principal:</strong>

                {{ $entreprise->profil_entreprise_a }}

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profile Entreprise secondaire:</strong>

                {{ $entreprise->profil_entreprise_b }}

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profile Entreprise tertiaire:</strong>

                {{ $entreprise->profil_entreprise_c }}

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

    <strong>Vos recherches de partenaires:</strong>

                {{ $entreprise->partenaire_rechercher }}

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

    <strong>Vous souhaitez rencontrer des partenaires dans
                         les secteurs d’activité  :</strong>

                {{ $entreprise->partenaire_rencontrer_a }}

</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Vous souhaitez rencontrer des partenaires dans
                         les secteurs d’activité  :</strong>

                {{ $entreprise->partenaire_rencontrer_b }}

</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Vous souhaitez rencontrer des partenaires dans
                         les secteurs d’activité  :</strong>

                {{ $entreprise->partenaire_rencontrer_c }}

</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profil(s) des partenaires recherchés :</strong>

                {{ $entreprise->profile_partenaire_rechercher_a }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profil(s) des partenaires recherchés :</strong>

                {{ $entreprise->profile_partenaire_rechercher_b }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Profil(s) des partenaires recherchés :</strong>

                {{ $entreprise->profile_partenaire_rechercher_c }}

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

        <strong>Civilité du participant:</strong>

        {{ $entreprise->identite }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

    <div class="form-group">

        <strong>Nom du participant:</strong>

        {{ $entreprise->nom }}

    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Prénom du participant:</strong>

        {{ $entreprise->prenom }}

</div>

</div>



<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Fonction du participant:</strong>

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Email du participant:</strong>

        {{ $entreprise->email }}

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12">


<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Téléphone Portable du participant:</strong>

        {{ $entreprise->portable }}

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Langue Principale:</strong>

        {{ $entreprise->langue }}

</div>

</div>

    </div>

     </div>
     </div>
     </div>

