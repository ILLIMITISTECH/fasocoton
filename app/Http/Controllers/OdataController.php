<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Producteur;
use Illuminate\Support\Facades\Http;
use DB;
use Auth;

class OdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *filtreProdGrpmt  
     * @return \Illuminate\Http\Response
     */
     
     
       public function getcheckapi()
    {
        // https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/d313e25768c6aafb1cba2e4fdef956ab/feed
        $url = "https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/f9eef4d068b9d1c9ac0c5b2f1ecdbd2c/feed?offset=0&limit=1000000&after_id=10000";
        
            $ch = curl_init($url); // such as http://example.com/example.xml
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "fallou.g@illimitis.com:12Sonatel");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'));
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            
            $result = curl_exec($ch);
             $data = json_decode( $result, true );
            curl_close($ch);
            dd($data);
            return $data;
    }
     
     
     
     
    public function lister()
    {  
        
  
      
        $pro = array();
        $proh = 0;
            
            // $prod = DB::table('producteurs')->count();
            // dd($prod);
            //producteurs
            $producteursH = DB::table('producteurs')
            ->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'homme')
            ->get();
            
            // dd($producteursH);
            
           
            
            $producteursF = DB::table('producteurs')
            ->select('producteurs.*')
          
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            // $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $scoops = DB::table('scoops')->where('closed', 'false')->where('code_scoop','<>','---')->where('owner_name','<>','demo')
           // ->where('campagne_coton', '=' , '23-24')
            ->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
           ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_montant_intrants');
            
             //$clc = $clc_total_cls + $clc_total__montant_intrant;
             $clc =  $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_montant_intrants');
            

            $mise_en_place = DB::table('intrant_equipements')
           ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            //$production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
             ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            //$qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qte_1_choix + $prix_coton_1_choix;
            //$qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qte_2_choix + $prix_coton_2_choix;
            $production_valoriseesOld = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*') 
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')->where('owner_name', '<>', 'demo.ac')
            //->where('campagne_coton', '=', '23-24')
            ->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')->where('owner_name', '<>', 'demo.ac')
            //->where('campagne_coton', '=', '23-24')
            ->sum('superficie_mesuree_ha');
            
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $mise_en_place - $production_valorisee;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.index', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
    public function zone()
    {  
            
           
                
            $producteursH = DB::table('producteurs')
            ->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'homme')
            ->where('producteurs.nom_zone', Auth::user()->nom_role)
            ->count();
            
            $producteursF = DB::table('producteurs')
            ->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'femme')
            ->where('producteurs.nom_zone', Auth::user()->nom_role)
           ->count();
            
          
            
            $producteursTotal = (int)$producteursF + (int)$producteursH;
            
            // dd($dataCount);

            //scoops
            $scoops = DB::table('scoops')
            ->where('closed', 'false')
            ->where('zone', Auth::user()->nom_role)
            ->where('owner_name',  '<>',  'demo')
            ->where('owner_name',  '<>',  'demo.ac')
           // ->groupBy('campagne_coton')
             //->where('campagne_coton', '23-24')
            ->get();
           // dd($scoops);
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
          
            
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_montant_intrants');
            
             $clc =  $clc_total__montant_intrant;
            

            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_montant_intrants');
            

            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
             ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
             ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix;
            $qt1er = $qte_1_choix + $prix_coton_1_choix;
            $qt2 = $qte_2_choix;
            $qt2eme = $qte_2_choix + $prix_coton_2_choix;
            $production_valoriseeold = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->sum('superficie_mesuree_ha');
            
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $mise_en_place - $production_valorisee;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.zone', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
     public function zorgho()
    {  
        //
        $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       //dd($dataODATAIntrant['value']);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
        
      
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        $pro = array();
        $proh = 0;
           
            //producteurs
            $producteursH = DB::table('producteurs')
            //->where('genre', 'homme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            ->where('producteurs.genre', 'homme')
            ->get();
            $producteursF = DB::table('producteurs')
            //->where('genre', 'femme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_prevu_groupement','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_realise_producteur','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            //$clc_total_cls = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_clc');
            //$clc_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
            //$clc = $clc_total_cls + $clc_total__montant_intrant;
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_clc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc = $clc_total_cls + $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_cdc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->sum('intrant_equipements.total_cdc');
            
            //$besoin_complementaire_total_bc = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_bc');
            //$besoin_complementaire_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$besoin_complementaire_total_bc + $besoin_complementaire_total__montant_intrant;
            
           // $mise_en_place_total_mp = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_mp');
            //$mise_en_place_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.total_montant_intrants');
            
            
            
            $prevision_de_production = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prevision_de_production_scoop');
            ->select('intrant_equipements.id', 'intrant_equipements.prevision_de_production_scoop','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'ZORGHO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valorisee = $qt1er + $qt2eme;
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->sum('superficie_mesuree_ha');
            
          
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $mise_en_place - $production_valorisee;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.zorgho', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
     public function tenkodogo()
    {  
        //
        $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       //dd($dataODATAIntrant['value']);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
        
      
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        $pro = array();
        $proh = 0;
           
            //producteurs
            $producteursH = DB::table('producteurs')
            //->where('genre', 'homme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            ->where('producteurs.genre', 'homme')
            ->get();
            $producteursF = DB::table('producteurs')
            //->where('genre', 'femme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_prevu_groupement','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_realise_producteur','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            //$clc_total_cls = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_clc');
            //$clc_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
            //$clc = $clc_total_cls + $clc_total__montant_intrant;
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_clc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc = $clc_total_cls + $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_cdc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->sum('intrant_equipements.total_cdc');
            
            //$besoin_complementaire_total_bc = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_bc');
            //$besoin_complementaire_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$besoin_complementaire_total_bc + $besoin_complementaire_total__montant_intrant;
            
           // $mise_en_place_total_mp = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_mp');
            //$mise_en_place_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.total_montant_intrants');
            
           
            $prevision_de_production = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prevision_de_production_scoop');
            ->select('intrant_equipements.id', 'intrant_equipements.prevision_de_production_scoop','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'TENKODOGO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valorisee = $qt1er + $qt2eme;
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->sum('superficie_mesuree_ha');
            
          
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $production_valorisee - $mise_en_place;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.tenkodogo', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
     public function manga()
    {  
        //
        $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       //dd($dataODATAIntrant['value']);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
        
      
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        $pro = array();
        $proh = 0;
           
            //producteurs
            $producteursH = DB::table('producteurs')
            //->where('genre', 'homme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            ->where('producteurs.genre', 'homme')
            ->get();
            $producteursF = DB::table('producteurs')
            //->where('genre', 'femme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_prevu_groupement','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_realise_producteur','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            //$clc_total_cls = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_clc');
            //$clc_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
            //$clc = $clc_total_cls + $clc_total__montant_intrant;
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_clc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc = $clc_total_cls + $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_cdc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->sum('intrant_equipements.total_cdc');
            
            //$besoin_complementaire_total_bc = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_bc');
            //$besoin_complementaire_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$besoin_complementaire_total_bc + $besoin_complementaire_total__montant_intrant;
            
           // $mise_en_place_total_mp = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_mp');
            //$mise_en_place_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.total_montant_intrants');
            
           
            
            $prevision_de_production = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prevision_de_production_scoop');
            ->select('intrant_equipements.id', 'intrant_equipements.prevision_de_production_scoop','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'MANGA')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valorisee = $qt1er + $qt2eme;
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->sum('superficie_mesuree_ha');
            
           
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $production_valorisee - $mise_en_place;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.manga', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
     public function po()
    {  
        //
        $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       //dd($dataODATAIntrant['value']);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
        
      
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        $pro = array();
        $proh = 0;
           
            //producteurs
            $producteursH = DB::table('producteurs')
            //->where('genre', 'homme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            ->where('producteurs.genre', 'homme')
            ->get();
            $producteursF = DB::table('producteurs')
            //->where('genre', 'femme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_prevu_groupement','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_realise_producteur','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            //$clc_total_cls = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_clc');
            //$clc_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
            //$clc = $clc_total_cls + $clc_total__montant_intrant;
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_clc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc = $clc_total_cls + $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_cdc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->sum('intrant_equipements.total_cdc');
            
            //$besoin_complementaire_total_bc = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_bc');
            //$besoin_complementaire_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$besoin_complementaire_total_bc + $besoin_complementaire_total__montant_intrant;
            
           // $mise_en_place_total_mp = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_mp');
            //$mise_en_place_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.total_montant_intrants');
         
            $prevision_de_production = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prevision_de_production_scoop');
            ->select('intrant_equipements.id', 'intrant_equipements.prevision_de_production_scoop','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'PO')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valorisee = $qt1er + $qt2eme;
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->sum('superficie_mesuree_ha');
            
        
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $production_valorisee - $mise_en_place;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.po', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
     public function kombissiri()
    {  
        //
        $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       //dd($dataODATAIntrant['value']);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
        
      
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        $pro = array();
        $proh = 0;
           
            //producteurs
            $producteursH = DB::table('producteurs')
            //->where('genre', 'homme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            ->where('producteurs.genre', 'homme')
            ->get();
            $producteursF = DB::table('producteurs')
            //->where('genre', 'femme')->where('closed', 'false')
            ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
            ->where('producteurs.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            ->where('producteurs.genre', 'femme')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            //$superficie_prevue = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_prevu_groupement');
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_prevu_groupement','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_prevu_groupement');
            
            //$superficie_realise = DB::table('intrant_equipements')->where('closed', 'false')->sum('superficie_realise_producteur');
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.superficie_realise_producteur','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            //$clc_total_cls = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_clc');
            //$clc_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
            //$clc = $clc_total_cls + $clc_total__montant_intrant;
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_clc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc = $clc_total_cls + $clc_total__montant_intrant;
            
            //$cdc = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
            
            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_cdc','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->sum('intrant_equipements.total_cdc');
            
            //$besoin_complementaire_total_bc = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_bc');
            //$besoin_complementaire_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$besoin_complementaire_total_bc + $besoin_complementaire_total__montant_intrant;
            
           // $mise_en_place_total_mp = 0; //DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_mp');
            //$mise_en_place_total__montant_intrant = DB::table('intrant_equipements')->where('closed', 'false')->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.id', 'intrant_equipements.total_montant_intrants','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.total_montant_intrants');
            
            //$mise_en_place_total_mp + $mise_en_place_total__montant_intrant;
            
            //$prevision_de_production = DB::table('intrant_equipements')->where('closed', 'false')->sum('prevision_de_production_scoop');
           // $qte_1_choix = DB::table('intrant_equipements')->where('closed', 'false')->sum('qte_1er_choix');
            //$qte_1_choix_mag = DB::table('intrant_equipements')->where('closed', 'false')->sum('qte_1er_choix_mag');
           // $qte_2_choix = DB::table('intrant_equipements')->where('closed', 'false')->sum('qte_2eme_choix');
           // $qte_2_choix_mag = DB::table('intrant_equipements')->where('closed', 'false')->sum('qte_2eme_choix_mag');
            //$production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
           // $prix_coton_1_choix = DB::table('intrant_equipements')->where('closed', 'false')->sum('prix_coton_1er_choix');
            //$prix_coton_2_choix = DB::table('intrant_equipements')->where('closed', 'false')->sum('prix_coton_2eme_choix');
            
            $prevision_de_production = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prevision_de_production_scoop');
            ->select('intrant_equipements.id', 'intrant_equipements.prevision_de_production_scoop','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_1er_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_1er_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('qte_2eme_choix_mag');
            ->select('intrant_equipements.id', 'intrant_equipements.qte_2eme_choix_mag','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_1_choix_mag + $qte_2_choix + $qte_2_choix_mag;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_1er_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_1er_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            //->where('closed', 'false')->sum('prix_coton_2eme_choix');
            ->select('intrant_equipements.id', 'intrant_equipements.prix_coton_2eme_choix','intrant_equipements.campagne_coton',
            'intrant_equipements.closed', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
            ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
            ->where('intrant_equipements.closed', 'false')
            ->where('scoops.closed', 'false')
            ->where('scoops.zone', 'KOMBISSIRI')
            //->where('intrant_equipements.closed', 'false')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valorisee = $qt1er + $qt2eme;
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->sum('supercifie_declaree');
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->sum('superficie_mesuree_ha');
            
        
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $production_valorisee - $mise_en_place;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.kombissiri', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
    public function producteurs()
    {
        $producteurs = DB::table('producteurs')->select('scoops.code_scoop', 'producteurs.prenom_producteur','producteurs.nom_producteur',
        'producteurs.code_producteur','producteurs.code_scoop_producteur','producteurs.date_de_naissance',
        'scoops.nom_scoop', 'producteurs.closed', 'scoops.village', 'scoops.closed','scoops.owner_name','producteurs.owner_name')
        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.closed', 'false')
        ->where('scoops.closed', 'false')
        ->where('producteurs.prenom_producteur', '!=', null)
        ->where('producteurs.prenom_producteur', '!=', '---')
        ->where('producteurs.nom_producteur', '!=', null)
        ->where('producteurs.genre', '!=', null)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('scoops.owner_name', '<>', 'demo')
        ->paginate(20);
        
        return view('MobiagriDashboard.producteur', compact('producteurs'));
    }
    
    public function scoops()
    {
        $scoops = DB::table('scoops')->where('owner_name',  '<>',  'demo')->where('closed', 'false')->paginate(20);
       
        return view('MobiagriDashboard.liste_scoops', compact('scoops'));
    }

    public function prodGrpmt()
    {
        $campagnes = DB::table('producteurs')
        ->select('producteurs.campagne_coton', 'producteurs.owner_name', 'producteurs.closed')
        ->where('producteurs.campagne_coton','<>', '')
        ->where('producteurs.campagne_coton','<>', '---')
        ->where('producteurs.owner_name',  '<>',  'demo')
        ->where('producteurs.closed',  'false')
        ->where('producteurs.actif', 1)
        ->where('producteurs.campagne_coton','<>','2021-2022')
        ->where('producteurs.campagne_coton','<>','2022-2023')
        ->where('producteurs.campagne_coton','<>','21-22')
        ->groupBy('producteurs.campagne_coton')
        ->get();
        
        $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre total de producteurs';
                $sections = DB::table('scoops')->select('section')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get();
                if (Auth::user()->nom_role == 'admin') {
                    
                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();

                  /*  $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->distinct()
                        ->get(); */

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    
                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                ->where('producteurs.nom_section', Auth::user()->section)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();

                   /* $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_section',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('producteurs.nom_section', Auth::user()->section)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->where('scoops.section', Auth::user()->section)
                        ->get(); */

                    $dataCount = $datas->count();

                
                } else {

                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('scoops.zone', Auth::user()->nom_role)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
                 /*   $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur','!=','---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get(); */

                    $dataCount = $datas->count();

                }

        return view('MobiagriDashboard.prod_grpmt', compact('campagnes', 'dataCount', 'datas', 'title', 'sections','img'));
    }
    
    public function prodGrpmt_zone()
    {
        $campagnes = DB::table('producteurs')
        ->select('producteurs.campagne_coton', 'producteurs.owner_name', 'producteurs.actif', 
        'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton','<>', '')
        ->where('producteurs.campagne_coton','<>', '---')
        ->groupBy('campagne_coton')
        ->where('producteurs.owner_name',  '<>',  'demo')
        ->where('scoops.owner_name',  '<>',  'demo')
        ->where('producteurs.closed',  'false')
        ->where('producteurs.actif', 1)
        ->where('scoops.closed',  'false')
        ->get();
        
        return view('MobiagriDashboard.prod_grpmt_zone', compact('campagnes'));
    }

    public function selectCampagneProducteur()
    {
        $data = DB::table('producteurs')->select('campagne_coton')->where('campagne_coton', '<>', '')->where('campagne_coton', '<>', '---')->where('actif', '1')->where('closed', 'false')->where('owner_name', '<>', 'demo')->groupBy('campagne_coton')->get();
        return response()->json($data);
    }

    public function selectZoneProducteur()
    {
        $data = DB::table('producteurs')->join('scoops', 'producteurs.code_scoop_producteur', 'scoops.code_scoop')
            ->select('scoops.zone')
            ->where('scoops.zone', '<>', '')
            ->where('scoops.zone', '<>', '---')
            ->where('scoops.closed', 'false')
            ->where('scoops.owner_name', '<>', 'demo')
            ->groupBy('scoops.zone')->get();

        return response()->json($data);
    }

    public function selectScoop()
    {
        if (Auth::user()->nom_role == 'admin') {
            $data = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.zone', 'scoops.village')
                ->where('scoops.closed', 'false')
                ->where('scoops.code_scoop', '<>', '---')
                ->where('scoops.owner_name', '<>', 'demo')
                ->groupBy('code_scoop')->get();
        } elseif (Auth::user()->nom_role == 'ca') {
            $section = Auth::user()->section;
            
            $data = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.zone', 'scoops.village')
                ->where('scoops.closed', 'false')
                ->where('scoops.code_scoop', '<>', '---')
                ->where('scoops.section', $section)
                ->groupBy('code_scoop')->get();        } 
        else {
            $zone = Auth::user()->nom_role;

            $data = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.zone', 'scoops.village')
                ->where('scoops.closed', 'false')
                ->where('scoops.code_scoop', '<>', '---')
                ->where('scoops.zone', $zone)
                ->groupBy('code_scoop')->get();        }
        

        return response()->json($data);
    }

    public function selectZoneScoop($zone)
    {
        $data = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.zone', 'scoops.village')
            ->where('scoops.closed', 'false')
            ->where('scoops.code_scoop', '<>', '---')
            ->where('scoops.zone', $zone)
            ->groupBy('code_scoop')->get();        

        return response()->json($data);
    }

    public function selectSection($value)
    {
        $data = DB::table('scoops')->select('section')
            ->where('zone', $value)
            ->where('section', '<>', '')
            ->where('section', '<>', '---')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->groupBy('section')->get();

        return response()->json($data);
    }

    public function adminFiltreGroupement(Request $request)
    {
        // dd($request->all());
        $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
        $title = 'Nombre de Groupements';
        $campagnes = DB::table('producteurs')->select('campagne_coton')->where('campagne_coton', '<>', '')->where('campagne_coton', '<>', '---')->where('campagne_coton','<>','2021-2022')
        ->where('campagne_coton','<>','2022-2023')
        ->where('campagne_coton','<>','21-22')->groupBy('campagne_coton')->get();
        $sections = DB::table('scoops')->select('section')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get();

        switch ($request->optRadio) {
            case 'zone':
                if (Auth::user()->nom_role == 'admin') {

                    $datas = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.village')
                        ->where('scoops.closed', 'false')
                        ->where('scoops.code_scoop', '<>', '---')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->where('scoops.zone', $request->zone)                        
                        ->get();

                    $dataCount = $datas->count();
                } elseif (Auth::user()->nom_role == 'ca') {

                    $datas = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('section', Auth::user()->section)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->count();
                }
                
                break;
            case 'section':
                if (Auth::user()->nom_role == 'admin') {

                    $datas = DB::table('scoops')->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.village')
                        ->where('scoops.closed', 'false')
                        ->where('scoops.code_scoop', '<>', '---')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->where('scoops.zone', $request->zone)
                        ->where('scoops.section', $request->section)
                        ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {

                    $datas = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('section', Auth::user()->section)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->count();
                } else {

                    $datas = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('scoops.section', $request->section)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->count();
                }
                break;
        }

        $route = 'prodGrpmt';
        return view('MobiagriDashboard.detail_filtre_rapport', ['dataCount' => $dataCount, 'campagnes' => $campagnes, 'img' => $img, 'title' => $title, 'route' => $route, 'datas' => $datas, 'sections' => $sections]);

    }

    public function adminFiltreProducteur(Request $request)
    {
        // dd($request->all());
        $campagnes = DB::table('producteurs')->select('campagne_coton')->where('campagne_coton', '<>', '')->where('campagne_coton', '<>', '---')->where('campagne_coton','<>','2021-2022')
        ->where('campagne_coton','<>','2022-2023')
        ->where('campagne_coton','<>','21-22')->groupBy('campagne_coton')->get();

        $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
        $title = 'Nombre total de producteurs';
        $sections = DB::table('scoops')->select('section')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get();
        switch ($request->optRadio) {
            case 'campagne':

                if (Auth::user()->nom_role == 'admin') {
                    
                     $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();

                  /*  $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    
                     $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('producteurs.nom_section', Auth::user()->section)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                   /* $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.nom_section',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('producteurs.nom_section', Auth::user()->section)
                    ->where('producteurs.campagne_coton', $request->campagne)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get(); */

                    $dataCount = $datas->count();
                } else {
                    
                    
                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('producteurs.nom_zone', Auth::user()->nom_role)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
                    /* $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                        )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.zone', Auth::user()->nom_role)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                }
                break;
            case 'zone':
                if (Auth::user()->nom_role == 'admin') {
                    
                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('producteurs.nom_zone', $request->zone)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();

                    /*$datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('scoops.zone', $request->zone)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                } elseif (Auth::user()->nom_role == 'ca') {

                         $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                               ->where('producteurs.nom_section', Auth::user()->section)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
                    /*$datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.section', Auth::user()->section)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                } else {


                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                ->where('producteurs.nom_zone', Auth::user()->nom_role)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                   /* $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.zone', Auth::user()->nom_role)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                }
                break;
            case 'section':
                if (Auth::user()->nom_role == 'admin') {


                     $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                ->where('producteurs.nom_zone', $request->zone)
                                ->where('producteurs.nom_section', $request->section)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
                    /*$datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('scoops.zone', $request->zone)
                        ->where('scoops.section', $request->section)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                } elseif (Auth::user()->nom_role == 'ca') {


                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                 ->where('producteurs.nom_section', Auth::user()->section)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
                    /*$datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.section', Auth::user()->section)
                        ->where('producteurs.campagne_coton', $request->campagne)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get(); */

                    $dataCount = $datas->count();
                } else {
                    
                    $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                ->where('producteurs.nom_zone', Auth::user()->nom_role)
                                ->where('producteurs.nom_section', $request->section)
                               ->where('producteurs.campagne_coton', $request->campagne)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                    
                  /*  $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'producteurs.campagne_coton',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.section', $request->section)
                    ->where('producteurs.campagne_coton', $request->campagne)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get(); */

                    $dataCount = $datas->count();
                }
            break;
            case 'scoop':
                
                $datas = DB::table('producteurs')->select('producteurs.*')
                              ->where('producteurs.closed', 'false')
                              ->where('producteurs.owner_name', '<>', 'demo')
                               ->where('producteurs.owner_name', '<>', 'demo.ac')
                               ->where('producteurs.actif', 1)
                                ->where('producteurs.code_scoop_producteur', $request->scoop)
                               ->whereIn('producteurs.genre', ['homme', 'femme'])
                              ->get();
                              
               /* $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.zone',
                    'scoops.section',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'producteurs.campagne_coton',
                    'scoops.closed'
                )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.code_scoop_producteur', $request->scoop)
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get(); */

                $dataCount = $datas->count();
                
            break;
            
        }

        $route = 'prodGrpmt';
        return view('MobiagriDashboard.detail_filtre_rapport', ['dataCount' => $dataCount, 'campagnes' => $campagnes, 'img' => $img, 'title' => $title, 'route' => $route, 'datas' => $datas, 'sections' => $sections]);

    }


    public function filtreProdGrpmt(Request $request)
    {
       
        $campagnes = DB::table('producteurs')->select('campagne_coton')->where('campagne_coton', '<>', '')->where('campagne_coton', '<>', '---')->groupBy('campagne_coton')->where('campagne_coton','<>','2021-2022')
        ->where('campagne_coton','<>','2022-2023')
        ->where('campagne_coton','<>','21-22')->get();
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de Groupements';
                if (Auth::user()->nom_role == 'admin') {

                    $datas = DB::table('scoops')->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->count();
                    $sections = '';
                } elseif (Auth::user()->nom_role == 'ca') {
                    // $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    
                    $datas = DB:: table('scoops') -> where('section', Auth:: user() -> section) -> where('closed', 'false') -> where('code_scoop', '<>', '---') -> get();

                    // $datas = DB::table('producteurs')
                    //     ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    //     ->select('scoops.nom_scoop', 'scoops.code_scoop', 'scoops.section','scoops.zone', 'scoops.village')
                    //     ->where('actif', '1')
                    //     ->where('producteurs.closed', 'false')
                    //     ->where('producteurs.owner_name', $owner_name)
                    //     ->groupBy('code_scoop_producteur')
                    //     ->get();
                    
                    $sections = '';
                    $dataCount = $datas->count();
                
                } else {
                
                    $datas = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $sections = DB::table('scoops')->select('section')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get();
                    $dataCount = $datas->count();
                
                }
                
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre total de producteurs';
                $sections = DB::table('scoops')->select('section')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get();
                if (Auth::user()->nom_role == 'admin') {

                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;

                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.nom_section',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('producteurs.nom_section', Auth::user()->section)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();

                
                } else {

                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur','!=','---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                }

                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs (Hommes)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.genre', 'homme')
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();
                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.section', Auth::user()->section)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.genre', 'homme')
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                        ->where('scoops.zone', Auth::user()->nom_role)
                        ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.genre', 'homme')
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();
                }
                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerFemal.png';
                $title = 'Nombre de producteurs (Femmes)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.zone',
                        'scoops.section',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                        ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.genre', 'femme')
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();
                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                        ->where('producteurs.prenom_producteur', '!=', null)
                        ->where('producteurs.prenom_producteur', '!=', '---')
                        ->where('producteurs.nom_producteur', '!=', null)
                        ->where('producteurs.nom_producteur', '!=', '---')
                        ->where('producteurs.genre', '!=', null)
                        ->where('producteurs.genre', '!=', '---')
                        ->where('producteurs.actif', 1)
                        ->where('producteurs.genre', 'femme')
                        ->where('producteurs.owner_name', '<>', 'demo')
                        ->where('scoops.owner_name', '<>', 'demo')
                        ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.genre', 'femme')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs individuels';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    
                    $datas = DB::table('producteur_individuels')
                        ->where('closed', 'false')
                        ->where('owner_name', '<>', 'demo')
                        ->where('code_producteur', '<>', null)
                        ->get();

                        $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {

                    $datas = DB::table('producteur_individuels')
                        ->where('section', Auth::user()->section)
                        ->where('closed', 'false')
                        ->where('owner_name', '<>', 'demo')
                        ->where('code_producteur', '<>', null)
                        ->get();

                    $dataCount = $datas->count();

                } else {

                    $datas = DB::table('producteur_individuels')
                        ->where('zone', Auth::user()->nom_role)
                        ->where('closed', 'false')
                        ->where('owner_name', '<>', 'demo')
                        ->where('code_producteur', '<>', null)
                        ->get();

                    $dataCount = $datas->count();

                }

                break;
            case '6':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs ni alphabétisés ni scolarisés';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'ni_alphabtise_ni_scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'ni_alphabtise_ni_scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'ni_alphabtise_ni_scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }
                break;
            case '7':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de producteurs scolarisés';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '8':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de producteurs Alphabétisés';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'alphabtise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('niveau_dalphabetisation', 'scolarise')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '9':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs manuels (N)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'n')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'n')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'n')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '10':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs en cours d’équipement (A)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'a')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'a')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'a')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '11':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs avec équipements complets (E)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'e')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'e')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'e')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                break;
            case '12':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs motorisés (ET)';
                $sections = '';
                if (Auth::user()->nom_role == 'admin') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'et')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();

                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.section', Auth::user()->section)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'et')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                } else {
                    $datas = DB::table('producteurs')->select(
                        'scoops.code_scoop',
                        'producteurs.prenom_producteur',
                        'producteurs.nom_producteur',
                        'producteurs.code_producteur',
                        'producteurs.code_scoop_producteur',
                        'producteurs.date_de_naissance',
                        'scoops.nom_scoop',
                        'producteurs.closed',
                        'scoops.village',
                        'scoops.owner_name',
                        'producteurs.owner_name',
                        'scoops.closed'
                    )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.nom_producteur', '!=', '---')
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.genre', '!=', '---')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'et')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->get();

                    $dataCount = $datas->count();
                }

                
                break;
        }

        $route = 'prodGrpmt';
        return view('MobiagriDashboard.detail_filtre_rapport', ['sections' => $sections, 'dataCount' => $dataCount, 'campagnes' => $campagnes, 'img' =>$img, 'title' =>$title, 'route' => $route, 'datas' => $datas]);
    }
    
    
    public function filtreProdGrpmt_zone(Request $request)
    {
       
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de Groupements';                
                $datas = DB::table('scoops')->where('closed', 'false')
                ->where('zone', Auth::user()->nom_role)
                ->where('code_scoop','<>','---')
                ->where('owner_name', '<>', 'demo')->get();
                
                $dataCount = $datas->count();
                
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre total de producteurs';

                $producteursH = DB::table('producteurs')
                    ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.owner_name',
                    'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('producteurs.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.genre', 'homme')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->count();

                $producteursF = DB::table('producteurs')
                    ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.owner_name',
                    'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('producteurs.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.genre', 'femme')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->count();

                $dataCount = (int)$producteursF + (int)$producteursH;

                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'scoops.zone',
                    'scoops.closed'
                )
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.prenom_producteur', '!=', null)
                ->where('producteurs.prenom_producteur', '!=', '---')
                ->where('producteurs.nom_producteur', '!=', null)
                ->where('producteurs.genre', '!=', null)
                ->where('producteurs.actif', 1)
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();

                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs (Hommes)';
                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'scoops.zone',
                    'scoops.closed'
                )
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.prenom_producteur', '!=', null)
                ->where('producteurs.prenom_producteur', '!=', '---')
                ->where('producteurs.nom_producteur', '!=', null)
                ->where('producteurs.genre', '!=', null)
                ->where('producteurs.actif', 1)
                ->where('producteurs.genre', 'homme')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();
                
                $dataCount = $datas->count();
                
                // dd($dataCount);

                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerFemal.png';
                $title = 'Nombre de producteurs (Femmes)';

                $datas = DB::table('producteurs')->select(
                'scoops.code_scoop',
                'producteurs.prenom_producteur',
                'producteurs.nom_producteur',
                'producteurs.code_producteur',
                'producteurs.code_scoop_producteur',
                'producteurs.date_de_naissance',
                'scoops.nom_scoop',
                'producteurs.closed',
                'scoops.village',
                'scoops.owner_name',
                'producteurs.owner_name',
                'scoops.zone',
                'scoops.closed'
                )
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.prenom_producteur', '!=', null)
                ->where('producteurs.prenom_producteur', '!=', '---')
                ->where('producteurs.nom_producteur', '!=', null)
                ->where('producteurs.genre', '!=', null)
                ->where('producteurs.actif', 1)
                ->where('producteurs.genre', 'femme')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();
                
                $dataCount = $datas->count();
                
                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs individuels';

                $dataCount = DB::table('producteur_individuels')
                ->where('closed', 'false')
                ->count();

                $datas = DB::table('producteur_individuels')
                ->where('closed', 'false')
                ->get();

                break;
            case '6':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs non-membres';
                $dataCount = 0;
                $datas =  '';
                break;
            case '7':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de producteurs scolarisés';

                $dataCount = DB::table('producteurs')
                // ->where('closed', 'false')
                // ->where('actif', 1)
                // ->where('niveau_dalphabetisation', 'scolarise')
                // ->where('owner_name', '<>', 'demo')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.niveau_dalphabetisation',  'producteurs.closed', 'producteurs.actif', 'producteurs.owner_name',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.niveau_dalphabetisation', 'scolarise')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas='';
                break;
            case '8':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de producteurs Alphabétisés';

                $dataCount = DB::table('producteurs')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.niveau_dalphabetisation', 'producteurs.actif', 'producteurs.owner_name',
                 'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.niveau_dalphabetisation', 'scolarise')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas ='';
                break;
            case '9':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs manuels (N)';

                $dataCount = DB::table('producteurs')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed','producteurs.type_exploitation', 'producteurs.actif', 'producteurs.owner_name',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.type_exploitation', 'n')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'producteurs.type_exploitation',
                    'scoops.zone',
                    'scoops.closed'
                )
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.prenom_producteur', '!=', null)
                ->where('producteurs.prenom_producteur', '!=', '---')
                ->where('producteurs.nom_producteur', '!=', null)
                ->where('producteurs.genre', '!=', null)
                ->where('producteurs.actif', 1)
                ->where('type_exploitation', 'n')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();

                break;
            case '10':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs en cours d’équipement (A)';

                $dataCount = DB::table('producteurs')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.type_exploitation', 'producteurs.actif', 'producteurs.owner_name',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.type_exploitation', 'a')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'producteurs.type_exploitation',
                    'scoops.zone',
                    'scoops.closed'
                )
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.prenom_producteur', '!=', null)
                ->where('producteurs.prenom_producteur', '!=', '---')
                ->where('producteurs.nom_producteur', '!=', null)
                ->where('producteurs.genre', '!=', null)
                ->where('producteurs.actif', 1)
                ->where('producteurs.type_exploitation', 'a')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();

                break;
            case '11':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs avec équipements complets (E)';

                $dataCount = DB::table('producteurs')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.type_exploitation', 'producteurs.owner_name',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.type_exploitation', 'e')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'producteurs.type_exploitation',
                    'scoops.zone',
                    'scoops.closed'
                )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('producteurs.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'e')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                break;
            case '12':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerGroup.png';
                $title = 'Nombre de producteurs motorisés (ET)';

                $dataCount = DB::table('producteurs')
                ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.type_exploitation', 'producteurs.owner_name',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('producteurs.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('producteurs.actif', 1)
                ->where('producteurs.type_exploitation', 'et')
                ->where('producteurs.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->count();

                $datas = DB::table('producteurs')->select(
                    'scoops.code_scoop',
                    'producteurs.prenom_producteur',
                    'producteurs.nom_producteur',
                    'producteurs.code_producteur',
                    'producteurs.code_scoop_producteur',
                    'producteurs.date_de_naissance',
                    'scoops.nom_scoop',
                    'producteurs.closed',
                    'scoops.village',
                    'scoops.owner_name',
                    'producteurs.owner_name',
                    'producteurs.type_exploitation',
                    'scoops.zone',
                    'scoops.closed'
                )
                    ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                    ->where('producteurs.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('producteurs.prenom_producteur', '!=', null)
                    ->where('producteurs.prenom_producteur', '!=', '---')
                    ->where('producteurs.nom_producteur', '!=', null)
                    ->where('producteurs.genre', '!=', null)
                    ->where('producteurs.actif', 1)
                    ->where('producteurs.type_exploitation', 'et')
                    ->where('producteurs.owner_name', '<>', 'demo')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                break;
        }

        $route = 'prodGrpmt_zone';
        return view('MobiagriDashboard.detail_filtre_rapport_zone', ['dataCount' => $dataCount, 'img' =>$img, 'title' =>$title, 'route' => $route, 'datas' => $datas]);
    }
    
    public function superficies_zone()
    {
        $campagnes = DB::table('producteurs')
        ->select('producteurs.campagne_coton', 'producteurs.owner_name', 'producteurs.actif',
        'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton', '<>', '')->where('producteurs.campagne_coton', '<>', '---')
        ->where('producteurs.closed', 'false')
        ->where('scoops.closed', 'false')
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('scoops.owner_name', '<>', 'demo')
        ->where('producteurs.actif', 1)
        ->where('scoops.zone', Auth::user()->nom_role)
        ->groupBy('producteurs.campagne_coton')->get();
        return view('MobiagriDashboard.superficie_zone', compact('campagnes'));
    }


    public function superficies()
    {
        $campagnes = DB::table('producteurs')
            ->select('campagne_coton')
            ->where('campagne_coton', '<>', '')->where('campagne_coton', '<>', '---')
            ->where('actif', 1)
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')->where('owner_name', '<>', 'demo.ac')->groupBy('campagne_coton')->get();
        
        if(Auth::user()->nom_role == 'admin'){
           $scoops = DB::table('scoops')->where('closed', 'false')->where('zone', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('zone')->get(); 
           $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 
        }elseif(Auth::user()->nom_role == 'ca'){
            $ection = Auth::user()->section;
            $scoops = DB::table('scoops')->where('section', Auth::user()->section)->where('closed', 'false')->where('code_scoop', '<>', '---')->get();
            $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 

        }else{
           $scoops = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('code_scoop', '<>', '---')->where('owner_name', '<>', 'demo')->get(); 
           $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 

            
        }
            

        
        return view('MobiagriDashboard.superficie', compact('campagnes', 'scoops', 'scoopsections'));
    }

    public function filtreSuperficie(Request $request)
    {
        
    // dd($request->all());
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies prévues (Ha)';
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('closed', 'false')->where('superficie_prevu_producteur', '<>', '')->where('superficie_prevu_producteur', '<>', '---')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('closed', 'false')->where('superficie_prevu_producteur', '<>', '')->where('superficie_prevu_producteur', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                }else{
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('closed', 'false')->where('superficie_prevu_producteur', '<>', '')->where('superficie_prevu_producteur', '<>', '---')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                }
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficieDeclare.png';
                $title = 'Superficies déclarées (Ha)';
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.supercifie_declaree',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->get();
                    $dataCount = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.supercifie_declaree',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.supercifie_declaree');
                    
                    //$datas->sum('parcelles.supercifie_declaree');
                } elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('supercifie_declaree', '<>', '')->where('supercifie_declaree', '<>', '---')->where('section', Auth::user()->section)->get();
                    $dataCount = $datas->sum('supercifie_declaree');
                }else{
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.supercifie_declaree',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                    $dataCount = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.supercifie_declaree',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.supercifie_declaree');
                    
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.campagne_coton', 'parcelles.nom_prenom_producteur', 'parcelles.supercifie_declaree')->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('parcelles.supercifie_declaree', '<>', '')->where('parcelles.supercifie_declaree', '<>', '---')->where('parcelles.owner_name', '<>', 'demo')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->sum('parcelles.supercifie_declaree');
                }
                
                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies mesurées (Ha)';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $superficieSaisie = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.mesure_saisie');
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('mesure_saisie');
                   
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $superficieMesureeHa = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_mesuree_ha');
                    
                    //$datas->sum('superficie_mesuree_ha');
                    
                    $dataCount = (float)$superficieMesureeHa - (float)$superficieSaisie;
                    
                  $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->get();
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                 
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    
                    $superficieSaisie = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('mesure_saisie');
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('section', Auth::user()->section)->get();
                    $superficieMesureeHa = $datas->sum('superficie_mesuree_ha');
                    
                    $dataCount = (float)$superficieMesureeHa - (float)$superficieSaisie;
                    
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('section', Auth::user()->section)->get();
                 
                }else{
                    
                    //$mesureSaisie = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.mesure_saisie')->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->where('parcelles.mesure_saisie', '<>', '')->where('parcelles.mesure_saisie', '<>', '---')->sum('parcelles.mesure_saisie');
                   // $superficieMesureeHa = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.superficie_mesuree_ha')->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('parcelles.superficie_mesuree_ha', '<>', '')->where('parcelles.superficie_mesuree_ha', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->where('parcelles.superficie_mesuree_ha', '<>', '')->where('parcelles.superficie_mesuree_ha', '<>', '---')->sum('parcelles.superficie_mesuree_ha');
                    $superficieSaisie = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.mesure_saisie');
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('mesure_saisie');
                    //$datas = DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('section', Auth::user()->section)->get();
                    $superficieMesureeHa = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_mesuree_ha');
                    $dataCount = (float)$superficieMesureeHa - (float)$mesureSaisie;
                    
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.mesure_saisie', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                    
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.campagne_coton', 'parcelles.nom_prenom_producteur', 'parcelles.mesure_saisie', 'parcelles.superficie_mesuree_ha')->where('scoops.code_scoop', $request->codeScoop)->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('parcelles.superficie_mesuree_ha', '<>', '')->where('parcelles.superficie_mesuree_ha', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->where('parcelles.superficie_mesuree_ha', '<>', '')->where('parcelles.superficie_mesuree_ha', '<>', '---')->get();
                }

                
                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies non-contrôlées (Ha)';

                $datas = DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();

                $superficieDeclarer = DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');
                
                $superficieMesureeHa = $datas->sum('superficie_mesuree_ha');
                $dataCount = (double)$superficieDeclarer - (double)$superficieMesureeHa;
                
                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies perdues (Ha)';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->get();
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_perdue', '<>', '')->where('superficie_perdue', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_perdue');
                    
                    //$datas->sum('superficie_perdue');

                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_perdue', '<>', '')->where('superficie_perdue', '<>', '---')->where('section', Auth::user()->section)->get();
                    $dataCount = $datas->sum('superficie_perdue');
                    
                }else{
                    
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                    
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.campagne_coton', 'parcelles.nom_prenom_producteur', 'parcelles.superficie_perdue')->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('parcelles.superficie_perdue', '<>', '')->where('parcelles.superficie_perdue', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->get();
                    $dataCount = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_perdue');
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.campagne_coton', 'parcelles.nom_prenom_producteur', 'parcelles.superficie_perdue')->where('scoops.code_scoop', $request->codeScoop)->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('parcelles.superficie_perdue', '<>', '')->where('parcelles.superficie_perdue', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->sum('parcelles.superficie_perdue');
                    
                }
                
                break;
            case '6':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficieDeclare.png';
                $title = 'Superficies corrigées (Ha)';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $superficieDeclarer = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.supercifie_declaree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.supercifie_declaree');
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');

                    $superficieMesureeHa = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_mesuree_ha');
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree_ha');
                    
                    if (doubleval($superficieDeclarer) == 0.0 || doubleval($superficieMesureeHa) == 0.0 ) {
                        $superficieDeclarer = 1;
                        $superficieMesureeHa = 1;
                    }
                    
                    $valueCoef = $superficieMesureeHa / $superficieDeclarer;
                    
                    $superficieMesuree = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_mesuree');
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('superficie_mesuree');                
                    
                    $dataCount = doubleval($superficieMesuree) * doubleval($valueCoef);
                    
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->get();
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('owner_name', '<>', 'demo')->get();                
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    
                    $superficieDeclarer = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('supercifie_declaree');

                    $superficieMesureeHa = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('superficie_mesuree_ha');
                    
                    if (doubleval($superficieDeclarer) == 0.0 || doubleval($superficieMesureeHa) == 0.0 ) {
                        $superficieDeclarer = 1;
                        $superficieMesureeHa = 1;
                    }
                    
                    $valueCoef = $superficieMesureeHa / $superficieDeclarer;
                    
                    $superficieMesuree = DB::table('parcelles')->where('closed', 'false')->where('section', Auth::user()->section)->sum('superficie_mesuree');                
                    
                    $dataCount = doubleval($superficieMesuree) * doubleval($valueCoef);
                    
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('section', Auth::user()->section)->get();                
                
                    
                }else{
                    
                    $superficieDeclarer = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.supercifie_declaree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.supercifie_declaree', '<>', '')
                    ->where('parcelles.supercifie_declaree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.supercifie_declaree');
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');

                    $superficieMesureeHa = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree_ha', '<>', '')
                    ->where('parcelles.superficie_mesuree_ha', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_mesuree_ha');
                    
                    if (doubleval($superficieDeclarer) == 0.0 || doubleval($superficieMesureeHa) == 0.0 ) {
                        $superficieDeclarer = 1;
                        $superficieMesureeHa = 1;
                    }
                    
                    $valueCoef = $superficieMesureeHa / $superficieDeclarer;
                    
                    $superficieMesuree = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_mesuree');
                    
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->where('scoops.code_scoop', $request->codeScoop)->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->sum('superficie_mesuree');                
                    
                    $dataCount = doubleval($superficieMesuree) * doubleval($valueCoef);
                    
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                    
                    //DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')->select('parcelles.campagne_coton', 'parcelles.nom_prenom_producteur', 'parcelles.superficie_mesuree')->where('scoops.code_scoop', $request->codeScoop)->where('parcelles.closed', 'false')->where('parcelles.campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('scoops.zone', Auth::user()->nom_role)->where('parcelles.owner_name', '<>', 'demo')->get();
                }

                break;
            case '7':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies réalisées (Ha)';
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'mise_en_place')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('total_montant_intrants', '<>', '')->where('total_montant_intrants', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                    
                    // dd($dataCount);
                }elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $datas = DB::table('intrant_equipements')->where('choix_formulaire_remplir', 'mise_en_place')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('total_montant_intrants', '<>', '')->where('total_montant_intrants', '<>', '---')->where('nom_section', Auth::user()->section)->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                }
                else{
                    
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'mise_en_place')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('total_montant_intrants', '<>', '')->where('total_montant_intrants', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    $dataCount = $datas->sum('superficie_prevu_producteur');
                }
              
                break;
            case '8':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies productives (Ha)';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $superficieMesuree = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_mesuree');
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree');
                    $superficiePerdue = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->sum('parcelles.superficie_perdue');
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_perdue');
                    $dataCount = doubleval($superficieMesuree) - doubleval($superficiePerdue);
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->get();
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                    
                }elseif (Auth::user()->nom_role == 'ca') {
                    
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $superficieMesuree = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('superficie_mesuree');
                    $superficiePerdue = DB::table('parcelles')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('section', Auth::user()->section)->sum('superficie_perdue');
                    $dataCount = doubleval($superficieMesuree) - doubleval($superficiePerdue);
                    $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('section', Auth::user()->section)->get();
                    
                }
                else{
                    
                    $superficieMesuree = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_mesuree');
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree');
                    $superficiePerdue = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_perdue', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_perdue', '<>', '')
                    ->where('parcelles.superficie_perdue', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->sum('parcelles.superficie_perdue');
                    
                    //DB::table('parcelles')->where('code_scoop', $request->codeScoop)->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_perdue');
                    $dataCount = doubleval($superficieMesuree) - doubleval($superficiePerdue);
                    $datas = DB::table('parcelles')->join('scoops', 'scoops.code_scoop', 'parcelles.code_scoop')
                    ->select('parcelles.closed','parcelles.campagne_coton','parcelles.superficie_mesuree', 'parcelles.owner_name', 'parcelles.nom_prenom_producteur', 'parcelles.code_scoop', 'parcelles.superficie_mesuree_ha',
                    'scoops.zone', 'scoops.section', 'scoops.closed', 'scoops.owner_name')
                    ->where('scoops.zone', $request->codeScoop)
                    ->where('scoops.section', $request->section)
                    ->where('parcelles.closed', 'false')
                    ->where('scoops.closed', 'false')
                    ->where('parcelles.campagne_coton', $request->campagne)
                    ->where('parcelles.superficie_mesuree', '<>', '')
                    ->where('parcelles.superficie_mesuree', '<>', '---')
                    ->where('scoops.owner_name', '<>', 'demo')
                    ->where('parcelles.owner_name', '<>', 'demo')
                    ->where('scoops.zone', Auth::user()->nom_role)
                    ->get();
                    
                }
                
                
                
                break;            
        }

        $route = 'superficies';
        return view('MobiagriDashboard.detail_filtre_rapport', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route, 'datas' => $datas]);
    }
    
    public function filtreSuperficie_zone(Request $request)
    {

        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies prévues';
                $dataCount = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->sum('intrant_equipements.superficie_prevu_producteur');
                
                $datas = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.superficie_prevu_producteur', '<>', '')
                ->where('intrant_equipements.superficie_prevu_producteur', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();
                // dd($datas);
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficieDeclare.png';
                $title = 'Superficies déclarées';
                $dataCount = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('supercifie_declaree', '<>', '')->where('supercifie_declaree', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                // dd($datas);
                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies mesurées';

                $superficieSaisie = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('mesure_saisie');
                $superficieMesureeHa = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree_ha');
                $dataCount = (float)$superficieMesureeHa - (float)$superficieSaisie;
                // $datas = '';
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('mesure_saisie', '<>', '')->where('mesure_saisie', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();
             
                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies non-contrôlées';
                
                $superficieDeclarer = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');
                $superficieMesureeHa = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree_ha');
                
                $dataCount = (double)$superficieDeclarer - (double)$superficieMesureeHa;
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('supercifie_declaree', '<>', '')->where('supercifie_declaree', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                // $datas='';
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies perdues';
                $dataCount = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_perdue');
                // $datas = '';
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_perdue', '<>', '')->where('superficie_perdue', '<>', '---')->where('owner_name', '<>', 'demo')->get();

                break;
            case '6':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficieDeclare.png';
                $title = 'Superficies corrigées';

                $superficieDeclarer = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('supercifie_declaree');
                $superficieMesureeHa = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree_ha');
                if (doubleval($superficieDeclarer) == 0.0 || doubleval($superficieMesureeHa) == 0.0 ) {
                    $superficieDeclarer = 1;
                    $superficieMesureeHa = 1;
                }
                $valueCoef = $superficieMesureeHa / $superficieDeclarer;
                $superficieMesuree = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree');                
                
                $dataCount = doubleval($superficieMesuree) * doubleval($valueCoef);
                
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('owner_name', '<>', 'demo')->get();                
                // $datas ='';
                // $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree_ha', '<>', '')->where('superficie_mesuree_ha', '<>', '---')->where('owner_name', '<>', 'demo')->get();                
                // $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('supercifie_declaree', '<>', '')->where('supercifie_declaree', '<>', '---')->where('owner_name', '<>', 'demo')->get();                

                break;
            case '7':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies réalisées';
                $dataCount = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->sum('intrant_equipements.total_montant_intrants');
                // $datas ='';
                $datas = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
                ->where('intrant_equipements.closed', 'false')
                ->where('scoops.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('intrant_equipements.total_montant_intrants', '<>', '')
                ->where('intrant_equipements.total_montant_intrants', '<>', '---')
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->get();

                break;
            case '8':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/superficie.png';
                $title = 'Superficies productives';

                $superficieMesuree = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_mesuree');
                $superficiePerdue = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('owner_name', '<>', 'demo')->sum('superficie_perdue');
                // dd($superficiePerdue);
                $dataCount = doubleval($superficieMesuree) - doubleval($superficiePerdue);
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_mesuree', '<>', '')->where('superficie_mesuree', '<>', '---')->where('owner_name', '<>', 'demo')->get();
                // $datas ='';
                $datas = DB::table('parcelles')->where('closed', 'false')->where('campagne_coton', $request->campagne)->where('superficie_perdue', '<>', '')->where('superficie_perdue', '<>', '---')->where('owner_name', '<>', 'demo')->get();

                break;            
        }

        $route = 'superficies';
        return view('MobiagriDashboard.detail_filtre_rapport_zone', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route, 'datas' => $datas]);
    }
    
    public function evaluProducton_zone()
    {
        $campagnes = DB::table('producteurs')
        // ->select('campagne_coton')->where('producteurs.campagne_coton', '<>', '')
        ->select('producteurs.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton', '<>', '---')
        ->where('producteurs.campagne_coton', '<>', '')
        ->where('producteurs.actif', 1)
        ->where('producteurs.closed', 'false')
        ->where('scoops.closed', 'false')
        ->where('scoops.owner_name', '<>', 'demo')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.evalution_production_zone', compact('campagnes'));
    }

    public function evaluProducton()
    {
        $campagnes = DB::table('producteurs')->select('campagne_coton')->where('producteurs.campagne_coton', '<>', '')->where('producteurs.campagne_coton', '<>', '---')->groupBy('campagne_coton')->get();
        return view('MobiagriDashboard.evalution_production', compact('campagnes'));
    }

    public function filtreEvaluation(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
        $title = 'Evaluation de la production';
        $dataCount = 0;

        $route = 'evaluProducton';
        return view('MobiagriDashboard.detail_filtre_rapport', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route]);
    }
    
     public function filtreEvaluation_zone(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
        $title = 'Evaluation de la production';
        $dataCount = 0;

        $route = 'evaluProducton';
        return view('MobiagriDashboard.detail_filtre_rapport_zone', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route]);
    }

    public function productionValorisee_zone()
    {
        $campagnes = DB::table('producteurs')
        // ->select('campagne_coton')
        // ->where('producteurs.campagne_coton', '<>', '')
        // ->where('producteurs.campagne_coton', '<>', '---')
        // ->groupBy('campagne_coton')
        ->select('producteurs.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton', '<>', '---')
        ->where('producteurs.campagne_coton', '<>', '')
        ->where('producteurs.actif', 1)
        ->where('producteurs.closed', 'false')
        ->where('scoops.closed', 'false')
        ->where('scoops.owner_name', '<>', 'demo')
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.production_valorisee_zone', compact('campagnes'));
    }
    
     public function filtreproductionValorisee_zone(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';

        switch ($request->option) {
            case '1':
                $title = 'Production totale';
                $total = '0';

                $value1 = DB::table('intrant_equipements')
                 ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.closed', 'false')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                
                $value2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix');

                $datas = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.qte_1er_choix', '<>', '0')->where('intrant_equipements.qte_1er_choix', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->get();
                
                $datas2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.qte_2eme_choix', '<>', '0')->where('intrant_equipements.qte_2eme_choix', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->get();

                break;
            case '2':
                $title = 'Prix du coton';
                $datas = '0';
                $datas2 = '0';
                $total ='0';
                $value1 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                // ->select('prix_coton_1er_choix')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.prix_coton_1er_choix', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->orderBy('intrant_equipements.prix_coton_1er_choix', 'desc')->limit(1)->first();
                
                $value2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                // ->select('prix_coton_2eme_choix')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.prix_coton_2eme_choix', '<>', '---')->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->groupBy('intrant_equipements.prix_coton_2eme_choix')->orderBy('intrant_equipements.prix_coton_2eme_choix', 'desc')->limit(1)->first();

                break;
            case '3':
                $title = 'Production valorisée';

                $val1 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('intrant_equipements.campagne_coton', $request->campagne)->sum('intrant_equipements.qte_1er_choix');
                
                $val2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('intrant_equipements.campagne_coton', $request->campagne)->sum('intrant_equipements.qte_2eme_choix');

                $prix1 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                // ->select('prix_coton_1er_choix')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.prix_coton_1er_choix', '<>', '---')->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->groupBy('intrant_equipements.prix_coton_1er_choix')->orderBy('intrant_equipements.prix_coton_1er_choix', 'desc')->limit(1)->first();
                
                $prix2 = DB::table('intrant_equipements')
                // ->select('prix_coton_2eme_choix')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.prix_coton_2eme_choix', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)->groupBy('intrant_equipements.prix_coton_2eme_choix')
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->orderBy('intrant_equipements.prix_coton_2eme_choix', 'desc')->limit(1)->first();

                $value1 = doubleval($val1) * doubleval($prix1->prix_coton_1er_choix);
                $value2 = doubleval($val2) * doubleval($prix2->prix_coton_2eme_choix);
                $total = $value1 + $value2;
                $datas ='0';
                $datas2='0';

                // dd($value1);
                break;
        }

        $route = 'productionValorisee';
        return view('MobiagriDashboard.detail_filtre_production_valorisee_zone', ['total' => $total,'datas2'=> $datas2, 'datas' => $datas, 'value1' => $value1, 'value2' => $value2, 'title' => $title, 'route' => $route, 'img' => $img]);

    }
    
    
    public function productionValorisee()
    {
        // $campagnes = DB::table('producteurs')->select('campagne_coton')->where('producteurs.campagne_coton', '<>', '')->where('owner_name', '<>', 'demo')->where('producteurs.campagne_coton', '<>', '---')->groupBy('campagne_coton')->get();
        // $campagnes = DB::table('intrant_equipements')->select('campagne_coton')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('prix_coton_1er_choix', '<>', '')->where('prix_coton_1er_choix', '<>', '0')->groupBy('campagne_coton')->get();
        // dd($value1);
        $campagnes = DB::table('parcelles')->select('campagne_coton')->where('closed', 'false')->where('owner_name', '<>', 'demo')->groupBy('campagne_coton')->get();
        $scoops = DB::table('scoops')->where('closed', 'false')->where('zone', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('zone')->get(); 
        $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 

        return view('MobiagriDashboard.production_valorisee', compact('campagnes', 'scoops', 'scoopsections'));
    }

    public function filtreproductionValorisee(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';

        switch ($request->option) {
            case '1':
                $title = 'Production totale';
                $total = '0';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $value1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $value2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
                    
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_1er_choix', '<>', '0')->where('qte_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                    $datas2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_2eme_choix', '<>', '0')->where('qte_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                } elseif (Auth::user()->nom_role == 'ca') {
                    $value1 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $value2 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');

                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_1er_choix', '<>', '0')->where('qte_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                    $datas2 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_2eme_choix', '<>', '0')->where('qte_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                }else{
                    
                    $value1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $value2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
                    
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_1er_choix', '<>', '0')->where('qte_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                    $datas2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('qte_2eme_choix', '<>', '0')->where('qte_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->get();
                }
                

                break;
            case '2':
                $title = 'Prix du coton';
                $datas = '0';
                $datas2 = '0';
                $total ='0';

                // dd($request->campagne);

                //$value1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_1er_choix')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('prix_coton_1er_choix', '<>', '')->where('prix_coton_1er_choix', '<>', '0')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
               // $value2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_2eme_choix')->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('prix_coton_2eme_choix', '<>', '')->where('prix_coton_2eme_choix', '<>', '0')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'asc')->limit(1)->first();
                // if (condition) {
                //     # code...
                // }
                //  dd($value2->prix_coton_2eme_choix);
                 if(Auth::user()->nom_role == 'admin'){
                     $value1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_1er_choix')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                     $value2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_2eme_choix')->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();
                 } elseif (Auth::user()->nom_role == 'ca') {
                     $value1 = DB::table('intrant_equipements')->select('prix_coton_1er_choix')->where('nom_section', Auth::user()->section)->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                    $value2 = DB::table('intrant_equipements')->select('prix_coton_2eme_choix')->where('nom_section', Auth::user()->section)->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();
                 }
                 else{
                    $value1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_1er_choix')->where('nom_zone', Auth::user()->nom_role)->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                   $value2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_2eme_choix')->where('nom_zone', Auth::user()->nom_role)->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();

                //     dd($value1);
                 }

                break;
            case '3':
                $title = 'Production valorisée';
                
                if(Auth::user()->nom_role == 'admin'){
                    
                    $val1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $val2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
    
                    $prix1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_1er_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                    $prix2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->select('prix_coton_2eme_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();
    
                    $value1 = doubleval($val1) * doubleval($prix1->prix_coton_1er_choix);
                    $value2 = doubleval($val2) * doubleval($prix2->prix_coton_2eme_choix);
                    $total = $value1 + $value2;
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    $val1 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $val2 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');

                    $prix1 = DB::table('intrant_equipements')->select('prix_coton_1er_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                    $prix2 = DB::table('intrant_equipements')->select('prix_coton_2eme_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();

                    $value1 = doubleval($val1) * doubleval($prix1->prix_coton_1er_choix);
                    $value2 = doubleval($val2) * doubleval($prix2->prix_coton_2eme_choix);
                    $total = $value1 + $value2;
                }
                else{
                    
                    $val1 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    $val2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
    
                    $prix1 = DB::table('intrant_equipements')->select('prix_coton_1er_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_1er_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_1er_choix')->orderBy('prix_coton_1er_choix', 'desc')->limit(1)->first();
                    $prix2 = DB::table('intrant_equipements')->select('prix_coton_2eme_choix')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('prix_coton_2eme_choix', '<>', '---')->where('campagne_coton', $request->campagne)->groupBy('prix_coton_2eme_choix')->orderBy('prix_coton_2eme_choix', 'desc')->limit(1)->first();
    
                    $value1 = doubleval($val1) * doubleval($prix1->prix_coton_1er_choix);
                    $value2 = doubleval($val2) * doubleval($prix2->prix_coton_2eme_choix);
                    $total = $value1 + $value2;
                }
                
                $datas ='0';
                $datas2='0';

                // dd($value1);
                break;
        }

        $route = 'productionValorisee';
        return view('MobiagriDashboard.detail_filtre_production_valorisee', ['total' => $total,'datas2'=> $datas2, 'datas' => $datas, 'value1' => $value1, 'value2' => $value2, 'title' => $title, 'route' => $route, 'img' => $img]);

    }
    
    
    public function situationCredit_zone()
    {
        $campagnes = DB::table('producteurs')
        // ->select('campagne_coton')
        ->select('producteurs.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton', '<>', '')
        ->where('producteurs.campagne_coton', '<>', '---')
        ->where('scoops.owner_name', '<>', 'demo')
        ->where('scoops.closed', 'false')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('producteurs.closed', 'false')
        ->where('producteurs.actif', 1)
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.situation_credit_zone', compact('campagnes'));
    }
    
     public function filtreSituationCredit_zone(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';

        switch ($request->option) {
            case '1':
                $title = 'Production totale';
                $qt1 = DB::table('intrant_equipements')
                 ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->sum('intrant_equipements.total_montant_intrants');
                $qt2 = '0';
                $total = '0';
                // $total = doubleval($qt1) + doubleval($qt2);

                break;
            case '2':
                $title = 'Prix du coton';
                break;
            case '3':
                $title = 'Production valorisée';

                break;
        }


        $dataCount = 0;

        $route = 'productionValorisee';
        return view('MobiagriDashboard.detail_filtre_production_valorisee_zone', ['qt1' => $qt1, 'qt2' => $qt2, 'total' => $total, 'title' => $title, 'route' => $route, 'img' => $img]);
    }

    

    public function situationCredit()
    {
        $campagnes = DB::table('producteurs')->select('campagne_coton')->where('producteurs.campagne_coton', '<>', '')->where('producteurs.campagne_coton', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('campagne_coton')->get();
        return view('MobiagriDashboard.situation_credit', compact('campagnes'));
    }

    public function filtreSituationCredit(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';

        switch ($request->option) {
            case '1':
                $title = 'Production totale';
                $qt1 = DB::table('intrant_equipements')->where('choix_formulaire_remplir', 'mise_en_place')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('total_montant_intrants');
                $qt2 = '0';
                $total = '0';
                // $total = doubleval($qt1) + doubleval($qt2);

                break;
            case '2':
                $title = 'Prix du coton';
                break;
            case '3':
                $title = 'Production valorisée';

                break;
        }


        $dataCount = 0;

        $route = 'productionValorisee';
        return view('MobiagriDashboard.detail_filtre_production_valorisee', ['qt1' => $qt1, 'qt2' => $qt2, 'total' => $total, 'title' => $title, 'route' => $route, 'img' => $img]);
    }
    
    public function productionRealisee_zone()
    {
        $campagnes = DB::table('producteurs')
        // ->select('campagne_coton')
        // ->where('producteurs.campagne_coton', '<>', '')
        // ->where('producteurs.campagne_coton', '<>', '---')
        // ->groupBy('campagne_coton')
        ->select('producteurs.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.campagne_coton', '<>', '')
        ->where('producteurs.campagne_coton', '<>', '---')
        ->where('scoops.owner_name', '<>', 'demo')
        ->where('scoops.closed', 'false')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('producteurs.closed', 'false')
        ->where('producteurs.actif', 1)
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.production_realisee_zone', compact('campagnes'));
    }
    
    

    public function productionRealisee()
    {
        
        $campagnes = DB::table('parcelles')->select('campagne_coton')->where('closed', 'false')->where('owner_name', '<>', 'demo')->groupBy('campagne_coton')->get();
        if(Auth::user()->nom_role == 'admin'){
           $scoops = DB::table('scoops')->where('closed', 'false')->where('zone', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('zone')->get(); 
           $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 
        }elseif(Auth::user()->nom_role == 'ca'){
            $ection = Auth::user()->section;
            $scoops = DB::table('scoops')->where('section', Auth::user()->section)->where('closed', 'false')->where('code_scoop', '<>', '---')->get();
            $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 
            
        }else{
           $scoops = DB::table('scoops')->where('zone', Auth::user()->nom_role)->where('closed', 'false')->where('zone', '<>', '---')->where('owner_name', '<>', 'demo')->get(); 
           $scoopsections = DB::table('scoops')->where('closed', 'false')->where('section', '<>', '---')->where('owner_name', '<>', 'demo')->groupBy('section')->get(); 
        }
        // dd($campagnes);
        return view('MobiagriDashboard.production_realisee', compact('campagnes','scoops', 'scoopsections'));
    }

    public function filtreProductionRealisee(Request $request)
    {
        // dd($request->all());
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production MAG';
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('owner_name','<>', 'demo')->where('type_marche', 'mag')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                       $qt1 = $datas->sum('qte_1er_choix');
                       $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);
                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('owner_name', '<>', 'demo')->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);

                }else{
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('owner_name', '<>', 'demo')->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);
                }
                
                
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production CD';
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);
                }else{
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    $total = doubleval($qt1) + doubleval($qt2);
                }
                
                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production Total en KG';
                
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    $data2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $magQt1 = $datas->sum('qte_1er_choix');
                    $magQt2 = $datas->sum('qte_2eme_choix');
                    
                    $cdQt1 =  $data2->sum('qte_1er_choix');
                    $cdQt2 = $data2->sum('qte_2eme_choix');
                    $qt1 = doubleval($magQt1) + doubleval($cdQt1);
                    $qt2 = doubleval($magQt2) + doubleval($cdQt2); 
    
                    $total = doubleval($qt1) + doubleval($qt2);
                } elseif (Auth::user()->nom_role == 'ca') {

                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    $data2 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $magQt1 = $datas->sum('qte_1er_choix');
                    $magQt2 = $datas->sum('qte_2eme_choix');
                    
                    $cdQt1 =  $data2->sum('qte_1er_choix');
                    $cdQt2 = $data2->sum('qte_2eme_choix');
                    
                    $qt1 = doubleval($magQt1) + doubleval($cdQt1);
                    $qt2 = doubleval($magQt2) + doubleval($cdQt2); 
                    
                    $qt2 = doubleval($magQt2) + doubleval($cdQt2);

                    $total = doubleval($qt1) + doubleval($qt2);
                
                }else{
                    
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    $data2 = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $magQt1 = $datas->sum('qte_1er_choix');
                    $magQt2 = $datas->sum('qte_2eme_choix');
                    
                    $cdQt1 =  $data2->sum('qte_1er_choix');
                    $cdQt2 = $data2->sum('qte_2eme_choix');
                    
                    $qt1 = doubleval($magQt1) + doubleval($cdQt1);
                    $qt2 = doubleval($magQt2) + doubleval($cdQt2); 
                    
                    $qt2 = doubleval($magQt2) + doubleval($cdQt2);

                    $total = doubleval($qt1) + doubleval($qt2);
                    
                    // $magQt1 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    // $cdQt1 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix');
                    // $qt1 = doubleval($magQt1) + doubleval($cdQt1);
    
                    // $magQt2 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'mag')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
                    // $cdQt2 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'production')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix');
                    // $qt2 = doubleval($magQt2) + doubleval($cdQt2);
    
                    // $total = doubleval($qt1) + doubleval($qt2);
                }
                
                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Entrées usines MAG';
                
                if(Auth::user()->nom_role == 'admin'){
                    // $datas = DB::table('intrant_equipements')->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                     $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'entree_usine')->where('type_marche', 'mag')->where('qte_1er_choix_mag', '<>', '')->where('qte_1er_choix_mag', '<>', '---')->where('qte_2eme_choix_mag', '<>', '')->where('qte_2eme_choix_mag', '<>', '---')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix_mag');
                    $qt2 = $datas->sum('qte_2eme_choix_mag');
                    
                    $total = doubleval($qt1) + doubleval($qt2);

                } elseif (Auth::user()->nom_role == 'ca') {
                    
                    $datas = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'entree_usine')->where('type_marche', 'mag')->where('qte_1er_choix_mag', '<>', '')->where('qte_1er_choix_mag', '<>', '---')->where('qte_2eme_choix_mag', '<>', '')->where('qte_2eme_choix_mag', '<>', '---')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix_mag');
                    $qt2 = $datas->sum('qte_2eme_choix_mag');
                    
                    $total = doubleval($qt1) + doubleval($qt2);

                }
                else{
                    
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'entree_usine')->where('type_marche', 'mag')->where('qte_1er_choix_mag', '<>', '')->where('qte_1er_choix_mag', '<>', '---')->where('qte_2eme_choix_mag', '<>', '')->where('qte_2eme_choix_mag', '<>', '---')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix_mag');
                    $qt2 = $datas->sum('qte_2eme_choix_mag');
                    
                    $total = doubleval($qt1) + doubleval($qt2);
                }


                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Entrées usines CD';
                
                if(Auth::user()->nom_role == 'admin'){
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'entree_usine')->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();;
                   
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    
                    $total = doubleval($qt1) + doubleval($qt2);
                    
                    // $qt2 = DB::table('intrant_equipements')->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix_mag');
                    
                    // $total = doubleval($qt1) + doubleval($qt2);
                    
                } elseif (Auth::user()->nom_role == 'ca') {
                    // $qt1 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix_mag');
                    // $qt2 = DB::table('intrant_equipements')->where('nom_section', Auth::user()->section)->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix_mag');

                    // $total = doubleval($qt1) + doubleval($qt2);  
                    
                    $datas = DB::table('intrant_equipements')->where('choix_formulaire_remplir', 'entree_usine')->where('nom_section', Auth::user()->section)->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();;
                   
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    
                    $total = doubleval($qt1) + doubleval($qt2);
                }
                else{
                    // $qt1 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_1er_choix_mag');
                    // $qt2 = DB::table('intrant_equipements')->where('nom_zone', Auth::user()->nom_role)->where('choix_formulaire_remplir', 'entree_usine')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->sum('qte_2eme_choix_mag');
    
                    // $total = doubleval($qt1) + doubleval($qt2);
                    $datas = DB::table('intrant_equipements')->where('nom_zone', $request->codeScoop)->where('nom_section', $request->section)->where('choix_formulaire_remplir', 'entree_usine')->where('nom_zone', Auth::user()->nom_role)->where('type_marche', 'cd')->where('owner_name', '<>', 'demo')->where('closed', 'false')->where('campagne_coton', $request->campagne)->get();
                   
                    foreach ($datas as $value) {
                        $data = $value->nom_scoop;
                    }
                    if(isset($value->nom_scoop)){
                        $data = $data;    
                    }else{
                        $data='';
                    }
                    $qt1 = $datas->sum('qte_1er_choix');
                    $qt2 = $datas->sum('qte_2eme_choix');
                    
                    $total = doubleval($qt1) + doubleval($qt2);
                }

                break;
            
        }

        $route = 'productionRealisee';
        return view('MobiagriDashboard.detail_filtre_production', ['data' => $data,'qt1' => $qt1, 'qt2' => $qt2, 'total' => $total, 'title' => $title, 'route' => $route, 'img' => $img]);
    }

    public function clc(Request $request)
    {
        if (Auth::user()->nom_role == 'admin') {
            $clc = DB::table('intrant_equipements')
                ->where('closed', 'false')
                 ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'clc')
                ->get();
            $clc_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                 ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'clc')
                ->sum('total_montant_intrants');
            
        $clc_value = DB::table('intrant_equipements')->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            // dd($owner_name);
            $clc = DB::table('intrant_equipements')->where('closed', 'false')
                 ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'clc')
                ->get();
            $clc_count = DB::table('intrant_equipements')->where('closed', 'false')
                 ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'clc')
                ->sum('total_montant_intrants');
                $clc_value = DB::table('intrant_equipements')->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_section', Auth::user()->section)
            ->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
        } else {
            $clc = DB::table('intrant_equipements')->where('closed', 'false')
             ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'clc') ->get();
            $clc_count = DB::table('intrant_equipements')->where('closed', 'false')
             ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
                $clc_value = DB::table('intrant_equipements')->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_zone', Auth::user()->nom_role)
            ->where('choix_formulaire_remplir', 'clc')->sum('total_montant_intrants');
                
        }

      
          
       
       

       $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                    ->where('closed', 'false')
                    ->where('choix_formulaire_remplir', 'clc')
                    ->where('owner_name', '<>', 'demo.ac')
                    ->where('owner_name', '<>', 'demo')->get();

        $zone_by_mise_en_place = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'clc')
            ->whereNotNull('nom_zone')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->select('nom_zone')
            ->distinct()
            ->get();

        $zone = $request->input('by_zone');

        $section_by_mise_en_place = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'clc')
            ->whereNotNull('nom_section')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->select('nom_section')
            ->where('nom_zone', $zone)
            ->distinct()
            ->get();
        
        return view('MobiagriDashboard.clc', compact('clc', 'clc_count', 'sections', 'zone_by_mise_en_place', 'section_by_mise_en_place'));
    }

    public function getCampagneClc(Request $request)
    {
        $search_campagne_clc = $request->input('search_campagne_clc');
        $campagne = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'clc')
            // ->where('campagne_coton', $search_campagne_clc)
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->whereNotNull('campagne_coton')
            ->get();
            $campagneSum = $campagne->sum('total_montant_intrants');
            $formattedCampagneSum = number_format($campagneSum, 2, ',', '.');
            
        return response()->json($formattedCampagneSum);
            
    }


    
    public function filtrer_clc(Request $request)
    {
        if (Auth::user()->nom_role == 'admin') {
            $clc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('choix_formulaire_remplir', 'clc')
                ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
                ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                ->paginate(100);
            $clc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('choix_formulaire_remplir', 'clc')
                ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
                ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                
                ->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            // dd($owner_name);
            $clc = DB::table('intrant_equipements')->where('closed', 'false')
                // ->where('nom_section', Auth::user()->section)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'clc')
                ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
                ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                ->paginate(100);
            $clc_count = DB::table('intrant_equipements')->where('closed', 'false')
                // ->where('nom_section', Auth::user()->section)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'clc')
                ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
                ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                ->sum('total_montant_intrants');
        } else {
            $clc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'clc')
                 ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
               ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                ->paginate(100);
            $clc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'clc')
                 ->when(request()->has('search_campagne_clc'), function($q){
                $q->where('campagne_coton', request('search_campagne_clc'));
                })
                ->when(request()->has('search_zone_clc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_clc'));
                })
               ->when(request()->has('search_section_clc'), function($q){
                $q->orWhere('nom_section', request('search_section_clc'));
                })
                ->sum('total_montant_intrants');
                
        }

       $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'clc')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

        
        return view('MobiagriDashboard.clc', compact('clc','clc_count', 'sections'));
    }
    
    public function cdc(Request $request)
    {
        
        if (Auth::user()->nom_role == 'admin') {
            $cdc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'cdc')->get();
            $cdc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            
            $cdc = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'cdc')->get();
            $cdc_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
        } else {
            $cdc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'cdc')->get();
            $cdc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'cdc')->sum('total_cdc');
        }
            $sections = DB::table('intrant_equipements')->select('nom_section')
                 ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'cdc')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

            $zone_by_mise_en_place = DB::table('intrant_equipements')
                ->where('choix_formulaire_remplir', 'cdc')
                ->whereNotNull('nom_zone')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->select('nom_zone')
                ->distinct()
                ->get();

            $zone = $request->input('by_zone');

            $section_by_mise_en_place = DB::table('intrant_equipements')
                ->where('choix_formulaire_remplir', 'cdc')
                ->whereNotNull('nom_section')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->select('nom_section')
                ->where('nom_zone', $zone)
                ->distinct()
                ->get();
                  
                 // dd($sections);
                    return view('MobiagriDashboard.cdc', compact('cdc', 'cdc_count', 'sections', 'zone_by_mise_en_place', 'section_by_mise_en_place'));
    }
    
    public function filtrer_cdc(Request $request)
    {
        
        if (Auth::user()->nom_role == 'admin') {
            $cdc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->paginate(100);
            $cdc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->sum('total_cdc');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            
            $cdc = DB::table('intrant_equipements')
                ->where('closed', 'false')
                // ->where('nom_section', Auth::user()->section)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->paginate(100);
            $cdc_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                // ->where('nom_section', Auth::user()->section)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->sum('total_cdc');
        } else {
            $cdc = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->paginate(100);
            $cdc_count = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'cdc')
                ->when(request()->has('search_campagne_cdc'), function($q){
                $q->where('campagne_coton', request('search_campagne_cdc'));
                })
                ->when(request()->has('search_zone_cdc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_cdc'));
                })
                ->when(request()->has('search_section_cdc'), function($q){
                $q->orWhere('nom_section', request('search_section_cdc'));
                })
                
                ->sum('total_cdc');
        }
      $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'cdc')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

        return view('MobiagriDashboard.cdc', compact('cdc', 'cdc_count', 'sections'));
    }
    
    public function mise_en_place(Request $request)
    {
        if (Auth::user()->nom_role == 'admin') {
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'mise_en_place')
            ->get();
              
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'mise_en_place')->get();
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
        } else {
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'mise_en_place')->get();
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'mise_en_place')->sum('total_montant_intrants');
        }
        $sections = DB::table('intrant_equipements')->select('nom_section')
            //->where('nom_zone', Auth::user()->nom_role)
            ->where('closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

            $zone_by_mise_en_place = DB::table('intrant_equipements')
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->whereNotNull('nom_zone')
                ->select('nom_zone')
                ->distinct()
                ->get();

            $zone = $request->input('by_zone');

            $section_by_mise_en_place = DB::table('intrant_equipements')
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
                ->whereNotNull('nom_section')
                ->select('nom_section')
                ->where('nom_zone', $zone)
                ->distinct()
                ->get();
  
        //   $mise_en_placeeee = $mise_en_place->where('nom_zone', $zone_by_mise_en_place->nom_zone);
        
       // $mise_en_place = $query->paginate(200);
        return view('MobiagriDashboard.mise_en_place', 
        compact('mise_en_place', 'mise_en_place_count', 'sections', 'zone_by_mise_en_place', 'section_by_mise_en_place'));
    }

    public function getSections(Request $request)
    {
        $zone = $request->input('zone');

        $sections = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_zone', $zone)
            ->whereNotNull('nom_section')
            ->select('nom_section')
            ->distinct()
            ->get();

        return response()->json($sections);
    }

    public function getSectionsByClc(Request $request)
    {
        $zone = $request->input('by_zone');

        $sections = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'clc')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_zone', $zone)
            ->whereNotNull('nom_section')
            ->select('nom_section')
            ->distinct()
            ->get();

        return response()->json($sections);
    }

    public function getCampagne(Request $request)
    {
        $search_campagne_mep = $request->input('search_campagne_mep');
        $campagne = DB::table('intrant_equipements')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->where('campagne_coton', $search_campagne_mep)
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->whereNotNull('campagne_coton')
            ->get();

            $campagneSum = $campagne->sum('total_montant_intrants');
            $formattedCampagneSum = number_format($campagneSum, 2, ',', '.');
            
        return response()->json($formattedCampagneSum);
            
    }
    
     public function filtrer_mep(Request $request)
    {
        if (Auth::user()->nom_role == 'admin') {
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                 ->where('owner_name', '<>', 'demo.ac')
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                ->paginate(200);
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('owner_name', '<>', 'demo.ac')
               // ->where('nom_producteur', '!=', null)
                //->where('prenom_producteur', '!=', null)
                ->where('choix_formulaire_remplir', 'mise_en_place')
                 ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                 //->when(request()->has('search_zone_mep'), function($q){
                // $q->orWhere('nom_zone', request('search_zone_mep'));
                // })
                // ->when(request()->has('search_section_mep'), function($q){
                // $q->orWhere('nom_section', request('search_section_mep'));
                // })
               
                ->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                ->when(request()->has('search_zone_mep'), function($q){
                $q->orWhere('nom_zone', request('search_zone_mep'));
                })
                ->when(request()->has('search_section_mep'), function($q){
                $q->orWhere('nom_section', request('search_section_mep'));
                })
                
                ->paginate(100);
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                ->when(request()->has('search_zone_mep'), function($q){
                $q->orWhere('nom_zone', request('search_zone_mep'));
                })
                ->when(request()->has('search_section_mep'), function($q){
                $q->orWhere('nom_section', request('search_section_mep'));
                })
                
                ->sum('total_montant_intrants');
        } else {
            $mise_en_place = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                ->when(request()->has('search_zone_mep'), function($q){
                $q->orWhere('nom_zone', request('search_zone_mep'));
                })
                ->when(request()->has('search_section_mep'), function($q){
                $q->orWhere('nom_section', request('search_section_mep'));
                })
                
                ->paginate(100);
            $mise_en_place_count = DB::table('intrant_equipements')
                ->where('closed', 'false')
                ->where('owner_name', '<>', 'demo')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'mise_en_place')
                ->when(request()->has('search_campagne_mep'), function($q){
                $q->where('campagne_coton', request('search_campagne_mep'));
                })
                ->when(request()->has('search_zone_mep'), function($q){
                $q->orWhere('nom_zone', request('search_zone_mep'));
                })
                ->when(request()->has('search_section_mep'), function($q){
                $q->orWhere('nom_section', request('search_section_mep'));
                })
                
                ->sum('total_montant_intrants');
        }
        
        $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'mise_en_place')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

        return view('MobiagriDashboard.mise_en_place', compact('mise_en_place', 'mise_en_place_count', 'sections'));
    }
    
    public function besoin_complementaire(Request $request)
    {

        if (Auth::user()->nom_role == 'admin') {
            $besoin_complementaire = DB::table('intrant_equipements')
                ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->get();
            $besoin_complementaire_count = DB::table('intrant_equipements')
                ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $besoin_complementaire = DB::table('intrant_equipements')
            ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_section', Auth::user()->sectione)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->get();
            $besoin_complementaire_count = DB::table('intrant_equipements')
           ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_section', Auth::user()->section)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants');
        } else {
            $besoin_complementaire = DB::table('intrant_equipements')
            ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_zone', Auth::user()->nom_role)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->get();
            $besoin_complementaire_count = DB::table('intrant_equipements')
            ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
            ->where('nom_zone', Auth::user()->nom_role)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')->sum('total_montant_intrants'); }
            
             $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'besoins_complementaires')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

                  $zone_by_mise_en_place = DB::table('intrant_equipements')
                  ->where('choix_formulaire_remplir', 'besoins_complementaires')
                  ->whereNotNull('nom_zone')
                  ->where('closed', 'false')
                  ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                  ->select('nom_zone')
                  ->distinct()
                  ->get();
  
              $zone = $request->input('by_zone');
  
              $section_by_mise_en_place = DB::table('intrant_equipements')
                  ->where('choix_formulaire_remplir', 'besoins_complementaires')
                  ->whereNotNull('nom_section')
                  ->where('closed', 'false')
                  ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                  ->select('nom_section')
                  ->where('nom_zone', $zone)
                  ->distinct()
                  ->get();

        return view('MobiagriDashboard.besoin_complementaire', compact('besoin_complementaire', 'besoin_complementaire_count', 'sections', 'zone_by_mise_en_place', 'section_by_mise_en_place'));
    }
    
    public function filtrer_bc(Request $request)
    {

        if (Auth::user()->nom_role == 'admin') {
            $besoin_complementaire = DB::table('intrant_equipements')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
                ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
                ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
                ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                })
                ->paginate(100);
            $besoin_complementaire_count = DB::table('intrant_equipements')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
                ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
                ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
                ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                })
                ->sum('total_montant_intrants');
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $besoin_complementaire = DB::table('intrant_equipements')
            ->where('nom_producteur', '!=', null)
            ->where('prenom_producteur', '!=', null)
            ->where('nom_section', Auth::user()->section)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
            ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
            ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                })    
            ->paginate(100);
            $besoin_complementaire_count = DB::table('intrant_equipements')
            ->where('nom_producteur', '!=', null)
            ->where('prenom_producteur', '!=', null)
            ->where('nom_section', Auth::user()->section)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
            ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
            ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                })    
            ->sum('total_montant_intrants');
        } else {
            $besoin_complementaire = DB::table('intrant_equipements')
            ->where('nom_producteur', '!=', null)
            ->where('prenom_producteur', '!=', null)
            ->where('nom_zone', Auth::user()->nom_role)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
            ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
            ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                }) 
            ->paginate(100); 
            $besoin_complementaire_count = DB::table('intrant_equipements')
            ->where('nom_producteur', '!=', null)
            ->where('prenom_producteur', '!=', null)
            ->where('nom_zone', Auth::user()->nom_role)
            ->where('closed', 'false')->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->when(request()->has('search_campagne_bc'), function($q){
                $q->where('campagne_coton', request('search_campagne_bc'));
                })
            ->when(request()->has('search_zone_bc'), function($q){
                $q->orWhere('nom_zone', request('search_zone_bc'));
                })
            ->when(request()->has('search_section_bc'), function($q){
                $q->orWhere('nom_section', request('search_section_bc'));
                })
                
            ->sum('total_montant_intrants');  }
            
            $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'besoins_complementaires')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

        return view('MobiagriDashboard.besoin_complementaire', compact('besoin_complementaire', 'besoin_complementaire_count', 'sections'));
    }
    
    public function formation()
    {
        if (Auth::user()->nom_role == 'admin') {
            $formations = DB::table('formations')->join('scoops', 'scoops.caseid', 'formations.case_id_scoop_selectionne')->where('formations.closed', 'false')->where('nom_prenom_formation', '<>', '')->where('formations.owner_name', '<>', 'demo')->paginate(200);
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $formations = DB::table('formations')->join('scoops', 'scoops.caseid', 'formations.case_id_scoop_selectionne')->where('formations.closed', 'false')->where('nom_prenom_formation', '<>', '')->where('formations.owner_name', $owner_name)->paginate(200);
        } else {
            $formations = DB::table('formations')->join('scoops', 'scoops.caseid', 'formations.case_id_scoop_selectionne')->where('formations.closed', 'false')->where('nom_prenom_formation', '<>', '')->where('formations.owner_name', '<>', 'demo')->where('scoops.zone', Auth::user()->nom_role)->groupBy('formations.case_id_scoop_selectionne')->paginate(200);
        }
        return view('MobiagriDashboard.formation', compact('formations'));
    }
    
    public function pluviometrie()
    {
        if (Auth::user()->nom_role == 'admin') {
            $pluviometries = DB::table('hauteurs')->where('closed', 'false')->where('hauteur_deau', '<>', '---')->where('owner_name', '<>', 'demo_illimitis')->where('owner_name', '<>', 'demo')->paginate(20);
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $pluviometries = DB::table('hauteurs')->where('hauteur_deau', '<>', '---')->where('closed', 'false')->where('section', Auth::user()->section)->paginate(20);
        } else {
            $pluviometries = DB::table('hauteurs')->where('closed', 'false')->where('hauteur_deau', '<>', '---')->where('owner_name', '<>', 'demo_illimitis')->where('owner_name', '<>', 'demo')->paginate(20);
        }
        
        return view('MobiagriDashboard.pluviometrie', compact('pluviometries'));
    }
    
    public function pluviometrie_filter(Request $request)
    {
        if (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $pluviometries = DB::table('hauteurs')->where('campagne_coton', $request->search_campagne)->where('decade', $request->search_decade)->where('closed', 'false')->where('section', Auth::user()->section)->get();
        } else {
            $pluviometries = DB::table('hauteurs')->where('campagne_coton', $request->search_campagne)->where('decade', $request->search_decade)->where('closed', 'false')->get();
        }
        
        return view('MobiagriDashboard.pluviometrie', compact('pluviometries'));
    }

    public function suiviParasitisme()
    {

        return view('MobiagriDashboard.suivi_parasitisme');
    }

    public function filtreSuiviParasitisme(Request $request)
    {
        $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';


        switch ($request->option) {
            case '1':
                $title = 'Nombre de parcelles précoces suivies';
                if (Auth::user()->nom_role == 'admin') {
                   $datas = DB::table('detail_scoops')->where('closed', 'false')->where('nombre_de_parcelles_prcoces_suivies', '<>', '---')->where('nombre_de_parcelles_prcoces_suivies', '<>', '')->where('owner_name', '<>', 'demo')->get();
                   $dataCount = $datas->sum('nombre_de_parcelles_prcoces_suivies');
                } elseif (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_prcoces_suivies');
                } else {
                    $dataCount = DB::table('detail_scoops') ->join('scoops', 'scoops.code_scoop', 'detail_scoops.code_scoop')->where('detail_scoops.closed', 'false')->where('detail_scoops.owner_name', '<>', 'demo')->where('scoops.zone', Auth::user()->nom_role)->sum('nombre_de_parcelles_prcoces_suivies');
                }
                break;
            case '2':
                $title = 'Nombre de parcelles normales suivies';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_normales_suivies');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_normales_suivies');
                }
                break;
            case '3':
                $title = 'Nombre de parcelles tardives  suivies';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_tardives_suivies');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_tardives_suivies');
                }
                break;
            case '4':
                $title = 'Nombre total de parcelles suivies';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_total_de_parcelles_suivies');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_total_de_parcelles_suivies');
                }
                break;
            case '5':
                $title = 'Nombre de parcelles infestées par des Atlises';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_alises');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_alises');
                }
                break;
            case '6':
                $title = 'Nombre de parcelles infestées par des pucerons';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_pucerons');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_pucerons');
                }
                break;
            case '7':
                $title = 'Nombre de parcelles infestées par des Haritalodes';
                $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_haritalodes');
                break;
            case '8':
                $title = 'Nombre de parcelles infestées par des Anomis flava';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_anomis_flava');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_anomis_flava');
                }
                break;
            case '9':
                $title = 'Nombre de parcelles infestées par des Larves Helicoverpa';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_larves_helicoverpa');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_larves_helicoverpa');
                }
                break;
            case '10':
                $title = 'Nombre de parcelles infestées par des Larves Diparopsis';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_larves_diparopsis');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_larves_diparopsis');
                }
                break;
            case '11':
                $title = 'Nombre de parcelles infestées par des Larves earias';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_larves_earias');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_larves_earias');
                }
                break;
            case '12':
                $title = 'Nombre de parcelles infestées par des oeufs de carpophages ';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages');
                }
                break;
            case '13':
                $title = 'Nombre de parcelles infestées par des pucerons adultes  ';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_pucerons_adultes');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_pucerons_adultes');
                }
                break;
            case '14':
                $title = 'Nombre de parcelles infestées par des jassides';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_jassides');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_jassides');
                }
                break;
            case '15':
                $title = 'Nombre de parcelles infestées par des Dysdercus';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_dysdercus');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_dysdercus');
                }
                break;
            case '16':
                $title = 'Nombre de parcelles infestées par des Bemisia nymphes';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_bemisia_nymphes');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_bemisia_nymphes');
                }
                break;
            case '17':
                $title = 'Nombre de parcelles infestées par des Bemisia';
                if (Auth::user()->nom_role == 'ca') {
                    $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('section', Auth::user()->section)->sum('nombre_de_parcelles_infestes_par_des_bemisia');
                } else {
                    $dataCount = DB::table('detail_scoops')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('nombre_de_parcelles_infestes_par_des_bemisia');
                }
                break;
            
        }

        return view('MobiagriDashboard.detail_filtre_suivi_parasitisme', compact('img', 'title', 'dataCount'));

    }

    
    
    public function production(Request $request)
    {

        if (Auth::user()->nom_role == 'admin') {
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                //->where('campagne_coton', '23-24')
                ->where('choix_formulaire_remplir', 'production')->get();
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                //->where('campagne_coton', '23-24')
                ->where('choix_formulaire_remplir', 'production')->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
               // ->where('campagne_coton', '23-24')
                ->where('choix_formulaire_remplir', 'production')->sum('qte_2eme_choix');
                
            $production_count = $production_count1 + $production_count2;
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')->get();
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')->sum('qte_2eme_choix');
            $production_count = $production_count1 + $production_count2;
        } else {
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')->get();
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')->sum('qte_2eme_choix');
            $production_count = $production_count1 + $production_count2;
        }
        
        $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'production')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

                  $zone_by_mise_en_place = DB::table('intrant_equipements')
                  ->where('choix_formulaire_remplir', 'production')
                  ->whereNotNull('nom_zone')
                  ->where('closed', 'false')
                  ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                  ->select('nom_zone')
                  ->distinct()
                  ->get();
  
              $zone = $request->input('by_zone');
  
              $section_by_mise_en_place = DB::table('intrant_equipements')
                  ->where('choix_formulaire_remplir', 'production')
                  ->whereNotNull('nom_section')
                  ->where('closed', 'false')
                  ->where('owner_name', '<>', 'demo')
                  ->where('owner_name', '<>', 'demo.ac')
                  ->select('nom_section')
                  ->where('nom_zone', $zone)
                  ->distinct()
                  ->get();

        return view('MobiagriDashboard.production', compact('production', 'production_count', 'sections', 'zone_by_mise_en_place', 'section_by_mise_en_place'));
    }
    
     public function filtrer_production(Request $request)
    {

        if (Auth::user()->nom_role == 'admin') {
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                //->where('campagne_coton', '23-24')
                ->where('choix_formulaire_remplir', 'production')
                 ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })->paginate(100);
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                //->where('campagne_coton', '23-24')
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('owner_name','<>', 'demo')
                ->where('owner_name','<>', 'demo.ac')
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->sum('qte_2eme_choix');
            $production_count = $production_count1 + $production_count2;
        } elseif (Auth::user()->nom_role == 'ca') {
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->paginate(100);
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_section', Auth::user()->section)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->sum('qte_2eme_choix');
            $production_count = $production_count1 + $production_count2;
        } else {
            $production = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->paginate(100);
            $production_count1 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->sum('qte_1er_choix');
            $production_count2 = DB::table('intrant_equipements')->where('closed', 'false')
                ->where('nom_producteur', '!=', null)
                ->where('prenom_producteur', '!=', null)
                ->where('prix_coton_1er_choix','<>', '---')
                ->where('prix_coton_1er_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '0')
                ->where('prix_coton_2eme_choix','<>', '---')
                ->where('qte_1er_choix','<>', '---')
                ->where('qte_2eme_choix','<>', '---')
                ->where('nom_zone', Auth::user()->nom_role)
                ->where('choix_formulaire_remplir', 'production')
                ->when(request()->has('search_campagne_production'), function($q){
                $q->where('campagne_coton', request('search_campagne_production'));
                })
                ->when(request()->has('search_zone_production'), function($q){
                $q->orWhere('nom_zone', request('search_zone_production'));
                })
                ->when(request()->has('search_section_production'), function($q){
                $q->orWhere('nom_section', request('search_section_production'));
                })
                
                ->sum('qte_2eme_choix');
            $production_count = $production_count1 + $production_count2;
        }
        
        $sections = DB::table('intrant_equipements')->select('nom_section')
                  //->where('nom_zone', Auth::user()->nom_role)
                  ->where('closed', 'false')
                   ->where('choix_formulaire_remplir', 'production')
                  ->where('owner_name', '<>', 'demo')->groupBy('nom_section')->get();

        return view('MobiagriDashboard.production', compact('production', 'production_count', 'sections'));
    }
    public function filtrer(Request $request)
    {
         $search = $request->input('search_dashboard');
         $searchZ = $request->input('searchZ');
         $searchS = $request->input('searchS');

         // V.A.R.I.A.B.L.E.S
         
         $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
       
         
        //recuperations des données from data base commcare faso coton
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        
           
            //producteurs
            $producteursH = DB::table('producteurs')->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.genre', 'homme')
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')

            ->get();
            $producteursF = DB::table('producteurs')->select('producteurs.*')
             ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.genre', 'femme')
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
             ->where('campagne_coton', 'like', '%'.$search.'%')
            ->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc =  $clc_total__montant_intrant;
            
            $cdc = DB::table('intrant_equipements')
           ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            
             $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
             ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix;
            $qt1er = $qte_1_choix + $prix_coton_1_choix;
            $qt2 = $qte_2_choix;
            $qt2eme = $qte_2_choix + $prix_coton_2_choix;
            $production_valoriseeOLD = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('campagne_coton', 'like', '%'.$search.'%')
            ->sum('supercifie_declaree');
           
            
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('campagne_coton', 'like', '%'.$search.'%')
            ->sum('superficie_mesuree_ha');
          
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->where('campagne_coton', 'like', '%'.$search.'%')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $mise_en_place - $production_valorisee;  
          
            
         
         return view('MobiagriDashboard.index',compact('search','producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    }
    
    
    public function filtrer_zone(Request $request)
    {
         $search = $request->input('search_dashboard');
         $searchZ = $request->input('searchZ_zone');
         $searchS = $request->input('searchS_zone');

         // V.A.R.I.A.B.L.E.S
         
         $dataODATAIntrants = json_decode(file_get_contents('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/6442c0119f2a9b814db1653287a0866e/feed'),true);
       $prixclc = 0;
       $prixcdc = 0;
       $prixmp = 0;
        //$prix_array = array();
        foreach($dataODATAIntrants['value'] as $dataODATAIntrant)
        {
            if($dataODATAIntrant['choix_formulaire_remplir'] == 'clc')
           $prixclc +=  settype($dataODATAIntrant['total_clc'],"integer");
           elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'cdc')
           $prixcdc +=  settype($dataODATAIntrant['total_cdc'],"integer");
            elseif($dataODATAIntrant['choix_formulaire_remplir'] == 'mp')
           $prixmp +=  settype($dataODATAIntrant['total_mp'],"integer");
        }
       
         
        //recuperations des données from data base commcare faso coton
        $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
        $quizzes = json_decode($response->body());
        
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        
           
           
          //producteurs
            $producteursH = DB::table('producteurs')->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.genre', 'homme')
            ->where('producteurs.nom_zone', Auth::user()->nom_role)
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')

            ->count();
            $producteursF = DB::table('producteurs')->select('producteurs.*')
             ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.genre', 'femme')
            ->where('producteurs.nom_zone', Auth::user()->nom_role)
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')
            ->count();
            $producteursTotal = ($producteursF) + ($producteursH);

            //scoops
            $scoops = DB::table('scoops')
            ->where('closed', 'false')
            ->where('zone', Auth::user()->nom_role)
            ->where('owner_name',  '<>',  'demo')
            ->where('owner_name',  '<>',  'demo.ac')
             ->when(request()->has('search_dashboard'), function($q){
                $q->where('campagne_coton', request('search_dashboard'));
                })
            ->get();
           /* $scoops = DB::table('scoops')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('zone', Auth::user()->nom_role)
             ->where('campagne_coton', 'like', '%'.$search.'%')
            ->get();*/
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc =  $clc_total__montant_intrant;
            
            $cdc = DB::table('intrant_equipements')
           ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            
             $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
             ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valoriseeOld = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_zone', Auth::user()->nom_role)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('campagne_coton', 'like', '%'.$search.'%')
            ->sum('supercifie_declaree');
           
            
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('campagne_coton', 'like', '%'.$search.'%')
            ->sum('superficie_mesuree_ha');
          
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
            
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->where('campagne_coton', 'like', '%'.$search.'%')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $mise_en_place - $production_valorisee;  
          
            
         
         return view('MobiagriDashboard.zone',compact('search','producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    }
    
    
     public function producteurs_filter(Request $request)
    {
        $search_producteur = $request->input('search_producteur');
        $search_producteurZ = $request->input('search_producteurZ');
        $search_producteurS = $request->input('search_producteurS');
        
        $producteurs = DB::table('producteurs')->select('scoops.code_scoop', 'producteurs.prenom_producteur','producteurs.nom_producteur',
        'producteurs.code_producteur','producteurs.code_scoop_producteur','producteurs.date_de_naissance',
        'scoops.nom_scoop', 'producteurs.closed', 'scoops.village', 'scoops.zone', 'scoops.section')
        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('producteurs.closed', 'false')
        //->orWhere('producteurs.campagne_coton', 'like', '%'.$search_producteur.'%')
        ->where('scoops.zone', 'like', '%'.$search_producteurZ.'%')
        ->where('scoops.section', 'like', '%'.$search_producteurS.'%')
        ->where('producteurs.prenom_producteur', '!=', null)
        ->where('producteurs.nom_producteur', '!=', null)
        ->where('producteurs.genre', '!=', null)
        ->get();
        
        return view('MobiagriDashboard.producteur', compact('producteurs'));
    }
    
     public function producteurs_zone()
    {
        $producteurs = DB::table('producteurs')->select('scoops.code_scoop', 'producteurs.prenom_producteur','producteurs.nom_producteur',
        'producteurs.code_producteur','producteurs.code_scoop_producteur','producteurs.date_de_naissance',
        'scoops.nom_scoop', 'producteurs.closed', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
         ->where('producteurs.closed', 'false')
        ->where('producteurs.prenom_producteur', '!=', null)
        ->where('producteurs.nom_producteur', '!=', null)
        ->where('producteurs.genre', '!=', null)
        ->get();
        
        return view('MobiagriDashboard.producteur_zone', compact('producteurs'));
    }
    
    public function scoops_zone()
    {
        $scoops = DB::table('scoops')
        ->where('closed', 'false')
        ->where('zone', Auth::user()->nom_role)
        ->get();
       
        return view('MobiagriDashboard.liste_scoops_zone', compact('scoops'));
    }
    
    public function clc_zone()
    {
        $clc = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.choix_formulaire_remplir', 'clc')->get();
        
        return view('MobiagriDashboard.clc_zone', compact('clc'));
    }
    
    public function cdc_zone()
    {
        $cdc = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')->get();

        return view('MobiagriDashboard.cdc_zone', compact('cdc'));
    }
    
    public function mise_en_place_zone()
    {
        $mise_en_place = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
        ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')->get();

        return view('MobiagriDashboard.mise_en_place_zone', compact('mise_en_place'));
    }
    
    public function besoin_complementaire_zone()
    {
        $besoin_complementaire = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
       ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')->get();

        return view('MobiagriDashboard.besoin_complementaire_zone', compact('besoin_complementaire'));
    }
    
    public function production_zone()
    {
        $production = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.zone', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
        ->where('intrant_equipements.choix_formulaire_remplir', 'production')->get();

        return view('MobiagriDashboard.production_zone', compact('production'));
    }
    
    public function helpdesks()
    {
        $helpdesks = DB::table('helpdesks')
        ->select('helpdesks.*')
        ->where('helpdesks.closed', 'false')
        ->where('statut_label', 'Requête Ouverte')
        ->orderBy('id', 'desc')
        ->get();
        $title = 'Requête Ouverte';
        return view('MobiagriDashboard.helpdesks', compact('helpdesks', 'title'));
    }

    public function helpdeskFermee()
    {
        $helpdesks = DB::table('helpdesks')
        ->select('helpdesks.*')
        ->where('helpdesks.closed', 'false')
        ->where('statut_label', 'Requête fermée')
        ->orderBy('id', 'desc')
        ->get();
        $title = 'Requête Fermée';
        return view('MobiagriDashboard.helpdesks', compact('helpdesks', 'title'));
    }
    
    
    public function physionomie()
    {
        $title = 'Physionomie de la campagne';

        if (Auth::user()->nom_role == 'admin') {
            
            $detail_scoops = DB::table('detail_scoops')
                ->where('detail_scoops.closed', 'false')
                ->where('detail_scoops.owner_name', '<>', 'demo')
                ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                ->where('detail_scoops.pourcentage_1er_traitement', '<>', '---')
                ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                ->paginate(20);
                
        } elseif (Auth::user()->nom_role == 'ca') {
            
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            
            $detail_scoops = DB::table('detail_scoops')
                ->where('detail_scoops.closed', 'false')
                ->where('detail_scoops.owner_name', $owner_name)
                ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                ->where('detail_scoops.pourcentage_1er_traitement', '<>', '---')
                ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                ->paginate(20);
        } else {
            $detail_scoops = DB::table('detail_scoops')
            ->join('scoops', 'scoops.code_scoop', 'detail_scoops.code_scoop')
            ->where('detail_scoops.closed', 'false')
                ->where('detail_scoops.owner_name', '<>', 'demo')
                ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                ->where('detail_scoops.pourcentage_1er_traitement', '<>', '---')
                ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->paginate(20);
        }

        
        return view('MobiagriDashboard.physionomie', compact('detail_scoops', 'title'));
    }
    
    public function travau_agricoles()
    {
        if (Auth::user()->nom_role == 'admin') {
            $detail_scoops = DB::table('detail_scoops')
            // ->join('scoops', 'scoops.code_scoop', 'detail_scoops.code_scoop')
                ->where('detail_scoops.closed', 'false')
                ->where('detail_scoops.owner_name', '<>', 'demo')
                // ->where('detail_scoops.pourcentage_semis_fra', '<>', '---')
                // ->where('detail_scoops.pourcentage_herbicidage_fra', '<>', '---')
                // ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                // ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                // ->where('detail_scoops.pourcentage_3e_sarclage', '<>', '---')
                // ->where('detail_scoops.pourcentage_buttage', '<>', '---')
                ->paginate(20);
        } elseif (Auth::user()->nom_role == 'ca') {
            
            $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
            
            $detail_scoops = DB::table('detail_scoops')
            // ->join('scoops', 'scoops.code_scoop', 'detail_scoops.code_scoop')
                ->where('detail_scoops.closed', 'false')
                ->where('detail_scoops.owner_name', $owner_name)
                // ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                // ->where('detail_scoops.pourcentage_1er_traitement', '<>', '---')
                // ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                // ->where('scoops.section', Auth::user()->section)
                ->paginate(20);
        } else {
            $detail_scoops = DB::table('detail_scoops')
            ->join('scoops', 'scoops.code_scoop', 'detail_scoops.code_scoop')
            ->where('detail_scoops.closed', 'false')
                // ->where('detail_scoops.owner_name', '<>', 'demo')
                // ->where('detail_scoops.pourcentage_1er_sarclage', '<>', '---')
                // ->where('detail_scoops.pourcentage_1er_traitement', '<>', '---')
                // ->where('detail_scoops.pourcentage_2e_sarclage', '<>', '---')
                ->where('scoops.zone', Auth::user()->nom_role)
                ->paginate(20);
        }

        // $detail_scoops = DB::table('detail_scoops')
        // ->where('detail_scoops.closed', 'false')
        // ->paginate(20);

        return view('MobiagriDashboard.travau_agricoles', compact('detail_scoops'));
    }
    
}
