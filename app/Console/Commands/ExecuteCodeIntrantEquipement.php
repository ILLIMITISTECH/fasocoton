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

class ExecuteCodeIntrantEquipement extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:intrant";

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

        // end point block 10 0000     new https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed 
        // DB::table('intrant_equipements_checks')->delete();  
        
        
        
      /*  $limit = 50000;
        $totalRecordsToFetch = 100000;
        $offset = 0;
        
        while ($offset < $totalRecordsToFetch) {
            $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed', [
                'limit' => $limit,
                'offset' => $offset
               // 'after_id' => 60000
            ]);
        
            $quizzes = json_decode($response->body());
        
            $quizzes_ara = array();
            foreach($quizzes as $quizze){
              array_push($quizzes_ara, $quizze);
            }
          // dd($quizzes);
            foreach ($quizzes_ara[2] as $dataODATA) {
                if($dataODATA->campagne_coton == '23-24'){
                // Vérifiez si l'enregistrement existe déjà dans la base de données
                $existingRecord = DB::table('intrant_equipements_checks')->where('caseid', $dataODATA->caseid)->first();
                
                // Si l'enregistrement n'existe pas, insérez-le
                if (!$existingRecord) {
                  
                    DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 'campagne_coton' => $dataODATA->campagne_coton,
                    'type_marche' => $dataODATA->type_marche, 'type_marche' => $dataODATA->type_marche,
                    'choix_formulaire_remplir' => $dataODATA->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATA->code_scoop_producteur,
                    'nom_producteur' => $dataODATA->nom_producteur, 'prenom_producteur' => $dataODATA->prenom_producteur,
                    'nom_scoop' => $dataODATA->nom_scoop, 'superficie_prevu_producteur' => $dataODATA->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATA->superficie_prevu_groupement,
                    'nbre_appareil_atomiseur_piece' => $dataODATA->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATA->superficie_realise_producteur,
                    'nbre_appareil_dos_piece' => $dataODATA->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATA->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATA->nbre_epi_piece,
                    'nbre_herbicides_post_levee' => $dataODATA->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATA->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATA->prevision_de_production_scoop,
                    'nbre_herbicides_total' => $dataODATA->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATA->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATA->nbre_insecticides_type_1_traitement,
                    'nbre_insecticides_type_2_specifiques_traitement' => $dataODATA->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATA->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATA->nbre_insecticides_type_3_specifiques_traitement,
                    'nbre_insecticides_type_3_traitement' => $dataODATA->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATA->nbre_pieces_appareil_piece,
                    'nbre_regulateur_croissance' => $dataODATA->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATA->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATA->nbre_sac_engrais_uree_50kg,
                    'semence_conventionnelle_sac_15kg' => $dataODATA->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATA->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATA->semence_conventionnelle_sac_45kg,
                    'semence_ogm_sac_15kg' => $dataODATA->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATA->semence_ogm_sac_30kg,
                    'semence_ogm_sac_45kg' => $dataODATA->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATA->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATA->semences_delintee_conventionnelle_sac_30kg,
                    'semences_delintee_conventionnelle_sac_45kg' => $dataODATA->semences_delintee_conventionnelle_sac_45kg,
                    'qte_1er_choix' => $dataODATA->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATA->qte_1er_choix_mag,
                    'qte_2eme_choix' => $dataODATA->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATA->qte_2eme_choix_mag,
                    'total_prix_coton_1er_choix' => $dataODATA->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATA->total_prix_coton_2eme_choix,
                    'prix_coton_1er_choix' => $dataODATA->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATA->prix_coton_2eme_choix,
                    'total_appareil_cdc' => $dataODATA->total_appareil_cdc,
                    'total_engrais_cdc' => $dataODATA->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATA->total_herbicide_cdc,
                    'total_insecticide_cdc' => $dataODATA->total_insecticide_cdc,
                    'total_semence_cdc' => $dataODATA->total_semence_cdc, 'total_cdc' => $dataODATA->total_cdc,
                    'total_appareil_clc' => $dataODATA->total_appareil_clc,
                    'total_engrais_clc' => $dataODATA->total_engrais_clc, 'total_herbicide_clc' => $dataODATA->total_herbicide_clc,
                    'total_insecticide_clc' => $dataODATA->total_insecticide_clc,
                    'total_semence_clc' => $dataODATA->total_semence_clc,
                    'total_clc' => $dataODATA->total_clc,
                    'total_engrais' => $dataODATA->total_engrais,
                    'total_herbicide' => $dataODATA->total_herbicide,
                    'total_insecticide' => $dataODATA->total_insecticide,
                    'total_semence' => $dataODATA->total_semence,
                    'total_appareil' => $dataODATA->total_appareil,
                    'total_appareil_bc' => $dataODATA->total_appareil_bc,
                    'total_engrais_bc' => $dataODATA->total_engrais_bc, 'total_herbicide_bc' => $dataODATA->total_herbicide_bc,
                    'total_insecticide_bc' => $dataODATA->total_insecticide_bc,
                    'total_semence_bc' => $dataODATA->total_semence_bc, 'total_bc' => $dataODATA->total_bc,
                    'total_appareil_mp' => $dataODATA->total_appareil_mp,
                    'total_engrais_mp' => $dataODATA->total_engrais_mp, 'total_herbicide_mp' => $dataODATA->total_herbicide_mp,
                    'total_insecticide_mp' => $dataODATA->total_insecticide_mp,
                    'total_semence_mp' => $dataODATA->total_semence_mp, 'total_mp' => $dataODATA->total_mp,
                    'total_montant_intrants' => $dataODATA->total_montant_intrants,
                    'nom_zone' => $dataODATA->nom_zone, 'nom_section' => $dataODATA->nom_section, 'campagne_coton' => $dataODATA->campagne_coton, 'owner_name' => $dataODATA->owner_name
                    ]);
               
                }
                
                }
            }
        
            $offset += $limit;
            
            // Vérifiez s'il y a une URL de pagination dans la réponse
            $nextLink = $quizzes_ara[2]->{'@odata.nextLink'};
        
            // Si aucune URL de pagination n'est fournie, sortez de la boucle
            if (!$nextLink) {
                break;
            }
           
        } */

        // first requete
    /*   $intrant_equipements = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed?limit=50000');

        $quizzes = json_decode($intrant_equipements->body());

        $quizzes_ara = array();
        foreach($quizzes as $quizzes){
          array_push($quizzes_ara, $quizzes);
        }

      
         foreach($quizzes_ara[2] as $dataODATA){
             if($dataODATA->campagne_coton == '23-24'){
            DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 'campagne_coton' => $dataODATA->campagne_coton,
            'type_marche' => $dataODATA->type_marche, 'type_marche' => $dataODATA->type_marche,
            'choix_formulaire_remplir' => $dataODATA->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATA->code_scoop_producteur,
            'nom_producteur' => $dataODATA->nom_producteur, 'prenom_producteur' => $dataODATA->prenom_producteur,
            'nom_scoop' => $dataODATA->nom_scoop, 'superficie_prevu_producteur' => $dataODATA->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATA->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $dataODATA->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATA->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $dataODATA->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATA->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATA->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATA->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATA->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATA->prevision_de_production_scoop,
            'nbre_herbicides_total' => $dataODATA->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATA->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATA->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATA->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATA->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATA->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATA->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATA->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATA->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATA->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATA->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATA->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATA->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATA->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATA->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATA->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATA->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATA->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATA->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATA->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATA->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATA->qte_1er_choix_mag,
            'qte_2eme_choix' => $dataODATA->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATA->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $dataODATA->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATA->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $dataODATA->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATA->prix_coton_2eme_choix,
            'total_appareil_cdc' => $dataODATA->total_appareil_cdc,
            'total_engrais_cdc' => $dataODATA->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATA->total_herbicide_cdc,
            'total_insecticide_cdc' => $dataODATA->total_insecticide_cdc,
            'total_semence_cdc' => $dataODATA->total_semence_cdc, 'total_cdc' => $dataODATA->total_cdc,
            'total_appareil_clc' => $dataODATA->total_appareil_clc,
            'total_engrais_clc' => $dataODATA->total_engrais_clc, 'total_herbicide_clc' => $dataODATA->total_herbicide_clc,
            'total_insecticide_clc' => $dataODATA->total_insecticide_clc,
            'total_semence_clc' => $dataODATA->total_semence_clc,
            'total_clc' => $dataODATA->total_clc,
            'total_engrais' => $dataODATA->total_engrais,
            'total_herbicide' => $dataODATA->total_herbicide,
            'total_insecticide' => $dataODATA->total_insecticide,
            'total_semence' => $dataODATA->total_semence,
            'total_appareil' => $dataODATA->total_appareil,
            'total_appareil_bc' => $dataODATA->total_appareil_bc,
            'total_engrais_bc' => $dataODATA->total_engrais_bc, 'total_herbicide_bc' => $dataODATA->total_herbicide_bc,
            'total_insecticide_bc' => $dataODATA->total_insecticide_bc,
            'total_semence_bc' => $dataODATA->total_semence_bc, 'total_bc' => $dataODATA->total_bc,
            'total_appareil_mp' => $dataODATA->total_appareil_mp,
            'total_engrais_mp' => $dataODATA->total_engrais_mp, 'total_herbicide_mp' => $dataODATA->total_herbicide_mp,
            'total_insecticide_mp' => $dataODATA->total_insecticide_mp,
            'total_semence_mp' => $dataODATA->total_semence_mp, 'total_mp' => $dataODATA->total_mp,
            'total_montant_intrants' => $dataODATA->total_montant_intrants,
            'nom_zone' => $dataODATA->nom_zone, 'nom_section' => $dataODATA->nom_section, 'campagne_coton' => $dataODATA->campagne_coton, 'owner_name' => $dataODATA->owner_name]);
        }  
         }

       // second requete

        $intrant_equipementsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed?after_id=10000&limit=50000&offset=10000');

        $quizzesafters = json_decode($intrant_equipementsafters->body());

        $quizzes_araafters = array();
        foreach($quizzesafters as $quizzesafter){
          array_push($quizzes_araafters, $quizzesafter);
        }


         foreach($quizzes_araafters[2] as $dataODATAafter){
             if($dataODATAafter->campagne_coton == '23-24'){
            DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed, 'campagne_coton' => $dataODATAafter->campagne_coton,
            'type_marche' => $dataODATAafter->type_marche, 'type_marche' => $dataODATAafter->type_marche,
            'choix_formulaire_remplir' => $dataODATAafter->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATAafter->code_scoop_producteur,
            'nom_producteur' => $dataODATAafter->nom_producteur, 'prenom_producteur' => $dataODATAafter->prenom_producteur,
            'nom_scoop' => $dataODATAafter->nom_scoop, 'superficie_prevu_producteur' => $dataODATAafter->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATAafter->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $dataODATAafter->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATAafter->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $dataODATAafter->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATAafter->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATAafter->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATAafter->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATAafter->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATAafter->prevision_de_production_scoop,
            'nbre_herbicides_total' => $dataODATAafter->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATAafter->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATAafter->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATAafter->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATAafter->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATAafter->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATAafter->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATAafter->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATAafter->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATAafter->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATAafter->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATAafter->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATAafter->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATAafter->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATAafter->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATAafter->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATAafter->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATAafter->qte_1er_choix_mag,
            'qte_2eme_choix' => $dataODATAafter->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATAafter->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $dataODATAafter->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATAafter->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $dataODATAafter->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATAafter->prix_coton_2eme_choix,
            'total_appareil_cdc' => $dataODATAafter->total_appareil_cdc,
            'total_engrais_cdc' => $dataODATAafter->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATAafter->total_herbicide_cdc,
            'total_insecticide_cdc' => $dataODATAafter->total_insecticide_cdc,
            'total_semence_cdc' => $dataODATAafter->total_semence_cdc, 'total_cdc' => $dataODATAafter->total_cdc,
            'total_appareil_clc' => $dataODATAafter->total_appareil_clc,
            'total_engrais_clc' => $dataODATAafter->total_engrais_clc, 'total_herbicide_clc' => $dataODATAafter->total_herbicide_clc,
            'total_insecticide_clc' => $dataODATAafter->total_insecticide_clc,
            'total_semence_clc' => $dataODATAafter->total_semence_clc,
            'total_clc' => $dataODATAafter->total_clc,
            'total_engrais' => $dataODATAafter->total_engrais,
            'total_herbicide' => $dataODATAafter->total_herbicide,
            'total_insecticide' => $dataODATAafter->total_insecticide,
            'total_semence' => $dataODATAafter->total_semence,
            'total_appareil' => $dataODATAafter->total_appareil,
            'total_appareil_bc' => $dataODATAafter->total_appareil_bc,
            'total_engrais_bc' => $dataODATAafter->total_engrais_bc, 'total_herbicide_bc' => $dataODATAafter->total_herbicide_bc,
            'total_insecticide_bc' => $dataODATAafter->total_insecticide_bc,
            'total_semence_bc' => $dataODATAafter->total_semence_bc, 'total_bc' => $dataODATAafter->total_bc,
            'total_appareil_mp' => $dataODATAafter->total_appareil_mp,
            'total_engrais_mp' => $dataODATAafter->total_engrais_mp, 'total_herbicide_mp' => $dataODATAafter->total_herbicide_mp,
            'total_insecticide_mp' => $dataODATAafter->total_insecticide_mp,
            'total_semence_mp' => $dataODATAafter->total_semence_mp, 'total_mp' => $dataODATAafter->total_mp,
            'total_montant_intrants' => $dataODATAafter->total_montant_intrants,
            'nom_zone' => $dataODATAafter->nom_zone, 'nom_section' => $dataODATAafter->nom_section, 'campagne_coton' => $dataODATAafter->campagne_coton, 'owner_name' => $dataODATAafter->owner_name]);
        }  
         }
       
 
        $intrant_equipementsLast = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed?after_id=20000&limit=50000&offset=20000');
        
        $quizzesLast = json_decode($intrant_equipementsLast->body());


        $quizzes_araLast = array();
        foreach($quizzesLast as $quizzesLast){
          array_push($quizzes_araLast, $quizzesLast);
        }

       
         foreach($quizzes_araLast[2] as $dataODATALast){

            if($dataODATALast->campagne_coton == '23-24'){
            DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATALast->caseid, 'closed' => $dataODATALast->closed, 'campagne_coton' => $dataODATALast->campagne_coton,
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
         }
        /// }
        
          $intrant_equipementsLastA = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed?after_id=30000&limit=50000&offset=30000');
        
        $quizzesLastA = json_decode($intrant_equipementsLastA->body());


        $quizzes_araLastA = array();
        foreach($quizzesLastA as $quizzesLastv){
          array_push($quizzes_araLastA, $quizzesLastv);
        }

       
         foreach($quizzes_araLastA[2] as $dataODATALastA){

            if($dataODATALastA->campagne_coton == '23-24'){
            DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATALastA->caseid, 'closed' => $dataODATALastA->closed, 'campagne_coton' => $dataODATALastA->campagne_coton,
            'type_marche' => $dataODATALastA->type_marche, 'type_marche' => $dataODATALastA->type_marche,
            'choix_formulaire_remplir' => $dataODATALastA->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATALastA->code_scoop_producteur,
            'nom_producteur' => $dataODATALastA->nom_producteur, 'prenom_producteur' => $dataODATALastA->prenom_producteur,
            'nom_scoop' => $dataODATALastA->nom_scoop, 'superficie_prevu_producteur' => $dataODATALastA->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATALastA->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $dataODATALastA->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATALastA->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $dataODATALastA->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATALastA->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATALastA->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATALastA->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATALastA->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATALastA->prevision_de_production_scoop,
            'nbre_herbicides_total' => $dataODATALastA->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATALastA->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATALastA->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATALastA->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATALastA->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATALastA->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATALastA->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATALastA->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATALastA->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATALastA->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATALastA->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATALastA->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATALastA->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATALastA->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATALastA->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATALastA->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATALastA->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATALastA->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATALastA->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATALastA->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATALastA->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATALastA->qte_1er_choix_mag,
            'qte_2eme_choix' => $dataODATALastA->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATALastA->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $dataODATALastA->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATALastA->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $dataODATALastA->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATALastA->prix_coton_2eme_choix,
            'total_appareil_cdc' => $dataODATALastA->total_appareil_cdc,
            'total_engrais_cdc' => $dataODATALastA->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATALastA->total_herbicide_cdc,
            'total_insecticide_cdc' => $dataODATALastA->total_insecticide_cdc,
            'total_semence_cdc' => $dataODATALastA->total_semence_cdc, 'total_cdc' => $dataODATALastA->total_cdc,
            'total_appareil_clc' => $dataODATALastA->total_appareil_clc,
            'total_engrais_clc' => $dataODATALastA->total_engrais_clc, 'total_herbicide_clc' => $dataODATALastA->total_herbicide_clc,
            'total_insecticide_clc' => $dataODATALastA->total_insecticide_clc,
            'total_semence_clc' => $dataODATALastA->total_semence_clc,
            'total_clc' => $dataODATALastA->total_clc,
            'total_engrais' => $dataODATALastA->total_engrais,
            'total_herbicide' => $dataODATALastA->total_herbicide,
            'total_insecticide' => $dataODATALastA->total_insecticide,
            'total_semence' => $dataODATALastA->total_semence,
            'total_appareil' => $dataODATALastA->total_appareil,
            'total_appareil_bc' => $dataODATALastA->total_appareil_bc,
            'total_engrais_bc' => $dataODATALastA->total_engrais_bc, 'total_herbicide_bc' => $dataODATALastA->total_herbicide_bc,
            'total_insecticide_bc' => $dataODATALastA->total_insecticide_bc,
            'total_semence_bc' => $dataODATALastA->total_semence_bc, 'total_bc' => $dataODATALastA->total_bc,
            'total_appareil_mp' => $dataODATALastA->total_appareil_mp,
            'total_engrais_mp' => $dataODATALastA->total_engrais_mp, 'total_herbicide_mp' => $dataODATALastA->total_herbicide_mp,
            'total_insecticide_mp' => $dataODATALastA->total_insecticide_mp,
            'total_semence_mp' => $dataODATALastA->total_semence_mp, 'total_mp' => $dataODATALastA->total_mp,
            'total_montant_intrants' => $dataODATALastA->total_montant_intrants,
            'nom_zone' => $dataODATALastA->nom_zone, 'nom_section' => $dataODATALastA->nom_section, 'campagne_coton' => $dataODATALastA->campagne_coton, 'owner_name' => $dataODATALastA->owner_name]);
        }
         }
        
          $intrant_equipementsLastAb = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed?after_id=40000&limit=50000&offset=40000');
        
        $quizzesLastAb = json_decode($intrant_equipementsLastAb->body());


        $quizzes_araLastAb = array();
        foreach($quizzesLastAb as $quizzesLastb){
          array_push($quizzes_araLastAb, $quizzesLastb);
        }

       
         foreach($quizzes_araLastAb[2] as $dataODATALastAb){

             if($dataODATALastAb->campagne_coton == '23-24'){
            DB::table('intrant_equipements_checks')->insert(['caseid' => $dataODATALastAb->caseid, 'closed' => $dataODATALastAb->closed, 'campagne_coton' => $dataODATALastAb->campagne_coton,
            'type_marche' => $dataODATALastAb->type_marche, 'type_marche' => $dataODATALastAb->type_marche,
            'choix_formulaire_remplir' => $dataODATALastAb->choix_formulaire_remplir, 'code_scoop_producteur' => $dataODATALastAb->code_scoop_producteur,
            'nom_producteur' => $dataODATALastAb->nom_producteur, 'prenom_producteur' => $dataODATALastAb->prenom_producteur,
            'nom_scoop' => $dataODATALastAb->nom_scoop, 'superficie_prevu_producteur' => $dataODATALastAb->superficie_prevu_producteur, 'superficie_prevu_groupement' => $dataODATALastAb->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $dataODATALastAb->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $dataODATALastAb->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $dataODATALastAb->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $dataODATALastAb->nbre_appareil_pile_piece, 'nbre_epi_piece' => $dataODATALastAb->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $dataODATALastAb->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $dataODATALastAb->nbre_herbicides_pre_levee, 'prevision_de_production_scoop' => $dataODATALastAb->prevision_de_production_scoop,
            'nbre_herbicides_total' => $dataODATALastAb->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $dataODATALastAb->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $dataODATALastAb->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $dataODATALastAb->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $dataODATALastAb->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $dataODATALastAb->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $dataODATALastAb->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $dataODATALastAb->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $dataODATALastAb->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $dataODATALastAb->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $dataODATALastAb->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $dataODATALastAb->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $dataODATALastAb->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $dataODATALastAb->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $dataODATALastAb->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $dataODATALastAb->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $dataODATALastAb->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $dataODATALastAb->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $dataODATALastAb->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $dataODATALastAb->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $dataODATALastAb->qte_1er_choix,  'qte_1er_choix_mag' => $dataODATALastAb->qte_1er_choix_mag,
            'qte_2eme_choix' => $dataODATALastAb->qte_2eme_choix,  'qte_2eme_choix_mag' => $dataODATALastAb->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $dataODATALastAb->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $dataODATALastAb->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $dataODATALastAb->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $dataODATALastAb->prix_coton_2eme_choix,
            'total_appareil_cdc' => $dataODATALastAb->total_appareil_cdc,
            'total_engrais_cdc' => $dataODATALastAb->total_engrais_cdc, 'total_herbicide_cdc' => $dataODATALastAb->total_herbicide_cdc,
            'total_insecticide_cdc' => $dataODATALastAb->total_insecticide_cdc,
            'total_semence_cdc' => $dataODATALastAb->total_semence_cdc, 'total_cdc' => $dataODATALastAb->total_cdc,
            'total_appareil_clc' => $dataODATALastAb->total_appareil_clc,
            'total_engrais_clc' => $dataODATALastAb->total_engrais_clc, 'total_herbicide_clc' => $dataODATALastAb->total_herbicide_clc,
            'total_insecticide_clc' => $dataODATALastAb->total_insecticide_clc,
            'total_semence_clc' => $dataODATALastAb->total_semence_clc,
            'total_clc' => $dataODATALastAb->total_clc,
            'total_engrais' => $dataODATALastAb->total_engrais,
            'total_herbicide' => $dataODATALastAb->total_herbicide,
            'total_insecticide' => $dataODATALastAb->total_insecticide,
            'total_semence' => $dataODATALastAb->total_semence,
            'total_appareil' => $dataODATALastAb->total_appareil,
            'total_appareil_bc' => $dataODATALastAb->total_appareil_bc,
            'total_engrais_bc' => $dataODATALastAb->total_engrais_bc, 'total_herbicide_bc' => $dataODATALastAb->total_herbicide_bc,
            'total_insecticide_bc' => $dataODATALastAb->total_insecticide_bc,
            'total_semence_bc' => $dataODATALastAb->total_semence_bc, 'total_bc' => $dataODATALastAb->total_bc,
            'total_appareil_mp' => $dataODATALastAb->total_appareil_mp,
            'total_engrais_mp' => $dataODATALastAb->total_engrais_mp, 'total_herbicide_mp' => $dataODATALastAb->total_herbicide_mp,
            'total_insecticide_mp' => $dataODATALastAb->total_insecticide_mp,
            'total_semence_mp' => $dataODATALastAb->total_semence_mp, 'total_mp' => $dataODATALastAb->total_mp,
            'total_montant_intrants' => $dataODATALastAb->total_montant_intrants,
            'nom_zone' => $dataODATALastAb->nom_zone, 'nom_section' => $dataODATALastAb->nom_section, 'campagne_coton' => $dataODATALastAb->campagne_coton, 'owner_name' => $dataODATALastAb->owner_name]);
        } 
         }
 

     echo "okay done";

        $check1 = DB::table('intrant_equipements_checks')->pluck('caseid')->toArray();

        $check2 = DB::table('intrant_equipements_checks_intgood')->pluck('caseid')->toArray();

        $results = array_diff($check1, $check2);

        $show_result1s = array();
        foreach($results as $result)
        {

            $checkA1s = DB::table('intrant_equipements_checks')->where('caseid', $result)->get();

            foreach($checkA1s as $checkA1)
            {

                array_push($show_result1s, $checkA1);
            }
        }


         foreach($show_result1s as $show_result1){

              DB::table('intrant_equipements_checks_intgood')->insert(['caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 'campagne_coton' => $show_result1->campagne_coton,
            'type_marche' => $show_result1->type_marche, 'type_marche' => $show_result1->type_marche,
            'choix_formulaire_remplir' => $show_result1->choix_formulaire_remplir, 'code_scoop_producteur' => $show_result1->code_scoop_producteur,
            'nom_producteur' => $show_result1->nom_producteur, 'prenom_producteur' => $show_result1->prenom_producteur,
            'nom_scoop' => $show_result1->nom_scoop, 'superficie_prevu_producteur' => $show_result1->superficie_prevu_producteur,
            'superficie_prevu_groupement' => $show_result1->superficie_prevu_groupement,
            'nbre_appareil_atomiseur_piece' => $show_result1->nbre_appareil_atomiseur_piece, 'superficie_realise_producteur' => $show_result1->superficie_realise_producteur,
            'nbre_appareil_dos_piece' => $show_result1->nbre_appareil_dos_piece, 'nbre_appareil_pile_piece' => $show_result1->nbre_appareil_pile_piece, 'nbre_epi_piece' => $show_result1->nbre_epi_piece,
            'nbre_herbicides_post_levee' => $show_result1->nbre_herbicides_post_levee, 'nbre_herbicides_pre_levee' => $show_result1->nbre_herbicides_pre_levee,
            'prevision_de_production_scoop' => $show_result1->prevision_de_production_scoop,
            'nbre_herbicides_total' => $show_result1->nbre_herbicides_total, 'nbre_insecticides_type_1_specifiques_traitement' => $show_result1->nbre_insecticides_type_1_specifiques_traitement, 'nbre_insecticides_type_1_traitement' => $show_result1->nbre_insecticides_type_1_traitement,
            'nbre_insecticides_type_2_specifiques_traitement' => $show_result1->nbre_insecticides_type_2_specifiques_traitement, 'nbre_insecticides_type_2_traitement' => $show_result1->nbre_insecticides_type_2_traitement, 'nbre_insecticides_type_3_specifiques_traitement' => $show_result1->nbre_insecticides_type_3_specifiques_traitement,
            'nbre_insecticides_type_3_traitement' => $show_result1->nbre_insecticides_type_3_traitement, 'nbre_pieces_appareil_piece' => $show_result1->nbre_pieces_appareil_piece,
            'nbre_regulateur_croissance' => $show_result1->nbre_regulateur_croissance, 'nbre_sac_engrais_npk_fu_50kg' => $show_result1->nbre_sac_engrais_npk_fu_50kg, 'nbre_sac_engrais_uree_50kg' => $show_result1->nbre_sac_engrais_uree_50kg,
            'semence_conventionnelle_sac_15kg' => $show_result1->semence_conventionnelle_sac_15kg, 'semence_conventionnelle_sac_30kg' => $show_result1->semence_conventionnelle_sac_30kg, 'semence_conventionnelle_sac_45kg' => $show_result1->semence_conventionnelle_sac_45kg,
            'semence_ogm_sac_15kg' => $show_result1->semence_ogm_sac_15kg, 'semence_ogm_sac_30kg' => $show_result1->semence_ogm_sac_30kg,
            'semence_ogm_sac_45kg' => $show_result1->semence_ogm_sac_45kg, 'semences_delintee_conventionnelle_sac_15kg' => $show_result1->semences_delintee_conventionnelle_sac_15kg, 'semences_delintee_conventionnelle_sac_30kg' => $show_result1->semences_delintee_conventionnelle_sac_30kg,
            'semences_delintee_conventionnelle_sac_45kg' => $show_result1->semences_delintee_conventionnelle_sac_45kg,
            'qte_1er_choix' => $show_result1->qte_1er_choix,  'qte_1er_choix_mag' => $show_result1->qte_1er_choix_mag,
            'qte_2eme_choix' => $show_result1->qte_2eme_choix,  'qte_2eme_choix_mag' => $show_result1->qte_2eme_choix_mag,
            'total_prix_coton_1er_choix' => $show_result1->total_prix_coton_1er_choix,  'total_prix_coton_2eme_choix' => $show_result1->total_prix_coton_2eme_choix,
            'prix_coton_1er_choix' => $show_result1->prix_coton_1er_choix,  'prix_coton_2eme_choix' => $show_result1->prix_coton_2eme_choix,
            'total_appareil_cdc' => $show_result1->total_appareil_cdc,
            'total_engrais_cdc' => $show_result1->total_engrais_cdc, 'total_herbicide_cdc' => $show_result1->total_herbicide_cdc,
            'total_insecticide_cdc' => $show_result1->total_insecticide_cdc,
            'total_semence_cdc' => $show_result1->total_semence_cdc, 'total_cdc' => $show_result1->total_cdc,
            'total_appareil_clc' => $show_result1->total_appareil_clc,
            'total_engrais_clc' => $show_result1->total_engrais_clc, 'total_herbicide_clc' => $show_result1->total_herbicide_clc,
            'total_insecticide_clc' => $show_result1->total_insecticide_clc,
            'total_semence_clc' => $show_result1->total_semence_clc,
            'total_clc' => $show_result1->total_clc,
            'total_engrais' => $show_result1->total_engrais,
            'total_herbicide' => $show_result1->total_herbicide,
            'total_insecticide' => $show_result1->total_insecticide,
            'total_semence' => $show_result1->total_semence,
            'total_appareil' => $show_result1->total_appareil,
            'total_appareil_bc' => $show_result1->total_appareil_bc,
            'total_engrais_bc' => $show_result1->total_engrais_bc, 'total_herbicide_bc' => $show_result1->total_herbicide_bc,
            'total_insecticide_bc' => $show_result1->total_insecticide_bc,
            'total_semence_bc' => $show_result1->total_semence_bc, 'total_bc' => $show_result1->total_bc,
            'total_appareil_mp' => $show_result1->total_appareil_mp,
            'total_engrais_mp' => $show_result1->total_engrais_mp, 'total_herbicide_mp' => $show_result1->total_herbicide_mp,
            'total_insecticide_mp' => $show_result1->total_insecticide_mp,
            'total_semence_mp' => $show_result1->total_semence_mp, 'total_mp' => $show_result1->total_mp,
            'total_montant_intrants' => $show_result1->total_montant_intrants,
            'nom_zone' => $show_result1->nom_zone, 'nom_section' => $show_result1->nom_section, 'campagne_coton' => $show_result1->campagne_coton, 'owner_name' => $show_result1->owner_name]);




        } */
        $this->info('Le Code a été executé');
    }

}
