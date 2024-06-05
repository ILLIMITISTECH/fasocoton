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
use GuzzleHttp\Client;


class ExecuteCodeIntrantEquipementBackup extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:intrantbackup";

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
        DB::table('intrant_equipementss_backs')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('intrant_equipementss_backs')->where('closed', '1')->update(['closed' => 'true']);
        DB::table('intrant_equipementss_checks')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('intrant_equipementss_checks')->where('closed', '1')->update(['closed' => 'true']);
        DB::table('intrant_equipementss_checks')->where('campagne_coton', '22-23')->delete();
        DB::table('intrant_equipementss_checks')->where('campagne_coton', '2022-2023')->delete();
        DB::table('intrant_equipementss_checks')->where('campagne_coton', '2021-2022')->delete();
        DB::table('intrant_equipementss_checks')->where('campagne_coton', '---')->delete();
        // end point block 10 0000     new https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/e04fadbd7d3461ca1e998a326c7ab21d/feed 
        // DB::table('intrant_equipementss_backs')->delete();  
     //   last https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/09f3893d36673a6c2d518a8d879b9e1c/feed
       // $parcelles = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/09f3893d36673a6c2d518a8d879b9e1c/feed?limit=50000');
       // $quizzes = json_decode($parcelles->body());
      //  dd($quizzes);
          $url = "https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/09f3893d36673a6c2d518a8d879b9e1c/feed";

        $client = new Client();

        do {
           $response = $client->request('GET', $url, [
               'auth' => ['fallou.g@illimitis.com', '12Sonatel']
            ]);

            $body = json_decode($response->getBody(), true);
            $data = $body['value'];
            
            foreach ($data as $item) {
             
                                DB::table('intrant_equipementss_backs')->insert($item);
                     
            }
            
           /* foreach ($data as $item) {
             
                                DB::table('intrant_equipementss_checks')->insert($item);
                     
            } */

            $url = $body['@odata.nextLink'] ?? null;
        } while ($url);
        
       // echo 'okay';
        
        
           
           
     /*   $check1 = DB::table('intrant_equipementss_backs')->pluck('caseid')->toArray();
        
        $check2 = DB::table('intrant_equipementss_checks')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('intrant_equipementss_backs')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
             if ($show_result1->campagne_coton == '23-24') {
                    DB::table('intrant_equipementss_checks')->insert($show_result1);
             }
            
        }
        
        foreach($show_result1s as $show_result1){
             if ($show_result1->campagne_coton == '24-25') {
                    DB::table('intrant_equipementss_checks')->insert($show_result1);
             }
            
        } */


        
    
     echo "okay done";

    /*    $check1 = DB::table('intrant_equipementss_backs')->pluck('caseid')->toArray();

        $check2 = DB::table('intrant_equipements_checks_intgood')->pluck('caseid')->toArray();

        $results = array_diff($check1, $check2);

        $show_result1s = array();
        foreach($results as $result)
        {

            $checkA1s = DB::table('intrant_equipementss_backs')->where('caseid', $result)->get();

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
