<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Session;

use App\Action;

use Auth;

use App\User;
use App\Agent;
use DB;
use App\Producteur;
use Illuminate\Support\Facades\Http;

use App\Notifications\EscalationAction;
use App\Notifications\EscalationActionResponsable;
use App\Notifications\AlerteEscalation;
use Notification;

class ExecuteCodeIntrantEquipementIndividuel extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:intrant_individuel";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mise a jour de  l activitée';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        DB::table('intrant_equipements_checksf')->delete();  
        $limit = 30000;

// Récupération des données depuis l'API
$response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed', [
    'limit' => $limit
]);

// Vérification de la réponse HTTP
if ($response->successful()) {
    // Récupération des données au format JSON
    $data = json_decode($response->body());
$quizzes_araLast = array();
        foreach($data as $quizzesLast){
          array_push($quizzes_araLast, $quizzesLast);
        }
        
    // Vérification si des données ont été récupérées
    if (!empty($quizzes_araLast[2])) {
        // Insertion des données dans la base de données
        foreach ($quizzes_araLast[2] as $dataODATALast) {
            // Assurez-vous que toutes les colonnes existent dans votre table de base de données
            DB::table('intrant_equipements_checksf')->insert(['caseid' => $dataODATALast->caseid, 'closed' => $dataODATALast->closed, 'campagne_coton' => $dataODATALast->campagne_coton,
            'type_marche' => $dataODATALast->type_marche, 'type_marche' => $dataODATALast->type_marche,
            'choix_formulaire_remplir' => $dataODATALast->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATALast->code_scoop_producteur,
            'nom_producteur' => $dataODATALast->nom_producteur, 'prenom_producteur' => $dataODATALast->prenom_producteur,
            'nom_scoop' => $dataODATALast->nom_scoop, 'superficie_prevu_producteur' => $dataODATALast->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATALast->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $dataODATALast->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATALast->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $dataODATALast->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATALast->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATALast->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATALast->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATALast->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATALast->prevision_de_production_scoop,
            'nbre_herbicides_total' => $dataODATALast->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATALast->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATALast->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATALast->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATALast->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATALast->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATALast->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATALast->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATALast->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATALast->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATALast->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATALast->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATALast->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATALast->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATALast->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATALast->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATALast->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATALast->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATALast->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATALast->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATALast->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATALast->qte_1er_choix_mag,
            'qte_2eme_choix' => $dataODATALast->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATALast->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $dataODATALast->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATALast->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $dataODATALast->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATALast->prix_coton_2eme_choix,
            'total_appareil_cdc' => $dataODATALast->total_appareil_cdc,
            'total_engrais_cdc' => $dataODATALast->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATALast->total_herbicide_cdc,
            'total_insecticide_cdc' => $dataODATALast->total_insecticide_cdc,
            'total_semence_cdc' => $dataODATALast->total_semence_cdc, 'total_cdc' => $dataODATALast->total_cdc,
            'total_appareil_clc' => $dataODATALast->total_appareil_clc,
            'total_engrais_clc' => $dataODATALast->total_engrais_clc, 'total_herbicide_clc' => $dataODATALast->total_herbicide_clc,
            'total_insecticide_clc' => $dataODATALast->total_insecticide_clc,
            'total_semence_clc' => $dataODATALast->total_semence_clc,
            'total_clc' => $dataODATALast->total_clc,
            'total_engrais' => $dataODATALast->total_engrais,
            'total_herbicide' => $dataODATALast->total_herbicide,
            'total_insecticide' => $dataODATALast->total_insecticide,
            'total_semence' => $dataODATALast->total_semence,
            'total_appareil' => $dataODATALast->total_appareil,
            'total_appareil_bc' => $dataODATALast->total_appareil_bc,
            'total_engrais_bc' => $dataODATALast->total_engrais_bc, 'total_herbicide_bc' => $dataODATALast->total_herbicide_bc,
            'total_insecticide_bc' => $dataODATALast->total_insecticide_bc,
            'total_semence_bc' => $dataODATALast->total_semence_bc, 'total_bc' => $dataODATALast->total_bc,
            'total_appareil_mp' => $dataODATALast->total_appareil_mp,
            'total_engrais_mp' => $dataODATALast->total_engrais_mp, 'total_herbicide_mp' => $dataODATALast->total_herbicide_mp,
            'total_insecticide_mp' => $dataODATALast->total_insecticide_mp,
            'total_semence_mp' => $dataODATALast->total_semence_mp, 'total_mp' => $dataODATALast->total_mp,
            'total_montant_intrants' => $dataODATALast->total_montant_intrants,
            'nom_zone' => $dataODATALast->nom_zone, 'nom_section' => $dataODATALast->nom_section, 'campagne_coton' => $dataODATALast->campagne_coton, 'owner_name' => $dataODATALast->owner_name]);

        }
    } else {
        // Gérer le cas où aucune donnée n'est récupérée
        // Log::warning('Aucune donnée récupérée depuis l\'API.');
    }
} else {
    // Gérer les cas d'erreur HTTP
    // $response->status();
}
 $okay = "check it";
        dd($okay);
        
        //DB::table('intrant_equipements_checksfg')->delete();  
      
        //$gn =  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed
        // the laast ODATA intrant_equipements https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff35071bc6/feed
        // the laast ODATA intrant_equipements_individuel https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892aca6053/feed
     DB::table('intrant_equipement_individuels_checks')->delete();  
        $intrant_equipements = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892aca6053/feed?limit=50000');
        $quizzes = json_decode($intrant_equipements->body());
        
        //   dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]); 
        //$i = 1;  
        foreach($quizzes_ara[1] as $dataODATA){
             
            DB::table('intrant_equipement_individuels_checks')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 
            'type_marche' => $dataODATA->type_marche, 'type_marche' => $dataODATA->type_marche,
            'nom_producteur' => $dataODATA->nom_producteur, 'prenom_producteur' => $dataODATA->prenom_producteur,
            'superficie_prevu_producteur' => $dataODATA->superficie_prevu_producteur,
            'nbre_appareil_atomiseur_piece' => $dataODATA->nbre_appareil_atomiseur_piece, 
            'nbre_appareil_dos_piece' => $dataODATA->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATA->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATA->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATA->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATA->nbre_herbicides_pre_levee,
            'nbre_herbicides_total' => $dataODATA->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATA->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATA->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATA->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATA->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATA->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATA->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATA->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATA->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATA->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATA->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATA->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATA->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATA->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATA->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATA->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATA->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATA->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATA->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATA->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATA->qte_1er_choix, 
            'qte_2eme_choix' => $dataODATA->qte_2eme_choix, 
            'total_montant_intrants' => $dataODATA->total_montant_intrants,
            'total_appareil' => $dataODATA->total_appareil,
            'total_engrais' => $dataODATA->total_engrais, 
            'total_herbicide' => $dataODATA->total_herbicide,
            'total_insecticide' => $dataODATA->total_insecticide, 
            'total_production' => $dataODATA->total_production,
            'total_production_kg' => $dataODATA->total_production_kg, 
            'total_semence' => $dataODATA->total_semence, 
            'case_link' => $dataODATA->case_link, 
            'number' => $dataODATA->number
            // ,
            // 'nom_zone' => $dataODATA->nom_zone, 'nom_section' => $dataODATA->nom_section, 'campagne_coton' => $dataODATA->campagne_coton
            
            ]);
        }        
        if($quizzes_ara[1] >= 10000)
        {
        $intrant_equipementsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892aca6053/feed?after_id=10000&limit=10000&offset=10000');
        $quizzesafters = json_decode($intrant_equipementsafters->body());
       
        //  dd($quizzesafters); 
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
        // dd($quizzes_araafters);
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAafter){
              
            DB::table('intrant_equipement_individuels_checks')->insert(['caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed,
            'type_marche' => $dataODATAafter->type_marche, 'type_marche' => $dataODATAafter->type_marche,
            'nom_producteur' => $dataODATAafter->nom_producteur, 'prenom_producteur' => $dataODATAafter->prenom_producteur,
           'superficie_prevu_producteur' => $dataODATAafter->superficie_prevu_producteur,
            'nbre_appareil_atomiseur_piece' => $dataODATAafter->nbre_appareil_atomiseur_piece, 
            'nbre_appareil_dos_piece' => $dataODATAafter->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATAafter->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATAafter->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATAafter->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATAafter->nbre_herbicides_pre_levee,
            'nbre_herbicides_total' => $dataODATAafter->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATAafter->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATAafter->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATAafter->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATAafter->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATAafter->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATAafter->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATAafter->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATAafter->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATAafter->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATAafter->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATAafter->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATAafter->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATAafter->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATAafter->qte_1er_choix, 
            'qte_2eme_choix' => $dataODATAafter->qte_2eme_choix, 
            'total_montant_intrants' => $dataODATAafter->total_montant_intrants,
            'total_appareil' => $dataODATAafter->total_appareil,
            'total_engrais' => $dataODATAafter->total_engrais, 
            'total_herbicide' => $dataODATAafter->total_herbicide,
            'total_insecticide' => $dataODATAafter->total_insecticide, 
            'total_production' => $dataODATAafter->total_production,
            'total_production_kg' => $dataODATAafter->total_production_kg, 
            'total_semence' => $dataODATAafter->total_semence, 
            'case_link' => $dataODATAafter->case_link, 
            'number' => $dataODATAafter->number
            // ,
            // 'nom_zone' => $dataODATAafter->nom_zone, 'nom_section' => $dataODATA->nom_section, 'campagne_coton' => $dataODATAafter->campagne_coton
            ]);
        }
        }
        
        
        
         if($quizzes_ara[1] >= 20000)
        {
        $intrant_equipementsaftersYup = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892aca6053/feed?after_id=10000&limit=10000&offset=20000');
        $quizzesafters = json_decode($intrant_equipementsaftersYup->body());
       
        // dd($quizzesafters); 
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
        // dd($quizzes_araafters);
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAafter){
              
            DB::table('intrant_equipement_individuels_checks')->insert(['caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed,
            'type_marche' => $dataODATAafter->type_marche, 'type_marche' => $dataODATAafter->type_marche,
            'nom_producteur' => $dataODATAafter->nom_producteur, 'prenom_producteur' => $dataODATAafter->prenom_producteur,
           'superficie_prevu_producteur' => $dataODATAafter->superficie_prevu_producteur,
            'nbre_appareil_atomiseur_piece' => $dataODATAafter->nbre_appareil_atomiseur_piece, 
            'nbre_appareil_dos_piece' => $dataODATAafter->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATAafter->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATAafter->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATAafter->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATAafter->nbre_herbicides_pre_levee,
            'nbre_herbicides_total' => $dataODATAafter->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATAafter->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATAafter->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATAafter->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATAafter->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATAafter->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATAafter->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATAafter->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATAafter->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATAafter->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATAafter->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATAafter->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATAafter->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATAafter->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATAafter->qte_1er_choix, 
            'qte_2eme_choix' => $dataODATAafter->qte_2eme_choix, 
            'total_montant_intrants' => $dataODATAafter->total_montant_intrants,
            'total_appareil' => $dataODATAafter->total_appareil,
            'total_engrais' => $dataODATAafter->total_engrais, 
            'total_herbicide' => $dataODATAafter->total_herbicide,
            'total_insecticide' => $dataODATAafter->total_insecticide, 
            'total_production' => $dataODATAafter->total_production,
            'total_production_kg' => $dataODATAafter->total_production_kg, 
            'total_semence' => $dataODATAafter->total_semence, 
            'case_link' => $dataODATAafter->case_link, 
            'number' => $dataODATAafter->number
            // ,
            // 'nom_zone' => $dataODATAafter->nom_zone, 'nom_section' => $dataODATA->nom_section, 'campagne_coton' => $dataODATAafter->campagne_coton
            ]);
        }
        }
        
        $check1 = DB::table('intrant_equipement_individuels_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('intrant_equipement_individuels')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('intrant_equipement_individuels_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
             DB::table('intrant_equipement_individuels')->insert(['caseid' => $show_result1->caseid, 'closed' => $show_result1->closed,
            'type_marche' => $show_result1->type_marche, 'type_marche' => $show_result1->type_marche,
            'nom_producteur' => $show_result1->nom_producteur, 'prenom_producteur' => $show_result1->prenom_producteur,
           'superficie_prevu_producteur' => $show_result1->superficie_prevu_producteur,
            'nbre_appareil_atomiseur_piece' => $show_result1->nbre_appareil_atomiseur_piece, 
            'nbre_appareil_dos_piece' => $show_result1->nbre_appareil_dos_piece,
            'nbre_appareil_pile_piece' => $show_result1->nbre_appareil_pile_piece, 'nbre_epi_piece' => $show_result1->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $show_result1->nbre_herbicides_post_levee,
            'nbre_herbicides_pre_levee' => $show_result1->nbre_herbicides_pre_levee,
            'nbre_herbicides_total' => $show_result1->nbre_herbicides_total, 
            'nbre_insecticides_type_1_specifiques_traitement' => $show_result1->nbre_insecticides_type_1_specifiques_traitement,
            'nbre_insecticides_type_1_traitement' => $show_result1->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $show_result1->nbre_insecticides_type_2_specifiques_traitement,
            'nbre_insecticides_type_2_traitement' => $show_result1->nbre_insecticides_type_2_traitement, 
            'nbre_insecticides_type_3_specifiques_traitement' => $show_result1->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $show_result1->nbre_insecticides_type_3_traitement,
            'nbre_pieces_appareil_piece' => $show_result1->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $show_result1->nbre_regulateur_croissance, 
            'nbre_sac_engrais_npk_fu_50kg' => $show_result1->nbre_sac_engrais_npk_fu_50kg, 
            'nbre_sac_engrais_uree_50kg' => $show_result1->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $show_result1->semence_conventionnelle_sac_15kg, 
            'semence_conventionnelle_sac_30kg' => $show_result1->semence_conventionnelle_sac_30kg,
            'semence_conventionnelle_sac_45kg' => $show_result1->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $show_result1->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $show_result1->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $show_result1->semence_ogm_sac_45kg, 
            'semences_delintee_conventionnelle_sac_15kg' => $show_result1->semences_delintee_conventionnelle_sac_15kg, 
            'semences_delintee_conventionnelle_sac_30kg' => $show_result1->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $show_result1->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $show_result1->qte_1er_choix, 
            'qte_2eme_choix' => $show_result1->qte_2eme_choix, 
            'total_montant_intrants' => $show_result1->total_montant_intrants,
            'total_appareil' => $show_result1->total_appareil,
            'total_engrais' => $show_result1->total_engrais, 
            'total_herbicide' => $show_result1->total_herbicide,
            'total_insecticide' => $show_result1->total_insecticide, 
            'total_production' => $show_result1->total_production,
            'total_production_kg' => $show_result1->total_production_kg, 
            'total_semence' => $show_result1->total_semence, 
            'case_link' => $show_result1->case_link, 
            'number' => $show_result1->number
            // ,
            ]);
    
            
        }
        $this->info('Le Code a été executé');
    }
    
}
