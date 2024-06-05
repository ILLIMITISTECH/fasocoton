<?php

use App\Http\Controllers\OdataController;
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

Route::get('/convert', 'Version3Controller@convert_csv_insert');

Route::get('/', function () {
    return view('admin.connexion.login');
});
Route::get('/ia', 'Version3Controller@indeex');

Route::get('/sendEmailAgent', 'AgentController@sendEmailAgent');
Route::post('/sendmailrappel', 'AgentController@sendmailrappel');

// Route::get('/sendEmailAgent_team', 'AgentController@sendEmailAgent');
Route::post('/sendmailrappel_mateam', 'AgentController@sendmailrappel');

Route::get('download/rapport_reunion','DirectionController@download');

Route::get('/connexion', 'Version3Controller@login');  
Route::post('/connexion', 'Version3Controller@login');

Route::get('/inscription', 'UserController@inscription');
Route::post('/inscription', 'UserController@inscriptions')->name('inscription.register');

/*
Route::get('/install', function () {
    app()->make(\Illuminate\Support\Composer::class)->run(['require', 'barryvdh/laravel-dompdf']);
    dd('Component created');
});
*/

Route::group(['middleware' => 'Connecter'], function(){

// Start Faso Coton Route

Route::get('/dashboard', 'OdataController@lister');
Route::get('/dashboard/zone', 'OdataController@zone');
Route::get('/dashboard/zone/zorgho', 'OdataController@zorgho');
Route::get('/dashboard/zone/tenkodogo', 'OdataController@tenkodogo');
Route::get('/dashboard/zone/manga', 'OdataController@manga');
Route::get('/dashboard/zone/po', 'OdataController@po');
Route::get('/dashboard/zone/kombissiri', 'OdataController@kombissiri');
Route::get('/producteurs', 'OdataController@producteurs');
Route::get('/scoops', 'OdataController@scoops');

// ca
Route::get('/dashboard/ca', 'CaController@ca');
Route::get('/search_dashboard_ca', 'CaController@filtrer_ca')->name('search_dashboard_ca');

Route::get('/producteurs/groupements_ca', 'CaController@prodGrpmt_ca')->name('prodGrpmt_ca');
Route::post('/resultat/filtre_ca', 'CaController@filtreProdGrpmt_ca')->name('filtreProdGrpmt_ca');

Route::get('/superficies_ca', 'CaController@superficies_ca')->name('superficies_ca');
Route::post('/superficie/filtres_ca', 'CaController@filtreSuperficie_ca')->name('filtreSuperficie_ca');

Route::get('/evaluation/production_ca', 'CaController@evaluProducton_ca')->name('evaluProducton_ca');
Route::post('/evaluation/filtres_ca', 'CaController@filtreEvaluation_ca')->name('filtreEvaluation_ca');

Route::get('/production/realisee_ca', 'CaController@productionRealisee_ca')->name('productionRealisee_ca');
Route::post('/production_realisee/filtres_ca', 'CaController@filtreProductionRealisee_ca')->name('filtreProductionRealisee_ca');

Route::get('/production/valorisee_ca', 'CaController@productionValorisee_ca')->name('productionValorisee_ca');
Route::post('/production_valorisee/filtres_ca', 'CaController@filtreproductionValorisee_ca')->name('filtreproductionValorisee_ca');

Route::get('/clc_ca', 'CaController@clc_ca');
Route::get('/cdc_ca', 'CaController@cdc_ca');

Route::get('/besoin_complementaire_ca', 'CaController@besoin_complementaire_ca');

Route::get('/mise_en_place_ca', 'CaController@mise_en_place_ca');

Route::get('/production_ca', 'CaController@production_ca');

    // end ca

Route::get('selectCampagneProducteur', 'OdataController@selectCampagneProducteur');
Route::get('selectZoneProducteur', 'OdataController@selectZoneProducteur');
Route::get('selectSection/{id}', 'OdataController@selectSection');
Route::get('selectZoneScoop/{id}', 'OdataController@selectZoneScoop');

Route::get('selectScoop', 'OdataController@selectScoop');

Route::post('/admin/filtre_producteur', 'OdataController@adminFiltreProducteur')->name('adminFiltreProducteur');
Route::post('/admin/filtre_groupement', 'OdataController@adminFiltreGroupement')->name('adminFiltreGroupement');



Route::get('/producteurs/groupements', 'OdataController@prodGrpmt')->name('prodGrpmt');
Route::post('/resultat/filtre', 'OdataController@filtreProdGrpmt')->name('filtreProdGrpmt');

Route::get('/suivi/parasitisme', 'OdataController@suiviParasitisme')->name('suiviParasitisme');
Route::post('/filtre/suivi_parasitisme', 'OdataController@filtreSuiviParasitisme')->name('filtreSuiviParasitisme');


Route::get('/producteurs/groupements_zone', 'OdataController@prodGrpmt_zone')->name('prodGrpmt_zone');
Route::post('/resultat/filtre_zone', 'OdataController@filtreProdGrpmt_zone')->name('filtreProdGrpmt_zone');

Route::get('/superficies', 'OdataController@superficies')->name('superficies');
Route::post('/superficie/filtres', 'OdataController@filtreSuperficie')->name('filtreSuperficie');

Route::get('/superficies_zone', 'OdataController@superficies_zone')->name('superficies_zone');
Route::post('/superficie/filtres_zone', 'OdataController@filtreSuperficie_zone')->name('filtreSuperficie_zone');

Route::get('/evaluation/production', 'OdataController@evaluProducton')->name('evaluProducton');
Route::post('/evaluation/filtres', 'OdataController@filtreEvaluation')->name('filtreEvaluation');

Route::get('/evaluation/production_zone', 'OdataController@evaluProducton_zone')->name('evaluProducton_zone');
Route::post('/evaluation/filtres_zone', 'OdataController@filtreEvaluation_zone')->name('filtreEvaluation_zone');

Route::get('/production/realisee', 'OdataController@productionRealisee')->name('productionRealisee');
Route::post('/production_realisee/filtres', 'OdataController@filtreProductionRealisee')->name('filtreProductionRealisee');

Route::get('/production/realisee_zone', 'OdataController@productionRealisee_zone')->name('productionRealisee_zone');
Route::post('/production_realisee/filtres_zone', 'OdataController@filtreProductionRealisee_zone')->name('filtreProductionRealisee_zone');

Route::get('/production/valorisee', 'OdataController@productionValorisee')->name('productionValorisee');
Route::post('/production_valorisee/filtres', 'OdataController@filtreproductionValorisee')->name('filtreproductionValorisee');

Route::get('/production/valorisee_zone', 'OdataController@productionValorisee_zone')->name('productionValorisee_zone');
Route::post('/production_valorisee/filtres_zone', 'OdataController@filtreproductionValorisee_zone')->name('filtreproductionValorisee_zone');

Route::get('/situation/credit', 'OdataController@situationCredit')->name('situationCredit');
Route::post('/situation_credit/filtres', 'OdataController@filtreSituationCredit')->name('filtreSituationCredit');

Route::get('/situation/credit_zone', 'OdataController@situationCredit_zone')->name('situationCredit_zone');
Route::post('/situation_credit/filtres_zone', 'OdataController@filtreSituationCredit_zone')->name('filtreSituationCredit_zone');

Route::get('/clc', 'OdataController@clc');
Route::get('/cdc', 'OdataController@cdc');
Route::get('/mise_en_place', 'OdataController@mise_en_place');

Route::post('/filter_by_zone', [OdataController::class, 'filter_by_zone'] )->name('filter_by_zone');
Route::get('/api/sections', [OdataController::class, 'getSections']);
Route::get('/api/campagne', [OdataController::class, 'getCampagne'])->name('getCampagne');

Route::get('/api/campagne/clc', [OdataController::class, 'getCampagneClc'])->name('getCampagneClc');
Route::get('/api/getSectionsByClc', [OdataController::class, 'getSectionsByClc']);



Route::get('/besoin_complementaire', 'OdataController@besoin_complementaire');
Route::get('/production', 'OdataController@production');
Route::get('/search_dashboard', 'OdataController@filtrer')->name('search_dashboard');
Route::get('/search_dashboard_zone', 'OdataController@filtrer_zone')->name('search_dashboard_zone');
Route::get('/search_clc', 'OdataController@filtrer_clc')->name('search_clc');
Route::get('/search_cdc', 'OdataController@filtrer_cdc')->name('search_cdc');
Route::get('/search_bc', 'OdataController@filtrer_bc')->name('search_bc');
Route::get('/search_mep', 'OdataController@filtrer_mep')->name('search_mep');
Route::get('/search_production', 'OdataController@filtrer_production')->name('search_production');
Route::get('/search_producteur', 'OdataController@producteurs_filter')->name('search_producteur');
Route::get('/producteurs_zone', 'OdataController@producteurs_zone');
Route::get('/scoops_zone', 'OdataController@scoops_zone');
Route::get('/clc_zone', 'OdataController@clc_zone');
Route::get('/cdc_zone', 'OdataController@cdc_zone');
Route::get('/mise_en_place_zone', 'OdataController@mise_en_place_zone');
Route::get('/besoin_complementaire_zone', 'OdataController@besoin_complementaire_zone');
Route::get('/production_zone', 'OdataController@production_zone');
Route::get('/ajouter_users', 'UserController@ajouter_users');
Route::post('/ajouter_users', 'UserController@ajouter_users_store');
Route::get('/helpdesks', 'OdataController@helpdesks');
Route::get('/helpdesk_requete_fermees', 'OdataController@helpdeskFermee');

Route::get('/pluviometrie', 'OdataController@pluviometrie');
Route::get('/search_pluviometrie', 'OdataController@pluviometrie_filter')->name('search_pluviometrie');

Route::get('/formations', 'OdataController@formation');
// Route::get('/suivi_parasitisme', 'OdataController@suivi_parasitisme');

// End Faso Coton Route

Route::resource('actions', 'ActionController');
Route::resource('agents', 'AgentController');  
Route::resource('reunions', 'ReunionController');
Route::resource('decissions', 'DecissionController');
Route::resource('directions', 'DirectionController');
Route::resource('services', 'ServiceController'); 
Route::resource('themes', 'ThemeController');
Route::resource('suivi_actions', 'Suivi_actionController');
Route::resource('suivi_indicateurs', 'Suivi_indicateurController');
Route::resource('indicateurs', 'IndicateurController');
Route::resource('suivi_modules', 'Suivi_moduleController');
Route::resource('modules', 'ModuleController');
Route::resource('roles', 'RoleController');
// Route::resource('formations', 'FormationController');
Route::resource('users', 'UserController');
Route::resource('annonces', 'AnnonceController');

Route::get('/ajout_source', 'FeedbackController@create_source');
Route::post('/ajout_source', 'FeedbackController@store_source');

Route::get('/physionomie', 'OdataController@physionomie');
Route::get('/travau_agricoles', 'OdataController@travau_agricoles');


// Modifier action avec projet ma team
Route::get('/action_ma_teamS{id}/edit', 'UserController@edit_action_ma_teamS')->name('action_ma_teamS.editer');
Route::patch('/action_user_dS/{id}', 'UserController@update_action_ma_teamS')->name('action_ma_teamS.update');
Route::get('/action_ma_teamM{id}/edit', 'UserController@edit_action_ma_teamM')->name('action_ma_teamM.editer');
Route::patch('/action_user_dM/{id}', 'UserController@update_action_ma_teamM')->name('action_ma_teamM.update');
Route::get('/action_ma_teamR{id}/edit', 'UserController@edit_action_ma_teamR')->name('action_ma_teamR.editer');
Route::patch('/action_user_dR/{id}', 'UserController@update_action_ma_teamR')->name('action_ma_teamR.update');

Route::get('/action_user/{action}/edit', 'UserController@edit_action')->name('action_user.editer');
Route::patch('/action_user/{action}', 'UserController@update_action')->name('action_user.update');
Route::get('/action_responsable/{action}/edit', 'UserController@edit_action_responsable')->name('action_responsable.editer');
Route::patch('/action_responsable/{action}', 'UserController@update_action_responsable')->name('action_responsable.update');
Route::get('/action_user_d/{action}/edit', 'UserController@edit_action_d')->name('action_user_d.editer');
Route::patch('/action_user_d/{action}', 'UserController@update_action_d')->name('action_user_d.update');

Route::get('/action_user_toute/{action}/edit', 'UserController@edit_action_toute')->name('action_user_toute.editer');
Route::patch('/action_user_toute/{action}', 'UserController@update_action_toute')->name('action_user_toute.update');
Route::get('/action_user_retard/{action}/edit', 'UserController@edit_action_retard')->name('action_user_retard.editer');
Route::patch('/action_user_retard/{action}', 'UserController@update_action_retard')->name('action_user_retard.update');
Route::get('/action_user_mois/{action}/edit', 'UserController@edit_action_mois')->name('action_user_mois.editer');
Route::patch('/action_user_mois/{action}', 'UserController@update_action_mois')->name('action_user_mois.update');

Route::get('/action_user_a/{action}/edit', 'UserController@edit_action_user')->name('action_user_a.editer');
Route::patch('/action_user_a/{action}', 'UserController@update_action_user')->name('action_user_a.update');
Route::get('/action_responsable_a/{action}/edit', 'UserController@edit_action_responsab')->name('action_responsable_a.editer');
Route::patch('/action_responsable_a/{action}', 'UserController@update_action_responsab')->name('action_responsable_a.update');
Route::get('/admin/banSuivi', 'UserController@banSuivi');

Route::get('/action_user_fresponsable/{action}/edit', 'UserController@edit_action_fresponsable')->name('action_user_fresponsable.editer');
Route::patch('/action_user_fresponsable/{action}', 'UserController@update_action_fresponsable')->name('action_user_fresponsable.update');

Route::get('/action_user_futilisateur/{action}/edit', 'UserController@edit_action_futilisateur')->name('action_user_futilisateur.editer');
Route::patch('/action_user_futilisateur/{action}', 'UserController@update_action_futilisateur')->name('action_user_futilisateur.update');

Route::get('/action_user_fdirecteur/{action}/edit', 'UserController@edit_action_fdirecteur')->name('action_user_fdirecteur.editer');
Route::patch('/action_user_fdirecteur/{action}', 'UserController@update_action_fdirecteur')->name('action_user_fdirecteur.update');

Route::get('/action_user_frapporteur/{action}/edit', 'UserController@edit_action_frapporteur')->name('action_user_frapporteur.editer');
Route::patch('/action_user_frapporteur/{action}', 'UserController@update_action_frapporteur')->name('action_user_frapporteur.update');

Route::get('/profil_user/{profil_user}/edit', 'UserController@profil_user')->name('profil_user.editer');
Route::patch('/profil_user/{profil_user}', 'UserController@update_profil_user')->name('profil_user.update');

Route::get('/profil_user_password/{profil_user}/edit', 'UserController@profil_user_password')->name('profil_user_password.editer');
Route::patch('/profil_user_password/{profil_user}', 'UserController@update_profil_user_password')->name('profil_user_password.update');

Route::get('/profil_rap/{profil_rap}/edit', 'UserController@profil_rap')->name('profil_rap.editer');
Route::patch('/profil_rap/{profil_rap}', 'UserController@update_profil_rap')->name('profil_rap.update');

Route::get('/profil_responsable/{profil_responsable}/edit', 'UserController@profil_responsable')->name('profil_responsable.editer');
Route::patch('/profil_responsable/{profil_responsable}', 'UserController@update_profil_responsable')->name('profil_responsable.update');

Route::get('/profil_dg/{profil_dg}/edit', 'UserController@profil_dg')->name('profil_dg.editer');
Route::patch('/profil_dg/{profil_dg}', 'UserController@update_profil_dg')->name('profil_dg.update');

Route::get('/action_responsable_reasigner/{action}/edit', 'UserController@edit_action_responsabreasigner')->name('action_responsable_reasigner.editer');
Route::patch('/action_responsable_reasigner/{action}', 'UserController@update_action_responsabreasigner')->name('action_responsable_reasigner.update');

Route::get('/action_rap_reasigner/{action}/edit', 'UserController@edit_action_rapreasigner')->name('action_rap_reasigner.editer');
Route::patch('/action_rap_reasigner/{action}', 'UserController@update_action_rapreasigner')->name('action_rap_reasigner.update');

Route::get('/action_dg_reasigner/{action}/edit', 'UserController@edit_action_dgreasigner')->name('action_dg_reasigner.editer');
Route::patch('/action_dg_reasigner/{action}', 'UserController@update_action_dgreasigner')->name('action_dg_reasigner.update');

Route::get('/action_responsable_asigner/{action}/edit', 'UserController@edit_action_responsabasigner')->name('action_responsable_asigner.editer');
Route::patch('/action_responsable_asigner/{action}', 'UserController@update_action_responsabasigner')->name('action_responsable_asigner.update');

Route::get('/action_rap_asigner/{action}/edit', 'UserController@edit_action_rapasigner')->name('action_rap_asigner.editer');
Route::patch('/action_rap_asigner/{action}', 'UserController@update_action_rapasigner')->name('action_rap_asigner.update');

Route::get('/action_dg_asigner/{action}/edit', 'UserController@edit_action_dgasigner')->name('action_dg_asigner.editer');
Route::patch('/action_dg_asigner/{action}', 'UserController@update_action_dgasigner')->name('action_dg_asigner.update');

Route::get('/dashboardDirecteur', function () {
    return view('v2.dashboard');
});

Route::get('/dashboardResponsable', function () {
    return view('v2.res_dash');
});

Route::get('/admin/dashboard', 'UserController@dashboard');
Route::get('/admin/dashboard/user', 'UserController@dashboard_user');
Route::get('/admin/dashboard/directeur', 'UserController@dashboard_directeur');
Route::get('/admin/dashboard/rapporteur', 'UserController@dashboard_rapporteur');
Route::get('/admin/dashboard/responsable', 'UserController@dashboard_responsable');
Route::get('/admin/dashboard/tech', 'UserController@tech');
Route::get('/admin/dashboard/marketing', 'UserController@marketing');
Route::get('/admin/dashboard/assistant', 'UserController@assistant');
Route::get('/admin/dashboard/secretaire', 'UserController@secretaire');
Route::post('/save_action', 'UserController@save_action');
Route::get('/voir_history/{id}', 'UserController@history')->name('history.voir');
Route::get('/voir_history_responsable/{id}', 'UserController@history_responsable')->name('history_responsable.voir');

Route::get('/voir_history_d/{id}', 'UserController@history_d')->name('history_d.voir');
Route::post('/save_action_d', 'UserController@save_action_d');
Route::get('/voir_direction/{id}', 'UserController@direction')->name('direction.voir');
Route::get('/voir_agent/{id}', 'UserController@agent')->name('agent.voir');
Route::get('/voir_user_agent/{id}', 'UserController@user_agent')->name('user_agent.voir');
Route::get('/voir_responsable_agent/{id}', 'UserController@responsable_agent')->name('responsable_agent.voir');

Route::get('/voir_user_agent_rap/{id}', 'UserController@user_agent_rap')->name('user_agent_rap.voir');
Route::get('/voir_history_r/{id}', 'UserController@history_r')->name('history_r.voir');
Route::post('/save_action_r', 'UserController@save_action_r');
Route::post('/save_action_responsable', 'UserController@save_action_responsable');
Route::get('/action_user_r/{action}/edit', 'UserController@edit_action_r')->name('action_user_r.editer');;
Route::patch('/action_user_r/{action}', 'UserController@update_action_r')->name('action_user_r.update');
Route::get('/action_user_rap/{action}/edit', 'UserController@edit_action_rap')->name('action_user_rap.editer');;
Route::patch('/action_user_rap/{action}', 'UserController@update_action_rap')->name('action_user_rap.update');
Route::get('/user_action_r', 'UserController@user_action_r');
Route::get('/user_actionA_r', 'UserController@user_actionA_r');
Route::get('/user_annonce_r', 'UserController@user_annonce_r');
Route::get('/ajout_annonce_r', 'UserController@ajout_annonce_r');
Route::post('/ajout_annonce_r', 'UserController@ajout_annonceA_r')->name('ajout.annonce_r');

Route::get('/user_annonce_res', 'UserController@user_annonce_res');
Route::get('/user_annonce_user', 'UserController@user_annonce_user');

Route::get('/user_reunion', 'UserController@user_reunion');
Route::get('/user_action', 'UserController@user_action');
Route::get('/user_action_semaine', 'Version3Controller@user_action_semaine');
Route::get('/user_action_mois', 'UserController@user_action_mois');
Route::get('/user_toute_action', 'UserController@user_toute_action');
Route::get('/action_mateam_semaine', 'UserController@action_mateam_semaine');
Route::get('/action_mateam', 'UserController@action_mateam');
Route::get('/action_retard_mateam', 'UserController@action_retard_mateam');
Route::get('/historique_performance', 'UserController@historique_performance');
Route::get('/historique_performance_mateam', 'UserController@historique_performance_mateam');


Route::get('/user_actionA', 'UserController@user_actionA');

Route::get('/responsable_reunion', 'UserController@responsable_reunion')->name('ajout.reunion');
Route::get('/responsable_action', 'UserController@responsable_action');
Route::get('/responsable_actionA', 'UserController@responsable_actionA');

Route::get('/user_reunion_dg', 'UserController@user_reunion_dg');
Route::get('/user_action_dg', 'UserController@user_action_dg');
Route::get('/user_actionA_dg', 'UserController@user_actionA_dg');
Route::get('/user_annonce', 'UserController@user_annonce');

Route::get('/ajout_annonce', 'UserController@ajout_annonce');
Route::post('/ajout_annonce', 'UserController@ajout_annonceA')->name('ajout.annonce');

Route::get('/search_a', 'UserController@my_filter');
Route::get('/search', 'ActionController@filter');
Route::get('/searchf/{id}', 'FeedbackController@filtrer_feedback')->name('searchfeedback');
Route::get('/search_mateam', 'UserController@filtrer_action_mateam');
Route::get('/search_mateam_retard', 'UserController@filtrer_action_retard_mateam');
Route::get('/action_cloture', 'ActionController@action_cloture');
Route::get('/action_assignee', 'ActionController@action_assignee');
Route::get('/search_ag', 'AgentController@filter_ag');
Route::get('/action_direct/{id}', 'ActionController@showDirection')->name('direction.vue');   

Route::get('/ajout_action_dg', 'ActionController@ajout_action_dg');
Route::post('/ajout_action_dg', 'ActionController@ajout_actionDG')->name('ajout.action_dg');
Route::get('/voir_action_dg', 'ActionController@voir_action_dg');
Route::get('/search_action', 'ActionController@filter_action_dg');
Route::get('/filter_action', 'UserController@filter_action');

Route::get('/contact', 'MailController@contact');
Route::get('/contact', 'MailManuController@contact');

Route::post('send/email', 'MailController@sendemail')->name('contact.store');
Route::post('send/emails', 'MailManuController@sendemail')->name('contactm.store');

Route::get('/responsable_actionAcloture', 'UserController@responsable_actionAcloture');
Route::get('/rapporteur_actionAcloture', 'UserController@rapporteur_actionAcloture');
Route::get('/directeur_actionAcloture', 'UserController@directeur_actionAcloture');

Route::get('/ajout_action_asigne', 'ActionController@ajout_action_asigneRES');
Route::post('/ajout_action_asigne', 'ActionController@ajout_actionAsigneRES')->name('ajout.action_asigneRES');

Route::get('/ajout_action_asigneR', 'ActionController@ajout_action_asigneRAP');
Route::post('/ajout_action_asigneR', 'ActionController@ajout_actionAsigneRAP')->name('ajout.action_asigneRAP');

Route::get('/ajout_action_asignerespon', 'ActionController@ajout_action_asignerespon');
Route::post('/ajout_action_asignerespon', 'ActionController@ajout_actionAsignerespon')->name('ajout.action_asignerespon');

Route::get('/ajout_action_asigneresponR', 'ActionController@ajout_action_asigneresponRAP');
Route::post('/ajout_action_asigneresponR', 'ActionController@ajout_actionAsigneresponRAP')->name('ajout.action_asigneresponRAP');

Route::get('/ajout_action_user_moi', 'ActionController@ajout_action_user_moi');
Route::post('/ajout_action_user_moi', 'ActionController@ajout_actionAuser_moi')->name('ajout.action_user_moi');

Route::get('/ajout_action_rap_moi', 'ActionController@ajout_action_rap_moi');
Route::post('/ajout_action_rap_moi', 'ActionController@ajout_actionArap_moi')->name('ajout.action_rap_moi');

Route::get('/ajout_action_responsable_moi', 'ActionController@ajout_action_responsable_moi');
Route::post('/ajout_action_responsable_moi', 'ActionController@ajout_actionAresponsable_moi')->name('ajout.action_responsable_moi');

Route::get('/ajout_action_dg_moi', 'ActionController@ajout_action_dg_moi');
Route::post('/ajout_action_dg_moi', 'ActionController@ajout_actionAdg_moi')->name('ajout.action_dg_moi');

Route::post('/cloture/{id}', 'UserController@status_cloture')->name('visibilite.cloture');
Route::post('/clotures/{id}', 'UserController@status_cloture1')->name('visibilite1.cloture');
Route::post('/valider/{id}', 'UserController@status_valider')->name('visibilite.valider');
Route::post('/refuser/{id}', 'UserController@status_refuser')->name('visibilite.refuser');
Route::post('/refuser_cloture/{id}', 'UserController@refuser_cloture')->name('refuser.cloture');


Route::post('/info/{id}', 'UserController@info')->name('info.valider');
Route::post('/passwords/{id}', 'UserController@passwords')->name('passwords.valider');
Route::post('/image/{id}', 'UserController@image')->name('image.valider');


Route::get('/res_reunion/{reunion}/edit', 'ReunionController@edit_res_reunion')->name('res_reunion.editer');
Route::patch('/res_reunion/{reunion}', 'ReunionController@update_res_reunion')->name('res_reunion.update');
Route::DELETE('res_reunion/{res_reunion}', 'ReunionController@res_supprimer')->name('res_reunion.destroy');

Route::get('/dg_reunion/{reunion}/edit', 'ReunionController@edit_dg_reunion')->name('dg_reunion.editer');
Route::patch('/dg_reunion/{reunion}', 'ReunionController@update_dg_reunion')->name('dg_reunion.update');
Route::DELETE('dg_reunion/{dg_reunion}', 'ReunionController@dg_supprimer')->name('dg_reunion.destroy');

Route::get('/res_annonce/{annonce}/edit', 'AnnonceController@edit_res_annonce')->name('res_annonce.editer');
Route::patch('/res_annonce/{annonce}', 'AnnonceController@update_res_annonce')->name('res_annonce.update');
Route::DELETE('res_annonce/{dg_annonce}', 'AnnonceController@res_supprimer')->name('res_annonce.destroy');

Route::get('/dg_annonce/{annonce}/edit', 'AnnonceController@edit_dg_annonce')->name('dg_annonce.editer');
Route::patch('/dg_annonce/{annonce}', 'AnnonceController@update_dg_annonce')->name('dg_annonce.update');
Route::DELETE('dg_annonce/{dg_annonce}', 'AnnonceController@dg_supprimer')->name('dg_annonce.destroy');

Route::get('/qui_est_en_ligne', 'UserController@statut_agents');
Route::get('/derniers_updates', 'UserController@derniers_updates');



Route::get('/administrateur', function () {
    return view('dashboard.index');
});

// version 3
Route::resource('activites', 'ActiviteController');
Route::resource('strategiques', 'StrategiqueController');
Route::resource('taches', 'TacheController');

Route::get('/v3/admin/dashboard', 'Version3Controller@dashboard');
Route::get('/mesperformances', 'Version3Controller@mesperformances');
Route::get('/evaluation', 'Version3Controller@evaluation');
Route::get('/agent_evaluation/{id}', 'Version3Controller@agent_evaluation')->name('agent_evaluation');
Route::get('/performance_de_ma_team', 'Version3Controller@teamperformance');
Route::get('/search_ech/', 'Version3Controller@filter')->name('search_ech');
Route::post('/fait/{id}', 'Version3Controller@fait')->name('fait');
Route::post('/pasfait/{id}', 'Version3Controller@pasfait')->name('pasfait');


//M.A.X B.I.R.D WAS HERE
Route::get('/cumul_retard/{direction}', 'Version3Controller@cumul_retard')->name('cumul_retard.direction');

Route::get('/taches_dg', function () {
    
    $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
    return view('v3.taches_dg', compact('headers'));
    


});


//modifier action avec projet
Route::get('/actionprojet/{action}/edit', 'ProjetController@edit_action_projet')->name('action_projet.edit');
Route::patch('/actionprojet/{action}', 'ProjetController@update_action_projet')->name('action_projet.update');
Route::get('/actionprojetd/{action}/edit', 'ProjetController@edit_action_projet_dash')->name('action_projet_dash.edit');
Route::patch('/actionprojetd/{action}', 'ProjetController@update_action_projet_dash')->name('action_projet_dash.update');
Route::get('/actionprojetm/{action}/edit', 'ProjetController@edit_action_projet_mois')->name('action_projet_mois.edit');
Route::patch('/actionprojetm/{action}', 'ProjetController@update_action_projet_mois')->name('action_projet_mois.update');
Route::get('/actionuserproj/{id}/edit', 'ProjetController@edit_action_proj')->name('action_proj.edit');
Route::patch('/actionuserproj/{id}', 'ProjetController@update_action_proj')->name('action_proj.update');

//modifier action
Route::get('/actionuser/{id}/edit', 'ActionController@edit_action_user2')->name('action_user2.edit');
Route::patch('/actionuser/{id}', 'ActionController@update_action_user2')->name('action_user2.update');
Route::get('/actionuser_assignee/{id}/edit', 'ActionController@edit_action_assignee')->name('action_assignee.edit');
Route::patch('/actionuser_assignee/{id}', 'ActionController@update_action_assignee')->name('action_assignee.update');

Route::get('/actionuser_mateam/{id}/edit', 'ActionController@edit_action_mateam')->name('action_mateam.edit');
Route::patch('/actionuser_mateam/{id}', 'ActionController@update_action_mateam')->name('action_mateam.update');

Route::get('/actionuser_mateam_retard/{id}/edit', 'ActionController@edit_action_mateam_retard')->name('action_mateam_retard.edit');
Route::patch('/actionuser_mateam_retard/{id}', 'ActionController@update_action_mateam_retard')->name('action_mateam_retard.update');

//Feedback
Route::get('/envoimail', 'FeedbackController@envoimail');

Route::get('/feedback_parsource', 'FeedbackController@listfeedback_par_source');
Route::get('/feedbackliste/{id}', 'FeedbackController@voir_listfeedback')->name('voir.feedback_source');
Route::get('/feedbackliste/download/{id}', 'FeedbackController@telecharger_listfeedback')->name('telecharger.feedback_source');

Route::get('/feedback/donner', 'FeedbackController@feedbackDonner');
Route::post('/feedback/donner', 'FeedbackController@feedbackDonner_store');
Route::get('/lister/feedback/recu', 'FeedbackController@ListeFeedbackRecu');
Route::get('/feedbackrecu/{id}', 'FeedbackController@feedbackRecu')->name('voir.feedbacks');
Route::get('/appreciation/donner', 'FeedbackController@appreciationDonner');
Route::post('/appreciations/donner', 'FeedbackController@appreciationDonner_store');
Route::get('/appreciation/recu/{id}', 'FeedbackController@appreciationRecus')->name('voir.appreciations');
Route::get('/liste/appreciation/recu', 'FeedbackController@ListerAppreciationRecu');
Route::get('/appreciation/demander', 'FeedbackController@appreciationDemander');
Route::post('/appreciation/demander', 'FeedbackController@appreciationDemander_store');
Route::get('/feedback/recu/{id}', 'FeedbackController@feedbackRecu1')->name('voir.reponse');
Route::get('/feedback/rapport', 'FeedbackController@feedbackRapport');
Route::get('/feedback/notation', 'FeedbackController@feedbackNotation');
//Route::get('/liste/feedback', 'FeedbackController@feedbackLister');
Route::get('/liste/feedback/recu', 'FeedbackController@ListerFeedbackRecu');
Route::get('/liste/appreciation/donner', 'FeedbackController@ListerAppreciationDonner');


//prospect 

Route::get('/feedback/demander', 'FeedbackController@feedbackDemander');
Route::post('/feedback/demander', 'FeedbackController@feedbackDemander_store');
Route::get('/liste/feedback/donner', 'FeedbackController@ListeFeedbackDonner');
Route::get('/feedback/donne/{id}', 'FeedbackController@donnerFeedback')->name('repondre.feedback');
Route::post('/feedback/donne/{id}', 'FeedbackController@donnerFeedback_store')->name('rep.feedback');
Route::get('/liste/feedback/recus', 'FeedbackController@ListeProspectFeedbackRecu');
Route::get('/feedback/recus/{id}', 'FeedbackController@prospectFeedbackRecu')->name('voir.feedback');

Route::get('/apprecier/demanders', 'FeedbackController@apprecierDemander');
Route::post('/apprecier/demanders', 'FeedbackController@apprecierDemander_store');
Route::get('/liste/apprecier/donner', 'FeedbackController@ListeapprecierDonner');
Route::get('/apprecier/donners/{id}', 'FeedbackController@apprecierDonners')->name('repondre.apprecier');
Route::post('/apprecier/donner/{id}', 'FeedbackController@apprecierDonner_store')->name('apprecier.Donner_store');
Route::get('/liste/apprecier/recu', 'FeedbackController@ListeapprecierRecu');
Route::get('/apprecier/recus/{id}', 'FeedbackController@ListeProspectapprecierRecu')->name('voir.apprecier');


//Connexion prospect

// Route::post('/inscription_prospect', 'UserController@connexions');
// Route::get('/inscriptions_prospect', 'UserController@inscriptio');
// Route::post('/inscriptions_prospect','UserController@saveinscription')->name('SaveInscriprion');
// Route::get('/feedback/prospect', 'UserController@prosp');

//end prospect






Route::get('/dg_asktocreate', function () {
    return view('activite/v2.dg_asktocreate');
});

Route::get('/dg_list_modeles', function () {
    return view('activite/v2.dg_list_modeles');
});

Route::get('/create_dg', 'ActiviteController@create_dg');
Route::post('/store_dg', 'ActiviteController@store_dg')->name('activite.store_dg');

// PROJET
Route::get('/create_projet','ProjetController@create_projet');
Route::post('/create_projet','ProjetController@store_projet')->name('create.projet');
Route::get('/action_projet','ProjetController@action_projet');

Route::get('/create_projet_action','ProjetController@create_projet_action');
Route::post('/create_projet_action','ProjetController@store_projet_action')->name('create.projet_action');

Route::get('/mes_projets','ProjetController@lister_mes_projets');
Route::get('/mes_projets/{projet}/edit', 'ProjetController@edit_projet')->name('monprojet.editer');
Route::patch('/mes_projets/{projet}', 'ProjetController@update_projet')->name('monprojet.update');
Route::get('/les_bakup/{id}', 'ProjetController@lesbakup')->name('lesbakup.projet');
Route::get('/tous_projets','ProjetController@lister_tous_projets');
Route::get('/projets_ma_team','ProjetController@projets_ma_team');
Route::get('/mes_projets_user','ProjetController@mes_projets_user');
Route::post('/cloturer/{id}', 'ProjetController@status_cloturer')->name('visibiliter.cloturer');
Route::post('/clotureractionprojet/{id}', 'ProjetController@action_projet_cloturer')->name('visibiliteraction.cloturer');

// modeles taches
Route::get('/ajouter_modele', 'ActiviteController@ajouter_modele_edit');
Route::post('/ajouter_modele', 'ActiviteController@ajouter_modele_store');
Route::get('/liste_modeles', 'ActiviteController@liste_modeles');
Route::get('/modele/{modele}/ajout', 'ActiviteController@ajouter_action')->name('ajouter_action.create');
Route::post('/ajouter_tache/{id}', 'ActiviteController@ajouter_action_store')->name('ajouter_action_store.store');
Route::get('/action/{id}/voir', 'ActiviteController@lister_action')->name('lister_action.voir');




Route::get('/modeles_activites', 'ActiviteController@modeles_activites');
Route::get('/categorie/{categorie}/edit', 'ActiviteController@edit_cat')->name('edit_categorie');
Route::patch('/update_categorie/{categorie}', 'ActiviteController@update_cat')->name('update_categorie');
Route::DELETE('destroy_cat/{categorie}', 'ActiviteController@destroy_cat')->name('destroy_cat');
Route::get('/modele/{modele}/edit', 'ActiviteController@modele_ajout')->name('ajout_modele');
Route::post('/add_modele', 'ActiviteController@modele_add')->name('add_modele');
Route::get('/modeles_live', 'Version3Controller@modeles_live');
Route::get('/search_echm/', 'Version3Controller@filterm')->name('search_echm');
Route::post('/faitm/{id}', 'Version3Controller@faitm')->name('faitm');
Route::post('/pasfaitm/{id}', 'Version3Controller@pasfaitm')->name('pasfaitm');
Route::post('/archiver/{id}', 'Version3Controller@archiver')->name('archiver');
Route::get('/ajout_cat', 'ActiviteController@ajout_cat');
Route::post('/add_cat', 'ActiviteController@add_cat')->name('add_cat');
Route::get('/all_activites', 'ActiviteController@all_activites');
Route::get('/search_dirac', 'ActiviteController@all_activites_filter');
Route::get('/voir_activite/{id}', 'ActiviteController@voir_activite')->name('voir_activite');
Route::get('/voir_modele/{id}', 'ActiviteController@voir_modele')->name('voir_modele');
Route::get('/strategiques', 'ActiviteController@strategiques');
Route::get('/activites_instance', 'Version3Controller@activites_instance');
Route::get('/activites_autre', 'Version3Controller@activites_autre');
Route::get('/activiter/{activiter}/edit', 'ActiviteController@active_edi')->name('active.modifier');
Route::patch('/activiter_update/{activiter}', 'ActiviteController@active_up')->name('active_update');

});

Route::get('/todolist', 'ListeController@todo');
Route::post('/todolist', 'ListeController@todolist')->name('todo.list');
Route::DELETE('/destroytache/{id}', 'ListeController@destroy')->name('liste.destroy');
Route::DELETE('/destroyactivite/{id}', 'ActiviteController@destroyac')->name('activite.destroyac');

Route::POST('/destroyactiviteta/{id}', 'ActiviteController@destroyta')->name('activite.destroyta');

Route::get('/activites_team', function () {
    
    $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
    return view('v3.activites_dg', compact('headers'));
});

Route::get('/todo-list_dg', function () {
    
    $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
    return view('v3.todo-list_dg', compact('headers'));
});
Auth::routes();  

Route::get('/home', 'HomeController@index')->name('home');

//PROSPECT CONNEXION
// Route::post('/inscription', 'UserController@connexions');
// Route::get('/inscriptions', 'UserController@inscriptio');
// Route::post('/inscriptions','UserController@saveinscription')->name('SaveInscriprion');
// Route::get('/feedback/prospect', 'UserController@prosp');


//Clear route cache:
 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });

 //Clear config cache:
 Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 }); 

// Clear application cache:
 Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });



 // Clear view cache:
  Route::get('/config-clear', function() {
     $exitCode = Artisan::call('config:clear');
     return 'Application cache cleared';
 });
 
  Route::get('/key-generate', function() {
     $exitCode = Artisan::call('key:generate');
     return 'Application cache cleared';
 });
 
 Route::get('/word-day', function() {
     $exitCode = Artisan::call('word:day');
     echo ($exitCode);
 }); 

 Route::get('/week-day', function() {
     $exitCode = Artisan::call('week:day');
     echo ($exitCode);
 });
 
 Route::get('/stras', function() {
     $exitCode = Artisan::call('stra:update');
     echo ($exitCode);
 });
 
 Route::get('/workday', function() {
     $exitCode = Artisan::call('word:day');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteIntrant', function() {
     $exitCode = Artisan::call('execute:intrant');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteIntrantBackup', function() {
     $exitCode = Artisan::call('execute:intrantbackup');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteParcelle', function() {
     $exitCode = Artisan::call('execute:parcelle');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteScoop', function() {
     $exitCode = Artisan::call('execute:scoop');
     echo ($exitCode);
 });
 
 Route::get('/ExecutePracitisme', function() {
     $exitCode = Artisan::call('execute:pracitisme');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteProducteur', function() {
     $exitCode = Artisan::call('execute:producteur');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteProducteurTest', function() {
     $exitCode = Artisan::call('execute:producteurTest');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteCodeProducteurIndividuel', function() {
     $exitCode = Artisan::call('execute:producteur_individuel');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteIntrantIndividuel', function() {
     $exitCode = Artisan::call('execute:intrant_individuel');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteHauteur', function() {
     $exitCode = Artisan::call('execute:hauteur');
     echo ($exitCode);
 });
  
 Route::get('/ExecuteFormation', function() {
     $exitCode = Artisan::call('execute:formation');
     echo ($exitCode);
 });
 
 Route::get('/ExecuteSection', function() {
     $exitCode = Artisan::call('update:section');
     echo ($exitCode);
 });
 
 
 Route::get('/ExecuteDetailScoop', function() {
     $exitCode = Artisan::call('execute:detail_scoop');
     echo ($exitCode);
 });
 
 Route::get('/weekday', function() {
     $exitCode = Artisan::call('week:day');
     echo ($exitCode);
 });
 
 Route::get('/hepldesks', function() {
     $exitCode = Artisan::call('help:desk');
     echo ($exitCode);
 });
 
 
Route::post('/checkapi', 'OdataController@checkapi');
Route::get('/getcheckapi', 'OdataController@getcheckapi');










