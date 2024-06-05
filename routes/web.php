<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/uppassword', function () {
    $password = Hash::make("12kafou34");
    DB::table('users')->where('email', 'kafouyat@gmail.com')->update(['password' => $password]);
    dd('ok');
}); 
Route::get('/mon_planning/pdf', 'App\Http\Controllers\PlanningController@createPDF');
Route::get('/mail-rappel', 'App\Http\Controllers\PlanningController@mail_rappel');

Route::get('/mail-rappel-participant', 'App\Http\Controllers\PlanningController@mail_rappel_participant');

Route::get('/ajouterParticipantSecondaire', 'App\Http\Controllers\EventController@ajouterParticipantSecondaire');
Route::get('/showEntreprise/{id}', 'App\Http\Controllers\EventController@showEntreprise')->name('showEntreprise');

Route::get('/EntrepriseB2BnonRenseignedescription', 'App\Http\Controllers\EventController@EntrepriseB2BnonRenseignedescription');
Route::get('/EntrepriseB2BnonRenseignepartenaire', 'App\Http\Controllers\EventController@EntrepriseB2BnonRenseignepartenaire');
Route::get('/EntrepriseB2BnonRenseigneprofil', 'App\Http\Controllers\EventController@EntrepriseB2BnonRenseigneprofil');
Route::get('/EntrepriseB2BnonRenseigneSendMail', 'App\Http\Controllers\EventController@EntrepriseB2BnonRenseigneSendMail');

Route::get('/plan_traducteur', 'App\Http\Controllers\EventController@plan_traducteur');
Route::get('/check_traducteur', 'App\Http\Controllers\EventController@check_traducteur');

Route::get('/', function () {
    return view('User.login');
})->name('garden');
Route::post('/logout', function () {
Auth::logout();
return redirect(route('garden'));
})->name('logout');
Route::get('/inscriptions', 'App\Http\Controllers\InscriptionController@inscription');
Route::get('/inscription', 'App\Http\Controllers\InscriptionController@inscriptionSansEnt');
Route::post('/inscriptionSansEnt', 'App\Http\Controllers\InscriptionController@inscriptionSansEntre')->name('inscription.SansEnt');

Route::get('/choice', 'App\Http\Controllers\EntrepriseController@choice');

Route::group(['middleware' => 'Connecter'], function(){
Route::get('/homes', 'App\Http\Controllers\InscriptionController@index');

Route::resource('/entreprises', 'App\Http\Controllers\EntrepriseController');



Route::resource('/achattickets', 'App\Http\Controllers\AchatTicketController');

Route::resource('/activites', 'App\Http\Controllers\ActiviteController');

Route::resource('/categories', 'App\Http\Controllers\CategorieController');

Route::resource('/chefdelegations', 'App\Http\Controllers\ChefDelegationController');

Route::resource('/delegations', 'App\Http\Controllers\ChefDelegationController@delegation');

Route::resource('/creneaux', 'App\Http\Controllers\CreneauController');

Route::resource('/events', 'App\Http\Controllers\EventController');

Route::get('/configurer', 'App\Http\Controllers\EventController@configurer');

Route::resource('/facilitateurs', 'App\Http\Controllers\FacilitateurController');

Route::resource('/hotels', 'App\Http\Controllers\HotelController');

Route::resource('/chambres', 'App\Http\Controllers\ChambreController');

Route::resource('/indisponibiliteparticipants', 'App\Http\Controllers\IndisponibiliteParticipantController');

Route::resource('/intervenants', 'App\Http\Controllers\IntervenantController');

Route::resource('/langues', 'App\Http\Controllers\LangueController');
Route::resource('/messages', 'App\Http\Controllers\MessageController');

Route::get('/participant_stand', 'App\Http\Controllers\ParticipantController@participant_stand');
Route::get('/participant_badge', 'App\Http\Controllers\ParticipantController@participant_badge');
Route::delete('/destroy_participantStand/{id}', 'App\Http\Controllers\ParticipantController@destroy_participantStand')->name('destroy_participantStand');
Route::get('/editStand/{id}', 'App\Http\Controllers\ParticipantController@editStand')->name('stand.edit');
Route::post('/updateStand/{id}', 'App\Http\Controllers\ParticipantController@updateStand')->name('stand.update');
// Route::get('/participant_village', 'App\Http\Controllers\ParticipantController@participant_village');


Route::get('/newletters', 'App\Http\Controllers\MessageController@newletter');
Route::post('/newletters', 'App\Http\Controllers\MessageController@newletters')->name('newletters.messages');

Route::resource('/organisateurs', 'App\Http\Controllers\OrganisateurController');

Route::resource('/participants', 'App\Http\Controllers\ParticipantController');
Route::get('/choix', 'App\Http\Controllers\ParticipantController@choix');

Route::get('/rendz-vous.B2B', 'App\Http\Controllers\RendezVousController@B2B');
Route::get('/rendz-vous.B2G', 'App\Http\Controllers\RendezVousController@B2G');

Route::resource('/passes', 'App\Http\Controllers\PasseController');

Route::get('/pricings', 'App\Http\Controllers\PasseController@pricing');

Route::resource('/pays', 'App\Http\Controllers\PaysController');

Route::resource('/produits', 'App\Http\Controllers\ProduitController');

Route::resource('/profils', 'App\Http\Controllers\profilController');

Route::resource('/traducteurs', 'App\Http\Controllers\TraducteurController');

Route::resource('/publicites', 'App\Http\Controllers\PubliciteController');
Route::get('/espacepublicitaires', 'App\Http\Controllers\PubliciteController@pub');

Route::get('/statistiques', 'App\Http\Controllers\EventController@statistique');

Route::resource('/salles', 'App\Http\Controllers\SalleController');

Route::resource('/secteuractivites', 'App\Http\Controllers\SecteurActiviteController');

Route::resource('/sejourparticipants', 'App\Http\Controllers\SejourParticipantController');

Route::resource('/souscriptions', 'App\Http\Controllers\SouscriptionController');

Route::resource('/sponsors', 'App\Http\Controllers\SponsorController');

Route::resource('/tables', 'App\Http\Controllers\TableController');

Route::resource('/types', 'App\Http\Controllers\TypeController');

Route::resource('/users', 'App\Http\Controllers\UserController');
Route::get('/parametres', 'App\Http\Controllers\UserController@parametre');
Route::post('/userparticipants', 'App\Http\Controllers\ParticipantController@userparticipant');
Route::post('/presenceparticipants/{id}', 'App\Http\Controllers\ParticipantController@presenceparticipant')->name('presence.participant');
Route::post('/presenceparticipantnons/{id}', 'App\Http\Controllers\ParticipantController@presenceparticipantnon')->name('presence.participantnon');
Route::post('/inscriptionentreprises/{id}', 'App\Http\Controllers\EntrepriseController@inscriptionentreprise')->name('inscription.entreprise');
Route::post('/secteur/profil/{id}', 'App\Http\Controllers\EntrepriseController@secteurrechercher')->name('secteur.profil');
Route::post('/secteur/profilvisit/{id}', 'App\Http\Controllers\EntrepriseController@secteurrecherchervisit')->name('secteur.profilvisit');
Route::post('/fonction/{id}', 'App\Http\Controllers\EntrepriseController@fonction')->name('fonction.participant');
Route::post('/fonctionvisit/{id}', 'App\Http\Controllers\EntrepriseController@fonctionvisit')->name('fonctionvisit.participant');

Route::resource('/voyages', 'App\Http\Controllers\VoyageController');

Route::get('/demandeVisa', 'App\Http\Controllers\VoyageController@demandeVisa');

Route::get('/confirmations', 'App\Http\Controllers\InscriptionController@confirmations');

Route::get('/connexions', 'App\Http\Controllers\InscriptionController@connexion');

Route::get('/homepsecondaires', 'App\Http\Controllers\InscriptionController@homepsecondaire');

Route::get('/home', 'App\Http\Controllers\InscriptionController@homeinscription');
Route::get('/homess', 'App\Http\Controllers\ParticipantController@participantsecond');
Route::get('/home_membre', 'App\Http\Controllers\QRcodeController@membre');
Route::get('/badge_intervenant', 'App\Http\Controllers\QRcodeController@intervenant');
Route::get('/badge_deleguer', 'App\Http\Controllers\QRcodeController@deleguer');
Route::get('/badge_facilitateur', 'App\Http\Controllers\QRcodeController@facilitateur');
Route::get('/badge_traducteur', 'App\Http\Controllers\QRcodeController@traducteur');
Route::get('/badge_organisateur', 'App\Http\Controllers\QRcodeController@organisateur');
Route::get('/badge_Psansentr', 'App\Http\Controllers\QRcodeController@partsansentr');

Route::get('/voirmesparticipants', 'App\Http\Controllers\InscriptionController@voirmesparticipants');


Route::get('/homeplannings', 'App\Http\Controllers\InscriptionController@homeplanning');

Route::get('/homesuggestions', 'App\Http\Controllers\InscriptionController@homesuggestion');

Route::get('/listeSuggestions', 'App\Http\Controllers\InscriptionController@listeSuggestions');
Route::get('/demandesFaites', 'App\Http\Controllers\InscriptionController@demandesFaites');
Route::get('/demandesRecues', 'App\Http\Controllers\InscriptionController@demandesRecues');


Route::get('/homecatalogues', 'App\Http\Controllers\InscriptionController@homecatalogue')->name('home.catalogue');
Route::get('/homecataloguepsecondaires', 'App\Http\Controllers\InscriptionController@homecataloguepsecondaire')->name('home.cataloguepsecondaire');

Route::get('/homecatalogues_rvs', 'App\Http\Controllers\InscriptionController@homecatalogue_rvs')->name('home.catalogue_rvs');

//My route by M.A.X B.I.R.D
Route::post('/review', 'App\Http\Controllers\InscriptionController@review_catalogue')->name('catalogue.review');

Route::get('/inscriptionstep0', 'App\Http\Controllers\InscriptionController@inscriptionstep0');

Route::get('/inscriptionstep1', 'App\Http\Controllers\InscriptionController@inscriptionstep1');

Route::get('/inscriptionstep2', 'App\Http\Controllers\InscriptionController@inscriptionstep2')->name('inscriptionStep2');

Route::get('/inscriptionstep3', 'App\Http\Controllers\InscriptionController@inscriptionstep3');

Route::get('/inscriptionstep2visit', 'App\Http\Controllers\InscriptionController@inscriptionstep2visit')->name('inscriptionstep2visit');

Route::get('/inscriptionstep3visit', 'App\Http\Controllers\InscriptionController@inscriptionstep3visit');

Route::get('/inscriptionstep4', 'App\Http\Controllers\InscriptionController@inscriptionstep4');

Route::get('/editprofils/{id}', 'App\Http\Controllers\InscriptionController@editprofil')->name('monprofil.edit');
Route::post('/editprofils/{id}', 'App\Http\Controllers\InscriptionController@update')->name('monprofil.update');
//mes participants ajouter par l'entreprise
Route::get('/createparticipant', 'App\Http\Controllers\InscriptionController@create');
Route::post('/createparticipant', 'App\Http\Controllers\InscriptionController@store');
// Route::get('/createentreprise', 'App\Http\Controllers\InscriptionController@creates');
// Route::post('/createentreprise', 'App\Http\Controllers\InscriptionController@stores');
Route::get('/editmesparticipant/{id}', 'App\Http\Controllers\InscriptionController@modifier')->name('mesparticipant.edit');
Route::post('/editmesparticipant/{id}', 'App\Http\Controllers\InscriptionController@updatess')->name('mesparticipant.update');
Route::delete('/destroy/{id}', 'App\Http\Controllers\InscriptionController@destroy')->name('mesparticipant.destroy');
//membre ajouter par delegation
Route::get('/membre_ajouter', 'App\Http\Controllers\ChefDelegationController@createmembre');
Route::post('/membre_ajouter', 'App\Http\Controllers\ChefDelegationController@storemembre');
Route::get('/edit_membre/{id}', 'App\Http\Controllers\ChefDelegationController@editmembre')->name('membre.edit');
Route::post('/edit_membre/{id}', 'App\Http\Controllers\ChefDelegationController@updatemembre')->name('membre.update');
Route::delete('/destroym/{id}', 'App\Http\Controllers\ChefDelegationController@destroymembre')->name('membre.destroy');

Route::get('/editdelegation/{id}', 'App\Http\Controllers\ChefDelegationController@editdelegation')->name('delegation.edit');
Route::post('/editdelegation/{id}', 'App\Http\Controllers\ChefDelegationController@updatedelegation')->name('delegation.update');
Route::get('/editmonparticipant/{id}', 'App\Http\Controllers\ChefDelegationController@modifierp')->name('monparticipant.edit');
Route::post('/editmonparticipant/{id}', 'App\Http\Controllers\ChefDelegationController@updatep')->name('monparticipant.update');
Route::delete('/destroys/{id}', 'App\Http\Controllers\ChefDelegationController@destroyp')->name('monparticipant.destroy');
//entreprise
Route::get('/inscriptionsD', 'App\Http\Controllers\ChefDelegationController@inscriptions');
Route::post('/inscriptionsD','App\Http\Controllers\ChefDelegationController@saveajout')->name('saveajout');
Route::get('/entrepriseajoutD', 'App\Http\Controllers\ChefDelegationController@createentreprise');
Route::post('/entrepriseajoutD', 'App\Http\Controllers\ChefDelegationController@storeentreprise');
Route::get('/modifierentreprises/{id}', 'App\Http\Controllers\ChefDelegationController@modifierentreprise')->name('entrepriseD.edite');
Route::post('/modifierentreprises/{id}', 'App\Http\Controllers\ChefDelegationController@updatesentreprise')->name('entrepriseD.updates');
Route::delete('/destroye/{id}', 'App\Http\Controllers\ChefDelegationController@destroye')->name('entrepriseD.destroye');
Route::get('/creerentreprises', 'App\Http\Controllers\ChefDelegationController@createentreprise0');
Route::post('/setting/{id}', 'App\Http\Controllers\ChefDelegationController@settingsupdates')->name('setting.updat');
Route::get('/editsetting/{id}', 'App\Http\Controllers\ChefDelegationController@editsetting')->name('setting.edits');



Route::delete('/destroySouhait/{id}', 'App\Http\Controllers\InscriptionController@destroy_souhait')->name('destroySouhait.destroy');
Route::post('/etat_valider/{id}', 'App\Http\Controllers\InscriptionController@souhait_accepter')->name('etat.valider');
Route::post('/non_valider/{id}', 'App\Http\Controllers\InscriptionController@souhait_refuser')->name('non.valider');
Route::post('/etats_validers/{id}', 'App\Http\Controllers\InscriptionController@souhaite_accepter')->name('etats.validers');
Route::post('/nons_validers/{id}', 'App\Http\Controllers\InscriptionController@souhaite_refuser')->name('nons.validers');

Route::delete('/destroySouhait_rvs/{id}', 'App\Http\Controllers\InscriptionController@destroy_souhait_rvs')->name('destroySouhait.destroy_rvs');
Route::post('/etat_valider_rvs/{id}', 'App\Http\Controllers\InscriptionController@souhait_accepter_rvs')->name('etat.valider_rvs');
Route::post('/non_valider_rvs/{id}', 'App\Http\Controllers\InscriptionController@souhait_refuser_rvs')->name('non.valider_rvs');
Route::post('/etats_validers_rvs/{id}', 'App\Http\Controllers\InscriptionController@souhaite_accepter_rvs')->name('etats.validers_rvs');
Route::post('/nons_validers_rvs/{id}', 'App\Http\Controllers\InscriptionController@souhaite_refuser_rvs')->name('nons.validers_rvs');

Route::get('/monentreprises', 'App\Http\Controllers\InscriptionController@monentreprise');
Route::get('/mesdemandesb2b', 'App\Http\Controllers\InscriptionController@mesdemandesb2b');
Route::get('/mesdemandesb2bedit/{id}', 'App\Http\Controllers\InscriptionController@mesdemandesb2bedit')->name('mesdemandesb2bedit');
Route::post('/mesdemandesb2bupdate/{id}', 'App\Http\Controllers\InscriptionController@mesdemandesb2bupdate')->name('mesdemandesb2bupdate');

Route::get('/editentreprises/{id}', 'App\Http\Controllers\InscriptionController@editentreprise')->name('monentreprise.edit');
Route::post('/editentreprises/{id}', 'App\Http\Controllers\InscriptionController@updates')->name('monentreprise.updates');
Route::get('/monprofils', 'App\Http\Controllers\InscriptionController@monprofil');


Route::post('/settings/{id}', 'App\Http\Controllers\InscriptionController@settingsupdate')->name('settings.update');
Route::get('/editsettings/{id}', 'App\Http\Controllers\InscriptionController@editsettings')->name('settings.edit');
Route::get('/madelegations', 'App\Http\Controllers\ChefDelegationController@madelegation');
Route::get('/createdelegations', 'App\Http\Controllers\InscriptionController@createdelegation');

//participant secondaire
Route::get('/monprofil', 'App\Http\Controllers\InscriptionController@profilps');
Route::get('/monbagde', 'App\Http\Controllers\QRcodeController@codeqr');
Route::get('/modifierprofils/{id}', 'App\Http\Controllers\InscriptionController@editprofilps')->name('profilps.edit');
Route::post('/modifierprofils/{id}', 'App\Http\Controllers\InscriptionController@updateps')->name('profilps.update');
Route::get('/sonentreprises', 'App\Http\Controllers\InscriptionController@sonentreprise');
// Route::get('/modifientreprise/{id}', 'App\Http\Controllers\InscriptionController@editentrepriseps')->name('entrepriseps.edit');
// Route::post('/modifientreprise/{id}', 'App\Http\Controllers\InscriptionController@updateps')->name('entrepriseps.updates');
Route::get('/sessuggestions', 'App\Http\Controllers\QRcodeController@sessuggestion');

//end 



Route::get('/messuggestions', 'App\Http\Controllers\InscriptionController@messuggestion');
Route::post('/valider_souhait/{id}', 'App\Http\Controllers\InscriptionController@Validersuggestion')->name('valider.souhait');
Route::post('/refuser_souhait/{id}', 'App\Http\Controllers\InscriptionController@Refusersuggestion')->name('refuser.souhait');
Route::post('/confirmer_souhait/{id}', 'App\Http\Controllers\InscriptionController@confirmer_souhait')->name('confirmer.souhait');
Route::post('/Notconfirmer_souhait/{id}', 'App\Http\Controllers\InscriptionController@Notconfirmer_souhait')->name('Notconfirmer.souhait');
//Route::post('/ajouter_souhait/{id}', 'App\Http\Controllers\InscriptionController@Validersuggestionss')->name('ajouter.souhait');

Route::get('/messuggestions_rvs', 'App\Http\Controllers\InscriptionController@messuggestion_rvs');
Route::post('/valider_souhait_rvs/{id}', 'App\Http\Controllers\InscriptionController@Validersuggestion_rvs')->name('valider.souhait_rvs');
Route::post('/refuser_souhait_rvs/{id}', 'App\Http\Controllers\InscriptionController@Refusersuggestion_rvs')->name('refuser.souhait_rvs');
Route::post('/confirmer_souhait_rvs/{id}', 'App\Http\Controllers\InscriptionController@confirmer_souhait_rvs')->name('confirmer.souhait_rvs');
Route::post('/Notconfirmer_souhait_rvs/{id}', 'App\Http\Controllers\InscriptionController@Notconfirmer_souhait_rvs')->name('Notconfirmer.souhait_rvs');
//Route::post('/ajouter_souhait/{id}', 'App\Http\Controllers\InscriptionController@Validersuggestionss')->name('ajouter.souhait');

#Add by maxbird to get wish 
Route::post('/ajouter_suggestion/{id}', 'App\Http\Controllers\InscriptionController@Ajoutersuggestion')->name('ajouter.suggestion');

Route::post('/ajouter_suggestion_rvs/{id}', 'App\Http\Controllers\InscriptionController@Ajoutersuggestion_rvs')->name('ajouter.suggestion_rvs');

Route::post('/alerter_suggestion_rvs/{id}', 'App\Http\Controllers\InscriptionController@Alertersuggestion_rvs')->name('alerter.suggestion_rvs');

#Add by maxbird to get wish 
Route::get('/generate_creneau/', 'App\Http\Controllers\InscriptionController@generate_creneau')->name('generate.creneau');

Route::post('/inscriptions','App\Http\Controllers\InscriptionController@saveinscription')->name('SaveInscriprion');

Route::post('/connexions','App\Http\Controllers\InscriptionController@saveconnexion')->name('SaveConnexion');

Route::post('/phase_1/events/{id}', 'App\Http\Controllers\EventController@phase_1')->name('phase_1.event');
Route::post('/phase_2/events/{id}', 'App\Http\Controllers\EventController@phase_2')->name('phase_2.event');
Route::post('/phase_3/events/{id}', 'App\Http\Controllers\EventController@phase_3')->name('phase_3.event');
Route::post('/phase_4/events/{id}', 'App\Http\Controllers\EventController@phase_4')->name('phase_4.event');
Route::post('/phase_des/events/{id}', 'App\Http\Controllers\EventController@phase_des')->name('phase_des.event');


Route::post('/phase_5_rvs/events/{id}', 'App\Http\Controllers\EventController@phase_5_rvs')->name('phase_5_rvs.event');

Route::get('/generate', 'App\Http\Controllers\SouhaitController@souhait');
Route::get('/admin/banSouhait', 'App\Http\Controllers\SouhaitController@banSouhait');

Route::get('/mes_participant', 'App\Http\Controllers\SouhaitController@participant');
Route::get('/participant/{id}','App\Http\Controllers\SouhaitController@details')->name('details.participant');

Route::get('/catalogues', 'App\Http\Controllers\SouhaitController@catalogue');
Route::get('/search', 'App\Http\Controllers\SouhaitController@filter');

//filtre catalogue

Route::get('/filtre_catalogues', 'App\Http\Controllers\InscriptionController@filtre_catalogues');


Route::resource('souhaits', 'App\Http\Controllers\SouhaitController');
Route::get('/suggesstion', 'App\Http\Controllers\SouhaitController@suggesstion');   

//Route::get('/catalogues', 'App\Http\Controllers\SouhaitController@catalogue');
Route::get('/entreprisecata/{id}','App\Http\Controllers\SouhaitController@details_ent')->name('entreprisecata.show');
Route::post('/save_souhait', 'App\Http\Controllers\SouhaitController@save_souhait');   
//Route::get('/search', 'SouhaitController@filter');
Route::get('/souhait_confirmer', 'App\Http\Controllers\SouhaitController@souhait_confirmer');  
Route::get('/admin/banSouhait_confirmer', 'App\Http\Controllers\SouhaitController@banSouhait_confirmer');

Route::post('/actif_sugg/{id}', 'App\Http\Controllers\SouhaitController@actif_sugg')->name('status.actif_sugg');
Route::post('/desactif_sugg/{id}', 'App\Http\Controllers\SouhaitController@desactif_sugg')->name('status.desactif_sugg');

Route::post('/actif_plan/{id}', 'App\Http\Controllers\SouhaitController@actif_plan')->name('etats.actif_plan');
Route::post('/desactif_plan/{id}', 'App\Http\Controllers\SouhaitController@desactif_plan')->name('etats.desactif_plan');

Route::get('/my_catalogues', 'App\Http\Controllers\SouhaitController@my_catalogue');
Route::get('/search_a', 'App\Http\Controllers\SouhaitController@my_filter');
Route::get('/my_details/{id}', 'App\Http\Controllers\SouhaitController@my_details')->name('catalogues.details');

Route::get('/adminplannings', 'App\Http\Controllers\PlanningController@listerplannings');
Route::get('/adminplannings/{id}', 'App\Http\Controllers\PlanningController@editplanning')->name('planningA.edit');
Route::post('/adminplannings/{id}', 'App\Http\Controllers\PlanningController@updateplanning')->name('planningA.update');


Route::get('/plannings', 'App\Http\Controllers\PlanningController@planning');
Route::get('/mon_planning', 'App\Http\Controllers\PlanningController@mon_planning');
Route::get('/mon_planning_final', 'App\Http\Controllers\PlanningController@mon_planning_final');
Route::get('/admin/banPlanning', 'App\Http\Controllers\PlanningController@banPlanning');
Route::get('/admin/banPlannings', 'App\Http\Controllers\PlanningController@banPlannings');
Route::DELETE('/planning/{planning}', 'App\Http\Controllers\PlanningController@destroy_planning')->name('planning.destroy');
    
    
Route::get('export-file/{type}', 'App\Http\Controllers\PlanningController@exportFile')->name('export.file');

Route::get('/messages','App\Http\Controllers\ParticipantController@message');
 
Route::post('/events/activer/{id}', 'App\Http\Controllers\EventController@activer')->name('activer.event');
Route::post('/events/desactiver/{id}', 'App\Http\Controllers\EventController@desactiver')->name('desactiver.event');

Route::get("/qrcode", "App\Http\Controllers\QRcodeController@generate");

//participant sans entreprise
Route::get('/monprofil3', 'App\Http\Controllers\InscriptionController@monprofile');
Route::get('/badge_participant', 'App\Http\Controllers\QRcodeController@participant');
Route::get('/homeInscriptionSansEnt', 'App\Http\Controllers\InscriptionController@homeInscriptionSansEnt');
Route::get('/myprofil', 'App\Http\Controllers\InscriptionController@profilsansentr');
Route::get('/editpartSansEntr/{id}', 'App\Http\Controllers\InscriptionController@editprofilSansEntr')->name('pSansEntr.edit');
Route::post('/editpartSansEntr/{id}', 'App\Http\Controllers\InscriptionController@updateSansEntr')->name('pSansEntr.updates');

Route::get('/listehotel3', 'App\Http\Controllers\HotelController@listehotele');






//Mail tested 
Route::get('send-mail', function () {
   
    \Mail::to("fallou.g@illimitis.com")->send(new \App\Mail\Heal());
   
    dd("Email is Sent.");
});
});

//Mail tested suggestion
Route::get('send-mail-suggestion', function () {
    $event =  DB::table('events')->where('status', 1 )->first();
    $user =  DB::table('users')->first();
    \Mail::to(['mohamed.t@illimitis.com','axel.n@illimitis.com','fallou.g@illimitis.com', 'roland.k@illimitis.com'])->send(new \App\Mail\SugestionsSouhaitsDeRendezVous($user, $event));
   
    dd("Suggestion Email is Sent.");
});




//Clear config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    $exit = Artisan::call('route:cache');
    
    return 'Config cache cleared';
});


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Start statistiques
Route::get('/page_statistiques', 'App\Http\Controllers\PlanningController@nombre');
Route::get('/page_entreprises', 'App\Http\Controllers\PlanningController@page_entreprises');
Route::get('/page_participants', 'App\Http\Controllers\PlanningController@page_participants');
Route::get('/page_rendez_vous', 'App\Http\Controllers\PlanningController@page_rendez_vous');
Route::get('/page_rendez_vous_p', 'App\Http\Controllers\PlanningController@page_rendez_vous_p');
Route::get('/page_comptes', 'App\Http\Controllers\PlanningController@page_comptes');
Route::get('/statistique_evenements', 'App\Http\Controllers\PlanningController@statistique_evenements');
Route::get('/page_inscrits', 'App\Http\Controllers\PlanningController@page_inscrits');
Route::get('/statistiques_inscriptions', 'App\Http\Controllers\PlanningController@inscriptions');


Route::get('/page_statistiques_a', 'App\Http\Controllers\PlanningController@nombre_a');
Route::get('/page_entreprises_a', 'App\Http\Controllers\PlanningController@page_entreprises_a');
Route::get('/page_participants_a', 'App\Http\Controllers\PlanningController@page_participants_a');
Route::get('/page_rendez_vous_a', 'App\Http\Controllers\PlanningController@page_rendez_vous_a');
Route::get('/page_rendez_vous_p_a', 'App\Http\Controllers\PlanningController@page_rendez_vous_p_a');
Route::get('/page_comptes_a', 'App\Http\Controllers\PlanningController@page_comptes_a');
Route::get('/entreprise_autres', 'App\Http\Controllers\PlanningController@entreprise_autres');
// End statistiques

// Home intervenant facilitateur traducteur organisateur
Route::get('/homeintervenants', 'App\Http\Controllers\InscriptionController@homeintervenant');
Route::get('/profilintervenant', 'App\Http\Controllers\InscriptionController@profilintervenant');
Route::get('/editintervenant/{id}', 'App\Http\Controllers\InscriptionController@editintervenant')->name('intervenant.edit');
Route::post('/editintervenant/{id}', 'App\Http\Controllers\InscriptionController@updateintervenant')->name('intervenant.update');

Route::get('/homefacilitateurs', 'App\Http\Controllers\InscriptionController@homefacilitateur');
Route::get('/editfacilitateur/{id}', 'App\Http\Controllers\InscriptionController@editfacilitateur')->name('facilitateur.edit');
Route::post('/editfacilitateur/{id}', 'App\Http\Controllers\InscriptionController@updatefacilitateur')->name('facilitateur.update');

Route::get('/hometraducteurs', 'App\Http\Controllers\InscriptionController@hometraducteur');
Route::get('/edittraducteur/{id}', 'App\Http\Controllers\InscriptionController@edittraducteur')->name('traducteur.edit');
Route::post('/edittraducteur/{id}', 'App\Http\Controllers\InscriptionController@updatetraducteur')->name('traducteur.update');

Route::post('/besoin/{id}', 'App\Http\Controllers\InscriptionController@besoin')->name('rendez-vous.besoin');
Route::post('/besoin_rvs/{id}', 'App\Http\Controllers\InscriptionController@besoin_rvs')->name('rendez-vous.besoin_rvs');

Route::get('/homeorganisateurs', 'App\Http\Controllers\InscriptionController@homeorganisateur');
Route::get('/editorganisateur/{id}', 'App\Http\Controllers\InscriptionController@editorganisateur')->name('organisateur.edit');
Route::post('/editorganisateur/{id}', 'App\Http\Controllers\InscriptionController@updateorganisateur')->name('organisateur.update');


Route::get('/editprofilPreinscri/{id}', 'App\Http\Controllers\InscriptionController@editprofilPreinscri')->name('editprofilPreinscri.edit');
Route::post('/editprofilPreinscri/{id}', 'App\Http\Controllers\InscriptionController@editprofilPreinscris')->name('editprofilPreinscris.update');

//Hotel
Route::get('/listehotels', 'App\Http\Controllers\HotelController@listehotel');

Route::get('/demandeB2G', 'App\Http\Controllers\ParticipantController@listerB2G');
Route::get('/mademandeb2g', 'App\Http\Controllers\ParticipantController@createB2G');
Route::post('/mademandeb2g', 'App\Http\Controllers\ParticipantController@ajoutB2G');
Route::get('/suivi_demandeb2g', 'App\Http\Controllers\ParticipantController@suivi_demandeb2g');
Route::post('/accepter/{id}', 'App\Http\Controllers\ParticipantController@accepter')->name('accepter');
Route::post('/refuser/{id}', 'App\Http\Controllers\ParticipantController@refuser')->name('refuser');
Route::get('/showdemandeur/{id}', 'App\Http\Controllers\ParticipantController@showdemandeur')->name('detaildemandeur.b2g');

Route::get('/homepreinscrits', 'App\Http\Controllers\InscriptionController@homepreinscrit');

Route::get('/completermonprofils/{id}', 'App\Http\Controllers\InscriptionController@completermonprofil')->name('completermonprofil');
Route::post('/completermonprofils/{id}', 'App\Http\Controllers\InscriptionController@completermonprofils')->name('completermonprofil.update');

Route::resource('/officiels', 'App\Http\Controllers\OfficielsController');

Route::get('/user/pdf', 'App\Http\Controllers\InscriptionController@createPDF');

Route::get('/pdf', function () {
      $qrcode = \QrCode::size(500)
            ->format('png')
            ->generate('https://sicot2022.optievent.xyz');
            
    return view('pdf_view', compact('qrcode'));
});

Route::get('/demandeVisaDemander', function () {
    return view('Admin/entreprise.demandeVisa');
});

Route::get('/demandeKitDemander', function () {
    return view('Admin/entreprise.demandeKit');
});

Route::get('/demandeB2BDemander', function () {
    return view('Admin/entreprise.demandeB2B');
});

Route::get('/demandeStandDemander', function () {
    return view('Admin/entreprise.demandeStand');
});

Route::get('/demandeHebergementDemander', function () {
    return view('Admin/entreprise.demandeHebergement');
});


Route::get('/listerExposants', function () {
    return view('Admin/exposant.listerExposant');
});


//M.A.X B.I.R.D was HERE : READ QR 
Route::get('/qrcode_parse/{id}', 'App\Http\Controllers\QRcodeController@read')->name('qrcode.read');
Route::get('/factory_setting_password', function(){
    $password = '123456';
    DB::table('users')
    ->update(['password' => Hash::make($password)]);
    dd("Password(s) reset successfully");
});

Route::get('/annuler/rendez_vous/{type}/{id}', 'App\Http\Controllers\InscriptionController@annuler_rendez_vous')->name('rendez-vous.annuler');
Route::get('/reactiver/rendez_vous/{type}/{id}', 'App\Http\Controllers\InscriptionController@reactiver_rendez_vous')->name('rendez-vous.reactiver');

Route::get('/Ajoutfacilitateurs', 'App\Http\Controllers\FacilitateurController@Ajoutfacilitateurs');
Route::post('/Storefacilitateurs', 'App\Http\Controllers\FacilitateurController@Storefacilitateurs')->name('Storefacilitateurs');

Route::get('/Ajoutintervenants', 'App\Http\Controllers\IntervenantController@Ajoutintervenants');
Route::post('/Storeintervenants', 'App\Http\Controllers\IntervenantController@Storeintervenants')->name('Storeintervenants');

Route::get('/Ajoutdelegations', 'App\Http\Controllers\ChefDelegationController@Ajoutdelegations');
Route::post('/Storedelegations', 'App\Http\Controllers\ChefDelegationController@Storedelegations')->name('Storedelegations');

Route::get('/inscriptions_participants', 'App\Http\Controllers\ParticipantController@inscriptions_participants');
Route::post('/inscriptions_participants', 'App\Http\Controllers\ParticipantController@inscriptions_participants_store');

Route::get('/AjoutExposants', 'App\Http\Controllers\FacilitateurController@AjoutExposants');
Route::post('/StoreExposants', 'App\Http\Controllers\FacilitateurController@StoreExposants')->name('StoreExposants');


