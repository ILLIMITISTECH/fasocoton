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
use App\Prospect;
use App\Mail\SendMail;
use App\Mail\SendMailRefuser;

class UserController extends Controller
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
            $message = 'Email ou Mot de passe incorrect';

            $data = $request->input();
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'admin'])){

                //echo "succes"; die;
                return redirect('/admin/dashboard')->with(['admin' => $admin]);
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
                return redirect('/admin/dashboard/user')->with(['utilisateur' => $utilisateur]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'responsable'])){
                return redirect('/admin/dashboard/responsable')->with(['responsable' => $responsable]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'directeur'])){
                return redirect('/v3/admin/dashboard')->with(['directeur' => $directeur]);;
            }

            elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'nom_role'=>'Rapporteur'])){
                return redirect('/admin/dashboard/rapporteur')->with(['rapporteur' => $rapporteur]);;
            }
             
            else{
                //echo "failed"; die;

                return redirect('/connexion')->with(['message' => $message]);  
            }
        }
        return view('admin/connexion.login');
    }

public function ajouter_users()
     {
 
      return view('MobiagriDashboard/ajouter_users');
 
     }

public function ajouter_users_store(Request $request)
     {
 
             $message = "Ajouté avec succès";

             $user = new User;
             $user->prenom = $request->get('prenom'); 
             $user->nom = $request->get('nom'); 
             $user->email = $request->get('email'); 
             $user->nom_role = $request->get('nom_role'); 
             $user->password = Hash::make(1234);
             $user->save();
             
     return back()->with(['message' => $message]);
 
     }


    public function dashboard()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        $suivi_actions = DB::table('agents')
                ->join('actions', 'actions.agent_id', 'agents.id')
                ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                        'actions.libelle','actions.raison', 'actions.deadline as date',
                        'actions.risque', 'actions.visibilite','actions.responsable', 'actions.id as Id', 
                        'agents.prenom', 'agents.nom', 'agents.photo', 'agents.date_naiss')->get(); 
        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                        'suivi_indicateurs.indicateur_id',
                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id')
                         ->get(); 
        $annonces = Annonce::all();  
        $users = User::where('id', Auth::user()->id)->get();
        return view('v2.dashboard_admin', compact('suivi_actions','users','suivi_indicateurs','annonces'));
    }

    public function banSuivi(Request $request){  
        //return $request->all();
        $visibilite = $request->visibilite;   
        $suiviID = $request->suiviID;
  
        $update_visibilite = DB::table('actions')
        ->where('id', $suiviID)
        ->update([
          'visibilite' => $visibilite
        ]);
        if($update_visibilite){
          echo "visibilite updated successfully";
        }
      }   

    public function dashboard_rapporteur()    
    {
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $bakup_users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->pluck('full_name','id');
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais',
                    'actions.pourcentage', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais',
                    'actions.pourcentage', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite', 'actions.bakup',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
        }
        $date1 = date('Y/m/d');
        $date2 = date('Y/m/d');
        $nbrJour = strtotime($date1) - strtotime($date2); 

        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $action_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
          $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');         
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.raison','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
         $agents = DB::table('agents')
            ->where('agents.direction_id', $user->direction_id)
            ->get();
       }   
       $recherches = Agent::all();
        $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.bakup', 'actions.libelle', 'actions.note',
                        'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais',
                         'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                         ->join('agents', 'agents.id', 'actions.agent_id')
                         ->get();   
        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                        'suivi_indicateurs.indicateur_id',
                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id', 'suivi_actions')
                         ->get(); 
        $decissions = DB::table('decissions')->select('decissions.id', 'decissions.libelle',
                        'decissions.agent_id','decissions.reunion_id',  'decissions.delais',
                        'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id',
                        'reunions.date','reunions.nombre_partici','reunions.heure_debut','reunions.heure_fin')
                        ->join('agents', 'agents.id', 'decissions.agent_id')
                         ->join('reunions', 'reunions.id', 'decissions.reunion_id')
                        ->get();
        $annonces = Annonce::all();  
        $reunions = Reunion::all(); 
        $agent_actions = Action::all();
        
         $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
        $users = User::where('id', Auth::user()->id)->get();
        return view('v2.dashboard_rap', compact('suivi_indicateurs','users','superieur1s','superieurs','annonces','agent_actions','reunions','decissions','suivi_actions',
        'actions','action_directions', 'sum_directions','headers','action_bakups','action_respons','action_users','date1','action_directionss','sum_directionss','sum_actions','agents','recherches'));
    }

     public function dashboard_user()  
    {
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $bakup_users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->pluck('full_name','id');
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){

                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'actions.updated_at','agents.photo','agents.niveau_hieracie', 'agents.niveau_hieracie','agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais',
                    'actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','actions.updated_at', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 
                    
                     
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite', 'actions.bakup',  'actions.risque', 'actions.delais','actions.updated_at','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        }
        $date1 = date('Y/m/d');
        $date2 = date('Y/m/d');
        $nbrJour = strtotime($date1) - strtotime($date2); 

        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $action_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','DESC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
          $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');         
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','actions.updated_at','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBy('actions.pourcentage', 'ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline as date','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
         $agents = DB::table('agents')
            ->where('agents.direction_id', $user->direction_id)
            
            ->get();
       }   
        $annonces = Annonce::all();   
       
        //dd($actions);
        
         $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.updated_at','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
        
         
        $users = User::where('id', Auth::user()->id)->get();
        $my_agentes = DB::table('agents')->get();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
        
        $count_actions = count($actions);
        $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
         
        $count_actions_dir = count($action_directions);
        $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
        return view('v2.dashboard_user', compact('actions','sum','sum_dir','users','my_agents','my_agentes','action_directions','superieur1s','superieurs','headers','action_respons','action_bakups', 'sum_directions','annonces', 'action_users','date1','action_directionss','sum_directionss','sum_actions','agents'));
    }
    public function dashboard_responsable()  
    {
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $bakup_users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->pluck('full_name','id');
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
         

                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note','actions.updated_at',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.niveau_hieracie', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais',
                    'actions.pourcentage','actions.action_respon', 'actions.note','actions.created_at', 'actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie','agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', '')
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup','actions.action_respon', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie', 'directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    //->orWhere('actions.raison','<>', 0)
                    ->where('actions.action_respon', '!=' , '')
                    //->orWhereNull('actions.action_respon')
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 
                   
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite', 'actions.bakup',  'actions.risque', 'actions.delais','actions.updated_at','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
                   
           
        }
        $date1 = date('Y/m/d');
        $date2 = date('Y/m/d');
        $nbrJour = strtotime($date1) - strtotime($date2); 

        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $action_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
          $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');         
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','actions.updated_at','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.niveau_hieracie', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline as date','actions.updated_at','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
         $agents = DB::table('agents')
            ->where('agents.direction_id', $user->direction_id)
            
            ->get();
       }   
        $annonces = Annonce::all();   
       
        //dd($actions);
        
         $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.updated_at', 'actions.note','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
        $my_agentes = DB::table('agents')->get();
        $users = User::where('id', Auth::user()->id)->get();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
        $count_actions = count($actions);
        $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
         
        $count_actions_dir = count($action_directions);
        $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
        return view('v2.dashboard_responsable', compact('actions','sum','sum_dir','action_escalades','users','my_agents','my_agentes','action_directions','superieur1s','superieurs','headers','action_respons','action_bakups', 'sum_directions','annonces', 'action_users','date1','action_directionss','sum_directionss','sum_actions','agents'));
    }


  
    public function dashboard_directeur()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->first();
        //foreach($users as $user){
        $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
             $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    //dd($action_respons);
                    $action_mois = date('m');
                    $action_semaineM7 = (date('d') -7);
                    $action_semaineP7 = (date('d') +7);
                    //$action_responsdff = array();
                    $action_respons = array();
                    //dd($action_semaineP7);
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                   // ->where('actions.bakup','=', $users->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                      
                        
                        if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        {
                            array_push($action_respons, $action_respf);
                            
                        }
                    }
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    //->orWhere('actions.raison','<>', 0)
                    ->where('actions.action_respon', '!=' , '')
                    //->orWhereNull('actions.action_respon')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

        
        
        $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();          
        //}
        $date1 = date('Y/m/d');
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        

            $action_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as ID')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  //->orderBY('actions.risque','ASC')
                  ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
            $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
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
                    // >orderBY('actions.risque','ASC')
                    ->sum('actions.pourcentage');  
                   //->get();
                        
                                  
                        
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
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')
            ->sum('actions.pourcentage');
            $indicateurs_global_dir = DB::table('actions')
            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')

            ->get();
            
            $count_dir = count($indicateurs_global_dir); 
            array_push($indi_array_dir, $indicateurs_global_dir);
            
             //$sum_dir = $indicateurs_sum_dir / $count_dir;
             
              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
             array_push($sum_array_dir,$sum_dir);
             
             //array_sum (array, $sum_array) : int|float;
             
             $sum_total_dir = array_sum($sum_array_dir);
             $counts_dir = count($sum_array_dir);

          }
         $taux_exe = $sum_total_dir / $counts_dir;
         
         $count_actions = count($actions);
         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
         
         $count_actions_dir = count($action_directions);
         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
         
         $userAgents = User::all();

        return view('v2.dashboard_dg', compact('actions','action_escalades','my_agents','users','action_directions','headers',
        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users',
        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
        'sum_array_dir','taux_exe','sum','sum_dir','userAgents'));

    }

    public function save_action(Request $request)
    {
        //
        $message = 'Action archivée avec succès';
            $suivi_action = new Suivi_action;
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save();
           return redirect()->back()->with(['message' => $message]);
  

    }

    public function save_action_responsable(Request $request)
    {
        //
        $message = 'Action archivée avec succès';
            $suivi_action = new Suivi_action;
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save();
           return redirect()->back()->with(['message' => $message]);
  

    }
    
    public function save_action_d(Request $request)
    {
        //
        $message = 'Action archivée avec succès';
            $suivi_action = new Suivi_action;
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save();
           return redirect()->back()->with(['message' => $message]);
  

    }
    
    public function save_action_r(Request $request)
    {
        //
        $message = 'Action archivée avec succès';
            $suivi_action = new Suivi_action;
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save();
           return redirect()->back()->with(['message' => $message]);
  

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_fresponsable($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.user_fresponsable_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_fresponsable(Request $request, $id)
    {
        //

        
        $messageResponsable = "Action mise à jour avec succès !";

            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/responsable')->with(['messageResponsable' => $messageResponsable]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_futilisateur($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.user_futilisateur_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_futilisateur(Request $request, $id)
    {
        //

        
        $messageUtilisateur = "Action mise à jour avec succès !";

            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/user')->with(['messageUtilisateur' => $messageUtilisateur]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_fdirecteur($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.user_fdirecteur_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_fdirecteur(Request $request, $id)
    {
        //

        
        $messageDirecteur = "Action mise à jour avec succès !";

            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais');
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage');
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/v3/admin/dashboard')->with(['messageDirecteur' => $messageDirecteur]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_frapporteur($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.user_frapporteur_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_frapporteur(Request $request, $id)
    {
        //

        
        $messageRapporteur = "Action mise à jour avec succès !";

            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/rapporteur')->with(['messageRapporteur' => $messageRapporteur]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.user_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
       /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/user')->with(['message' => $message]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_responsable($id)
    {
        //


        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.responsable_editer', compact('actions', 'action','agents','reunions','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_responsable(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
       /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/responsable')->with(['message' => $message]);
    }
    
     public function direction($id)
    {
        //
        $direction = Direction::find($id);

        $users = Agent::where('user_id', Auth::user()->id)->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline as date', 'actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque','actions.raison', 'actions.visibilite', 'actions.updated_at', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    //->where('actions.id','=', $action->id)
                    //->orderBY('actions.risque','ASC')
                    ->orderBY('actions.pourcentage','ASC')
                    ->get();
                   
                  
           
        }
        
        $directions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.direction_id', $direction->id)
                   ->orderBy('actions.pourcentage', 'ASC')
                   ->get();
        $date1 = date('Y/m/d');   
        
        $sum_suivi_actions =  DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.direction_id', $direction->id)
                    ->sum('actions.pourcentage'); 

        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                    ->where('user_id', Auth::user()->id)
                    ->join('directions', 'directions.id', 'agents.direction_id')
                    ->paginate(1);
        
        return view('direction/v2.dg_voir',compact('direction','headers','actions','directions','date1','sum_suivi_actions'));
    }
    
     public function agent($id)
    {
        //
        $agent = Agent::find($id);
        $agente = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->orderBy('prenom')->find($id);

        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    /*$actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->where('actions.id','=', $action->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('actions.pourcentage','ASC')
                    ->get();*/
                   
                  
           
        }
        
        $agents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id','agents.niveau_hieracie', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                   ->orWhere('actions.bakup','=', $agente->full_name)
                   ->orderBy('actions.pourcentage', 'ASC')
                   ->get();
                   
                   $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.niveau_hieracie', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.niveau_hieracie', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $agente->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
        
        $date1 = date('Y/m/d');   
        
        $sum_suivi_actions =  DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                   ->orWhere('actions.bakup','=', $agente->full_name)
                    ->sum('actions.pourcentage'); 
        
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                    ->where('user_id', Auth::user()->id)
                    ->join('directions', 'directions.id', 'agents.direction_id')
                    ->paginate(1);

        return view('agent/v2.dg_voir',compact('agent','agents','headers','action_respons','action_bakups','date1','sum_suivi_actions'));
    }


 public function user_agent($id)
    {
        //
        $agent_user = Agent::find($id);
        $agente = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->orderBy('prenom')->find($id);

        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline as date', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable','actions.raison', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom','agents.niveau_hieracie', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('actions.pourcentage','ASC')
                    ->get();
                        /*$agents = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->select(DB::raw('CONCAT(prenom, " ", nom) AS full_name'),'actions.pourcentage','actions.created_at', 'actions.note','actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id', $agent->id)
                    ->orWhere('actions.bakup','=', $agent->full_name)
                    ->orderBY('prenom')
                    ->get();*/
                   
                  
           
        }
        
    
        $agents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom','agents.niveau_hieracie', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent_user->id)
                    ->orWhere('actions.bakup','=', $agente->full_name)
                   ->get();
                   
                   $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie','agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $agente->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
        $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent_user->id)
                     ->orWhere('actions.bakup','=', $agente->full_name)
                   ->sum('actions.pourcentage');           
        $date1 = date('Y/m/d');   
        
        /*$sum_suivi_actions =  DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   ->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                    ->sum('actions.pourcentage'); */
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                    ->where('user_id', Auth::user()->id)
                    ->join('directions', 'directions.id', 'agents.direction_id')
                    ->paginate(1); 
        $my_agentes = DB::table('agents')->get();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();

        return view('agent/v2.utilisateur_voir',compact('agent_user','actions','my_agentes','my_agents','headers','agents','action_respons','action_bakups','date1','sum_suivi_actions'));
    }


    public function responsable_agent($id)
    {
        //
        $agent = Agent::find($id);
        $agente = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->orderBy('prenom')->find($id);

        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline as date', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable','actions.raison', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id','agents.niveau_hieracie', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('actions.pourcentage','ASC')
                    ->get();
                        /*$agents = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->select(DB::raw('CONCAT(prenom, " ", nom) AS full_name'),'actions.pourcentage','actions.created_at', 'actions.note','actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id', $agent->id)
                    ->orWhere('actions.bakup','=', $agent->full_name)
                    ->orderBY('prenom')
                    ->get();*/
                   
                  
           
        }
        
    
        $agents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom','agents.niveau_hieracie', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                    ->orWhere('actions.bakup','=', $agente->full_name)
                   ->get();
                   
                   $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at','actions.updated_at',
                    'agents.prenom', 'agents.nom','agents.niveau_hieracie', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.updated_at',
                    'agents.prenom', 'agents.nom', 'agents.niveau_hieracie','agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $agente->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
        $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                     ->orWhere('actions.bakup','=', $agente->full_name)
                   ->sum('actions.pourcentage');           
        $date1 = date('Y/m/d');   
        
        /*$sum_suivi_actions =  DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   ->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                    ->sum('actions.pourcentage'); */
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                    ->where('user_id', Auth::user()->id)
                    ->join('directions', 'directions.id', 'agents.direction_id')
                    ->paginate(1); 
         $my_agentes = DB::table('agents')->get();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
        return view('agent/v2.responsable_voir',compact('agent','actions','my_agents','my_agentes','headers','agents','action_respons','action_bakups','date1','sum_suivi_actions'));
    }
    
    public function user_agent_rap($id)
    {
        //
        $agent = Agent::find($id);
        $agente = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->orderBy('prenom')->find($id);

        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline as date', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable','actions.raison', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('actions.pourcentage','ASC')
                    ->get();
                        /*$agents = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->select(DB::raw('CONCAT(prenom, " ", nom) AS full_name'),'actions.pourcentage','actions.created_at', 'actions.note','actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline', 'actions.bakup', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id', $agent->id)
                    ->orWhere('actions.bakup','=', $agent->full_name)
                    ->orderBY('prenom')
                    ->get();*/
                   
                  
           
        }
        
    
        $agents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                    ->orWhere('actions.bakup','=', $agente->full_name)
                   ->get();
                   $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $agente->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
        $sum_suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                     ->orWhere('actions.bakup','=', $agente->full_name)
                   ->sum('actions.pourcentage');           
        $date1 = date('Y/m/d');   
        
        /*$sum_suivi_actions =  DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.direction_id', 'agents.photo', 'agents.direction_id', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   ->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('actions.agent_id', $agent->id)
                    ->sum('actions.pourcentage'); */
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                    ->where('user_id', Auth::user()->id)
                    ->join('directions', 'directions.id', 'agents.direction_id')
                    ->paginate(1);

        return view('agent/v2.rap_voir',compact('agent','actions','headers','agents','action_respons','action_bakups','date1','sum_suivi_actions'));
    }
    
    public function user_reunion()
    {
        $reunions = DB::table('reunions')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('reunion/v2.utilisateur_reunion', compact('reunions','headers'));
     
    }

    public function responsable_reunion()
    {
        $reunions = DB::table('reunions')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('reunion/v2.responsable_reunion', compact('reunions','headers'));
     
    }
    
    public function user_action()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                     $pro = DB::table('projets')->get();
                     
                     
                     $projets = DB::table('agent_projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle',
                    'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id',
                    'agent_projets.libelle_action', 'agent_projets.projet_id', 'agent_projets.backup', 'agent_projets.priorites', 'agent_projets.deadlines', 'agent_projets.pourcentages'
                    )
                     ->join('projets', 'projets.id', 'agent_projets.projet_id')
                    ->join('agents', 'agents.id', 'projets.responsable')
                    
                    ->where('agent_projets.agent_id','=', $user->id)
                    // ->orWhere('projets.bakup','=', $user->full_name)
                     ->get();
                      $projet = DB::table('projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle', 'projets.note',
                    'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id'
                    )
                    ->join('agent_projets', 'agent_projets.projet_id', 'projets.id')
                    ->join('agents', 'agents.id', 'projets.responsable')
                    
                    ->where('agent_projets.agent_id','=', $user->id)
                    ->first();
                     
                   $action_mois = date('m');
                    $action_semaineM7 = (date('d') -7);
                    $action_semaineP7 = (date('d') +7);
                    //$action_responsdff = array();
                    $action_respons = array();
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
                    
                    
                    foreach($action_responsf as $action_respf)
                    {
                      
                        
                        //if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            
                        }
                    }
                    //dd($action_respons);
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        }
        $late = count($action_respons);
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.utilisateur_action', compact('actions', 'projets', 'projet', 'pro', 'user', 'action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }
    
    // filter toutes les actions par directions 
    
        public function filter_action(Request $request)
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    // $search_a = $request->get('search_a');
                    // $agent_actions = Action::all();
                    // $recherches = Agent::all();
        
                    // $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.bakup', 'actions.libelle', 'actions.note',
                    //     'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais',
                    //      'agents.prenom', 'agents.nom', 'agents.photo','agents.direction_id', 'agents.id as Id')
                    //      ->join('agents', 'agents.id', 'actions.agent_id')
                    //       ->where('agents.prenom', 'like', '%'.$search_a.'%')
                    //       ->orderBy('actions.id')
                    //      ->get();
               
               
                     $pro = DB::table('projets')->get();
                     
                     
                     $projets = DB::table('agent_projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle',
                    'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id',
                    'agent_projets.libelle_action', 'agent_projets.projet_id', 'agent_projets.backup', 'agent_projets.priorites', 'agent_projets.deadlines', 'agent_projets.pourcentages'
                    )
                     ->join('projets', 'projets.id', 'agent_projets.projet_id')
                    ->join('agents', 'agents.id', 'projets.responsable')
                    
                    ->where('agent_projets.agent_id','=', $user->id)
                    // ->orWhere('projets.bakup','=', $user->full_name)
                     ->get();
                      $projet = DB::table('projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle', 'projets.note',
                    'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id'
                    )
                    ->join('agent_projets', 'agent_projets.projet_id', 'projets.id')
                    ->join('agents', 'agents.id', 'projets.responsable')
                    
                    ->where('agent_projets.agent_id','=', $user->id)
                    ->first();
                     
                    $search_a = $request->get('search_a');
                    $agent_actions = Action::all();
                    $recherches = Agent::all();
                    $action_mois = date('m');
                    $action_semaineM7 = (date('d') -7);
                    $action_semaineP7 = (date('d') +7);
                    //$action_responsdff = array();
                    $action_respons = array();
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
                    ->where('actions.pourcentage','like', '%'.$search_a.'%')
                    ->where('actions.pourcentage','!=', 100)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                      
                        
                        //if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            
                        }
                    }
                    //dd($action_respons);
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.utilisateur_action', compact('actions', 'agent_actions', 'recherches', 'search_a', 'projets', 'projet', 'pro', 'user', 'action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }
    
    
    public function user_action_mois()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    
                    
                    $pro = DB::table('projets')->get();
                    
                     
                    $action_mois = date('m');
                    $action_respons = array();
                    //dd($action_mois);
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison', 'actions.projet_id', 'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                        if($action_mois == date('m', strtotime($action_respf->deadline)))
                        {
                            array_push($action_respons, $action_respf);
                            
                            //dd($action_respons);
                        }
                    }
                    $action_mois = date('m');
                    $projet_respons = array();
                    //dd($action_mois);
                     $projets = DB::table('agent_projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle',
                    'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id',
                    'agent_projets.libelle_action', 'agent_projets.projet_id', 'agent_projets.priorites', 'agent_projets.backup', 'agent_projets.deadlines', 'agent_projets.pourcentages','directions.nom_direction'
                    )
                    ->join('projets', 'projets.id', 'agent_projets.projet_id')
                    ->join('agents', 'agents.id', 'projets.responsable')
                    
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('agent_projets.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('agent_projets.pourcentages', 'ASC')
                    ->get();
                    
                    foreach($projets as $projet)
                    {
                        if($action_mois == date('m', strtotime($projet->deadlines)))
                        {
                            array_push($projet_respons, $projet);
                            
                            //dd($projet_respons);
                        }
                    }
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.utilisateur_action_mois', compact('actions', 'pro', 'user', 'projets', 'projet_respons', 'action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }

public function user_toute_action()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                        //  liste des projets
                        
                        $pro = DB::table('projets')->get();
                       
                        
                        //  $projet = DB::table('projets')->select('projets.id', 'projets.deadline', 'projets.responsable', 'projets.libelle', 'projets.note',
                        // 'projets.priorite','projets.pourcentage', 'projets.note', 'projets.visibilite', 'projets.created_at',
                        // 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agent_projets.agent_id', 'agent_projets.projet_id'
                        // )
                        // ->join('agent_projets', 'agent_projets.projet_id', 'projets.id')
                        // ->join('agents', 'agents.id', 'projets.responsable')
                        
                        // ->where('agent_projets.agent_id','=', $user->id)
                        // ->first();
                    //  dd($projets);
                   
                    
                     
                     $action_projet_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.projet_id', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                     
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.projet_id', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.created_at', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        }
        //dd($action_respons);
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.utilisateu_action', compact('actions','action_projet_respons', 'user', 'pro', 'action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }
    
    
    public function action_mateam_semaine()
    {
        
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
       // foreach($users as $user){
         //dd($user);
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                   
                    
                //     $action_mois = date('m');
                //     $action_semaineM7 = (date('d') -7);
                //     $action_semaineP7 = (date('d') +7);
                //     $action_responsdff = array();
                //     $projet_respons = array();
                //     //dd($action_semaineP7);
                //     $agent_ma_teams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                //   foreach($agent_ma_teams as $agent_ma_team)
                //     {
                //     $projet_responsf = DB::table('actions')->select('actions.id', 'actions.deadline','actions.projet_id', 'actions.responsable', 
                //     'actions.libelle', 'actions.note',
                //     'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                //     'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                //     'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction', 'projets.id'
                //     )
                //     ->join('agents', 'agents.id', 'actions.agent_id')
                //     ->join('projets', 'projets.id', 'actions.projet_id')
                //     ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                //     ->where('actions.agent_id','=', $agent_ma_team->id)
                //     ->orWhere('actions.projet_id','=', 'projets.id')
                //     ->orderBy('actions.pourcentage', 'ASC')
                //     ->get();
                    
                //     foreach($projet_responsf as $projet_res)
                //     {
                //       if(($action_semaineP7 >= date('d', strtotime($projet_res->deadline))) && ($action_semaineM7 <= date('d', strtotime($projet_res->deadline))) && ($action_mois == date('m', strtotime($projet_res->deadline))))
                //         {
                //         array_push($projet_respons, $projet_res);
                            
                //         }
                //     }
                    
                //   } 
                   
                   
                    
                    $action_mois = date('m');
                    $action_semaineM7 = (date('d') -7);
                    $action_semaineP7 = (date('d') +7);
                    //$action_responsdff = array();
                    $action_respons = array();
                    //dd($action_semaineP7);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                      
                        
                        if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))))
                        {
                            array_push($action_respons, $action_respf);
                            
                        }
                    }
                    
                   } 
                   
                   
                    //dd($action_respons);
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        //}
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.action_mateam_semaine', compact('actions', 'user', 'action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    

    }
    
    public function action_mateam()
    {
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        //foreach($users as $user){
        $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $projet_respons = array();
                    //dd($action_semaineP7);
                    $agent_ma_teams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_ma_teams as $agent_ma_team)
                    {
                    $projet_responsf = DB::table('actions')->select('actions.id', 'actions.deadline','actions.projet_id', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction', 'projets.id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('projets', 'projets.id', 'actions.projet_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_ma_team->id)
                    ->orWhere('actions.projet_id','=', 'projets.id')
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($projet_responsf as $projet_res)
                    {
                       
                        array_push($projet_respons, $projet_res);
                            
                        
                    }
                    
                   } 
                   
                    $action_mois = date('m');
                    $action_respons = array();
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    
                    foreach($action_responsf as $action_respf)
                    {
                        
                            array_push($action_respons, $action_respf);
                            
                            //dd($action_respons);
                        
                    }
                    
                    }
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        //}
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.action_mateam_mois', compact('actions','action_users', 'projet_respons' ,'headers','sum_actions','action_respons','action_bakups','date1'));
    

    }
    
    public function filtrer_action_mateam(Request $request)
    {
        $search = $request->get('search');
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        //foreach($users as $user){
        $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $projet_respons = array();
                    //dd($action_semaineP7);
                    $agent_ma_teams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_ma_teams as $agent_ma_team)
                    {
                    $projet_responsf = DB::table('actions')->select('actions.id', 'actions.deadline','actions.projet_id', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction', 'projets.id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('projets', 'projets.id', 'actions.projet_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_ma_team->id)
                    ->orWhere('actions.projet_id','=', 'projets.id')
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($projet_responsf as $projet_res)
                    {
                       
                        array_push($projet_respons, $projet_res);
                            
                        
                    }
                    
                   } 
                   
                    $action_mois = date('m');
                    $action_respons = array();
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    ->where('actions.agent_id','like', '%'.$search.'%')
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    
                    foreach($action_responsf as $action_respf)
                    {
                        
                            array_push($action_respons, $action_respf);
                            
                            //dd($action_respons);
                        
                    }
                    
                    }
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        //}
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.action_mateam_mois', compact('actions','action_users', 'projet_respons' ,'headers','sum_actions','action_respons','action_bakups','date1'));
    

    }
    
    
    public function action_retard_mateam()
    {
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
       // foreach($users as $user){
         
                     $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                     $action_mois = date('m');
                    $projet_respons = array();
                    //dd($action_semaineP7);
                    $agent_ma_teams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_ma_teams as $agent_ma_team)
                    {
                    $projet_responsf = DB::table('actions')->select('actions.id', 'actions.deadline','actions.projet_id', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction', 'projets.id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('projets', 'projets.id', 'actions.projet_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_ma_team->id)
                    ->orWhere('actions.projet_id','=', 'projets.id')
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($projet_responsf as $projet_res)
                    {
                        if(($projet_res->deadline < now()) && $projet_res->pourcentage < 100)
                        {
                        array_push($projet_respons, $projet_res);
                            
                        }
                    }
                    
                   } 
                   
                    $action_mois = date('m');
                    $action_respons = array();
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            
                            //dd($action_respons);
                        }
                    }
                    
                    }
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
       // }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.action_retard_mateam', compact('actions','action_users', 'projet_respons', 'headers','sum_actions','action_respons','action_bakups','date1'));
    

    }
    
    public function filtrer_action_retard_mateam(Request $request)
    {
        $search = $request->get('search');
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
       // foreach($users as $user){
         
                     $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                     $action_mois = date('m');
                    $projet_respons = array();
                    //dd($action_semaineP7);
                    $agent_ma_teams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_ma_teams as $agent_ma_team)
                    {
                    $projet_responsf = DB::table('actions')->select('actions.id', 'actions.deadline','actions.projet_id', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction', 'projets.id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('projets', 'projets.id', 'actions.projet_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_ma_team->id)
                    ->orWhere('actions.projet_id','=', 'projets.id')
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($projet_responsf as $projet_res)
                    {
                        if(($projet_res->deadline < now()) && $projet_res->pourcentage < 100)
                        {
                        array_push($projet_respons, $projet_res);
                            
                        }
                    }
                    
                   } 
                   
                    $action_mois = date('m');
                    $action_respons = array();
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    ->where('actions.agent_id','like', '%'.$search.'%')
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            
                            //dd($action_respons);
                        }
                    }
                    
                    }
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
       // }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.action_retard_mateam', compact('actions','action_users', 'projet_respons', 'headers','sum_actions','action_respons','action_bakups','date1'));
    

    }

    public function historique_performance()
    {
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        //foreach($users as $user){
         
                                         $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                     $action_mois = date('m');
                    $action_respons = array();
                    $action_respons_sum = array();
                    $sum = 0;
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   //foreach($agent_mateams as $agent_mateam)
                    //{
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            $sum += $action_respf->pourcentage;
                             array_push($action_respons_sum, $sum);
                            //dd($action_respons);
                            //$count = count($action_responsf);
                           
                        }
                    }
                    
                    //}
                    $count = count($action_respons);
                    
                    $perfo_total = ($count == 0 ? 0 : array_sum($action_respons_sum) / $count);
                    
                    //dd($action_respons);
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        //}
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.historique_performance', compact('perfo_total','actions','action_users','headers','sum_actions','action_respons','action_bakups','date1'));
   
    }
    
    public function historique_performance_mateam()
    {
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        //foreach($users as $user){
         
                                         $user = DB::table('agents')->where('user_id', Auth::user()->id)->first();
         
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    $action_mois = date('m');
                    $action_respons = array();
                    $action_respons_sum = array();
                    $sum = 0;
                    //dd($action_mois);
                    $agent_mateams = DB::table('agents')->where('direction_id', $user->direction_id)->get();
                   foreach($agent_mateams as $agent_mateam)
                    {
                    $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 
                    'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $agent_mateam->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    foreach($action_responsf as $action_respf)
                    {
                        if(($action_respf->deadline < now()) && $action_respf->pourcentage < 100)
                        {
                            array_push($action_respons, $action_respf);
                            $sum += $action_respf->pourcentage;
                             array_push($action_respons_sum, $sum);
                            //dd($action_respons);
                            //$count = count($action_responsf);
                           
                        }
                    }
                    
                    }
                    $count = count($action_respons);
                    
                    $perfo_total = ($count == 0 ? 0 : array_sum($action_respons_sum) / $count);
                    //dd($perfo_total);
                      //dd( array_sum($action_respons_sum));
                      
                    //dd($action_respons);
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    //->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         
           
        //}
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.historique_performance_mateam', compact('perfo_total','actions','action_users','headers','sum_actions','action_respons','action_bakups','date1'));
   
    }


    public function responsable_action()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
          /* $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();  */

                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie', 'directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         /*    DB::table('agents')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('suivi_actions.id as ID', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                  'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                  'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                  'agents.prenom', 'agents.id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                  ->where('actions.agent_id','=', $user->id)
                  ->orWhere('agents.id','=', $user->id)
                  ->orderBY('actions.risque','ASC')
                  ->get();  */
                   
                   
                   /*$sum_actions = DB::table('agents')
                   ->join('actions', 'actions.agent_id', 'agents.id')
                   ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                   ->select('suivi_actions.id', 'suivi_actions.deadline', 'actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                           'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                           'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                           'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                           ->where('actions.agent_id','=', $user->id)
                           ->orderBY('actions.risque','ASC')
                           ->sum('actions.pourcentage');*/
           
        }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.responsable_action', compact('actions','action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }
    
    public function user_actionA()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.updated_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id','agents.niveau_hieracie',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','actions.updated_at','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.niveau_hieracie','agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.utilisateur_actionA', compact('actions','sum_actions','headers','sum_directionss','action_directionss','date1'));
    }
    public function responsable_actionA()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.updated_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.niveau_hieracie','agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.responsable_actionA', compact('actions','sum_actions','headers','sum_directionss','action_directionss','date1'));
    }
    
    public function user_action_r()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
          /* $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();  */

                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         /*    DB::table('agents')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('suivi_actions.id as ID', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                  'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                  'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                  'agents.prenom', 'agents.id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                  ->where('actions.agent_id','=', $user->id)
                  ->orWhere('agents.id','=', $user->id)
                  ->orderBY('actions.risque','ASC')
                  ->get();  */
                   
                   
                   /*$sum_actions = DB::table('agents')
                   ->join('actions', 'actions.agent_id', 'agents.id')
                   ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                   ->select('suivi_actions.id', 'suivi_actions.deadline', 'actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                           'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                           'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                           'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                           ->where('actions.agent_id','=', $user->id)
                           ->orderBY('actions.risque','ASC')
                           ->sum('actions.pourcentage');*/
           
        }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.rap_action', compact('actions','action_users','headers','sum_actions','action_respons','action_bakups','date1'));
    }
    
    public function user_actionA_r()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.rap_actionA', compact('actions','sum_actions','headers','sum_directionss','action_directionss','date1'));
    }
    
    
    
     public function user_annonce()
    {
        $message = "";
        $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.dg_annonce', compact('annonces','headers','message'));
     
    }
    
     public function user_annonce_res()
    {
        
        $message = "";
        $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.responsable_annonce', compact('annonces','headers','message'));
     
    }
    
    public function user_annonce_user()
    {
        $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.user_annonce', compact('annonces','headers'));
     
    }
    
    public function user_annonce_r()
    {
        $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.rap_annonce', compact('annonces','headers'));
     
    }
     public function user_reunion_dg()
    {
        $message = "";
        $reunions = DB::table('reunions')->orderBy('created_at', 'DESC')->get();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('reunion/v2.dg_reunion', compact('reunions','headers','message'));
     
    }
    
    public function user_action_dg()
    {
        
         $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
          /* $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();  */

                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie','agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                     $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable','actions.bakup', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage');
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
         /*    DB::table('agents')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('suivi_actions.id as ID', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                  'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                  'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                  'agents.prenom', 'agents.id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                  ->where('actions.agent_id','=', $user->id)
                  ->orWhere('agents.id','=', $user->id)
                  ->orderBY('actions.risque','ASC')
                  ->get();  */
                   
                   
                   /*$sum_actions = DB::table('agents')
                   ->join('actions', 'actions.agent_id', 'agents.id')
                   ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                   ->select('suivi_actions.id', 'suivi_actions.deadline', 'actions.pourcentage','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                           'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                           'actions.risque', 'actions.visibilite', 'actions.id as Id', 
                           'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                           ->where('actions.agent_id','=', $user->id)
                           ->orderBY('actions.risque','ASC')
                           ->sum('actions.pourcentage'); */
           
        }
        $date1 = date('Y/m/d'); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $agents = Agent::all();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
     return view('action/v2.dg_action', compact('actions','my_agents','agents','headers','action_users','sum_actions','action_respons','action_bakups','date1'));
    }
    
    public function user_actionA_dg()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at','actions.updated_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   //->orderBY('actions.risque','ASC')
                   ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');      
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
     return view('action/v2.dg_actionA', compact('actions','sum_actions','headers','sum_directionss','action_directionss','date1'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history($id)
    {
        //
        $action = Action::find($id);

        $users = Agent::where('user_id', Auth::user()->id)->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite','actions.raison', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->where('actions.id','=', $action->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();
                   
                  
           
        }
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        
        return view('suivi_action.user_history',compact('action','actions','headers'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history_responsable($id)
    {
        //
        $action = Action::find($id);

        $users = Agent::where('user_id', Auth::user()->id)->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite','actions.raison', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->where('actions.id','=', $action->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();
                   
                  
           
        }
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        
        return view('suivi_action.responsable_history',compact('action','actions','headers'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history_d($id)
    {
        //
        $action = Action::find($id);

        $users = Agent::where('user_id', Auth::user()->id)->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite','actions.raison', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->where('actions.id','=', $action->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();
                   
                  
           
        }
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        
        return view('suivi_action.dg_history',compact('action','actions','headers'));
    }
    
    public function history_r($id)
    {
        //
        $action = Action::find($id);

        $users = Agent::where('user_id', Auth::user()->id)->get();
        foreach($users as $user){

                    /* $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id',  'actions.visibilite',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id', 'reunions.date', 'reunions.heure_debut', 'reunions.heure_fin', 'reunions.id as ID'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->join('reunions', 'reunions.id', 'actions.reunion_id')
                    ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->get(); */
                    $actions = DB::table('agents')
                    ->join('actions', 'actions.agent_id', 'agents.id')
                    ->join('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->select('suivi_actions.id', 'suivi_actions.deadline', 'suivi_actions.pourcentage','suivi_actions.action_id','suivi_actions.created_at', 'suivi_actions.note','suivi_actions.delais',
                    'actions.libelle','actions.responsable', 'actions.deadline as date', 'actions.delais as duree', 'actions.agent_id',
                    'actions.risque', 'actions.visibilite','actions.raison', 'actions.id as ID', 
                    'agents.prenom', 'agents.id as Id', 'agents.nom', 'agents.photo', 'agents.date_naiss')
                    ->where('actions.agent_id','=', $user->id)
                    ->where('actions.id','=', $action->id)
                    ->orderBY('actions.risque','ASC')
                    ->orderBY('suivi_actions.pourcentage','ASC')
                    ->get();
                   
                  
           
        }

        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        
        return view('suivi_action.history_r',compact('action','actions','headers'));
    }
    /**  
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    //  modifier action avec projet de ma team
      public function edit_action_ma_teamS($id)
    {
       
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.actionmateamS_editer', compact('actions', 'action','agents','reunions','headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_ma_teamS(Request $request, $id)
    {
        $message = "Action mise à jour avec succès !";
      
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/action_mateam_semaine')->with(['message' => $message]);
    }
     
      public function edit_action_ma_teamM($id)
    {
       
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.actionmateamM_editer', compact('actions', 'action','agents','reunions','headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_ma_teamM(Request $request, $id)
    {
        $message = "Action mise à jour avec succès !";
      
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/action_mateam_mois')->with(['message' => $message]);
    }
     
        public function edit_action_ma_teamR($id)
    {
       
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.actionmateamR_editer', compact('actions', 'action','agents','reunions','headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_ma_teamR(Request $request, $id)
    {
        $message = "Action mise à jour avec succès !";
      
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/action_retard_mateam')->with(['message' => $message]);
    }
     
     
    public function edit_action_d($id)
    {
        //


        /* $suivi_action = Suivi_action::find($id);
        $actions = Action::all();
        return view('suivi_action.editer_d', compact('actions', 'suivi_action'));
 */
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.dg_editer', compact('actions', 'action','agents','reunions','headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_d(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
        /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
 
    // mes actions en retard
     public function edit_action_retard($id)
    {
        //


        /* $suivi_action = Suivi_action::find($id);
        $actions = Action::all();
        return view('suivi_action.editer_d', compact('actions', 'suivi_action'));
 */
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.dg_editer_retard', compact('actions', 'action','agents','reunions','headers'));
    }
    public function update_action_retard(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
        /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/user_action')->with(['message' => $message]);
    }
       //Toute mes actions 
     public function edit_action_toute($id)
    {
        //


        /* $suivi_action = Suivi_action::find($id);
        $actions = Action::all();
        return view('suivi_action.editer_d', compact('actions', 'suivi_action'));
 */
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.dg_editer_toute', compact('actions', 'action','agents','reunions','headers'));
    }
    public function update_action_toute(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
        /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/user_toute_action')->with(['message' => $message]);
    }
    // mes actions de ce mois
     public function edit_action_mois($id)
    {
        //


        /* $suivi_action = Suivi_action::find($id);
        $actions = Action::all();
        return view('suivi_action.editer_d', compact('actions', 'suivi_action'));
 */
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.dg_editer_mois', compact('actions', 'action','agents','reunions','headers'));
    }
    public function update_action_mois(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
        /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/user_action_mois')->with(['message' => $message]);
    }
    
     /**  
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_r($id)
    {
        //


        /* $suivi_action = Suivi_action::find($id);
        $actions = Action::all();
        return view('suivi_action.editer_d', compact('actions', 'suivi_action'));
 */
        $action = Action::find($id);
        $actions = Action::all();
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('suivi_action/v2.rap_editer', compact('actions', 'action','agents','reunions','headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_r(Request $request, $id)
    {
        //

        
        $message = "Action mise à jour avec succès !";
        /*  $suivi_action = Suivi_action::find($id);
        $suivi_actionUpdate = $request->all();
        $suivi_action->save($suivi_actionUpdate);
 */
            /* $suivi_action = Suivi_action::find($id);
            $suivi_action->deadline = $request->get('deadline');
            $suivi_action->pourcentage = $request->get('pourcentage'); 
            $suivi_action->note = $request->get('note');
            $suivi_action->delais = $request->get('delais');
            $suivi_action->action = $request->get('action');
            $suivi_action->action_id = $request->get('action_id'); 
            $suivi_action->save(); */
           /*  $action = Action::find($id);
            $actionUpdate = $request->all();  
            $action->update($actionUpdate); */
            $action = Action::find($id);
            $action->libelle = $request->get('libelle');
            $action->deadline = $request->get('deadline'); 
            $action->visibilite = $request->get('visibilite');
            $action->note = $request->get('note');
            $action->risque = $request->get('risque');   
            $action->delais = $request->get('delais'); 
            $action->reunion = $request->get('reunion');
            $action->responsable = $request->get('responsable');
            $action->bakup = $request->get('bakup');
            $action->agent = $request->get('agent');
            $action->pourcentage = $request->get('pourcentage'); 
            $action->agent_id = $request->get('agent_id'); 
            $action->reunion_id = $request->get('reunion_id');
            $action->raison = $request->get('raison');
            $action->update();

        return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
    }
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_rap($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('action/v2.rap_escalader', compact('agents','reunions', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_rap(Request $request, $id)
    {
        //

        
        $message = "Action escaladée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_user($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $agens = Agent::paginate(1);
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('action/v2.user_escalader', compact('agents','agens','reunions', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_user(Request $request, $id)
    {
        //

        
        $message = "Action escaladée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/user')->with(['message' => $message]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_responsab($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $agens = Agent::paginate(1);
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('action/v2.responsable_escalader', compact('agents','agens','reunions', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_responsab(Request $request, $id)
    {
        //

        
        $message = "Action escaladée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/responsable')->with(['message' => $message]);
    }
    
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_responsabreasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.responsable_reasigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_responsabreasigner(Request $request, $id)
    {
        //

        
        $message = "Action asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/responsable')->with(['message' => $message]);
    }
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_rapreasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.rap_reasigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_rapreasigner(Request $request, $id)
    {
        //

        
        $message = "Action asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_dgreasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.dg_reasigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_dgreasigner(Request $request, $id)
    {
        //

        
        $message = "Action asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
    
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_responsabasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.responsable_asigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_responsabasigner(Request $request, $id)
    {
        //

        
        $message = "Action re-asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/responsable')->with(['message' => $message]);
    }
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_rapasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.rap_asigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_rapasigner(Request $request, $id)
    {
        //

        
        $message = "Action re-asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_action_dgasigner($id)
    {
        //


        $action = Action::find($id);
        $agents = Agent::all();
        $reunions = Reunion::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $res_agents = DB::table('agents')
        ->select('agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id',
        'services.nom_service','services.direction')
        ->join('services', 'services.id', 'agents.service_id')
        ->whereIn('services.nom_service', array('Responsable Technique' ,'Directeur Génerale','Responsable Marketing','Responsable Stratégique'))        
        ->get();
        return view('action/v2.dg_asigner', compact('agents','reunions','res_agents', 'action','headers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_action_dgasigner(Request $request, $id)
    {
        //

        
        $message = "Action re-asignée avec succès !";
        $action = Action::find($id);
        $actionUpdate = $request->all();  
        $action->update($actionUpdate);

        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
    public function tech()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        return view('admin.tech');
    }

    public function marketing()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        return view('admin.marketing');
    }

    public function assistant()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        return view('admin.assistant');
    }

    public function secretaire()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
        return view('admin.secretaire');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  
     {
         //
         $users = User::orderBy('id')->get();
         return view('user.lister', ['users' => $users]);
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
         $roles = Role::all();
        return view('user.create',compact('roles'));
     }

     public function inscription()
     {
         //
         $roles = Role::all();
        return view('admin.register',compact('roles'));
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

      public function inscriptions(Request $request)
     {
         //
 
          /* $this->validate($request, [
             'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
 
 
         ]); 
   */
         request()->validate([
             //'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:6|confirmed',
 
     ]);
 
            //$image = $request->file('photo');
            /*if($image){
            $imageName = $image->getClientOriginalName();
            $image->move(public_path().'/images/', $imageName);
             } */
             $message = "Ajouté avec succès";

             $user = new User;
             $user->prenom = $request->get('prenom'); 
             $user->nom = $request->get('nom'); 
             //$user->photo =  $imageName; 
             $user->email = $request->get('email'); 
             $user->nom_role = $request->get('nom_role'); 
             $user->role_id = $request->get('role_id'); 
             $user->password = Hash::make($request->get('password'));
             //$user->notify(new BienvenueACollaboratis());
 
             if($user->save())
             {
                 Auth::login($user);
                 $user->notify(new BienvenueACollaboratis());
                 return redirect('/admin/dashboard')->with(['message' => $message]);
     
             }
             else
             {
                 flash('user not saved')->error();
     
             }
     
     
     return back()->with(['message' => $message]);
 
     }
     public function store(Request $request)
     {
         //
 
          /* $this->validate($request, [
             'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
 
 
         ]); 
   */
       
             
       
 
         request()->validate([
            //'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:6|confirmed',
 
     ]);
 
            //$image = $request->file('photo');
            /*if($image){
            $imageName = $image->getClientOriginalName();
            $image->move(public_path().'/images/', $imageName);
             } */
             $message = "Ajouté avec succès";

             $user = new User;
             $user->prenom = $request->get('prenom'); 
             $user->nom = $request->get('nom'); 
             //$user->photo =  $imageName; 
             $user->email = $request->get('email'); 
             $user->nom_role = $request->get('nom_role'); 
             $user->role_id = $request->get('role_id'); 
             $user->password = Hash::make($request->get('password'));
             //$user->notify(new BienvenueACollaboratis());
 
             if($user->save())
             {
                 Auth::login($user);
                 $user->notify(new BienvenueACollaboratis());
                 return redirect('/admin/dashboard')->with(['message' => $message]);
     
             }
             else
             {
                 flash('user not saved')->error();
     
             }
     
     
     return back()->with(['message' => $message]);
 
     }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $candidat = Candidat::find($id);
        return view('administrateur.details',compact('candidat'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        return view('user.edite', compact('roles', 'user'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  

       /*  $message = "Utilisateur modifés avec succés";

        $image = $request->file('photo');
        if($image){
        $imageName = $image->getClientOriginalName();
        $image->move(public_path().'/images/', $imageName);    
        }
        $userUpdate = $request->all();
        $update = User::find($id)
        
        ->update(['photo' => $imageName, 'userUpdate' => $userUpdate]);

        if($update){

            return redirect('/users')->with(['message' => $message]);
        }

        else {
            echo 'Error';
        } */
       /* 
     */
            //$image = $request->file('photo');
            /*if($image){
            $imageName = $image->getClientOriginalName();
            $image->move(public_path().'/images/', $imageName);
             } */
             $message = "Utilisateur modifié avec succè";

             $user = User::find($id);
             $user->prenom = $request->get('prenom'); 
             $user->nom = $request->get('nom'); 
             //$user->photo =  $imageName; 
             $user->email = $request->get('email'); 
             $user->nom_role = $request->get('nom_role'); 
             $user->role_id = $request->get('role_id'); 
             $user->password = Hash::make($request->get('password'));
             //$user->notify(new BienvenueACollaboratis());
 
             if($user->update())
             {
                 Auth::login($user);
                 $user->notify(new BienvenueACollaboratis());
                 return redirect('/admin/dashboard')->with(['message' => $message]);
     
             }
             else
             {
                 flash('user not saved')->error();
     
             }

        return redirect('/users')->with(['message' => $message]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajout_annonce()
    {
        //
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.create_dg',compact('headers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajout_annonceA(Request $request)
    {
        //

        /*request()->validate([
            'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
            'titre' => 'required|string|max:255',
           

    ]);*/

          /* $image = $request->file('photo');
           if($image){
           $imageName = $image->getClientOriginalName();
           $image->move(public_path().'/images/', $imageName);
            } */
            $message = "Votre annonce a été publiée avec succés";
            
            $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                                          ->where('user_id', Auth::user()->id)
                                          ->join('directions', 'directions.id', 'agents.direction_id')
                                          ->paginate(1);

            $annonce = new Annonce;
            $annonce->titre = $request->get('titre'); 
            //$annonce->photo =  $imageName; 
            $annonce->description = $request->get('description'); 
            $annonce->save(); 
            
            $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
    
     return redirect('/user_annonce')->with(['headers'=>$headers,'annonces'=>$annonces,'message'=>$message]);
     
    }


 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajout_annonce_r()
    {
    
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        return view('annonce/v2.create_rap',compact('headers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajout_annonceA_r(Request $request)
    {
        //

        /*request()->validate([
            'photo.*' => 'mimes:doc,pdf,docx,zip,png,jpeg,odt,jpg,svc,csv,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
            'titre' => 'required|string|max:255',
           

    ]);*/

          /* $image = $request->file('photo');
           if($image){
           $imageName = $image->getClientOriginalName();
           $image->move(public_path().'/images/', $imageName);
            } */
            

            $message = "Votre annonce a été publiée avec succés";
            
            $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
                                          ->where('user_id', Auth::user()->id)
                                          ->join('directions', 'directions.id', 'agents.direction_id')
                                          ->paginate(1);
                                          
            $annonce = new Annonce;
            $annonce->titre = $request->get('titre'); 
            //$annonce->photo =  $imageName; 
            $annonce->description = $request->get('description'); 
            $annonce->save(); 
            
            $annonces = DB::table('annonces')->orderBy('created_at', 'DESC')->get();
            
            return redirect('/user_annonce_res')->with(['headers'=>$headers,'annonces'=>$annonces,'message'=>$message]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $user->delete();

        return back();
    }
    
    public function my_filter(Request $request){
        
         $bakup_users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->pluck('full_name','id');
        $users = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->where('user_id', Auth::user()->id)->orderBy('prenom')->get();
        foreach($users as $user){
                    $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_respons = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', $user->id)
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 
        
                  $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite', 'actions.bakup',  'actions.risque', 'actions.delais','actions.created_at',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   ->where('agents.id','=', $user->id)
                   ->get();   
                  
        }
        $date1 = date('Y/m/d');
        $date2 = date('Y/m/d');
        $nbrJour = strtotime($date1) - strtotime($date2); 

        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $action_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->get();
          $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');         
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline',
                 'actions.risque','actions.delais as duree','actions.raison', 'actions.visibilite','suivi_actions.deadline as date','actions.created_at', 'actions.pourcentage', 'actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
         $agents = DB::table('agents')
            ->where('agents.direction_id', $user->direction_id)
            ->get();
       }   
        $search_a = $request->get('search_a');
       $agent_actions = Action::all();
        $recherches = Agent::all();
        
       $suivi_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.bakup', 'actions.libelle', 'actions.note',
                        'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite',  'actions.risque', 'actions.delais',
                         'agents.prenom', 'agents.nom', 'agents.photo','agents.direction_id', 'agents.id as Id')
                         ->join('agents', 'agents.id', 'actions.agent_id')
                          ->where('agents.prenom', 'like', '%'.$search_a.'%')
                          ->orderBy('actions.id')
                         ->get();
               
        $suivi_indicateurs = DB::table('suivi_indicateurs')->select('suivi_indicateurs.id', 'suivi_indicateurs.date', 'suivi_indicateurs.pourcentage', 'suivi_indicateurs.note',
                        'suivi_indicateurs.indicateur_id',
                         'indicateurs.id', 'indicateurs.libelle', 'indicateurs.cible', 'indicateurs.date_cible')
                         ->join('indicateurs', 'indicateurs.id', 'suivi_indicateurs.indicateur_id', 'suivi_actions')
                         ->get(); 
        $decissions = DB::table('decissions')->select('decissions.id', 'decissions.libelle',
                        'decissions.agent_id','decissions.reunion_id',  'decissions.delais',
                        'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id',
                        'reunions.date','reunions.nombre_partici','reunions.heure_debut','reunions.heure_fin')
                        ->join('agents', 'agents.id', 'decissions.agent_id')
                         ->join('reunions', 'reunions.id', 'decissions.reunion_id')
                        ->get();
        $annonces = Annonce::all();  
        $reunions = Reunion::all(); 
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);

        return view('v2.dashboard_rap', compact('suivi_indicateurs','headers','annonces', 'agent_actions','reunions','decissions','suivi_actions',
         'actions','action_directions', 'sum_directions','action_respons','action_bakups','action_users','date1','action_directionss','sum_directionss','sum_actions','agents','recherches'));
      }    
      
       public function responsable_actionAcloture()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  ->orWhere('actions.visibilite','=', 1)
                   ->orderBY('actions.risque','ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  ->orWhere('actions.visibilite','=', 1)
                   ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
        $agents = Agent::all();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
     return view('action/v2.responsable_actionAcloture', compact('actions','sum_actions','my_agents','agents','superieur1s','superieurs','headers','sum_directionss','action_directionss','date1'));
    }
    public function rapporteur_actionAcloture()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  ->orWhere('actions.visibilite','=', 1)
                   ->orderBY('actions.risque','ASC')
                  ->get();
                  
            $sum_actions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable','actions.deadline',
                  'actions.risque','actions.delais', 'actions.visibilite', 'actions.bakup','actions.created_at', 'actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as idDI')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                   ->orderBY('actions.risque','ASC')
                   ->orWhere('actions.visibilite','=', 1)
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
     return view('action/v2.rapporteur_actionAcloture', compact('actions','sum_actions','superieurs','superieur1s','headers','sum_directionss','action_directionss','date1'));
    }

    public function directeur_actionAcloture()
    {
        
        $user_actions = Agent::where('user_id', Auth::user()->id)->get();
         foreach($user_actions as $user)
        {
        $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
        'actions.agent_id','actions.reunion_id', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
         'agents.prenom', 'agents.nom', 'agents.photo','agents.niveau_hieracie','agents.email', 'agents.id as Id')
         ->join('agents', 'agents.id', 'actions.agent_id')
         ->where('actions.visibilite','=', 1)
         ->whereIn('agents.niveau_hieracie',array('Chef de Service','Directeur') )
         ->orderBY('actions.risque','ASC')
         ->get();        
                 
                  
            $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
            'actions.agent_id','actions.reunion_id', 'actions.bakup',  'actions.visibilite','actions.created_at',  'actions.risque', 'actions.delais',
             'agents.prenom', 'agents.nom', 'agents.photo','agents.email', 'agents.id as Id')
             ->join('agents', 'agents.id', 'actions.agent_id')
             ->orWhere('actions.visibilite','=', 2)
             ->orderBY('actions.risque','ASC')
                  ->sum('actions.pourcentage');
        }   
        
        $user_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($user_actionss as $user)
       {
       $action_directionss = DB::table('directions')
        ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.agent_id','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.id as ID','suivi_actions.action_id', 'suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orWhere('actions.agent_id','=', $user->id)
                 ->orderBY('agents.prenom','ASC')
                 ->get();
                 
                
       }   

      
       $sum_actionss = Agent::where('user_id', Auth::user()->id)->get();
        foreach($sum_actionss as $user)
       {
       $sum_directionss = DB::table('directions')
         ->join('agents', 'agents.direction_id', 'directions.id')
         ->join('actions', 'actions.agent_id', 'agents.id')
         ->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
         ->select('actions.id',
                 'actions.libelle', 'actions.responsable','actions.deadline as date',
                 'actions.risque','actions.delais as duree', 'actions.visibilite','suivi_actions.deadline','suivi_actions.created_at', 'actions.pourcentage', 'suivi_actions.note','suivi_actions.delais',
                 'agents.prenom', 'agents.nom', 'agents.photo', 'agents.service_id', 'agents.date_naiss', 'agents.id as Id',
                 'directions.nom_direction','directions.id as ID')
                 ->where('agents.direction_id' ,'=', $user->direction_id)
                 ->orderBY('actions.risque','ASC')
                 ->sum('actions.pourcentage');
                 //->get();
        
       }   
       
       $date1 = date('Y/m/d');
       $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $superieur1s = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
        'actions.agent_id','actions.reunion_id',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
        'agents.prenom', 'agents.nom', 'agents.photo','agents.email','agents.superieur_id', 'agents.id as Id','directions.nom_direction'
        )
        ->join('agents', 'agents.id', 'actions.agent_id')
        ->leftjoin('directions', 'directions.id', 'agents.direction_id')
        ->where('actions.agent_id','=', $user->id)
        ->paginate(1);
        $superieurs = DB::table('agents')
        ->get();
        $agents = Agent::all();
        $my_agents = Agent::select('id', DB::raw('CONCAT(prenom, " ", nom) AS full_name'))->get();
     return view('action/v2.directeur_actionAcloture', compact('actions','my_agents','agents','sum_actions','superieur1s','superieurs','headers','sum_directionss','action_directionss','date1'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil_dg($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = User::where('id', Auth::user()->id)->get();
        return view('user/v2.editer_directeur', compact('roles', 'user','headers','users'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profil_dg(Request $request, $id)
    {
     $image = $request->file('photo');
     $message = "Utilisateur modifié avec succès";
        
     if($image != null){    

		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->photo =  $name; 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                //$user->notify(new RegisterNotify());	
                //$user->save();
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		 }
        }
        
        else{
            
                $user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
             
         }  
       
            

        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info(Request $request, $id)
    {
        //    
        $message = "Utilisateur modifié avec succès";
        $user = User::findOrFail($id);
        $user->prenom = $request->get('prenom'); 
        $user->nom = $request->get('nom'); 
        $user->email = $request->get('email'); 
        $user->nom_role = $request->get('nom_role'); 
        $user->role_id = $request->get('role_id'); 
        //$user->password = Hash::make($request->get('password'));
        if($user->save())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function passwords(Request $request, $id)
    {
        //    
        $message = "Mot de passe modifié avec succès";
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->get('password'));
        if($user->save())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request, $id)
    {
        //    
     $image = $request->file('photo');
     $message = "Profil modifié avec succès";
        
     if($image != null){    

		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::find($id);
                $user->photo =  $name; 
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		 }
        }
        return redirect('/v3/admin/dashboard')->with(['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil_responsable($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = User::where('id', Auth::user()->id)->get();
        return view('user/v2.editer_responsable', compact('roles', 'user','headers','users'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profil_responsable(Request $request, $id)
    {
       
     $image = $request->file('photo');
     $message = "Utilisateur modifié avec succès";
        
     if($image != null){    

		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->photo =  $name; 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                //$user->notify(new RegisterNotify());	
                //$user->save();
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		 }
        }
        else
        {
            $user = User::find($id);
            $user->prenom = $request->get('prenom'); 
            $user->nom = $request->get('nom'); 
            $user->email = $request->get('email'); 
            $user->nom_role = $request->get('nom_role'); 
            $user->role_id = $request->get('role_id'); 
            $user->password = Hash::make($request->get('password'));
            if($user->update())
            {
                Auth::login($user);
                //$user->notify(new BienvenueACollaboratis());
                return redirect('/v3/admin/dashboard')->with(['message' => $message]);
            }
            else
            {
                flash('user not saved')->error();
    
            } 
         }  
       
            

        return redirect('/admin/dashboard/responsable')->with(['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
         public function profil_user_password($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = User::where('id', Auth::user()->id)->get();
        return view('user/v2.edit_password', compact('roles', 'user','headers','users'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profil_user_password(Request $request, $id)
    {
       
     $image = $request->file('photo');
     $message = "Utilisateur modifié avec succès";
        
     if($image != null){    

		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::findOrFail($id);
                // $user->prenom = $request->get('prenom'); 
                // $user->nom = $request->get('nom'); 
                // $user->photo =  $name; 
                // $user->email = $request->get('email'); 
                // $user->nom_role = $request->get('nom_role'); 
                // $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                //$user->notify(new RegisterNotify());	
                //$user->save();
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		 }
        }
        else{
                $user = User::findOrFail($id);
                // $user->prenom = $request->get('prenom'); 
                // $user->nom = $request->get('nom'); 
                // $user->email = $request->get('email'); 
                // $user->nom_role = $request->get('nom_role'); 
                // $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
             
         }  
       
            

        return redirect('/admin/dashboard/user')->with(['message' => $message]);
    }
     
     
    public function profil_user($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = User::where('id', Auth::user()->id)->get();
        return view('user/v2.editer_user', compact('roles', 'user','headers','users'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profil_user(Request $request, $id)
    {
       
     $image = $request->file('photo');
     $message = "Utilisateur modifié avec succès";
        
     if($image != null){    

		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->photo =  $name; 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                //$user->notify(new RegisterNotify());	
                //$user->save();
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		 }
        }
        else{
                $user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/v3/admin/dashboard')->with(['message' => $message]);
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
             
         }  
       
            

        return redirect('/admin/dashboard/user')->with(['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil_rap($id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $headers = DB::table('agents')->select('agents.prenom', 'agents.nom','directions.nom_direction')
        ->where('user_id', Auth::user()->id)
        ->join('directions', 'directions.id', 'agents.direction_id')
        ->paginate(1);
        $users = User::where('id', Auth::user()->id)->get();
        return view('user/v2.editer_rap', compact('roles', 'user','headers','users'));

    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profil_rap(Request $request, $id)
    {
        $image = $request->file('photo');
        $message = "Utilisateur modifié avec succès";

	  if($image != null)
		
		if($image->isValid()){
			$chemin = public_path().'/images/';
			$extension = $image->getClientOriginalExtension();
			
			do{
				$name = Str::random(10) . '.' . $extension;
			}while(file_exists($chemin.'/'.$name));

			if($image->move(public_path().'/images/',$name)){
               
				$user = User::find($id);
                $user->prenom = $request->get('prenom'); 
                $user->nom = $request->get('nom'); 
                $user->photo =  $name; 
                $user->email = $request->get('email'); 
                $user->nom_role = $request->get('nom_role'); 
                $user->role_id = $request->get('role_id'); 
                $user->password = Hash::make($request->get('password'));
                //$user->notify(new BienvenueACollaboratis());	
                //$user->save();
                if($user->update())
                {
                    Auth::login($user);
                    //$user->notify(new BienvenueACollaboratis());
                    return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
        
                }
                else
                {
                    flash('user not saved')->error();
        
                } 
			}
		}
       
            

        return redirect('/admin/dashboard/rapporteur')->with(['message' => $message]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status_cloture($id)
    {
        

        $cloture = "Action clôturée avec succès";
        $action = Action::findOrFail($id);
        $action->pourcentage = 100; //M.A.X B.I.R.D was here
        $action->visibilite = 1; //Approved
        $action->save();
        
        //M.A.X B.I.R.D was here
        $manager = Agent::findOrFail($action->agent_auth_id);
        $user = Agent::findOrFail($action->agent_id);
        $subject = $user->prenom . " " . $user->nom . " a cloturé l'action : " .  $action->libelle ;
        $message = "L'action : " .  $action->libelle . " a été clôturée avec succès par " . $user->prenom . " " . $user->nom;
        
        
        if($user->id != $manager->id)
            Mail::to(array($manager->email))->send(new SendMail($subject, $message));
        
        return back()->with(['cloture' => $cloture]); 
    }
    
    public function refuser_cloture($id)
    {
        

        $cloture = "Cloture refusée avec succès";
        $action = Action::findOrFail($id);
        $action->pourcentage = 00; //M.A.X B.I.R.D was here
        $action->visibilite = 0; //Approved
        $action->save();
        
        $manager = Agent::findOrFail($action->agent_auth_id);
        $user = Agent::findOrFail($action->agent_id);
        $subject =  $manager->prenom . " " . $manager->nom . " a refusé la cloture de l'action : " .  $action->libelle ;
        $message = "Cette action - " .  $action->libelle . " - n’est pas terminée  " ;
        
        
        if($manager->id != $user->id)
            Mail::to(array($user->email))->send(new SendMailRefuser($subject, $message));
        
        return back()->with(['cloture' => $cloture]); 
    }
    
      public function status_cloture1($id)
    {
        //    
        $cloture = "Action clôturée avec succès";
        $action = Action::findOrFail($id);
        $action->pourcentage = 100; //M.A.X B.I.R.D was here
        $action->visibilite = 1; //Approved
        $action->save();
        
        //M.A.X B.I.R.D was here
        $manager = Agent::findOrFail($action->agent_auth_id);
        $user = Agent::findOrFail($action->agent_id);
        $subject =  $user->prenom . " " . $user->nom . " a cloturé l'action : " .  $action->libelle ;
        $message = "Cette action - " .  $action->libelle . " a ete cloturer avec succes par " . $user->prenom . " " . $user->nom;
        
        
        if($user->id != $manager->id)
            Mail::to(array($manager->email))->send(new SendMail($subject, $message));
            
        return redirect()->back()->with(['cloture' => $cloture]); 
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status_valider($id)
    {
        //    
        $valider = "Action validée avec succès";
        $action = Action::findOrFail($id);
        $action->visibilite = 2; //Approved
        $action->save();
        return redirect()->back()->with(['valider' => $valider]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status_refuser(Request $request, $id)
    {
        //    
        $refuser = "Action refusée";
        $action = Action::find($id);
        $action->visibilite = 0; //Approved
        $action->raison = $request->get('raison');
        $action->save();
        return redirect()->back()->with(['refuser' => $refuser]); 
    }
    
    public function statut_agents()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
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
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
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
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    //->orWhere('actions.raison','<>', 0)
                    ->where('actions.action_respon', '!=' , '')
                    //->orWhereNull('actions.action_respon')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

        
        
        $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
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
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as ID')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  //->orderBY('actions.risque','ASC')
                  ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
            $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
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
                    // >orderBY('actions.risque','ASC')
                    ->sum('actions.pourcentage');  
                   //->get();
                        
                                  
                        
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
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')
            ->sum('actions.pourcentage');
            $indicateurs_global_dir = DB::table('actions')
            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')

            ->get();
            
            $count_dir = count($indicateurs_global_dir); 
            array_push($indi_array_dir, $indicateurs_global_dir);
            
             //$sum_dir = $indicateurs_sum_dir / $count_dir;
             
              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
             array_push($sum_array_dir,$sum_dir);
             
             //array_sum (array, $sum_array) : int|float;
             
             $sum_total_dir = array_sum($sum_array_dir);
             $counts_dir = count($sum_array_dir);

          }
         $taux_exe = $sum_total_dir / $counts_dir;
         
         $count_actions = count($actions);
         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
         
         $count_actions_dir = count($action_directions);
         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
         
         $userAgents = User::orderBy('last_online_at', 'desc')->where('id', '!=', 3)
                                                              ->Where('id', '!=', 78)
                                                              ->Where('id', '!=', 156)
                                                              ->Where('id', '!=', 150)
                                                              ->Where('id', '!=', 147)->get();
         $userAgentss = DB::table('users')->where('id', '!=', 3)->get();
         $actionAgents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note',
                    'actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom','agents.user_id', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->latest('actions.updated_at')
                    ->get();
         foreach($userAgentss as $userAgent){
         
            foreach($actionAgents as $actionAgent){ 
                if($userAgent->id = $actionAgent->user_id)
                    $action = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note',
                    'actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom','agents.user_id', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->where('agents.user_id','=', $userAgent->id)
                    ->latest('actions.updated_at')

                    ->first();
    }
         }
        return view('v2.statut_agent', compact('actions','action_escalades','my_agents','users','action_directions','headers',
        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users',
        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','actionAgents','action'));

    }
    
    public function derniers_updates()  
    {
        //
        //$recruteurs = Recruteur::orderBy('id')->get();
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
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
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
                    //->orWhere('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                     $action_escalades = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at', 'actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    ->where('actions.agent_id','=', Auth::user()->id)
                    //->orWhere('actions.raison','<>', 0)
                    ->where('actions.action_respon', '!=' , '')
                    //->orWhereNull('actions.action_respon')
                   ->orderBy('actions.updated_at', 'DESC')
                    ->get();
                    
                    $action_bakups = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','agents.niveau_hieracie','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note','actions.updated_at','actions.created_at','actions.updated_at', 
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','agents.niveau_hieracie','directions.nom_direction'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                    //->where('actions.agent_id','=', $user->id)
                    ->where('actions.bakup','=', $user->full_name)
                    ->orderBy('actions.pourcentage', 'ASC')
                    ->get();
                    
                    $sum_actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque','actions.updated_at', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->join('reunions', 'reunions.id', 'actions.reunion_id')
                    //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
                    ->where('actions.agent_id','=', $user->id)
                    ->orWhere('actions.bakup','=', $user->full_name)
                    ->sum('actions.pourcentage'); 

        
        
        $action_users = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.libelle', 'actions.pourcentage', 'actions.note','actions.responsable',
                  'actions.agent_id','actions.reunion_id','actions.raison', 'actions.bakup',  'actions.visibilite','actions.updated_at','actions.created_at',  'actions.risque', 'actions.delais',
                   'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id')
                   ->join('agents', 'agents.id', 'actions.agent_id')
                   //->join('reunions', 'reunions.id', 'actions.reunion_id')
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
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
          ->select('actions.id',
                  'actions.libelle', 'actions.responsable', 'actions.bakup','actions.deadline',
                  'actions.risque','actions.delais','actions.raison', 'actions.updated_at','actions.visibilite','actions.created_at','actions.pourcentage', 'actions.note',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.direction_id', 'agents.date_naiss', 'agents.id as Id',
                  'directions.nom_direction','directions.id as ID')
                  ->where('agents.direction_id' ,'=', $user->direction_id)
                  ->orWhere('actions.agent_id','=', $user->id)
                  //->orderBY('actions.risque','ASC')
                  ->orderBy('actions.pourcentage', 'ASC')
                  ->get();
            $sum_directions = DB::table('directions')
          ->join('agents', 'agents.direction_id', 'directions.id')
          ->join('actions', 'actions.agent_id', 'agents.id')
          //->leftjoin('suivi_actions', 'suivi_actions.action_id', 'actions.id')
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
                    // >orderBY('actions.risque','ASC')
                    ->sum('actions.pourcentage');  
                   //->get();
                        
                                  
                        
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
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')
            ->sum('actions.pourcentage');
            $indicateurs_global_dir = DB::table('actions')
            ->select('actions.*','agents.prenom','agents.nom','agents.direction_id')
            //->join('directions', 'directions.id', '=','agents.direction_id')
            ->join('agents', 'agents.id','=', 'actions.agent_id')
            ->where('agents.direction_id', '=', $dir->id)
            ->orWhereNull('agents.direction_id')

            ->get();
            
            $count_dir = count($indicateurs_global_dir); 
            array_push($indi_array_dir, $indicateurs_global_dir);
            
             //$sum_dir = $indicateurs_sum_dir / $count_dir;
             
              $sum_dir = $count_dir == 0 ? 0 : $indicateurs_sum_dir / $count_dir;
             array_push($sum_array_dir,$sum_dir);
             
             //array_sum (array, $sum_array) : int|float;
             
             $sum_total_dir = array_sum($sum_array_dir);
             $counts_dir = count($sum_array_dir);

          }
         $taux_exe = $sum_total_dir / $counts_dir;
         
         $count_actions = count($actions);
         $sum = $count_actions == 0 ? 0 : $sum_actions / $count_actions;
         
         $count_actions_dir = count($action_directions);
         $sum_dir = $count_actions_dir == 0 ? 0 : $sum_directions / $count_actions_dir;
         
         $userAgents = User::where('nom_role', '!=','admin')->where('id', '!=', 156)->get();
         $userAgentss = User::all();
         $actionAgents = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note',
                    'actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom','agents.user_id', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->latest('actions.updated_at')
                    ->get();
         foreach($userAgentss as $userAgent){
         
            foreach($actionAgents as $actionAgent){ 
                if($userAgent->id = $actionAgent->user_id)
                    $action = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup', 
                    'actions.risque', 'actions.delais','actions.pourcentage','actions.action_respon', 'actions.note',
                    'actions.updated_at','actions.created_at',
                    'agents.prenom', 'agents.nom','agents.user_id', 'agents.niveau_hieracie', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    //->where('agents.user_id','=', $userAgent->id)
                    ->latest('actions.updated_at')
                    ->first();
    }
         }
        return view('v2.derniers_updates', compact('actions','action_escalades','my_agents','users','action_directions','headers',
        'action_respons','action_bakups', 'sum_directions','annonces', 'action_users',
        'suivi_indicateurs','suivi_actions','date1','sum_directionss','sum_suivi_actions','sum_actions','directions','agents',
        'sum_array_dir','taux_exe','sum','sum_dir','userAgents','actionAgents','action'));

    }
    
    public function connexions(Request $request)
    {
        request()->validate([
           'email' => 'required|email|unique:users,email',

    ]);
        
        $user = new User;
        $user->prenom = $request->get('prenom');
        $user->nom = $request->get('nom');
        $user->email = $request->get('email');
        $user->nom_role = 'prospect';
    
        if($user->save())
            {
           
        $prospect = new Prospect;
        $prospect->nom = $request->get('nom');
        $prospect->prenom = $request->get('prenom');
        $prospect->email = $request->get('email');
        $prospect->user_id = $user->id;
        $prospect->save();
        
         return redirect('/v3/admin/dashboard');
        }
    }
    public function inscriptio()
    {
   
        return view('v3.inscription_prospect');
    }
    public function prosp()
    {
         
   
        return view('feedback.Dashbordprospect');
    }
    
   public function saveinscription(Request $request)
    {
    request()->validate([
            'email' => 'required|email|unique:users,email',
             
    ]);
   
   

        $user = new User;
        $user->prenom = $request->get('prenom');
        $user->nom = $request->get('nom');
        $user->email = $request->get('email');
        $user->nom_role = 'prospect';
        $user->password = Hash::make($request->get('password'));
    
       

    if($user->save())
        {
            Auth::login($user);
            
        $message = 'Participant ajoutÃ©e avec succÃ©s';
        $prospect = new Prospect;
        $prospect->nom = $user->nom;
        $prospect->prenom = $user->prenom;
        $prospect->user_id = $user->id;
        $prospect->save();  
            return redirect('/feedback/demander');
        }
    else
        {
            flash('User not saved')->error();
        }
     
          
    $message = 'Vous etes inscrits avec succes';
    return redirect('/feedback/demander')->with(['message' => $message]);
}


}
