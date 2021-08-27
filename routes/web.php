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

Route::get('/', function () {
    return view('User.connexion');
});

Route::get('/homes', 'App\Http\Controllers\InscriptionController@index');

Route::resource('/entreprises', 'App\Http\Controllers\EntrepriseController');

Route::resource('/achattickets', 'App\Http\Controllers\AchatTicketController');

Route::resource('/activites', 'App\Http\Controllers\ActiviteController');

Route::resource('/categories', 'App\Http\Controllers\CategorieController');

Route::resource('/chefdelegations', 'App\Http\Controllers\ChefDelegationController');

Route::resource('/creneaux', 'App\Http\Controllers\CreneauxController');

Route::resource('/events', 'App\Http\Controllers\EventController');
Route::get('/configurer', 'App\Http\Controllers\EventController@configurer');

Route::resource('/facilitateurs', 'App\Http\Controllers\FacilitateurController');

Route::resource('/hotels', 'App\Http\Controllers\HotelController');

Route::resource('/indisponibiliteparticipants', 'App\Http\Controllers\IndisponibiliteParticipantController');

Route::resource('/intervenants', 'App\Http\Controllers\IntervenantController');

Route::resource('/langues', 'App\Http\Controllers\LangueController');

Route::resource('/messages', 'App\Http\Controllers\MessageController');

Route::get('/newletters', 'App\Http\Controllers\MessageController@newletter');

Route::resource('/organisateurs', 'App\Http\Controllers\OrganisateurController');

Route::resource('/participants', 'App\Http\Controllers\ParticipantController');
Route::get('/choix', 'App\Http\Controllers\ParticipantController@choix');

Route::get('/rendz-vous.B2B', 'App\Http\Controllers\RendezVousController@B2B');
Route::get('/rendz-vous.B2G', 'App\Http\Controllers\RendezVousController@B2G');



Route::resource('/passes', 'App\Http\Controllers\PasseController');

Route::get('/pricings', 'App\Http\Controllers\PasseController@pricing');

Route::resource('/pays', 'App\Http\Controllers\PaysController');

Route::resource('/produits', 'App\Http\Controllers\ProduitController');

Route::resource('/profils', 'App\Http\Controllers\ProfilController');

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


Route::resource('/voyages', 'App\Http\Controllers\VoyageController');

Route::get('/demandeVisa', 'App\Http\Controllers\VoyageController@demandeVisa');

Route::get('/confirmations', 'App\Http\Controllers\InscriptionController@confirmations');

Route::get('/connexions', 'App\Http\Controllers\InscriptionController@connexion');

Route::get('/homeconfirmations', 'App\Http\Controllers\InscriptionController@homeconfirmation');

Route::get('/homeinscriptions', 'App\Http\Controllers\InscriptionController@homeinscription');

Route::get('/homeplannings', 'App\Http\Controllers\InscriptionController@homeplanning');

Route::get('/homesuggestions', 'App\Http\Controllers\InsriptionController@homesuggestion');

Route::get('/inscriptions', 'App\Http\Controllers\InscriptionController@inscription');

Route::get('/inscriptionstep1', 'App\Http\Controllers\InscriptionController@inscriptionstep1');

Route::get('/inscriptionstep2', 'App\Http\Controllers\InscriptionController@inscriptionstep2');

Route::get('/inscriptionstep3', 'App\Http\Controllers\InscriptionController@inscriptionstep3');

Route::get('/inscriptionstep4', 'App\Http\Controllers\InscriptionController@inscriptionstep4');

Route::get('/messuggestions', 'App\Http\Controllers\InscriptionController@messuggestion');

Route::post('/inscriptions','App\Http\Controllers\InscriptionController@saveinscription')->name('SaveInscriprion');

Route::post('/connexions','App\Http\Controllers\InscriptionController@saveconnexion')->name('SaveConnexion');
