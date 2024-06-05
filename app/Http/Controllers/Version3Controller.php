<?php

namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\BienvenueACollaboratis;
use Illuminate\Support\Str;
use App\Role;
use App\User;  
use Auth;    
use Mail;
use Session;
use App\Suivi_action;   
use DB;
use App\Action;
use App\Service;
use App\Agent;
use App\Annonce;
use App\Reunion;
use App\Decission;
use App\Direction;
use App\Tache;
use App\Tache_modele;
use App\Modele;
use App\Activite;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Version3Controller extends Controller
{

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    } 
    
    
    public function convert_csv_insert()
    {
        //echo 'heelo';
        
        
         // Chargez le fichier CSV
        //$file = File::get(File::base_path() . '/resources/views/mentsIntrants.csv');
      $file = File::get(base_path('resources/views/mentsIntrants.csv'));

// Convertissez le fichier CSV en tableau
$data = array_map('str_getcsv', explode("\n", $file));

// Supprimez la première ligne (en-tête)
array_shift($data);

// Obtenez les noms des colonnes
$columns = array_keys($data[0]);

// Convertissez les données du tableau en tableau associatif
$data = array_combine($columns, $data);

// Insérez les données dans la base de données
foreach ($data as $row) {
    DB::table('ments')->insert($row);
}

        return response()->json([
            'success' => true,
        ]);
        
        // Chargez le fichier CSV
        //$file = File::get(base_path('resources/views/intrants_equipements.xlsx'));
      // $file = base64_encode(File::get(base_path('resources/views/intrants_equipements.xlsx')));
        
        
        
       // $spreadsheet = IOFactory::load(base_path('resources/views/test.xlsx'));
       // $data = $spreadsheet->getActiveSheet()->toArray();

       //  array_shift($data); // Supprime la première ligne (en-tête)
            // Insérez les données dans la base de données
        //    foreach ($data as $row) {
         //       DB::table('ments')->insert($row);
         //   }
      

       // return response()->json([
      //      'success' => true,
       // ]);
    }

    public function login(Request $request){

        if($request->isMethod('post')){
            $admin = 'Bienvenue dans la partie admin';
            $tech = 'Bienvenue dans la partie tech';
            $marketing = 'Bienvenue dans la partie marketing';
            $assistant = 'Bienvenue dans la partie assistant';
            $secretaire = 'Bienvenue dans la partie secretaire';
            $rapporteur = 'Bienvenue dans la partie Rapporteur';
            $utilisateur = 'Bienvenue dans la partie Utilisateur';
            $responsable = 'Bienvenue dans la partie Responsable';
            $directeur = 'Bienvenue dans la partie Directeur';
            $prospect= 'Bienvenue dans la partie Prospect';
            $message = 'Email ou Mot de passe incorrect';
            $help_desk = "Bienvenue dans l'espace helpdesk'";
            $ca = "Bienvenue dans l'espace du Conseiller Agricole'";

            $data = $request->input();
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'admin'])){

                //echo "succes"; die;
               // return redirect('/producteurs/groupements')->with(['admin' => $admin]);
                return redirect('/dashboard')->with(['admin' => $admin]);
            }
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'ZORGHO'])){
                return redirect('/dashboard/zone')->with(['tech' => $tech]);;
            }
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'TENKODOGO'])){
                return redirect('/dashboard/zone')->with(['tech' => $tech]);;
            }
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'MANGA'])){
                return redirect('/dashboard/zone')->with(['tech' => $tech]);;
            }
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'PO'])){
                return redirect('/dashboard/zone')->with(['tech' => $tech]);;
            }
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'KOMBISSIRI'])){
                return redirect('/dashboard/zone')->with(['tech' => $tech]);;
            }
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'tech'])){
                return redirect('/admin/dashboard/tech')->with(['tech' => $tech]);;
            }
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'marketing'])){
                return redirect('/admin/dashboard/marketing')->with(['marketing' => $marketing]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'assistant(e)'])){
                return redirect('/admin/dashboard/assistant')->with(['admin' => $admin]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'secretaire'])){
                return redirect('/admin/dashboard/secretaire')->with(['admin' => $admin]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'utilisateur'])){
                return redirect('/v3/admin/dashboard/')->with(['utilisateur' => $utilisateur]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'responsable'])){
                return redirect('/v3/admin/dashboard/')->with(['responsable' => $responsable]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'directeur'])){
                return redirect('/v3/admin/dashboard')->with(['directeur' => $directeur]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'Rapporteur'])){
                return redirect('/admin/dashboard/rapporteur')->with(['rapporteur' => $rapporteur]);;
            }
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'Prospect'])){
                return redirect('/feedback/prospect')->with(['prospect' => $prospect]);;
            }
            
             elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'helpdesk'])){
                return redirect('/helpdesks')->with(['help_desk' => $help_desk]);;
            }
            
            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'ca'])){
                return redirect('/dashboard/ca')->with(['ca' => $ca]);;
            }
             
            else{
                //echo "failed"; die;

                return redirect('/connexion')->with(['message' => $message]);  
            }
        }
        return view('admin/connexion.login');
    }
    
    public function dashboard()  
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                  $projets = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.projet_id', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                     $action_me = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                     $pro = DB::table('projets')->get();
                    //  dd($projets);
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                              ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             //dd(array_sum($sum_array_dir));
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                        $count_actions = 9;
                        $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                        $count_actions_dir = count($action_directions);
                        $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $taches = DB::table('taches')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->orderBy('deadline', 'DESC')->get();
                         $activi = DB::table('activites')->where('statut', '=', 0)->get();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                         $strategiques = DB::table('strategiques')->get();
                         
                         $ag = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $strategiquess = DB::table('strategiques')->where('direction_id', $ag->direction_id)->get();
                         
                         $results_id = DB::table('strategiques')
                            ->select('strategiques.id')
                            ->get();
                            
                          $indi_array = array();
                          $sum_array = array();
                          $count_array = array();
                          
                          foreach($results_id as $resul)
                          {
                            $indicateurs_sum = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->get();
                            $count = count($indicateurs_global); 
                            array_push($indi_array, $indicateurs_global);
                            
                             //$sum = $indicateurs_sum / $count;
                             $sum = $count == 0 ? 0 : $indicateurs_sum / $count;
                             array_push($sum_array,$sum);
                          }
                          
                           $results_ids = DB::table('strategiques')
                            ->select('id')->where('direction_id', $ag->direction_id)
                            ->get();
                            
                          $indi_arrays = array();
                          $sum_arrays = array();
                          $count_arrays = array();
                          $sums = array();
                          
                          $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          
                          foreach($results_ids as $resuls)
                          {
                          
                          $age = DB::table('agents')->where('direction_id', $agen->direction_id)->get();
                              foreach($age as $ag)
                              {
                                $indicateurs_sums = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->sum('modeles.pourcentage');
                                $indicateurs_globals = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->get();
                                $counts = count($indicateurs_globals); 
                                array_push($indi_arrays, $indicateurs_globals);
                                
                                 //$sum = $indicateurs_sum / $count;
                                 $sums = $counts == 0 ? 0 : $indicateurs_sums / $counts;
                                 array_push($sum_arrays,$sums);
                              }
                          }
                          
                          $call_array = array();
                          $count_array = array();
                          $calpourcen_array = array();
                          $calculs = DB::table('strategiques')->get();
                          $total = 0;
                          foreach($calculs as $calcul)
                          {
                            $calpourcen = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->sum('modeles.pourcentage');
                            array_push($calpourcen_array,$calpourcen);
                            $compter = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->count();
                             array_push($count_array,$compter);

                            $total = $compter == 0 ? 0 : $calpourcen / $compter ;
                            
                            array_push($call_array,$total);

                          }
                         $ageAction = DB::table('agents')->where('user_id',Auth::user()->id)->first();
                         $agent_id = DB::table('agents')
                            //->select('agents.id')
                           ->where('direction_id', $ageAction->direction_id)
                            ->get();
                            
                         $indi_array_agent = array();
                         $sum_array_agent = array();
                         $count_array_agent = array();
                         $actMoisagent = date('m');
                         foreach ($agent_id as $agentes){
                             
                             $action_count = DB::table('performances')
                            ->select('performances.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->count();
                             
                              $action_sum =  DB::table('performances')
                            ->select('performances.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->sum('performances.sommes');
                             
                             

                              $sum_agent = $action_count == 0 ? 0 : $action_sum / $action_count;
                             array_push($sum_array_agent,$sum_agent);
                             
                             
                         }
                         
                        
                         $date_today = now();
                         $decembre = date('Y-m');
                         $perfo_decembre_count = array();
                         $perfo_decembre_sum = array();
                         $perfo_decembre_total = array();
                         
                         $agent_mois = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         
                         
                           $action_agents_mois_sum = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)
                             
                             ->sum('actions.pourcentage');
                              $action_agents_mois_countss = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)->count();
                             
                             $total_pourcentage = $action_agents_mois_countss == 0 ? 0 : $action_agents_mois_sum / $action_agents_mois_countss;
                           // DB::table('performances')->insert(['agent_id' => $agent_mois->id, 'sommes' => $total_pourcentage,  'created_at' => $date_today, 'updated_at' => $date_today]);
                             
                             //dd($action_agents_mois_sum);
                             
                            //Ma Performance / mois / semaine / semaine passer 
                             
                             $semaine_passe = (date('d') - 7);
                             $semaineM = (date('d') - 7);
                             $semaineP = (date('d') + 7);
                             $mois = date('m');
                             
                             $somme_mois = 0;
                             $total_mois = array();
                             $total_semaine = array();
                             $total_semaine_passe = array();
                             $perfNows = DB::table('actions')->where('agent_id', $agent_mois->id)->get();
                             //dd($perfNows);
                             $var = array();
                             $vari = array();
                             
                             foreach($perfNows as $perfNow)
                             {
                                 if($semaine_passe == date('d', strtotime($perfNow->deadline)))
                                 {
                                     $somme_semaine_passe = $perfNow->pourcentage;
                                      //dd($somme_semaine_passe);
                                       array_push($vari,$perfNow);
                                      //dd($vari);
                                    array_push($total_semaine_passe, $somme_semaine_passe);
  
                                 }
                                  
                                 elseif((date('d', strtotime($perfNow->deadline)) > $semaineM) && ( date('d', strtotime($perfNow->deadline)) < $semaineP))
                                 {
                                      $somme_semaine = $perfNow->pourcentage;
                                      //$var += $perfNow;
                                      array_push($var,$perfNow);
                                      $semaine_count = count($perfNows);
                                      //dd($semaine_count);
                                     array_push($total_semaine, $somme_semaine);

                                 }
                                
                                 if($mois == date('m', strtotime($perfNow->deadline)))
                                 {
                                     
                                      $somme_mois = $perfNow->pourcentage;
                                      
                                      array_push($total_mois, $somme_mois);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             $semaine_passer = array_sum($total_semaine_passe);
                             $semaines = array_sum($total_semaine);
                             $perfoMe = count($var);
                             $perfoPastMe = count($total_semaine_passe);
                             $ma_semaine_total = $perfoMe == 0 ? 0 : $semaines / $perfoMe;
                             $ma_semaine_passe = $perfoPastMe == 0 ? 0 : $semaine_passer / $perfoPastMe;
                             $count_mois = count($total_mois);
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois = $count_mois == 0 ? 0 : (array_sum($total_mois) / $count_mois);
                         
                          //dd($somme_total_mois);
                          
                          // Performance de ma direction / mois / semaine / semaine passer
                          
                             $semaine_passe_dir = (date('d') - 7);
                             $semaine_dir = date('d');
                             $semaine_dirM = (date('d') - 5);
                             $semaine_dirP = (date('d') + 7);
                             $mois_dir = date('m');
                             
                             $somme_mois_dir = 0;
                             $total_mois_dir = array();
                             $total_semaine_dir = array();
                             $total_semaine_passe_dir = array();
                             
                             $agent_dirs = DB::table('agents')->where('direction_id', $agent_mois->direction_id)->get();
                             foreach($agent_dirs as $agent_dir)
                             {
                             $perfNows_dir = DB::table('actions')->where('agent_id', $agent_dir->id)->get();
                             foreach($perfNows_dir as $perfNow_dir)
                             {
                                 if($semaine_passe_dir == date('d', strtotime($perfNow_dir->deadline)))
                                 {
                                     $somme_semaine_passe_dir = $perfNow_dir->pourcentage;
                                      //dd($somme_semaine_passe);
                                    array_push($total_semaine_passe_dir, $somme_semaine_passe_dir);
  
                                 }
                                 
                                 elseif((date('d', strtotime($perfNow_dir->deadline)) > $semaine_dirM) && ( date('d', strtotime($perfNow_dir->deadline)) < $semaine_dirP))
                                 {
                                      $somme_semaine_dir = $perfNow_dir->pourcentage;
                                      //dd($somme_semaine);
                                     array_push($total_semaine_dir, $somme_semaine_dir);
                                     //dd($total_semaine_dir);

                                 }
                                
                                 if($mois_dir == date('m', strtotime($perfNow_dir->deadline)))
                                 {
                                     
                                      $somme_mois_dir = $perfNow_dir->pourcentage;
                                      
                                      array_push($total_mois_dir, $somme_mois_dir);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             }
                             $semaine_passer_dir = array_sum($total_semaine_passe_dir);
                             $semaines_dir = array_sum($total_semaine_dir);
                             $perfo_counts = count($total_semaine_dir);
                            //dd($perfo_counts);
                             $somme_total_semaine_dir = $perfo_counts == 0 ? 0 : $semaines_dir / $perfo_counts;
                             $count_mois_dir = count($total_mois_dir);
                             
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois_dir = $count_mois_dir == 0 ? 0 : (array_sum($total_mois_dir) / $count_mois_dir);

                              $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                             
                          $action_indi_array_dir = array();
                          $action_sum_array_dir = array();
                          $action_count_array_dir = array();
                         
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $action_indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois_dir)
                            ->sum('actions.pourcentage');
                            //dd($action_indicateurs_sum_dir);
                            $action_indicateurs_global_dir = DB::table('actions')
                           ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois_dir)
                
                            ->get();
                            $action_count_dir = count($action_indicateurs_global_dir); 
                            $action_sum_dir = $action_count_dir == 0 ? 0 : $action_indicateurs_sum_dir / $action_count_dir;
                        
                            array_push($action_sum_array_dir,$action_sum_dir);
                            
                           // dd($action_sum_array_dir);
                            
                           
                           
                          }
                           $action_mois = date('m');
                                $action_semaineM7 = (date('d') -7);
                                $action_semaineP7 = (date('d') +7);
                          
                          $action_respons = array();
                           $action_responss = array();
                           $action_bakupss = array();
                    //dd($action_semaineP7);
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison', 'actions.projet_id',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    $action_bakupsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable',
                                'actions.libelle', 'actions.note',
                                'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',
                                'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                                'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                                )
                                ->join('agents', 'agents.id', 'actions.agent_id')
                                ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                                //->where('actions.agent_id','=', $user->id)
                                ->where('actions.bakup','=', $user->id)
                                ->orderBy('actions.pourcentage', 'ASC')
                                ->get();
                    //M.A.X B.I.R.D was HERE
                    $cumul_delay = 0;

                    foreach($action_responsf as $action_respf)
                    {
                      
                        if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        {
                                        array_push($action_responss, $action_respf);
                        }
                        //if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            //M.A.X B.I.R.D was HERE
                            $cumul_delay += intval(abs(strtotime("now") - strtotime($action_respf->deadline))/ 86400);
                            
                            array_push($action_respons, $action_respf);
                        }
                        
                    }
                    foreach($action_bakupsf as $action_bakupf)
                                {
                                    if(($action_semaineP7 >= date('d', strtotime($action_bakupf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_bakupf->deadline))) && ($action_mois == date('m', strtotime($action_bakupf->deadline))))
                                    {
                                        array_push($action_bakupss, $action_bakupf);
                                    }
                                }
                    $late = count($action_respons);
                    $due = count($action_responss);
                    $due_backup = count($action_bakupss);

                         //dd($action_sum_array_dir);
                          
                        return view('v2.dashboard_dg', compact('agent_id', 'pro', 'user', 'projets', 'action_me', 'semaines', 'semaine_passer', 'somme_total_mois','semaines_dir', 'semaine_passer_dir', 'somme_total_mois_dir','action_sum_array_dir', 'actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','action_bakupss','annonces', 'action_users','strategiques','strategiquess',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','action_bakupsf','due_backup','late','action_respons','action_responss','due','action_responsf','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','ma_semaine_total','sums','ma_semaine_passe','sum_dir','call_array','userAgents','total', 'activites','taches','activi','tache_modeles','modeles','activim','modeles_intervients','sum_array','sum_arrays','sum_array_agent','count_array_agent','somme_total_semaine_dir', 'cumul_delay'));

    }
    public function user_action_semaine()  
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                  $projets = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.projet_id', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $pro = DB::table('projets')->get();
                    //  dd($projets);
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                              ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             //dd(array_sum($sum_array_dir));
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                        $count_actions = 9;
                        $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                        $count_actions_dir = count($action_directions);
                        $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $taches = DB::table('taches')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->orderBy('deadline', 'DESC')->get();
                         $activi = DB::table('activites')->where('statut', '=', 0)->get();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                         $strategiques = DB::table('strategiques')->get();
                         
                         $ag = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $strategiquess = DB::table('strategiques')->where('direction_id', $ag->direction_id)->get();
                         
                         $results_id = DB::table('strategiques')
                            ->select('strategiques.id')
                            ->get();
                            
                          $indi_array = array();
                          $sum_array = array();
                          $count_array = array();
                          
                          foreach($results_id as $resul)
                          {
                            $indicateurs_sum = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->get();
                            $count = count($indicateurs_global); 
                            array_push($indi_array, $indicateurs_global);
                            
                             //$sum = $indicateurs_sum / $count;
                             $sum = $count == 0 ? 0 : $indicateurs_sum / $count;
                             array_push($sum_array,$sum);
                          }
                          
                           $results_ids = DB::table('strategiques')
                            ->select('id')->where('direction_id', $ag->direction_id)
                            ->get();
                            
                          $indi_arrays = array();
                          $sum_arrays = array();
                          $count_arrays = array();
                          $sums = array();
                          
                          $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          
                          foreach($results_ids as $resuls)
                          {
                          
                          $age = DB::table('agents')->where('direction_id', $agen->direction_id)->get();
                              foreach($age as $ag)
                              {
                                $indicateurs_sums = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->sum('modeles.pourcentage');
                                $indicateurs_globals = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->get();
                                $counts = count($indicateurs_globals); 
                                array_push($indi_arrays, $indicateurs_globals);
                                
                                 //$sum = $indicateurs_sum / $count;
                                 $sums = $counts == 0 ? 0 : $indicateurs_sums / $counts;
                                 array_push($sum_arrays,$sums);
                              }
                          }
                          
                          $call_array = array();
                          $count_array = array();
                          $calpourcen_array = array();
                          $calculs = DB::table('strategiques')->get();
                          $total = 0;
                          foreach($calculs as $calcul)
                          {
                            $calpourcen = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->sum('modeles.pourcentage');
                            array_push($calpourcen_array,$calpourcen);
                            $compter = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->count();
                             array_push($count_array,$compter);

                            $total = $compter == 0 ? 0 : $calpourcen / $compter ;
                            
                            array_push($call_array,$total);

                          }
                         $ageAction = DB::table('agents')->where('user_id',Auth::user()->id)->first();
                         $agent_id = DB::table('agents')
                            //->select('agents.id')
                           ->where('direction_id', $ageAction->direction_id)
                            ->get();
                            
                         $indi_array_agent = array();
                         $sum_array_agent = array();
                         $count_array_agent = array();
                         $actMoisagent = date('m');
                         foreach ($agent_id as $agentes){
                             
                             $action_count = DB::table('performances')
                            ->select('performances.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->count();
                             
                              $action_sum =  DB::table('performances')
                            ->select('performances.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->sum('performances.sommes');
                             
                             

                              $sum_agent = $action_count == 0 ? 0 : $action_sum / $action_count;
                             array_push($sum_array_agent,$sum_agent);
                             
                             
                         }
                         
                        
                         $date_today = now();
                         $decembre = date('Y-m');
                         $perfo_decembre_count = array();
                         $perfo_decembre_sum = array();
                         $perfo_decembre_total = array();
                         
                         $agent_mois = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         
                         
                           $action_agents_mois_sum = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)
                             
                             ->sum('actions.pourcentage');
                              $action_agents_mois_countss = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)->count();
                             
                             $total_pourcentage = $action_agents_mois_countss == 0 ? 0 : $action_agents_mois_sum / $action_agents_mois_countss;
                           // DB::table('performances')->insert(['agent_id' => $agent_mois->id, 'sommes' => $total_pourcentage,  'created_at' => $date_today, 'updated_at' => $date_today]);
                             
                             //dd($action_agents_mois_sum);
                             
                            //Ma Performance / mois / semaine / semaine passer 
                             
                             $semaine_passe = (date('d') - 7);
                             $semaineM = (date('d') - 7);
                             $semaineP = (date('d') + 7);
                             $mois = date('m');
                             
                             $somme_mois = 0;
                             $total_mois = array();
                             $total_semaine = array();
                             $total_semaine_passe = array();
                             $perfNows = DB::table('actions')->where('agent_id', $agent_mois->id)->get();
                             //dd($perfNows);
                             $var = array();
                             $vari = array();
                             
                             foreach($perfNows as $perfNow)
                             {
                                 if($semaine_passe == date('d', strtotime($perfNow->deadline)))
                                 {
                                     $somme_semaine_passe = $perfNow->pourcentage;
                                      //dd($somme_semaine_passe);
                                       array_push($vari,$perfNow);
                                      //dd($vari);
                                    array_push($total_semaine_passe, $somme_semaine_passe);
  
                                 }
                                  
                                 elseif((date('d', strtotime($perfNow->deadline)) > $semaineM) && ( date('d', strtotime($perfNow->deadline)) < $semaineP))
                                 {
                                      $somme_semaine = $perfNow->pourcentage;
                                      //$var += $perfNow;
                                      array_push($var,$perfNow);
                                      $semaine_count = count($perfNows);
                                      //dd($semaine_count);
                                     array_push($total_semaine, $somme_semaine);

                                 }
                                
                                 if($mois == date('m', strtotime($perfNow->deadline)))
                                 {
                                     
                                      $somme_mois = $perfNow->pourcentage;
                                      
                                      array_push($total_mois, $somme_mois);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             $semaine_passer = array_sum($total_semaine_passe);
                             $semaines = array_sum($total_semaine);
                             $perfoMe = count($var);
                             $perfoPastMe = count($total_semaine_passe);
                             $ma_semaine_total = $perfoMe == 0 ? 0 : $semaines / $perfoMe;
                             $ma_semaine_passe = $perfoPastMe == 0 ? 0 : $semaine_passer / $perfoPastMe;
                             $count_mois = count($total_mois);
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois = $count_mois == 0 ? 0 : (array_sum($total_mois) / $count_mois);
                         
                          //dd($somme_total_mois);
                          
                          // Performance de ma direction / mois / semaine / semaine passer
                          
                             $semaine_passe_dir = (date('d') - 7);
                             $semaine_dir = date('d');
                             $semaine_dirM = (date('d') - 5);
                             $semaine_dirP = (date('d') + 7);
                             $mois_dir = date('m');
                             
                             $somme_mois_dir = 0;
                             $total_mois_dir = array();
                             $total_semaine_dir = array();
                             $total_semaine_passe_dir = array();
                             
                             $agent_dirs = DB::table('agents')->where('direction_id', $agent_mois->direction_id)->get();
                             foreach($agent_dirs as $agent_dir)
                             {
                             $perfNows_dir = DB::table('actions')->where('agent_id', $agent_dir->id)->get();
                             foreach($perfNows_dir as $perfNow_dir)
                             {
                                 if($semaine_passe_dir == date('d', strtotime($perfNow_dir->deadline)))
                                 {
                                     $somme_semaine_passe_dir = $perfNow_dir->pourcentage;
                                      //dd($somme_semaine_passe);
                                    array_push($total_semaine_passe_dir, $somme_semaine_passe_dir);
  
                                 }
                                 
                                 elseif((date('d', strtotime($perfNow_dir->deadline)) > $semaine_dirM) && ( date('d', strtotime($perfNow_dir->deadline)) < $semaine_dirP))
                                 {
                                      $somme_semaine_dir = $perfNow_dir->pourcentage;
                                      //dd($somme_semaine);
                                     array_push($total_semaine_dir, $somme_semaine_dir);
                                     //dd($total_semaine_dir);

                                 }
                                
                                 if($mois_dir == date('m', strtotime($perfNow_dir->deadline)))
                                 {
                                     
                                      $somme_mois_dir = $perfNow_dir->pourcentage;
                                      
                                      array_push($total_mois_dir, $somme_mois_dir);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             }
                             $semaine_passer_dir = array_sum($total_semaine_passe_dir);
                             $semaines_dir = array_sum($total_semaine_dir);
                             $perfo_counts = count($total_semaine_dir);
                            //dd($perfo_counts);
                             $somme_total_semaine_dir = $perfo_counts == 0 ? 0 : $semaines_dir / $perfo_counts;
                             $count_mois_dir = count($total_mois_dir);
                             
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois_dir = $count_mois_dir == 0 ? 0 : (array_sum($total_mois_dir) / $count_mois_dir);

                              $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                             
                          $action_indi_array_dir = array();
                          $action_sum_array_dir = array();
                          $action_count_array_dir = array();
                         
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $action_indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois_dir)
                            ->sum('actions.pourcentage');
                            //dd($action_indicateurs_sum_dir);
                            $action_indicateurs_global_dir = DB::table('actions')
                           ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois_dir)
                
                            ->get();
                            $action_count_dir = count($action_indicateurs_global_dir); 
                            $action_sum_dir = $action_count_dir == 0 ? 0 : $action_indicateurs_sum_dir / $action_count_dir;
                        
                            array_push($action_sum_array_dir,$action_sum_dir);
                            
                           // dd($action_sum_array_dir);
                            
                           
                           
                          }

                         //dd($action_sum_array_dir);
                          
                        return view('action/v2.action_semaine', compact('agent_id', 'pro', 'user', 'projets', 'semaines', 'semaine_passer', 'somme_total_mois','semaines_dir', 'semaine_passer_dir', 'somme_total_mois_dir','action_sum_array_dir', 'actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques','strategiquess',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','ma_semaine_total','sums','ma_semaine_passe','sum_dir','call_array','userAgents','total', 'activites','taches','activi','tache_modeles','modeles','activim','modeles_intervients','sum_array','sum_arrays','sum_array_agent','count_array_agent','somme_total_semaine_dir'));

    }
    
    
    
    public function mesperformances()  
    {
        //
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             //dd(array_sum($sum_array_dir));
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $taches = DB::table('taches')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->orderBy('deadline', 'DESC')->get();
                         $activi = DB::table('activites')->where('statut', '=', 0)->get();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                         $strategiques = DB::table('strategiques')->get();
                         
                         $ag = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         $strategiquess = DB::table('strategiques')->where('direction_id', $ag->direction_id)->get();
                         
                         $results_id = DB::table('strategiques')
                            ->select('strategiques.id')
                            ->get();
                            
                          $indi_array = array();
                          $sum_array = array();
                          $count_array = array();
                          
                          foreach($results_id as $resul)
                          {
                            $indicateurs_sum = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->get();
                            $count = count($indicateurs_global); 
                            array_push($indi_array, $indicateurs_global);
                            
                             //$sum = $indicateurs_sum / $count;
                             $sum = $count == 0 ? 0 : $indicateurs_sum / $count;
                             array_push($sum_array,$sum);
                          }
                          
                           $results_ids = DB::table('strategiques')
                            ->select('id')->where('direction_id', $ag->direction_id)
                            ->get();
                            
                          $indi_arrays = array();
                          $sum_arrays = array();
                          $count_arrays = array();
                          $sums = array();
                          
                          $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          
                          foreach($results_ids as $resuls)
                          {
                          
                          $age = DB::table('agents')->where('direction_id', $agen->direction_id)->get();
                              foreach($age as $ag)
                              {
                                $indicateurs_sums = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->sum('modeles.pourcentage');
                                $indicateurs_globals = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->get();
                                $counts = count($indicateurs_globals); 
                                array_push($indi_arrays, $indicateurs_globals);
                                
                                 //$sum = $indicateurs_sum / $count;
                                 $sums = $counts == 0 ? 0 : $indicateurs_sums / $counts;
                                 array_push($sum_arrays,$sums);
                              }
                          }
                          
                          $call_array = array();
                          $count_array = array();
                          $calpourcen_array = array();
                          $calculs = DB::table('strategiques')->get();
                          $total = 0;
                          foreach($calculs as $calcul)
                          {
                            $calpourcen = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->sum('modeles.pourcentage');
                            array_push($calpourcen_array,$calpourcen);
                            $compter = DB::table('modeles')->where('strategique_id', '=', $calcul->id)
                            ->count();
                             array_push($count_array,$compter);

                            $total = $compter == 0 ? 0 : $calpourcen / $compter ;
                            
                            array_push($call_array,$total);

                          }
                         $ageAction = DB::table('agents')->where('user_id',Auth::user()->id)->first();
                         $agent_id = DB::table('agents')
                            //->select('agents.id')
                             ->where('direction_id', $ageAction->direction_id)
                            ->get();
                            
                         $indi_array_agent = array();
                         $sum_array_agent = array();
                         $count_array_agent = array();
                         $actMoisagent = date('m');
                         foreach ($agent_id as $agentes){
                             
                             $action_count = DB::table('performances')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->count();
                             
                              $action_sum =  DB::table('performances')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->sum('performances.sommes');
                             
                             

                              $sum_agent = $action_count == 0 ? 0 : $action_sum / $action_count;
                             array_push($sum_array_agent,$sum_agent);
                             //dd($sum_array_agent);
                             
                         }
                         
                        
                         $date_today = now();
                         $decembre = date('Y-m');
                         $perfo_decembre_count = array();
                         $perfo_decembre_sum = array();
                         $perfo_decembre_total = array();
                         
                         $agent_mois = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         
                         
                           $action_agents_mois_sum = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)
                             
                             ->sum('actions.pourcentage');
                              $action_agents_mois_countss = DB::table('actions')->select('actions.*')
                             ->where('actions.agent_id', $agent_mois->id)->count();
                             
                             $total_pourcentage = $action_agents_mois_countss == 0 ? 0 : $action_agents_mois_sum / $action_agents_mois_countss;
                           // DB::table('performances')->insert(['agent_id' => $agent_mois->id, 'sommes' => $total_pourcentage,  'created_at' => $date_today, 'updated_at' => $date_today]);
                             
                             //dd($action_agents_mois_sum);
                             
                            //Ma Performance / mois / semaine / semaine passer 
                             
                             $semaine_passe = (date('d') - 7);
                             $semaineM = (date('d')- 7);
                             $semaineP = (date('d') + 7);
                             $mois = date('m');
                             
                             $somme_mois = 0;
                             $total_mois = array();
                             $total_semaine = array();
                             $total_semaine_passe = array();
                             $perfNows = DB::table('actions')->where('agent_id', $agent_mois->id)->get();
                             //dd($perfNows);
                             $var = array();
                             $vari = array();
                             
                             foreach($perfNows as $perfNow)
                             {
                                 if($semaine_passe =strtotime($perfNow->deadline))
                                 {
                                     $somme_semaine_passe = $perfNow->pourcentage;
                                      //dd($somme_semaine_passe);
                                       array_push($vari,$perfNow);
                                      //dd($vari);
                                    array_push($total_semaine_passe, $somme_semaine_passe);
  
                                 }
                                  
                                 if((date('d', strtotime($perfNow->deadline)) > $semaineM) && ( date('d', strtotime($perfNow->deadline)) < $semaineP))
                                 {
                                      $somme_semaine = $perfNow->pourcentage;
                                      //$var += $perfNow;
                                      array_push($var,$perfNow);
                                      $semaine_count = count($perfNows);
                                      //dd($semaine_count);
                                     array_push($total_semaine, $somme_semaine);

                                 }
                                
                                 if($mois == date('m', strtotime($perfNow->deadline)))
                                 {
                                     
                                      $somme_mois = $perfNow->pourcentage;
                                      
                                      array_push($total_mois, $somme_mois);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             $semaine_passer = array_sum($total_semaine_passe);
                             $semaines = array_sum($total_semaine);
                             $perfoMe = count($total_semaine);
                             $perfoPastMe = count($total_semaine_passe);
                             $ma_semaine_total = $perfoMe == 0 ? 0 : $semaines / $perfoMe;
                             $ma_semaine_passe = $perfoPastMe == 0 ? 0 : $semaine_passer / $perfoPastMe;
                             $sommes_semaine = array_sum($total_mois);
                             $count_mois = count($total_mois);
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois = $count_mois == 0 ? 0 : $sommes_semaine / $count_mois;
                         
                          //dd($somme_total_mois);
                          
                          // Performance de ma direction / mois / semaine / semaine passer
                          
                             $semaine_passe_dir = (date('d') - 7);
                             $semaine_dir = date('d');
                             $semaine_dirM = (date('d') - 5);
                             $semaine_dirP = (date('d') + 7);
                             $mois_dir = date('m');
                             
                             $somme_mois_dir = 0;
                             $total_mois_dir = array();
                             $total_semaine_dir = array();
                             $total_semaine_passe_dir = array();

                             $agent_dirs = DB::table('agents')->where('direction_id', $agent_mois->direction_id)->get();
                             foreach($agent_dirs as $agent_dir)
                             {
                             $perfNows_dir = DB::table('actions')->where('agent_id', $agent_dir->id)->get();
                             foreach($perfNows_dir as $perfNow_dir)
                             {
                                 if($semaine_passe_dir = strtotime($perfNow_dir->deadline))
                                 {
                                     $somme_semaine_passe_dir = $perfNow_dir->pourcentage;
                                     //dd($somme_semaine_passe_dir);
                                    array_push($total_semaine_passe_dir, $somme_semaine_passe_dir);

  
                                 }
                                 
                                 if((date('d', strtotime($perfNow_dir->deadline)) > $semaine_dirM) && ( date('d', strtotime($perfNow_dir->deadline)) < $semaine_dirP))
                                 {
                                      $somme_semaine_dir = $perfNow_dir->pourcentage;
                                      //dd($somme_semaine);
                                     array_push($total_semaine_dir, $somme_semaine_dir);
                                     //dd($total_semaine_dir);

                                 }
                                
                                 if($mois_dir == date('m', strtotime($perfNow_dir->deadline)))
                                 {
                                     
                                      $somme_mois_dir = $perfNow_dir->pourcentage;
                                      
                                      array_push($total_mois_dir, $somme_mois_dir);
                                     
                                  
                                     
                                 }
                                 
                                 
                               
                             }
                             
                             }

                             $semaine_passer_dir = array_sum($total_semaine_passe_dir);
                             $semaines_dir = array_sum($total_semaine_dir);
                             $mois_dir = array_sum($total_mois_dir);
                             $perfo_counts = count($total_semaine_dir);
                             $semaines_passerr = count($total_semaine_passe_dir);
                            
                            
                             $somme_total_semaine_dir = $perfo_counts == 0 ? 0 : $semaines_dir / $perfo_counts;
                             $count_mois_dir = count($total_mois_dir);
                             //dd($mois_dir);
                             //$omme = array_sum($total_semaine_passe);
                             
                             //dd(array_sum($total_mois));
                             $somme_total_mois_dir = $count_mois_dir == 0 ? 0 : $mois_dir / $count_mois_dir;
                             $somme_semaine_passer_dir = $semaines_passerr == 0 ? 0 : $semaine_passer_dir / $semaines_passerr;
                             
                            //dd($somme_semaine_passer_dir);
                              $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                             //dd($direction_id);
                          $action_indi_array_dir = array();
                          $action_sum_array_dir = array();
                          $action_count_array_dir = array();
                         
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $action_indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois)
                            ->sum('actions.pourcentage');
                            //dd($action_indicateurs_sum_dir);
                            $action_indicateurs_global_dir = DB::table('actions')
                           ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            
                            ->where('agents.direction_id', '=', $dir->id)
                            ->where(DB::raw("(DATE_FORMAT(actions.deadline,'%m'))"), $mois)
                            //->orWhereNull('agents.direction_id')
                            //->where((DB::raw("DATE_FORMAT(performances.created_at, 'm') as formatted_dob")), $mois_dir)
                            ->get();
                            //dd($action_indicateurs_global_dir);
                            $action_count_dir = count($action_indicateurs_global_dir); 
                            // dd($action_count_dir);
                            $action_sum_dir = $action_count_dir == 0 ? 0 : $action_indicateurs_sum_dir / $action_count_dir;
                        
                            array_push($action_sum_array_dir,$action_sum_dir);
                            
                            //dd($action_sum_array_dir);
                            
                           
                           
                          }

                         //dd($action_sum_array_dir);
                          
                          
                        return view('v2.mesperformances', compact('agent_id','semaines','somme_semaine_passer_dir', 'semaines_passerr','semaine_passer', 'somme_total_mois','semaines_dir', 'semaine_passer_dir', 'somme_total_mois_dir','action_sum_array_dir', 'actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques','strategiquess',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','ma_semaine_total','sums','ma_semaine_passe','sum_dir','call_array','userAgents','total', 'activites','taches','activi','tache_modeles','modeles','activim','modeles_intervients','sum_array','sum_arrays','sum_array_agent','count_array_agent','somme_total_semaine_dir'));

    }
    
   
    
    public function filter(Request $request){
                             
                              
                             
                               $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global_dir = DB::table('modeles')
                            ->select('modeles.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'modeles.res_dir')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         
                         $search_ech = $request->get('search_ech');
                         $taches = DB::table('taches')->where('deadline','like', '%'.$search_ech.'%')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->where('deadline','like', '%'.$search_ech.'%')
                         ->orderBy('deadline', 'DESC')
                         ->get();
                         $activi = DB::table('activites')->get();
                         
                         $search_echm = $request->get('search_echm');
                         $tache_modeles = DB::table('tache_modeles')->where('deadline','like', '%'.$search_echm.'%')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         //$modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $modeles = DB::table('modeles')->where('res_dir',$agen->id)->where('deadline','like', '%'.$search_echm.'%')
                         ->orderBy('deadline', 'DESC')
                         ->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                          $strategiques = DB::table('strategiques')->get(); 
                          
                          $ag = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          $strategiquess = DB::table('strategiques')->where('direction_id', $ag->direction_id)->get();
                         
                          $results_id = DB::table('strategiques')
                            ->select('strategiques.id')
                            ->get();
                            
                          $indi_array = array();
                          $sum_array = array();
                          $count_array = array();
                          $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          $age = DB::table('agents')->where('direction_id', $agen->direction_id)->get();
                          foreach($results_id as $resul)
                          {
                            $indicateurs_sum = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->sum('modeles.pourcentage');
                            $indicateurs_global = DB::table('modeles')
                            ->select('modeles.*')
                            ->where('modeles.strategique_id', '=', $resul->id)
                             ->orWhereNull('modeles.strategique_id')
                            ->get();
                            $count = count($indicateurs_global); 
                            array_push($indi_array, $indicateurs_global);
                            
                             //$sum = $indicateurs_sum / $count;
                             $sum = $count == 0 ? 0 : $indicateurs_sum / $count;
                             array_push($sum_array,$sum);
                          }
                          
                          $results_ids = DB::table('strategiques')
                            ->select('strategiques.id')
                            ->get();
                            
                          $indi_arrays = array();
                          $sum_arrays = array();
                          $count_arrays = array();
                          $sums = array();
                          
                          $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                          //$strategiquess = DB::table('strategiques')->get(); 
                          foreach($results_ids as $resuls)
                          {
                          
                          $age = DB::table('agents')->where('direction_id', $agen->direction_id)->get();
                              foreach($age as $ag)
                              {
                                $indicateurs_sums = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->sum('modeles.pourcentage');
                                $indicateurs_globals = DB::table('modeles')
                                ->select('modeles.*')
                                ->where('modeles.strategique_id', '=', $resuls->id)
                                ->where('modeles.res_dir', '=', $ag->id)
                                 ->orWhereNull('modeles.strategique_id')
                                ->get();
                                $counts = count($indicateurs_globals); 
                                array_push($indi_arrays, $indicateurs_globals);
                                
                                 //$sum = $indicateurs_sum / $count;
                                 $sums = $counts == 0 ? 0 : $indicateurs_sums / $counts;
                                 array_push($sum_arrays,$sums);
                              }
                          }
                        return view('v2.dashboard_dg', compact('actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques','strategiquess',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','sums','sum_dir','userAgents','activites','taches','activi','modeles','tache_modeles','activim','modeles_intervients','sum_array','sum_arrays'));

                          }    
                          
                          
                           /**
                         * Show the form for creating a new resource.
                         *
                         * @return \Illuminate\Http\Response
                         */
                        public function fait(Request $request, $id)
                        {
                            //    
                            $fait = "Tache fait";
                            $tache = Tache::find($id);
                            $tache->statut = 1; //Approved
                            $tache->save();
                            return redirect()->back()->with(['fait' => $fait]); 
                        }
                        
                        
                         /**
                         * Show the form for creating a new resource.
                         *
                         * @return \Illuminate\Http\Response
                         */
                        public function pasfait(Request $request, $id)
                        {
                            //    
                            $pasfait = "Tache pas fait";
                            $tache = Tache::find($id);
                            $tache->statut = 0; //Approved
                            $tache->save();
                            return redirect()->back()->with(['pasfait' => $pasfait]); 
                        }
                        
                        
                         public function modeles_live()  
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('actions.pourcentage');
                            $indicateurs_global_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $modeles = DB::table('modeles')->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $strategiques = DB::table('strategiques')->get();
                        return view('activite/v2.modeles_live', compact('actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','modeles','tache_modeles','activim'));

    }
    
                        public function filterm(Request $request){
                             
                              
                             
                               $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('actions.pourcentage');
                            $indicateurs_global_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         
                         $search_echm = $request->get('search_echm');
                         $tache_modeles = DB::table('tache_modeles')->where('deadline','like', '%'.$search_echm.'%')->get();
                         $modeles = DB::table('modeles')->where('deadline','like', '%'.$search_echm.'%')
                         ->orderBy('deadline', 'DESC')
                         ->get();
                         $activim = DB::table('modeles')->get();
                         
                        $strategiques = DB::table('strategiques')->get();
                        return view('activite/v2.modeles_live', compact('actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','modeles','tache_modeles','activim'));

                          }    
                          
                          
                           /**
                         * Show the form for creating a new resource.
                         *
                         * @return \Illuminate\Http\Response
                         */
                        public function faitm(Request $request, $id)
                        {
                            //    
                            $fait = "Tache fait";
                            $tache = Tache_modele::find($id);
                            $tache->statut = 1; //Approved
                            $tache->save();
                            return redirect()->back()->with(['fait' => $fait]); 
                        }
                        
                        
                         /**
                         * Show the form for creating a new resource.
                         *
                         * @return \Illuminate\Http\Response
                         */
                        public function pasfaitm(Request $request, $id)
                        {
                            //    
                            $pasfait = "Tache pas fait";
                            $tache = Tache_modele::find($id);
                            $tache->statut = 0; //Approved
                            $tache->save();
                            return redirect()->back()->with(['pasfait' => $pasfait]); 
                        }

                        /**
                         * Show the form for creating a new resource.
                         *
                         * @return \Illuminate\Http\Response
                         */
                        public function archiver(Request $request, $id)
                        {
                            //    
                            $archiver = "La tâche a été archivée avec succès !";
                            $tache = Tache_modele::find($id);
                            $tache->statut = 2; //Approved
                            $tache->save();
                            return redirect()->back()->with(['pasfait' => $archiver]); 
                        }
                        
                        
                        public function activites_instance()  
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('actions.pourcentage');
                            $indicateurs_global_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $taches = DB::table('taches')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->orderBy('deadline', 'DESC')->get();
                         $activi = DB::table('activites')->where('statut', '=', 0)->get();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         //$modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                         $strategiques = DB::table('strategiques')->get();
                        return view('activite/v2.activites_instance', compact('actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','activites','taches','activi','tache_modeles','modeles','activim','modeles_intervients'));

    }
    
     public function teamperformance () {
          $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view ('v2.team_performance', compact('headers'));
    }
    public function activites_autre()  
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    ->where('actions.action_respon', '!=' , '')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

                    $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                              'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                               'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                               ->join('agents', 'agents.id', 'actions.agent_id')
                               ->where('agents.id','=', $user->id)
                               ->get();          
                    }
                    $date1 = date('Y/m/d');
                    $user_actions = Agent::where('user_id', Auth::user()->id)->get();
                     foreach($user_actions as $user)
                    {
                    
            
                        $action_directions = DB::table('directions')
                      ->join('agents', 'agents.direction_id', 'directions.id')
                      ->join('actions', 'actions.agent_id', 'agents.id')
                      ->select('actions.id',
                              'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                              'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                              'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                              'directions.nom_direction','directions.id as ID')
                              ->where('agents.direction_id' ,'=', $user->direction_id)
                              ->orWhere('actions.agent_id','=', $user->id)
                              ->orderBy('actions.pourcentage', 'ASC')
                              ->get();
                        $sum_directions = DB::table('directions')
                          ->join('agents', 'agents.direction_id', 'directions.id')
                          ->join('actions', 'actions.agent_id', 'agents.id')
                          ->select('actions.id',
                                  'actions.libelle', 'actions.responsable','actions.deadline',
                                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                                  'directions.nom_direction','directions.id as idDI')
                                  ->where('agents.direction_id' ,'=', $user->direction_id)
                                  ->orWhere('actions.agent_id','=', $user->id)
                                   ->orderBY('actions.risque','ASC')
                                  ->sum('actions.pourcentage'); 
                        }   
                        $annonces = Annonce::all();   
                        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                                        'suivi_indicateurs.indicateur_id',
                                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                                         ->get(); 
                        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.updated_at','actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                  
                                   ->get();  
                        
                         $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                                  'actions.agent_id','actions.reunion_id','actions.raison','actions.updated_at', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                                   ->join('agents', 'agents.id', 'actions.agent_id')
                                    ->sum('actions.pourcentage');  
                
                                        $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
                                        foreach($sum_actionss as $user)
                                       {
                                       $sum_directionss = DB::table('directions')
                                         ->join('agents', 'agents.direction_id', 'directions.id')
                                         ->join('actions', 'actions.agent_id', 'agents.id')
                                         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                                         ->select('actions.id',
                                 'actions.libelle', 'actions.responsable','actions.deadline','actions.bakup',
                                 'actions.risque','actions.raison','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                                 'agents.prenom', 'agents.nom','actions.updated_at', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                                 'directions.nom_direction','directions.id as ID')
                                 ->where('agents.direction_id' ,'=', $user->direction_id)
                                 ->orderBY('actions.risque','ASC')
                                 ->sum('actions.pourcentage');
                                 //->get();
                       }   
        //dd($actions);
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                            
                          $indi_array_dir = array();
                          $sum_array_dir = array();
                          $count_array_dir = array();
                          
                          foreach($direction_id as $dir)
                          {
                           
                            
                            $indicateurs_sum_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                            ->sum('actions.pourcentage');
                            $indicateurs_global_dir = DB::table('actions')
                            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
                            ->join('agents', 'agents.id','=', 'actions.agent_id')
                            ->where('agents.direction_id', '=', $dir->id)
                            ->orWhereNull('agents.direction_id')
                
                            ->get();
                            
                            $count_dir = count($indicateurs_global_dir); 
                            array_push($indi_array_dir, $indicateurs_global_dir);
                            
                              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
                             array_push($sum_array_dir,$sum_dir);
                             
                             $sum_total_dir = array_sum($sum_array_dir);
                             $counts_dir = count($sum_array_dir);
                
                          }
                         $taux_exe = $sum_total_dir / $counts_dir;
                         
                         $count_actions = count($actions);
                         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
                         
                         $count_actions_dir = count($action_directions);
                         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
                         
                         $userAgents = User::all();
                         $taches = DB::table('taches')->get();
                         $activites = DB::table('activites')->where('statut', '=', 0)->orderBy('deadline', 'DESC')->get();
                         $activi = DB::table('activites')->where('statut', '=', 0)->get();
                         $tache_modeles = DB::table('tache_modeles')->get();
                         $agen = DB::table('agents')->where('user_id', Auth::user()->id)->first();
                         //$modeles = DB::table('modeles')->where('res_dir',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $modeles = DB::table('modeles')->where('backup',$agen->id)->orderBy('deadline', 'DESC')->get();
                         $activim = DB::table('modeles')->get();
                         $modeles_intervients = DB::table('modeles')
                                                ->select('modeles.*','tache_modeles.libelle as libel','tache_modeles.res_dir as res')
                                                ->join('tache_modeles', 'tache_modeles.modele_id', 'modeles.id')
                                                ->orderBy('deadline', 'DESC')->get();
                         $strategiques = DB::table('strategiques')->get();
                        return view('activite/v2.activites_autre', compact('actions','action_escalades','my_agents','users','action_directions','headers',
                        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users','strategiques',
                        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
                        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','activites','taches','activi','tache_modeles','modeles','activim','modeles_intervients'));

    }

    public function cumul_retard($id_direction){
        $agents = DB::table('agents')->where('direction_id', $id_direction)->get(); 
        $direction = Direction::findOrFail($id_direction);
        
        return view ('v2.cumul_retard', compact('agents', 'direction'));
    }
    
    public function evaluation()  
    {
        //
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        
                   
                         $directions = DB::table('directions')->get();
                         $agents = DB::table('agents')->get();
                         $users = User::where('id', Auth::user()->id)->get();
                         $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
                         
                            $direction_id = DB::table('directions')
                            ->select('directions.id')
                            ->get();
                         
                         $ageAction = DB::table('agents')->where('user_id',Auth::user()->id)->first();
                         $agent_id = DB::table('agents')->orderBy('prenom', 'ASC')->get();
                            
                         $indi_array_agent = array();
                         $sum_array_agent = array();
                         $count_array_agent = array();
                         $actMoisagent = date('m');
                         foreach ($agent_id as $agentes){
                             
                             $action_count = DB::table('performances')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->count();
                             
                              $action_sum =  DB::table('performances')
                            ->join('agents', 'agents.id','=', 'performances.agent_id')
                            ->where('performances.agent_id', '=', $agentes->id)
                             ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                             ->sum('performances.sommes');
                             
                             

                              $sum_agent = $action_count == 0 ? 0 : $action_sum / $action_count;
                             array_push($sum_array_agent,$sum_agent);
                             //dd($sum_array_agent);
                             
                         }
                        return view('v2.evaluation', compact('headers','users','directions','my_agents','direction_id','ageAction','agent_id','indi_array_agent','sum_array_agent',
                        'count_array_agent','actMoisagent','action_count','action_sum','sum_agent'));

    }
    public function agent_evaluation($id)  
    {
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        $agents = Agent::find($id);
        $actMoisagent = date('m');
        $pourcentage = DB::table('performances')
                        ->join('agents', 'agents.id','=', 'performances.agent_id')
                        ->where('performances.agent_id', '=', $agents->id)
                        ->where(DB::raw("(DATE_FORMAT(performances.created_at,'%m'))"), $actMoisagent)
                        ->select('sommes')
                        ->get();
        return view ('v2.agent_evaluation',compact('headers','users','agents','pourcentage'));
    }
    

}