<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Producteur;
use Illuminate\Support\Facades\Http;
use DB;
use Auth;

class CaController extends Controller
{
     public function production_ca()
    {
        $production = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.section', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
        ->where('intrant_equipements.choix_formulaire_remplir', 'production')->get();

        return view('MobiagriDashboard.production_ca', compact('production'));
    }
    
    public function mise_en_place_ca()
    {
        $mise_en_place = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.section', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
        ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')->get();

        return view('MobiagriDashboard.mise_en_place_ca', compact('mise_en_place'));
    }
    
    public function besoin_complementaire_ca()
    {
        $besoin_complementaire = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.section', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.nom_producteur', '!=', null)
        ->where('intrant_equipements.prenom_producteur', '!=', null)
       ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')->get();

        return view('MobiagriDashboard.besoin_complementaire_ca', compact('besoin_complementaire'));
    }
    
    public function cdc_ca()
    {
        $cdc = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.section', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')->get();

        return view('MobiagriDashboard.cdc_ca', compact('cdc'));
    }
    
    public function clc_ca()
    {
        $clc = DB::table('intrant_equipements')
        ->select('intrant_equipements.*', 'scoops.nom_scoop', 'scoops.village', 'scoops.section', 'scoops.zone')
        ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('scoops.closed', 'false')
        ->where('intrant_equipements.closed', 'false')
        ->where('intrant_equipements.choix_formulaire_remplir', 'clc')->get();
        
        return view('MobiagriDashboard.clc_ca', compact('clc'));
    }
    
     public function filtreproductionValorisee_ca(Request $request)
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                
                $value2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->groupBy('intrant_equipements.prix_coton_1er_choix')
                ->orderBy('intrant_equipements.prix_coton_1er_choix', 'desc')->limit(1)->first();
                
                $value2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                // ->select('prix_coton_2eme_choix')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.prix_coton_2eme_choix', '<>', '---')->where('intrant_equipements.campagne_coton', $request->campagne)
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('intrant_equipements.campagne_coton', $request->campagne)->sum('intrant_equipements.qte_1er_choix');
                
                $val2 = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.closed', 'false')
                 ->where('scoops.owner_name', '<>', 'demo')
                 ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
        return view('MobiagriDashboard.detail_filtre_production_valorisee_ca', ['total' => $total,'datas2'=> $datas2, 'datas' => $datas, 'value1' => $value1, 'value2' => $value2, 'title' => $title, 'route' => $route, 'img' => $img]);

    }
    
    public function productionValorisee_ca()
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
        ->where('scoops.section', Auth::user()->nom_role)
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.production_valorisee_ca', compact('campagnes'));
    }
    
     public function filtreProductionRealisee_ca(Request $request)
    {
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production MAG';
                $qt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'mag')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                
                $qt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'mag')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix');
                // dd($qt2);
                $total = doubleval($qt1) + doubleval($qt2);
                break;
            case '2':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production CD';
                $qt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'cd')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                
                $qt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'cd')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix');
                $total = doubleval($qt1) + doubleval($qt2);
                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Production Total en KG';

                $magQt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'cd')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                
                $cdQt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'cd')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix');
                $qt1 = doubleval($magQt1) + doubleval($cdQt1);

                $magQt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'mag')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix');
                
                $cdQt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'production')->where('intrant_equipements.type_marche', 'cd')
                ->where('intrant_equipements.closed', 'false')->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix');
                $qt2 = doubleval($magQt2) + doubleval($cdQt2);

                $total = doubleval($qt1) + doubleval($qt2);
                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Entrées usines MAG';

                $qt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'entree_usine')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix_mag');
                
                $qt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'entree_usine')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix_mag');

                $total = doubleval($qt1) + doubleval($qt2);

                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/statistics.png';
                $title = 'Entrées usines CD';

                $qt1 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'entree_usine')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_1er_choix_mag');
                
                $qt2 = DB::table('intrant_equipements')
                ->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'intrant_equipements.code_scoop_producteur')
                ->where('intrant_equipements.choix_formulaire_remplir', 'entree_usine')->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('scoops.owner_name', '<>', 'demo')
                ->where('scoops.closed', 'false')
                ->where('scoops.section', Auth::user()->nom_role)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->sum('intrant_equipements.qte_2eme_choix_mag');

                $total = doubleval($qt1) + doubleval($qt2);

                break;
            
        }

        $route = 'productionRealisee';
        return view('MobiagriDashboard.detail_filtre_production_ca', ['qt1' => $qt1, 'qt2' => $qt2, 'total' => $total, 'title' => $title, 'route' => $route, 'img' => $img]);
    }
    
    public function productionRealisee_ca()
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
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->where('producteurs.closed', 'false')
        ->where('producteurs.actif', 1)
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.production_realisee_ca', compact('campagnes'));
    }
    
    public function evaluProducton_ca()
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
        ->where('scoops.section', Auth::user()->nom_role)
        ->where('producteurs.owner_name', '<>', 'demo')
        ->groupBy('producteurs.campagne_coton')
        ->get();
        return view('MobiagriDashboard.evalution_production_ca', compact('campagnes'));
    }
    
     public function filtreEvaluation_ca(Request $request)
    {
        // dd($request->all());

        $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
        $title = 'Evaluation de la production';
        $dataCount = 0;

        $route = 'evaluProducton';
        return view('MobiagriDashboard.detail_filtre_rapport_ca', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route]);
    }
    
    public function superficies_ca()
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
        ->where('scoops.section', Auth::user()->nom_role)
        ->groupBy('producteurs.campagne_coton')->get();
        return view('MobiagriDashboard.superficie_ca', compact('campagnes'));
    }
    public function filtreSuperficie_ca(Request $request)
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->sum('intrant_equipements.superficie_prevu_producteur');
                
                $datas = DB::table('intrant_equipements')->select('intrant_equipements.*',
                'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                ->where('intrant_equipements.closed', 'false')
                ->where('intrant_equipements.superficie_prevu_producteur', '<>', '')
                ->where('intrant_equipements.superficie_prevu_producteur', '<>', '---')
                ->where('intrant_equipements.campagne_coton', $request->campagne)
                ->where('intrant_equipements.owner_name', '<>', 'demo')
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
        return view('MobiagriDashboard.detail_filtre_rapport_ca', ['dataCount' => $dataCount, 'img' => $img, 'title' => $title, 'route' => $route, 'datas' => $datas]);
    }
    
    public function prodGrpmt_ca()
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
        ->where('scoops.section', Auth::user()->nom_role)
        ->get();
        
        return view('MobiagriDashboard.prod_grpmt_ca', compact('campagnes'));
    }
    
    public function filtreProdGrpmt_ca(Request $request)
    {
       
        switch ($request->option) {
            case '1':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/AmountFarmerGroup.png';
                $title = 'Nombre de Groupements';
                // $dataCount = DB::table('scoops')->where('closed', 'false')
                // ->where('zone', Auth::user()->nom_role)
                // ->where('code_scoop','<>','---')
                // ->where('owner_name', '<>', 'demo')->count();
                
                $datas = DB::table('scoops')->where('closed', 'false')
                ->where('section', Auth::user()->nom_role)
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
                    ->where('scoops.section', Auth::user()->nom_role)
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
                    ->where('scoops.section', Auth::user()->nom_role)
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
                    'scoops.section',
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->get();

                break;
            case '3':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs (Hommes)';

                // $dataCount = DB::table('producteurs')
                // ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.owner_name',
                // 'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                // ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                // ->where('producteurs.closed', 'false')
                // ->where('scoops.closed', 'false')
                // ->where('producteurs.actif', 1)
                // ->where('producteurs.genre', 'homme')
                // ->where('producteurs.owner_name', '<>', 'demo')
                // ->where('scoops.owner_name', '<>', 'demo')
                // ->where('scoops.section', Auth::user()->nom_role)
                // ->count();

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
                    'scoops.section',
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->get();
                
                $dataCount = $datas->count();
                
                // dd($dataCount);

                break;
            case '4':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmerFemal.png';
                $title = 'Nombre de producteurs (Femmes)';

                // $dataCount = DB::table('producteurs')
                // // ->where('closed', 'false')
                // // ->where('actif', 1)
                // // ->where('genre', 'femme')
                // // ->where('owner_name', '<>', 'demo')
                // ->select('producteurs.id', 'producteurs.genre', 'producteurs.closed', 'producteurs.actif', 'producteurs.owner_name',
                // 'scoops.owner_name', 'scoops.code_scoop', 'scoops.section', 'scoops.zone', 'scoops.closed')
                // ->join('scoops', 'scoops.code_scoop', 'producteurs.code_scoop_producteur')
                // ->where('producteurs.closed', 'false')
                // ->where('scoops.closed', 'false')
                // ->where('producteurs.actif', 1)
                // ->where('producteurs.genre', 'femme')
                // ->where('producteurs.owner_name', '<>', 'demo')
                // ->where('scoops.owner_name', '<>', 'demo')
                // ->where('scoops.zone', Auth::user()->nom_role)
                // ->count();

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
                'scoops.section',
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
                ->where('scoops.section', Auth::user()->nom_role)
                ->get();
                
                $dataCount = $datas->count();
                
                // dd($dataCount);

                break;
            case '5':
                $img = 'MobiagriDashboard/assets/img/icons/unicons/farmer.png';
                $title = 'Nombre de producteurs individuels';

                $dataCount = DB::table('producteur_individuels')
                ->where('closed', 'false')
                ->count();
                // $dataCount ='0';
                
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                    'scoops.section',
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                    'scoops.section',
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                    'scoops.section',
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
                    ->where('scoops.section', Auth::user()->nom_role)
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
                ->where('scoops.section', Auth::user()->nom_role)
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
                    'scoops.section',
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
                    ->where('scoops.section', Auth::user()->nom_role)
                    ->get();
                break;
        }

        $route = 'prodGrpmt_zone';
        return view('MobiagriDashboard.detail_filtre_rapport_ca', ['dataCount' => $dataCount, 'img' =>$img, 'title' =>$title, 'route' => $route, 'datas' => $datas]);
    }
    
    public function ca()
    {  
        
        
        $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
        $owner_nameSection = Auth::user()->section;
     
        $producteursH = DB::table('producteurs')
            ->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'homme')
            ->where('producteurs.nom_section', $owner_nameSection)
            ->get();
           // dd(count($producteursH));
            $producteursF = DB::table('producteurs')
            ->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'femme')
            ->where('producteurs.nom_section', $owner_nameSection)
           ->get();
            
          
            
            $producteursTotal = (count($producteursF)) + (count($producteursH));
            
            // dd($dataCount);

            //scoops
            $scoops = DB::table('scoops')
            ->where('closed', 'false')
            ->where('owner_name',  '<>',  'demo')
            ->where('owner_name',  '<>',  'demo.ac')
             ->where('section', $owner_nameSection)
            ->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
          
            
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_montant_intrants');
            
             $clc =  $clc_total__montant_intrant;
            

            $cdc = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_montant_intrants');
            

            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.prevision_de_production_scoop');
            $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
             ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
             ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valoriseeOLD = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.owner_name', '<>', 'demo.ac')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')->where('owner_name', $owner_name)->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('section', $owner_nameSection)
            ->sum('supercifie_declaree');
           
            $superficie_mesuree = DB::table('parcelles')
            ->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
            ->where('owner_name', '<>', 'demo.ac')
            ->where('section', $owner_nameSection)
            ->sum('superficie_mesuree_ha');
             
            
            $coeficient_de_correction =  $superficie_declarer == 0 ? 0 : $superficie_mesuree / $superficie_declarer;
            $superficie_corrige =  $superficie_declarer * $coeficient_de_correction;
            $superficie_productive = $superficie_corrige - $superficie_perdue;
          //  dd($coeficient_de_correction);
            //mise en place
            $rendement_moyen = DB::table('mise_en_places')->sum('rendement_moyen_groupements');
            $rendement_moyen_scoops = $nombre_scoops == 0 ? 0 : $rendement_moyen / $nombre_scoops;
            
            //rendement et mari
            $rendement = $superficie_corrige == 0 ? 0 : $production_tonnes / $superficie_corrige;
            $mari = $production_valorisee - $mise_en_place;
          
            //dd($superficie_prevue);
            //view('odata.dashboard'
           return view('MobiagriDashboard.ca', compact('producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
    
    }
    
    
    public function filtrer_ca(Request $request)
    {
         $owner_name = Auth::user()->nom . '' . Auth::user()->prenom;
         $owner_nameSection = Auth::user()->section;
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
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'homme')
            ->where('producteurs.nom_section', $owner_nameSection)
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')

            ->get();
            $producteursF = DB::table('producteurs')->select('producteurs.*')
            ->where('producteurs.closed', 'false')
            ->where('producteurs.actif', 1)
            ->where('producteurs.owner_name', '<>', 'demo')
            ->where('producteurs.owner_name', '<>', 'demo.ac')
            ->where('producteurs.genre', 'femme')
            ->where('producteurs.nom_section', $owner_nameSection)
            ->where('producteurs.campagne_coton', 'like', '%'.$search.'%')
            ->get();
            $producteursTotal = (count($producteursF)) + (count($producteursH));

            //scoops
            $scoops = DB::table('scoops')->where('closed', 'false')
            ->where('owner_name', '<>', 'demo')
             ->where('section', $owner_nameSection)
             ->where('campagne_coton', 'like', '%'.$search.'%')
            ->get();
            $nombre_scoops = count($scoops);
            
            //intrant et equipement
            $superficie_prevue = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->where('choix_formulaire_remplir', 'mise_en_place')
            ->sum('intrant_equipements.superficie_prevu_producteur');
            //->sum('intrant_equipements.superficie_prevu_groupement');
            
            $superficie_realise = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.superficie_realise_producteur');
            
            $clc_total_cls = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_clc');
            
            $clc_total__montant_intrant = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'clc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $clc =  $clc_total__montant_intrant;
            
            $cdc = DB::table('intrant_equipements')
           ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'cdc')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_cdc');
            
            $besoin_complementaire = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'besoins_complementaires')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $mise_en_place = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.choix_formulaire_remplir', 'mise_en_place')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_montant_intrants');
            
            $prevision_de_production = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prevision_de_production_scoop');
            
             $qte_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix');
            $qte_1_choix_mag = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_1er_choix_mag');
            $qte_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix');
            $qte_2_choix_mag = DB::table('intrant_equipements')
             ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.qte_2eme_choix_mag');
            $production_tonnes = $qte_1_choix + $qte_2_choix;
            $prix_coton_1_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_1er_choix');
            $prix_coton_2_choix = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.prix_coton_2eme_choix');
            $qt1 = $qte_1_choix + $qte_1_choix_mag;
            $qt1er = $qt1 * $prix_coton_1_choix;
            $qt2 = $qte_2_choix + $qte_2_choix_mag;
            $qt2eme = $qt2 * $prix_coton_2_choix;
            $production_valoriseeOLD = $qt1er + $qt2eme;
            
            $production_valorisee = DB::table('intrant_equipements')
            ->select('intrant_equipements.*')
            ->where('intrant_equipements.closed', 'false')
            ->where('intrant_equipements.owner_name', '<>', 'demo')
            ->where('intrant_equipements.nom_section', $owner_nameSection)
            ->where('intrant_equipements.campagne_coton', 'like', '%'.$search.'%')
            ->sum('intrant_equipements.total_production');
            
            //visite et suivi du parasitisme
            $superficie_perdue = DB::table('visite_paracitismes')->where('closed', 'false')->where('owner_name', '<>', 'demo')->where('owner_name', $owner_name)->sum('superficie_perdue');

            //parcelles
            $superficie_declarer = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')->where('section', $owner_nameSection)
            ->where('campagne_coton', 'like', '%'.$search.'%')
            ->sum('supercifie_declaree');
           
            
            $superficie_mesuree = DB::table('parcelles')->where('closed', 'false')->where('owner_name', '<>', 'demo')->where('section', $owner_nameSection)
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
            $mari = $production_valorisee - $mise_en_place; 
          
            
         
         return view('MobiagriDashboard.ca',compact('search','producteursH', 'producteursF', 'producteursTotal',
           'nombre_scoops', 'superficie_prevue', 'superficie_realise', 'clc', 'cdc', 'besoin_complementaire',
           'mise_en_place', 'prevision_de_production', 'production_tonnes', 'production_valorisee', 'superficie_perdue',
           'superficie_declarer', 'superficie_mesuree', 'superficie_corrige', 'superficie_productive',
           'rendement_moyen_scoops', 'rendement', 'mari'));
           
    }
    
}