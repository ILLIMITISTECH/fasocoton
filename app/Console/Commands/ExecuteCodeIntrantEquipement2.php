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

class ExecuteCodeIntrantEquipement2 extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:intrant2";

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
        // DB::table('intrant_equipements_checks2')->delete();  
        
        
        
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
                if($dataODATA->campagne_coton == '24-25'){
                // Vérifiez si l'enregistrement existe déjà dans la base de données
                $existingRecord = DB::table('intrant_equipements_checks2')->where('caseid', $dataODATA->caseid)->first();
                
                // Si l'enregistrement n'existe pas, insérez-le
                if (!$existingRecord) {
                  
                    DB::table('intrant_equipements_checks2')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 'campagne_coton' => $dataODATA->campagne_coton,
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

     
        $this->info('Le Code a été executé');
    }

}
