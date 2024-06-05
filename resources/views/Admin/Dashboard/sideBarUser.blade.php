

      <!-- partial:partials/_navbar.html -->
      
      <!-- partial -->
      

        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/homes">
                <span class="menu-title">Tabeau de bord</span>
                <i class="mdi mdi-home menu-icon"style="background:#F49800; color:white;"></i>
              </a>
            </li>
            
              <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#Organisateurs" aria-expanded="false" aria-controls="Organisateurs">
                <span class="menu-title">Organisateurs</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="Organisateurs">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="{{route('organisateurs.index')}}">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{route('organisateurs.create')}}">Ajouter</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#evenements" aria-expanded="false" aria-controls="evenements">
                <span class="menu-title">Évènements</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-calendar menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="evenements">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/events/create">Ajouter</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/events">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/configurer">Configurer</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#actives" aria-expanded="false" aria-controls="actives">
                <span class="menu-title">Activités</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-ballot-recount menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="actives">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/activites">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/activites/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#secteurs-activites" aria-expanded="false" aria-controls="secteurs-activites">
                <span class="menu-title">Secteurs d'activités</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-google-circles-group menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="secteurs-activites">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/secteuractivites">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/secteuractivites/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#profils" aria-expanded="false" aria-controls="profils">
                <span class="menu-title">Profils</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-box menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="profils">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/profils"> </i> </i></i></i></i></i></i></i></i></i></i>Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="profils/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#entreprises" aria-expanded="false" aria-controls="entreprises">
                <span class="menu-title">Qualité des données B2B</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-home-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="entreprises">
                <ul class="nav flex-column">
                  <!--<li class="nav-item"> <a class="nav-link" href="/EntrepriseB2BnonRenseignedescription">  B2B non renseigné description</a></li>-->
                  <li class="nav-item"> <a class="nav-link" href="/EntrepriseB2BnonRenseignepartenaire">B2B non renseigné partenaire rechercher</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/EntrepriseB2BnonRenseigneprofil">  B2B non renseigné profil rechercher</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/EntrepriseB2BnonRenseigneSendMail">Send Mail</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#entreprises" aria-expanded="false" aria-controls="entreprises">
                <span class="menu-title">Entreprises</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-home-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="entreprises">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/entreprises">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/entreprises/create">Ajouter</a></li>
                  <!--<li class="nav-item"> <a class="nav-link" href="/demandeB2BDemander">  Demande B2B</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/demandeVisaDemander">  Demande Visa</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/demandeKitDemander">  Demande Kit</a></li>-->
                  <li class="nav-item"> <a class="nav-link" href="/participant_stand">  Demande Stand</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/participant_badge">  Demande Badge</a></li>
                  <!--<li class="nav-item"> <a class="nav-link" href="/demandeHebergementDemander">  Demande d'hebergement</a></li>-->
                </ul>
              </div>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#participants" aria-expanded="false" aria-controls="participants">
                <span class="menu-title">Participants</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="participants">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/participants">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/participants/create">Ajouter</a></li>
                  
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#intervenants" aria-expanded="false" aria-controls="intervenants">
                <span class="menu-title">Intervenants</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="intervenants">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/intervenants">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/intervenants/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#facilitateurs" aria-expanded="false" aria-controls="facilitateurs">
                <span class="menu-title">Facilitateurs</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="facilitateurs">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/facilitateurs">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/facilitateurs/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
        <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#delegations" aria-expanded="false" aria-controls="delegations">
                <span class="menu-title">Délégations</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="delegations">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/chefdelegations">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/chefdelegations/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#plannings" aria-expanded="false" aria-controls="plannings">
                <span class="menu-title">Plannings</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="plannings">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/adminplannings">  Lister</a></li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#demandeB2G" aria-expanded="false" aria-controls="demandeB2G">
                <span class="menu-title">Demande B2G</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="demandeB2G">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/demandeB2G">  Lister</a></li>
                </ul>
              </div>
            </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#sponsors" aria-expanded="false" aria-controls="sponsors">
                <span class="menu-title">Sponsor</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="sponsors">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/sponsors">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/sponsors/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#traducteurs" aria-expanded="false" aria-controls="traducteurs">
                <span class="menu-title">Traducteur</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="traducteurs">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/traducteurs">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/traducteurs/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#hotels" aria-expanded="false" aria-controls="hotels">
                <span class="menu-title">Hotel</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="hotels">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/hotels">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/hotels/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#chambres" aria-expanded="false" aria-controls="chambres">
                <span class="menu-title">Chambre</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="chambres">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/chambres">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/chambres/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
              <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#types" aria-expanded="false" aria-controls="types">
                <span class="menu-title">Type</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="types">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/types">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/types/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#officiels" aria-expanded="false" aria-controls="officiels">
                <span class="menu-title">Officiels</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="officiels">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/officiels">  Lister</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/officiels/create">Ajouter</a></li>
                </ul>
              </div>
            </li>
            
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#exposants" aria-expanded="false" aria-controls="exposants">
                <span class="menu-title">Exposants</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="officiels">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/listerExposants">  Lister</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#rendz-vous.B2B" aria-expanded="false" aria-controls="rendz-vous.B2B">
                <span class="menu-title">Rendez-vous</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-briefcase-check menu-icon" style="background:#F49800; color:white;"></i>
              </a>
              <div class="collapse" id="rendz-vous.B2B">
                <ul class="nav flex-column">
                  <li class="nav-item"> <a class="nav-link" href="/rendz-vous.B2B">  B2B</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/rendz-vous.B2G"> B2G</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/crenaux"> Creneaux</a></li>
                </ul>
              </div>
            </li>
            
           <!-- <li class="nav-item">
              <a class="nav-link" href="/demandeVisa">
                <span class="menu-title">Demande de Visa</span>
                <i class="mdi mdi-home menu-icon"style="background:#F49800; color:white;"></i>
              </a>
            </li> -->
            
            <li class="nav-item">
              <a class="nav-link" href="/newletters">
                <span class="menu-title">Newletter</span>
                <i class="mdi mdi-gmail menu-icon" style="background:#F49800; color:white;"></i>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/parametres">
                <span class="menu-title">Parametre</span>
                <i class="mdi mdi-brightness-7 menu-icon"style="background:#F49800; color:white;"></i>
              </a>
            </li>
            
           
       
          </ul>
        </nav>
        <!-- partial -->
      
       