<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Participant;
use App\Models\Souhait;
use App\Models\Souhaits_rv;
use App\Models\Souhaite;
use App\Models\Souhaites_rv;
use App\Models\Creneaus_rv;
use App\Models\Creneau;
use App\Models\Planning_f;
use App\Models\Planning;
use App\Models\Plannings_rv;
use App\Models\Plannings_f_rv;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
session_start();
use Auth;
use Session;
use DB;
use App\Notifications\RegisterNotify;
use App\Models\Entreprise;
use App\Mail\BesoinDesRendezvousB2B;
use App\Mail\BesoinTraducteur;


//mail namespace
use App\Mail\WelcomeEmail;
use App\Mail\KitEmail;

//random str generate 
use Str;
use PDF;

//zoom meeting
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;


class InscriptionController extends Controller
{
    use ZoomMeetingTrait;  

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    
   use AuthenticatesUsers;

    /**mo
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    } 

    
public function confirmations()
{
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
    $entreprise_id = $entreprise->id;
    
    $plannings = DB::table('planning_fs')->where('entreprise_rv_id', $entreprise_id)->get();

    $input = array();
    $inputS = array();
    
    $planning_fs = array();
    $souhaits = array();
 
    foreach($plannings as $planning){
        if(!in_array($planning->entreprise_id, $input) && $planning->etats != 1 ){
            array_push($input, $planning->entreprise_id);
            array_push($planning_fs, $planning);
        }else if(!in_array($planning->entreprise_id, $inputS) && $planning->etats == 1) {
            array_push($inputS, $planning->entreprise_id);
            array_push($souhaits, $planning);    
        }
    }
    
    return view('User.confirmations', compact('planning_fs', 'souhaits'));
}
public function connexion()
{
    return view('User.connexion');
}

public function homefacilitateur()
{
    $activities = DB::table('activites')->get();

    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    return view('User.homeFacilitateur', compact('pays', 'activities'));
}
 public function editfacilitateur($id)
    {
        $facilitateur = User::find($id);
        
        return view('User.editFacilitateur', compact('facilitateur'));
    }
public function updatefacilitateur(Request $request, $id)
    {
        if($request->file('pic')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
     $message = 'Profil modifié avec succès';
        $facilitateur = User::findOrFail($id);
        $facilitateur->prenom  = (empty($request->get('prenom'))) ? $facilitateur->prenom : $request->get('prenom');
        $facilitateur->nom  = (empty($request->get('nom'))) ? $facilitateur->nom : $request->get('nom');
        $facilitateur->email  = (empty($request->get('email'))) ? $facilitateur->email : $request->get('email');
        $facilitateur->portable  = (empty($request->get('portable'))) ? $facilitateur->portable : $request->get('portable');
        $facilitateur->photo  = (isset($file_name)) ? $file_name : $facilitateur->photo;
        $facilitateur->update();
        DB::table('facilitateurs')->where('user_id', $facilitateur->id)->update(['prenom' => $facilitateur->prenom]);
        DB::table('facilitateurs')->where('user_id', $facilitateur->id)->update(['nom' => $facilitateur->nom]);
        DB::table('facilitateurs')->where('user_id', $facilitateur->id)->update(['email' => $facilitateur->email]);
        DB::table('facilitateurs')->where('user_id', $facilitateur->id)->update(['phone' => $facilitateur->portable]);
        return redirect('/homeifacilitateurs')->with(['message' => $message]);   
    }
public function homeintervenant()
{
    $intervenant = DB::table('intervenants')->where('user_id', Auth::user()->id)->first();

    $interventions = DB::table('interventions')->select('activites.libelle', 'activites.date', 'activites.heure_debut', 'activites.heure_fin',  'activites.join_url', 'activites.password', 'intervenants.id', 'intervenants.prenom', 'intervenants.nom')
    ->join('activites', 'activites.id', 'interventions.activite_id')
    ->join('intervenants', 'intervenants.id', 'interventions.intervenant_id')
    ->where('intervenants.id', $intervenant->id)
    ->get();
    
    $activities = DB::table('activites')->get();
    
    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    return view('User.homeIntervenant', compact('pays', 'intervenant', 'interventions', 'activities'));
}
public function profilintervenant()
{
    $intervenant = DB::table('intervenants')->where('user_id', Auth::user()->id)->first();

    $interventions = DB::table('interventions')->select('activites.libelle', 'activites.date', 'activites.heure_debut', 'activites.heure_fin',  'activites.join_url', 'activites.password', 'intervenants.id', 'intervenants.prenom', 'intervenants.nom')
    ->join('activites', 'activites.id', 'interventions.activite_id')
    ->join('intervenants', 'intervenants.id', 'interventions.intervenant_id')
    ->where('intervenants.id', $intervenant->id)
    ->get();
    
    $activities = DB::table('activites')->get();
    
    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    return view('User.profilIntervenant', compact('pays', 'intervenant', 'interventions', 'activities'));
}
 public function editintervenant($id)
    {
        $intervenant = User::find($id);
        
        return view('User.editIntervenant', compact('intervenant'));
    }
public function updateintervenant(Request $request, $id)
    {
        if($request->file('pic')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
     $message = 'Profil modifié avec succès';
        $intervenant = User::findOrFail($id);
        $intervenant->prenom  = (empty($request->get('prenom'))) ? $intervenant->prenom : $request->get('prenom');
        $intervenant->nom  = (empty($request->get('nom'))) ? $intervenant->nom : $request->get('nom');
        $intervenant->email  = (empty($request->get('email'))) ? $intervenant->email : $request->get('email');
        $intervenant->portable  = (empty($request->get('portable'))) ? $intervenant->portable : $request->get('portable');
        $intervenant->photo  = (isset($file_name)) ? $file_name : $intervenant->photo;
        $intervenant->update();
        DB::table('intervenants')->where('user_id', $intervenant->id)->update(['prenom' => $intervenant->prenom]);
        DB::table('intervenants')->where('user_id', $intervenant->id)->update(['nom' => $intervenant->nom]);
        DB::table('intervenants')->where('user_id', $intervenant->id)->update(['email' => $intervenant->email]);
        DB::table('intervenants')->where('user_id', $intervenant->id)->update(['phone' => $intervenant->portable]);
        
        return redirect('/homeintervenants')->with(['message' => $message]);   
    }
    
    public function hometraducteur()
{
    $traducteur = DB::table('traducteurs')->where('user_id', Auth::user()->id)->first();
    
    $interventions = DB::table('interventions')->select('activites.libelle', 'activites.date', 'activites.heure_debut', 'activites.heure_fin',  'activites.join_url', 'activites.password', 'traducteurs.id', 'traducteurs.prenom', 'traducteurs.nom')
    ->join('activites', 'activites.id', 'interventions.activite_id')
    ->join('traducteurs', 'traducteurs.id', 'interventions.traducteur_id')
    ->where('traducteurs.id', $traducteur->id)
    ->get();
    
    $traductions = DB::table('traducteurs')->where('id', Auth::user()->id)->first();
    if($traductions)
    $planing = DB::table('plannings')->where('traducteur_id', $traductions->id)->get();
    else
    $planing = DB::table('plannings')->get();
    
    $traducteurs = DB::table('traducteurs')->get();
    return view('User.homeTraducteur', compact('traducteurs', 'interventions', 'planing'));
}

 public function edittraducteur($id)
    {
        $traducteur = User::find($id);
        
        return view('User.editTraduction', compact('traducteur'));
    }
public function updatetraducteur(Request $request, $id)
    {
        if($request->file('photo')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
        $message = 'Profil modifié avec succès';
        $traducteur = User::findOrFail($id);
        $traducteur->prenom  = (empty($request->get('prenom'))) ? $traducteur->prenom : $request->get('prenom');
        $traducteur->nom  = (empty($request->get('nom'))) ? $traducteur->nom : $request->get('nom');
        $traducteur->email  = (empty($request->get('email'))) ? $traducteur->email : $request->get('email');
        $traducteur->portable  = (empty($request->get('portable'))) ? $traducteur->portable : $request->get('portable');
        $traducteur->photo  = (isset($file_name)) ? $file_name : $traducteur->photo;
        $traducteur->update();
        DB::table('traducteurs')->where('user_id', $traducteur->id)->update(['prenom' => $traducteur->prenom]);
        DB::table('traducteurs')->where('user_id', $traducteur->id)->update(['nom' => $traducteur->nom]);
        DB::table('traducteurs')->where('user_id', $traducteur->id)->update(['email' => $traducteur->email]);
        DB::table('traducteurs')->where('user_id', $traducteur->id)->update(['tel' => $traducteur->portable]);
        
        return redirect('/hometraducteurs')->with(['message' => $message]);   
    }
public function homeorganisateur()
{
    return view('User.homeOrganisateur');
}
 public function editorganisateur($id)
    {
        $organisateur = User::find($id);
        
        return view('User.editOrganisateur', compact('organisateur'));
    }
public function updateorganisateur(Request $request, $id)
    {
        if($request->file('pic')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
        $message = 'Profil modifié avec succès';
        $organisateur = User::findOrFail($id);
        $organisateur->prenom  = (empty($request->get('prenom'))) ? $organisateur->prenom : $request->get('prenom');
        $organisateur->nom  = (empty($request->get('nom'))) ? $organisateur->nom : $request->get('nom');
        $organisateur->email  = (empty($request->get('email'))) ? $organisateur->email : $request->get('email');
        $organisateur->portable  = (empty($request->get('portable'))) ? $organisateur->portable : $request->get('portable');
        $organisateur->photo  = (isset($file_name)) ? $file_name : $organisateur->photo;
        $organisateur->update();
        DB::table('organisateurs')->where('user_id', $organisateur->id)->update(['prenom' => $organisateur->prenom]);
        DB::table('organisateurs')->where('user_id', $organisateur->id)->update(['nom' => $organisateur->nom]);
        DB::table('organisateurs')->where('user_id', $organisateur->id)->update(['email' => $organisateur->email]);
        DB::table('organisateurs')->where('user_id', $organisateur->id)->update(['portable' => $organisateur->portable]);
        
        return redirect('/homeorganisateurs')->with(['message' => $message]);   
    }

public function homeinscription(Request $request)
    {
    
        $event =  DB::table('events')->where('status', 1 )->first();
    
        $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
        
        if($entreprise)
            $entreprise_id = $entreprise->id;
        
        $plannings = array();
        $plannings_rvs = array();
        if($event->phase == 4){
            $planningss = DB::table('plannings')->where('entreprise_rv_id', $entreprise_id)->get();
            $input = array();
            
            $planningss_rvss = DB::table('plannings_rvs')->where('entreprise_rv_id', $entreprise_id)->get();
            $inputs = array();
           
            if($planningss)
                foreach($planningss as $planning)
                    if(!in_array($planning->entreprise_id, $input)){
                        array_push($input, $planning->entreprise_id);
                        array_push($plannings, $planning);  
                    }
                    
        
        
           
            if($planningss_rvss)
                foreach($planningss_rvss as $planning_rv)
                    if(!in_array($planning_rv->entreprise_id, $inputs)){
                        array_push($inputs, $planning_rv->entreprise_id);
                        array_push($plannings_rvs, $planning_rv);  
                    }
                    
        }
      
        $activites = DB::table('activites')->get();
        
        return view('User.homeInscription',compact('activites','plannings','plannings_rvs'));
    }
    
    
//M.A.X B.I.R.D WAS HERE    
public function annuler_rendez_vous($type, $id){
    
    
    DB::table($type)
    ->where($type.'.id', $id)
    ->update(['status_rv' => 1]);
    
    $message = "Rendez-vous annuler avec succés !"; 
    
    return redirect('/home')->with(['message' => $message]);
    
}
 
 public function reactiver_rendez_vous($type, $id){
    
    
   DB::table($type)
    ->where($type.'.id', $id)
    ->update(['status_rv' => 0]);
    
    $message = "Rendez-vous réactiver avec succés !"; 
    
    return redirect('/home')->with(['message' => $message]);
    
}   
    
public function participantsecond()
{
        return view('User.participantsecond');
}

public function homesuggestion()
{
    return view('User.homeSuggestion');
}
public function homepsecondaire()
{
    
    $event =  DB::table('events')->where('status', 1 )->first();
    
        $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
        
        //if($entreprise)
           // $entreprise_id = $entreprise->id;
        
        ///$plannings = array();
        //if($event->phase == 4){
           // $planningss = DB::table('plannings')->where('entreprise_rv_id', $entreprise_id)->get();
            //$input = array();
        
           
          //  if($planningss)
                //foreach($planningss as $planning)
                    //if(!in_array($planning->entreprise_id, $input)){
                       // array_push($input, $planning->entreprise_id);
                       // array_push($plannings, $planning);  
                   // }
        //}
        $activites = DB::table('activites')->get();
        
        return view('User.homePSecondaire',compact('activites'));
}
public function homepreinscrit()
{
        return view('User.homePreInscrit');
}

public function profilps()
{
    $particip = DB::table('participants')->where('user_id', Auth::user()->id)->first();
    $p_entreprise = DB::table('entreprises')->where('id', $particip->entreprise_id)->first();
    $p_pays = DB::table('pays')->where('id', $particip->pays_id)->first();
        return view('User.profil2', compact('p_entreprise', 'p_pays'));
}
 public function editprofilps($id)
    {
        $profilps = User::find($id);
        
        return view('User.editprofilps', compact('profilps'));
    }

public function updateps(Request $request, $id)
    {
        if($request->file('pic')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
     $message = 'Profil modifié avec succès';
        $profilps = User::findOrFail($id);
        $profilps->prenom  = (empty($request->get('prenom'))) ? $profilps->prenom : $request->get('prenom');
        $profilps->nom  = (empty($request->get('nom'))) ? $profilps->nom : $request->get('nom');
        $profilps->email  = (empty($request->get('email'))) ? $profilps->email : $request->get('email');
        $profilps->portable  = (empty($request->get('portable'))) ? $profilps->portable : $request->get('portable');
        $profilps->photo  = (isset($file_name)) ? $file_name : $profilps->photo;
        $profilps->update();
        
        return redirect('/monprofil')->with(['message' => $message]);   
    }
    
    
//M.A.X B.I.R.D get handle
public function homecatalogue()
{
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaits = array();
    if(isset($entreprise_id)){
        $souhaits = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaits as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    $entreprises = DB::table('entreprise_rvs')->where('user_id', '<>', Auth::id() )->orderBy('nom_entreprise', 'asc')->get();
    
    return view('User.catalogue', compact('entreprises', 'input'));
}

public function homecatalogue_rvs()
{
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaits = array();
    if(isset($entreprise_id)){
        $souhaits = DB::table('souhaites_rvs')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits_rvs')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaits as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    $entreprises = DB::table('entreprise_rvs')->where('user_id', '<>', Auth::id() )->orderBy('nom_entreprise', 'asc')->get();
    
    return view('User.catalogue_rvs', compact('entreprises', 'input'));
}

public function filtre_catalogues(Request $request)
{
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaits = array();
    if(isset($entreprise_id)){
        $souhaits = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaits as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    $search_pays = $request->get('filtre_catalogues_pays'); 
    $secteur_a = $request->get('secteur_a');
    $profile_entreprise_a = $request->get('profile_entreprise_a');
   
    
    $entreprises = DB::table('entreprise_rvs')->where('user_id', '<>', Auth::id())
    ->where('pays', 'like', '%'.$search_pays.'%')
    ->where('secteur_a', 'like', '%'.$secteur_a.'%')
    ->where('profile_entreprise_a', 'like', '%'.$profile_entreprise_a.'%')
   ->orderBy('nom_entreprise', 'asc')
     ->paginate(30);
     //dd($entreprises);
    return view('User.catalogue', compact('entreprises', 'input'));
}




public function homecataloguepsecondaire()
{
    
    return view('User.cataloguePSecondaire');
}

public function review_catalogue(Request $request)
{
    $input = $request->all();

    $output = "";
    
    $venturas = "";
    $pays = "";
    $secteurs = "";
    $profils = "";

    $entreprises = DB::table('entreprise_rvs')->where('user_id' ,'<>', Auth::id())->get();

    if(strlen($request->search) >= 2){
        foreach($entreprises as $entreprise){
            $filter = $entreprise->nom_entreprise;
            if(stristr($filter, $request->search)){
                if(in_array($entreprise->id, $input))
                    $add = "<input type='submit' id='p1' style='background: #7f8c8d; color:white' class='btn btn-default' value='Ajouter' disabled></button>";
                else
                    $add = "<input type='submit' id='p1' class='btn btn-primary' value='Ajouter'/>";

                $venturas .= 
                    " <tr>
                                                        
                        <td><a href='#'>". $entreprise->nom_entreprise ."</a></td>
                        
                        <td>". $entreprise->pays ."</td>
                    
                        <td>" . $entreprise->secteur_a . "</td>
                        
                        <td>" . $entreprise->profile_entreprise_a . "</td>
                                        
                        <td>
                        
                            <form method='POST' action='" . route('ajouter.suggestion', $entreprise->id). "'>"
                                . csrf_field() 
                                . " " .
                                $add ."
                                
                            </form>

                        </td>

                    </tr>
                    ";
            }
            $filter = $entreprise->secteur_a ." ". $entreprise->secteur_b ." ". $entreprise->secteur_c ;
            if(stristr($filter, $request->search)){
                if(in_array($entreprise->id, $input))
                    $add = "<input type='submit' id='p1' style='background: #7f8c8d; color:white' class='btn btn-default' value='Ajouter' disabled></button>";
                else
                    $add = "<input type='submit' id='p1' class='btn btn-primary' value='Ajouter'/>";

                $secteurs .= 
                    " <tr>
                                                        
                        <td><a href='#'>". $entreprise->nom_entreprise ."</a></td>
                        
                        <td>". $entreprise->pays ."</td>
                    
                        <td>" . $entreprise->secteur_a . "</td>
                        
                        <td>" . $entreprise->profile_entreprise_a . "</td>
                                        
                        <td>
                        
                            <form method='POST' action='" . route('ajouter.suggestion', $entreprise->id). "'>"
                                . csrf_field() 
                                . " " .
                                $add ."
                                
                            </form>

                        </td>

                    </tr>
                    ";
            }
            $filter = $entreprise->pays;
            if(stristr($filter, $request->search)){
                if(in_array($entreprise->id, $input))
                    $add = "<input type='submit' id='p1' style='background: #7f8c8d; color:white' class='btn btn-default' value='Ajouter' disabled></button>";
                else
                    $add = "<input type='submit' id='p1' class='btn btn-primary' value='Ajouter'/>";

                $pays .= 
                    " <tr>
                                                        
                        <td><a href='#'>". $entreprise->nom_entreprise ."</a></td>
                        
                        <td>". $entreprise->pays ."</td>
                    
                        <td>" . $entreprise->secteur_a . "</td>
                        
                        <td>" . $entreprise->profile_entreprise_a . "</td>
                                        
                        <td>
                        
                            <form method='POST' action='" . route('ajouter.suggestion', $entreprise->id). "'>"
                                . csrf_field() 
                                . " " .
                                $add ."
                                
                            </form>

                        </td>

                    </tr>
                    ";
            }
            $filter = $entreprise->profile_entreprise_a ." ". $entreprise->profile_entreprise_b ." ". $entreprise->profile_entreprise_c ;
            if(stristr($filter, $request->search)){
                if(in_array($entreprise->id, $input))
                    $add = "<input type='submit' id='p1' style='background: #7f8c8d; color:white' class='btn btn-default' value='Ajouter' disabled></button>";
                else
                    $add = "<input type='submit' id='p1' class='btn btn-primary' value='Ajouter'/>";

                $profils .= 
                    " <tr>
                                                        
                        <td><a href='#'>". $entreprise->nom_entreprise ."</a></td>
                        
                        <td>". $entreprise->pays ."</td>
                    
                        <td>" . $entreprise->secteur_a . "</td>
                        
                        <td>" . $entreprise->profile_entreprise_a . "</td>
                                        
                        <td>
                        
                            <form method='POST' action='" . route('ajouter.suggestion', $entreprise->id). "'>"
                                . csrf_field() 
                                . " " .
                                $add ."
                                
                            </form>

                        </td>

                    </tr>
                    ";
            }

        }

    }

    if($venturas != "" || $pays != "" || $secteurs != "" || $profils != ""){
        if($venturas != "")
            $output .= "<tr><td colspan='6' style='color:#6C757D; font-weight:bold'><i class='fa fa-building'></i>&nbsp;Entreprises</td></tr>" . $venturas;
        if($pays != "")
            $output .= "<tr><td colspan='6' style='color:#6C757D; font-weight:bold'><i class='fa fa-flag'></i>&nbsp;Pays</td></tr>" . $pays;  
        if($secteurs != "")
            $output .= "<tr><td colspan='6' style='color:#6C757D; font-weight:bold'><i class='fa fa-cogs'></i>&nbsp;Secteurs</td></tr>" . $secteurs;
        if($profils != "")
            $output .= "<tr><td colspan='6' style='color:#6C757D; font-weight:bold'><i class='fa fa-id-badge'></i>&nbsp;Profils</td><tr>" . $profils;
        return $output; 
        console.log($output);
    }else 
        return "<td colspan='4' style='color:#6C757D; font-weight:bold'>No matches <i class='fa fa-bomb'></i> </td>";

         
    }

public function generate_creneau(){
    $event =  DB::table('events')->where('status', 1 )->first();

    $time = '10/15/2021 09:00';
    $pause = '10/15/2021 13:30'; //stop 13H30 and continue at 14H30
    $limit = '10/15/2021 18:00';
    
    $rooom_id = 0;

    $time = strtotime($time);
    $pause = strtotime($pause);
    $limit = strtotime($limit);
    $max_table = 3;  
    
    $heure_fin = date('H:i', $time);

    $salles = DB::table('salles')->get();
    
    for($i=1; $i<=$max_table; $i++){
        $time = '10/15/2021 09:00';
        $time = strtotime($time);
        //One table iteration
        while($time != $limit){
            $libelle_t = "Table " . $i;
         
            $heure_deb = date('H:i', $time);
            $time += 1800;
            $heure_fin = date('H:i', $time);
            
            $lag_meet = 0;
            
            $day = date('Y-m-d', $time); 
            $start_time = date('Y-m-d H:i:s', $time) ; 
            
            //Create meet zoom 
            $data = array();
            $data['start_time'] = $start_time;
            $data['topic'] = $event->nom_event_fr .' : '. $salles[$rooom_id]->libelle . ' - ' .  $libelle_t;
            $data['duration'] = 30;
            $data['host_video']  = 1;
            $data['participant_video']  = 1;

            
            if($time != $pause ){
                $meet = $this->created($data);
                dd($meet);

                DB::table('creneaus')->insert([
                    ['libelle_t' => $libelle_t, 'sale_id' => $salles[$rooom_id]->id, 'event_id' => $event->id, 'date_c' => $day, 'heure_deb' => $heure_deb, 'heure_fin' => $heure_fin, 'start_url' => $meet['data']['start_url'], 'join_url' => $meet['data']['join_url'], 'password' => $meet['data']['password'], 'duration' => 30]
                ]);
                sleep(1);   
            }
            else{
                $heure_fin = date('H:i', $time);
                $heure_deb = date('H:i', $time - 1800);
                $time += 3600; 
                DB::table('creneaus')->insert([
                    ['libelle_t' => $libelle_t, 'sale_id' => $salles[$rooom_id]->id, 'event_id' => $event->id, 'date_c' => $day, 'heure_deb' => $heure_deb, 'heure_fin' => $heure_fin, 'start_url' => $meet['data']['start_url'], 'join_url' => $meet['data']['join_url'], 'password' => $meet['data']['password'], 'duration' => 30]
                ]);
                sleep(1);  
            }
                
            echo "Start Hour : " . $heure_deb . "<br>";
            echo "End Hour : " . $heure_fin . "<br>";
            
        }
    }
    //END ITERATION FOR ONE ROOM
    echo "Generation appointment done successfully for rooom  " . $salles[$rooom_id]->libelle;
   
}

public function index()
{
    return view('Admin/Dashboard.index');
}
public function inscription()
{
    $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
    $langue= DB::table('langues')->orderby('libelle_eng', 'asc')->get();
    return view('User.inscription', compact('pays', 'langue'));
}
public function inscriptionSansEnt()
{
    $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
    $langue= DB::table('langues')->orderby('libelle_eng', 'asc')->get();
    return view('User.inscriptionSansEnt', compact('pays', 'langue'));
}
public function inscriptionstep0()
{
    return view('User.inscriptionStep0');
}
public function inscriptionstep1()
{
    return view('User.inscriptionStep1');
}
public function inscriptionstep2()
{
    $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();
        $secteur= DB::table('secteur_activites')->orderBy('libelle')->get();
        $profil= DB::table('profils')->orderBy('libelle')->get();
        $villages= DB::table('villages')->get();
        $badges= DB::table('badges')->get();
    return view('User.inscriptionStep2', compact( 'pays', 'secteur', 'profil', 'villages', 'badges'));
}

public function inscriptionstep2visit()
{
    $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();
        $secteur= DB::table('secteur_activites')->orderBy('libelle')->get();
        $profil= DB::table('profils')->orderBy('libelle')->get();
        $villages= DB::table('villages')->get();
        $badges= DB::table('badges')->get();
    return view('User.inscriptionStep2visit', compact( 'pays', 'secteur', 'profil', 'villages', 'badges'));
}
  public function inscriptionstep3()
{
        $secteur= DB::table('secteur_activites')->orderBy('libelle')->get();
        $profil= DB::table('profils')->orderBy('libelle')->get();
    return view('User.inscriptionStep3', compact('secteur', 'profil'));
}
public function inscriptionstep4()
{
    return view('User.inscriptionStep4');
}

//M.A.X B.I.R.D was here
public function editprofil($id)
{
    $monprofil = User::find($id);
    $langages = DB::table('langues')
                ->where('langues.libelle_eng','Francais')
                ->orWhere('langues.libelle_eng','Anglais')
                ->get();
    
    return view('User.editProfil', compact('monprofil', 'langages'));
}

public function update(Request $request, $id)
{
    if($request->file('photo')){
       $photo = $request->file('photo');
       $file_name = $photo->getClientOriginalName();
       $photo->move(public_path().'/image/', $file_name);
    }
    
    $message = 'Profil modifié avec succès';
    $monprofil = User::findOrFail($id);
    $monprofil->prenom  = (empty($request->get('prenom'))) ? $monprofil->prenom : $request->get('prenom');
    $monprofil->nom  = (empty($request->get('nom'))) ? $monprofil->nom : $request->get('nom');
    $monprofil->email  = (empty($request->get('email'))) ? $monprofil->email : $request->get('email');
    $monprofil->portable  = (empty($request->get('portable'))) ? $monprofil->portable : $request->get('portable');
    $monprofil->langue_id  = (empty($request->get('langage_system'))) ? $monprofil->langue_id : $request->get('langage_system');
    $monprofil->photo  = (isset($file_name)) ? $file_name : $monprofil->photo;
    $monprofil->update();
    DB::table('participants')->where('user_id', $monprofil->id)->update(['prenom' => $monprofil->prenom]);
    DB::table('participants')->where('user_id', $monprofil->id)->update(['nom' => $monprofil->nom]);
    DB::table('participants')->where('user_id', $monprofil->id)->update(['email' => $monprofil->email]);
    DB::table('participants')->where('user_id', $monprofil->id)->update(['tel_part' => $monprofil->portable]);
    
    if(!empty($request->get('fonction'))){
        DB::table('participants')
          ->where('user_id', Auth::id())
          ->update(['fonction' => $request->get('fonction')]); 
    }
    
    return redirect('/monprofils')->with(['message' => $message]);   
}

public function editsettings($id){
     $monprofil = User::find($id);

    return view('User.settings', compact('monprofil'));
}

public function settingsupdate(Request $request, $id)
{
    $message = 'Mot de passe  modifié avec succès';
    $monprofil = User::findOrFail($id);   
    $monprofil->password = Hash::make($request->get('password'));
    $monprofil->update();
    return redirect('/monprofils')->with(['message' => $message]);  
}

public function monentreprise()
    {
        $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        $participants = DB::table('participants')->where('entreprise_id', $nomentreprise->id)->get();
        $pays = DB::table('entreprises')->where('user_id', Auth::id())->first();
            return view('User.monEntreprise', compact('fonction', 'nomentreprise', 'pays', 'participants'));
    }
    
    public function mesdemandesb2b()
    {
        $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        $participants = DB::table('participants')->where('entreprise_id', $nomentreprise->id)->get();
        $pays = DB::table('entreprises')->where('user_id', Auth::id())->first();
            return view('User.demandeb2b', compact('fonction', 'nomentreprise', 'pays', 'participants'));
    }
    
     public function mesdemandesb2bedit($id)
    {
        $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        $participants = DB::table('participants')->where('entreprise_id', $nomentreprise->id)->get();
        $pays = DB::table('entreprises')->where('user_id', Auth::id())->first();
        $entreprise = Entreprise::find($id);
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
        return view('User.demandeb2bedit', compact('fonction', 'nomentreprise', 'pays', 'participants', 'entreprise','secteur','profil'));
    }
    
    public function mesdemandesb2bupdate(Request $request, $id)
    {
        $message = "Modifieé avec succès";

        $entreprises = Entreprise::findOrFail($id);
        $entreprises->partenaire_rencontrer_a = $request->get('partenaire_rencontrer_a');
        $entreprises->partenaire_rencontrer_b = $request->get('partenaire_rencontrer_b');
        $entreprises->partenaire_rencontrer_c = $request->get('partenaire_rencontrer_c');
        $entreprises->profile_partenaire_rechercher_a = $request->get('profile_partenaire_rechercher_a');
        $entreprises->profile_partenaire_rechercher_b = $request->get('profile_partenaire_rechercher_b');
        $entreprises->profile_partenaire_rechercher_c = $request->get('profile_partenaire_rechercher_c');
        $entreprises->partenaire_rechercher = $request->get('partenaire_rechercher');
        $entreprises->save();
        
       
        return redirect('/mesdemandesb2b')->with(['message' => $message]);

    }
    
public function voirmesparticipants()
    {
        $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        $participants = DB::table('participants')->where('entreprise_id', $nomentreprise->id)->get();
        $pays = DB::table('entreprises')->where('user_id', Auth::id())->first();
            return view('User.voirmesparticipants', compact('fonction', 'nomentreprise', 'pays', 'participants'));
    }
public function sonentreprise()
    {
        $parti = DB::table('participants')->where('user_id', Auth::user()->id)->first();
        $p_pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
            return view('User.sonEntreprise', compact('p_pays', 'parti'));
    }
    
public function editentreprise($id)
    {
        $monentreprise = Entreprise::find($id);

        return view('User.editEntreprise', compact('monentreprise'));
    }
    
public function updates(Request $request, $id) 
    {
        if($request->file('photos')){
           $photo = $request->file('photos');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/photos/', $file_name);
        }
        
        $message = 'Entreprise modifiée avec succès';
        $monentreprise = Entreprise::findOrFail($id);
        $monentreprise->nom_entreprise = (empty($request->get('nom_entreprise'))) ? $monentreprise->nom_entreprise : $request->get('nom_entreprise');
        $monentreprise->site = (empty($request->get('site'))) ? $monentreprise->site : $request->get('site');
        $monentreprise->tel_entreprise = (empty($request->get('tel_entreprise'))) ? $monentreprise->tel_entreprise : $request->get('tel_entreprise');
        $monentreprise->slogan = (empty($request->get('slogan'))) ? $monentreprise->slogan : $request->get('slogan');
        $monentreprise->photos  = (isset($file_name)) ? $file_name : $monentreprise->photos;                
        $monentreprise->update();
       
        return redirect('/monentreprises')->with(['message' => $message]);   
    }
    //ajouter PARTICIPANTS
     public function create()
    {
        return view('User.ajouterparticipant');
    }
    public function store(Request $request)
    {
        request()->validate([
           'email' => 'required|email|unique:users,email',
            //'email_confirmation' => 'required'
             
    ]);
        $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        
        $event = DB::table('events')->where('status','=', 1)->first();
        
        $message = 'Participant ajoute avec succes';
        
        $user = new User;
        $user->prenom = $request->get('prenom');
        $user->nom = $request->get('nom');
        $user->email = $request->get('email');
        $user->portable = $request->get('tel_part');

        //Password not hached
        $pass = Str::random(5);
    
        $user->password = Hash::make($pass);
        $user->event_id = $event->id;
    
        if($user->save())
            {
           
        $participant = new Participant;
        $participant->nom = $request->get('nom');
        $participant->prenom = $request->get('prenom');
        $participant->email = $request->get('email');
        $participant->fonction = $request->get('fonction');
        $participant->entreprise_id = $entreprise->id;
        $participant->event_id = $event->id;
        $participant->tel_part = $user->tel_part;
        $participant->user_id = $user->id;
        $participant->save();
        
         \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            //return redirect('/monentreprises');
            return back()->with(['message' => $message]);
        }
    else
        {
            flash('User not saved')->error();
        }
        
        //return redirect('/monentreprises')->with(['message' => $message]);
        return back()->with(['message' => $message]);

    }
     public function modifier($id)
    {
        $mesparticipant = Participant::find($id);
        
        return view('User.editparticipant', compact('mesparticipant'));
    }

public function updatess(Request $request, $id)
    {
        $message = 'Participant modifiÃ© avec succÃ©s';
        $mesparticipant = Participant::findOrFail($id);
        $mesparticipant->prenom  = (empty($request->get('prenom'))) ? $mesparticipant->prenom : $request->get('prenom');
        $mesparticipant->nom  = (empty($request->get('nom'))) ? $mesparticipant->nom : $request->get('nom');
        $mesparticipant->email  = (empty($request->get('email'))) ? $mesparticipant->email : $request->get('email');
        $mesparticipant->update();
        DB::table('users')->where('id', $mesparticipant->user_id)->update(['prenom' => $mesparticipant->prenom]);
        DB::table('users')->where('id', $mesparticipant->user_id)->update(['nom' => $mesparticipant->nom]);
        DB::table('users')->where('id', $mesparticipant->user_id)->update(['email' => $mesparticipant->email]);
        return redirect('/monentreprises')->with(['message' => $message]);   
    }

public function destroy($id) //supprimer 
    {
        $mesparticipant = Participant::find($id);
        $mesparticipant->delete();
DB::table('users')->where('id', $mesparticipant->user_id)->delete();
        return back()->with('info', "Participant a été bien supprimé dans la base de donnée.");
    }
//  public function creates()
//     {
//         return view('User.ajouterentreprise');
//     }
//     public function stores(Request $request)
//     {
//         $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
//         $message = 'Participant ajoutÃ©e avec succÃ©s';
//         $participant = new Participant;
//         $participant->nom = $request->get('nom');
//         $participant->prenom = $request->get('prenom');
//         $participant->email = $request->get('email');
//         $participant->entreprise_id = $entreprise->id;
//         $participant->save();
//         return redirect('/madelegations')->with(['message' => $message]);

//     }
//profil
public function monprofil()
{
    $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
    $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
        return view('User.monProfil', compact('fonction', 'nomentreprise', 'pays'));
}
public function monprofile()
{
    $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
    $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
        return view('User.monProfil3', compact('fonction', 'nomentreprise', 'pays'));
}

public function messuggestion()
{
    
    $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    
    $event = DB::table('events')->where('status', 1 )->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaites = array();
    $accepted = array();
    if(isset($entreprise_id)){
        $souhaites = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaites as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
   
    $souhaits = array(); 
    $suggestions = array(); 
    $suggestion_all = array();
    $draft_suggestions = array(); 
    $one_bunch = array();
    $two_bunch = array();
    $three_bunch = array();
    $four_bunch = array();
    $five_bunch = array();
    $six_bunch = array();
    $seven_bunch = array();
   
    $others = array();
    
    if($event->phase == 2){
        if(isset($entreprise_id)){
            
            $souhaits = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 1)->limit(20);
            
            $draft_suggestions = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 0)->get();
            foreach($draft_suggestions as $suggestion){
                $suggestion_enterprise = DB::table('entreprises')->where('id', $suggestion->entreprise_id)->first();
            
                if($entreprise->secteur_a == $suggestion_enterprise->secteur_a){
                    if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($one_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($two_bunch, $suggestion);
                        else
                            array_push($three_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($four_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($five_bunch, $suggestion);
                        else
                            array_push($six_bunch, $suggestion);
                    else
                        array_push($three_bunch, $suggestion);

                }else if($entreprise->secteur_a == $suggestion_enterprise->secteur_b){
                     if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($two_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($three_bunch, $suggestion);
                        else
                            array_push($four_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($five_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($six_bunch, $suggestion);
                        else
                            array_push($seven_bunch, $suggestion);
                    else
                        array_push($four_bunch, $suggestion);
                }
                else{
                    array_push($others, $suggestion);
                }
                
                
            }

            $all = array_merge($one_bunch, $two_bunch, $three_bunch, $four_bunch, $five_bunch, $six_bunch, $seven_bunch, $others);
            foreach($all as $key => $suggestion){
                if($key == 20)
                    break;
                array_push($suggestions,$suggestion);
                
            }
        }
    }
    
    return view('User.mesSuggestions', compact('souhaits','suggestions', 'input'));
}

public function listeSuggestions()
{
    
    $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    
    $event = DB::table('events')->where('status', 1 )->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaites = array();
    $accepted = array();
    if(isset($entreprise_id)){
        $souhaites = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaites as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
   
    $souhaits = array(); 
    $suggestions = array(); 
    $suggestion_all = array();
    $draft_suggestions = array(); 
    $one_bunch = array();
    $two_bunch = array();
    $three_bunch = array();
    $four_bunch = array();
    $five_bunch = array();
    $six_bunch = array();
    $seven_bunch = array();
   
    $others = array();
    
    if($event->phase == 2){
        if(isset($entreprise_id)){
            
            $souhaits = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 1)->limit(20);
            
            $draft_suggestions = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 0)->get();
            foreach($draft_suggestions as $suggestion){
                $suggestion_enterprise = DB::table('entreprises')->where('id', $suggestion->entreprise_id)->first();
            
                if($entreprise->secteur_a == $suggestion_enterprise->secteur_a){
                    if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($one_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($two_bunch, $suggestion);
                        else
                            array_push($three_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($four_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($five_bunch, $suggestion);
                        else
                            array_push($six_bunch, $suggestion);
                    else
                        array_push($three_bunch, $suggestion);

                }else if($entreprise->secteur_a == $suggestion_enterprise->secteur_b){
                     if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($two_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($three_bunch, $suggestion);
                        else
                            array_push($four_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($five_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($six_bunch, $suggestion);
                        else
                            array_push($seven_bunch, $suggestion);
                    else
                        array_push($four_bunch, $suggestion);
                }
                else{
                    array_push($others, $suggestion);
                }
                
                
            }

            $all = array_merge($one_bunch, $two_bunch, $three_bunch, $four_bunch, $five_bunch, $six_bunch, $seven_bunch, $others);
            foreach($all as $key => $suggestion){
                if($key == 20)
                    break;
                array_push($suggestions,$suggestion);
                
            }
        }
    }
    
    return view('User.listeSuggestions', compact('souhaits','suggestions', 'input'));
}


public function demandesFaites()
{
    
    $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    
    $event = DB::table('events')->where('status', 1 )->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaites = array();
    $accepted = array();
    if(isset($entreprise_id)){
        $souhaites = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaites as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
   
    $souhaits = array(); 
    $suggestions = array(); 
    $suggestion_all = array();
    $draft_suggestions = array(); 
    $one_bunch = array();
    $two_bunch = array();
    $three_bunch = array();
    $four_bunch = array();
    $five_bunch = array();
    $six_bunch = array();
    $seven_bunch = array();
   
    $others = array();
    
    if($event->phase == 2){
        if(isset($entreprise_id)){
            
            $souhaits = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 1)->limit(20);
            
            $draft_suggestions = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 0)->get();
            foreach($draft_suggestions as $suggestion){
                $suggestion_enterprise = DB::table('entreprises')->where('id', $suggestion->entreprise_id)->first();
            
                if($entreprise->secteur_a == $suggestion_enterprise->secteur_a){
                    if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($one_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($two_bunch, $suggestion);
                        else
                            array_push($three_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($four_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($five_bunch, $suggestion);
                        else
                            array_push($six_bunch, $suggestion);
                    else
                        array_push($three_bunch, $suggestion);

                }else if($entreprise->secteur_a == $suggestion_enterprise->secteur_b){
                     if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($two_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($three_bunch, $suggestion);
                        else
                            array_push($four_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($five_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($six_bunch, $suggestion);
                        else
                            array_push($seven_bunch, $suggestion);
                    else
                        array_push($four_bunch, $suggestion);
                }
                else{
                    array_push($others, $suggestion);
                }
                
                
            }

            $all = array_merge($one_bunch, $two_bunch, $three_bunch, $four_bunch, $five_bunch, $six_bunch, $seven_bunch, $others);
            foreach($all as $key => $suggestion){
                if($key == 20)
                    break;
                array_push($suggestions,$suggestion);
                
            }
        }
    }
    
    return view('User.demandesFaites', compact('souhaits','suggestions', 'input'));
}


public function demandesRecues()
{
    
    $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    
    $event = DB::table('events')->where('status', 1 )->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaites = array();
    $accepted = array();
    if(isset($entreprise_id)){
        $souhaites = DB::table('souhaites')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaites as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
   
    $souhaits = array(); 
    $suggestions = array(); 
    $suggestion_all = array();
    $draft_suggestions = array(); 
    $one_bunch = array();
    $two_bunch = array();
    $three_bunch = array();
    $four_bunch = array();
    $five_bunch = array();
    $six_bunch = array();
    $seven_bunch = array();
   
    $others = array();
    
    if($event->phase == 2){
        if(isset($entreprise_id)){
            
            $souhaits = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 1)->limit(20);
            
            $draft_suggestions = DB::table('souhaits')->where('entreprise_rv_id', $entreprise_id)->where('status', 0)->get();
            foreach($draft_suggestions as $suggestion){
                $suggestion_enterprise = DB::table('entreprises')->where('id', $suggestion->entreprise_id)->first();
            
                if($entreprise->secteur_a == $suggestion_enterprise->secteur_a){
                    if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($one_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($two_bunch, $suggestion);
                        else
                            array_push($three_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($four_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_a)
                            array_push($five_bunch, $suggestion);
                        else
                            array_push($six_bunch, $suggestion);
                    else
                        array_push($three_bunch, $suggestion);

                }else if($entreprise->secteur_a == $suggestion_enterprise->secteur_b){
                     if($entreprise->profile_partenaire_rechercher_a)
                        if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($two_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_a == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($three_bunch, $suggestion);
                        else
                            array_push($four_bunch, $suggestion);
                    else if($entreprise->profile_partenaire_rechercher_b )
                        if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_a && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($five_bunch, $suggestion);
                        else if($entreprise->profile_partenaire_rechercher_b == $suggestion_enterprise->profile_entreprise_b && $entreprise->secteur_a == $suggestion_enterprise->secteur_b)
                            array_push($six_bunch, $suggestion);
                        else
                            array_push($seven_bunch, $suggestion);
                    else
                        array_push($four_bunch, $suggestion);
                }
                else{
                    array_push($others, $suggestion);
                }
                
                
            }

            $all = array_merge($one_bunch, $two_bunch, $three_bunch, $four_bunch, $five_bunch, $six_bunch, $seven_bunch, $others);
            foreach($all as $key => $suggestion){
                if($key == 20)
                    break;
                array_push($suggestions,$suggestion);
                
            }
        }
    }
    
    return view('User.demandesRecues', compact('souhaits','suggestions', 'input'));
}

public function messuggestion_rvs()
{
    
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
    
    $event =  DB::table('events')->where('status', 1 )->first();

    if($entreprise)
        $entreprise_id = $entreprise->id;
        
    $souhaites = array();
    $accepted = array();
    if(isset($entreprise_id)){
        $souhaites = DB::table('souhaites_rvs')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get();
        $accepted = DB::table('souhaits_rvs')->select('entreprise_rv_id')->where('entreprise_id', $entreprise_id)->where('status', 1)->get(); 
    }
    
    $input = array(); 
    foreach($souhaites as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
    foreach($accepted as $souhait)
        array_push($input, $souhait->entreprise_rv_id);
        
   
    $souhaits = array(); 
    $suggestions = array(); 
    
    if($event->phase == 2){
        if(isset($entreprise_id)){
            $souhaits = DB::table('souhaits_rvs')->where('entreprise_rv_id', $entreprise_id)->where('status', 1)->get();
            $suggestions = DB::table('souhaits_rvs')->where('entreprise_rv_id', $entreprise_id)->where('status', 0)->get();
        }
    }
    
    return view('User.mesSuggestions_rvs', compact('souhaits','suggestions', 'input'));
}

public function sessuggestion()
{
    $var = 'yt';
    dd($var);
    return view('User.sesSuggestions');
}

public function Alertersuggestion_rvs($id)
{
    $message = 'Alert a été envoyée avec success, vous pouvez maintenant ajouter, confimer et accepter vos suggestions automatique de rendez-vous, ';
    $event  = Event::findOrFail($id);
    $event->phase_rvs = 4;
    $event->save();
    
   $users = User::where('email', '=', 'fallou.g@illimitis.com')->orWhere('email', '=', 'axel.n@illimitis.com')
   ->orWhere('email', '=', 'gnagna.n@illimitis.com')->orWhere('email', '=', 'christianna.m@illimitis.com')
   ->orWhere('email', '=', 'mohamed.t@illimitis.com')
   ->get();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new BesoinDesRendezvousB2B($user, $event));
            
           
            
        }
        
    
        
    return redirect('/messuggestions_rvs')->with(['message' => $message]);
}


public function Validersuggestion($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhait::findOrFail($id);
    $souhait->status = 1;
    $souhait->etats = 1;
    $souhait->save();
    
    $entrepri = DB::table('entreprise_rvs')->where('user_id', '=', Auth::user()->id)->first();
    
    DB::table('souhaites')->insert(['entreprise_id' => $entrepri->id, 'entreprise_rv_id' => $souhait->entreprise_id, 'priorite' => 1, 'status' => 1, 'etats' => 0, 'user_id' => $entrepri->user_id]);

    return redirect()->back()->with(['message' => $message]);
}

public function Refusersuggestion($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhait::findOrFail($id);
    $souhait->status = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

public function besoin($id)
{
    $message = 'Bien Reçu';
    $planning  = Planning::findOrFail($id);
    $planning->status_rv = 4;
    $planning->save();
    
     $users = User::where('email', '=', 'fallou.g@illimitis.com')->orWhere('email', '=', 'axel.n@illimitis.com')
       ->orWhere('email', '=', 'gnagna.n@illimitis.com')->orWhere('email', '=', 'christianna.m@illimitis.com')
       ->orWhere('email', '=', 'mohamed.t@illimitis.com')
       ->get();
   $participant = DB::table('users')->where('id', $planning->user_id)->first();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new BesoinTraducteur($user, $event, $participant));
            
           
            
        }
    return back()->with(['message' => $message]);
}

public function besoin_rvs($id)
{
    $event =  DB::table('events')->where('status', 1 )->first();
    $message = 'Bien Reçu';
    $planning  = Plannings_rv::findOrFail($id);
    $planning->status_rv = 4;
    $planning->save();
    
    
    $users = User::where('email', '=', 'fallou.g@illimitis.com')->orWhere('email', '=', 'axel.n@illimitis.com')
       ->orWhere('email', '=', 'gnagna.n@illimitis.com')->orWhere('email', '=', 'christianna.m@illimitis.com')
       ->orWhere('email', '=', 'mohamed.t@illimitis.com')
       ->get();
   $participant = DB::table('users')->where('id', $planning->user_id)->first();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new BesoinTraducteur($user, $event, $participant));
            
           
            
        }
    return back()->with(['message' => $message]);
}


public function confirmer_souhait($id)
{
    $message = 'Valider avec success';
    $planning  = Planning_f::findOrFail($id);
    $planning->etats = 1;
    $planning->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function Notconfirmer_souhait($id)
{
    $message = 'Refuser avec success';
    $planning  = Planning_f::findOrFail($id);
    $planning->etats = 0;
    $planning->save();
    return redirect()->back()->with(['message' => $message]);
}

public function Validersuggestion_rvs($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhaits_rv::findOrFail($id);
    $souhait->status = 1;
    $souhait->etats = 1;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

public function Refusersuggestion_rvs($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhaits_rv::findOrFail($id);
    $souhait->status = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}


public function confirmer_souhait_rvs($id)
{
    $message = 'Valider avec success';
    $planning  = Plannings_f_rv::findOrFail($id);
    $planning->etats = 1;
    $planning->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function Notconfirmer_souhait_rvs($id)
{
    $message = 'Refuser avec success';
    $planning  = Plannings_f_rv::findOrFail($id);
    $planning->etats = 0;
    $planning->save();
    return redirect()->back()->with(['message' => $message]);
}

//In case we need to add manually a wish 
public function Ajoutersuggestion($entreprise_rv_id)
{
    $message = 'Souhait manuellement ajouter avec succÃ©s';
    
    $souhait = new Souhaite;
    
    $event =  DB::table('events')->where('status', 1 )->first();
    $souhait->event_id = $event->id;
    
    //
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
    $souhait->entreprise_id = $entreprise->id;
    
    $rec = DB::table('entreprise_rvs')->where('id', $souhait->entreprise_id)->first();
    $souhait->user_id = $rec->user_id;
    
    $souhait->entreprise_rv_id = $entreprise_rv_id;
    
    //$souhait->entreprise_rv_id = $entreprise->id;
    
    $souhait->priorite = 1;
    
    $souhait->status = 1;

    $souhait->save(); 
    
    return redirect()->back()->with(['message' => $message]);
}


public function Ajoutersuggestion_rvs($entreprise_rv_id)
{
    $message = 'Souhait manuellement ajouter avec succÃ©s';
    
    $souhait = new Souhaites_rv;
    
    $event =  DB::table('events')->where('status', 1 )->first();
    $souhait->event_id = $event->id;
    
    //
    $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
    $souhait->entreprise_id = $entreprise->id;
    
    $rec = DB::table('entreprise_rvs')->where('id', $souhait->entreprise_id)->first();
    $souhait->user_id = $rec->user_id;
    
    $souhait->entreprise_rv_id = $entreprise_rv_id;
    
    //$souhait->entreprise_rv_id = $entreprise->id;
    
    $souhait->priorite = 1;
    
    $souhait->status = 1;
    $souhait->etats = 1;  
    
    $souhait->save(); 
    
    return redirect()->back()->with(['message' => $message]);
}

public function saveinscription(Request $request)
{
    request()->validate([
            'email' => 'required|email|unique:users,email|confirmed',
            'email_confirmation' => 'required'
             
    ]);
   
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1 )->first();

    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('portable');
    
    //Password not hached
    $pass = Str::random(5);

    $user->password = Hash::make($pass);
    $user->pays_id = $request->get('pays_id');
    $user->langue_id = $request->get('langue_id');
    $user->admin = $request->get('admin');
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;
    $user->profil = 1;
    $user->need = 1;

    if($user->save())
        {
            Auth::login($user);
            
        $message = 'Participant ajouté avec succès';
        $participant = new Participant;
        $participant->nom = Auth::user()->nom;
        $participant->prenom = Auth::user()->prenom;
        $participant->email = Auth::user()->email;
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = Auth::user()->portable;
        $participant->langue_id = Auth::user()->langue_id;
        $participant->pays_id = Auth::user()->pays_id;
        $participant->user_id = Auth::user()->id;
        $participant->event_id = $event->id;
        $participant->profil = 1;
        $participant->save();   
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return redirect('/inscriptionstep1');
        }
    else
        {
            flash('User not saved')->error();
        }
     
          
    $message = 'Vous etes inscrits avec succes';
    return redirect('/inscriptionstep1')->with(['message' => $message]);
}

public function saveconnexion(Request $request){
    if($request->isMethod('post')){

        $data = $request->input();
        
        $event =  DB::table('events')->where('status', 1 )->first();
        if(!$event)
            $event = 'Anonym';
          
        $message = "Bienvenu au " . $event->nom_event_en;
        $inscription_message = "Bienvenu au " ." ".$event->nom_event_en.","." ". "😊 , Veuillez completer les informations de votre entreprise";
        $messages = 'Mot de Passe ou email Incorrect';
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 1])){

            //echo "success"; die;
            return redirect('/homes')->with(['message' => $message]);
        }
        
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 2])){

            //echo "success"; die;
            return redirect('/madelegations')->with(['message' => $message]);
        }
        
         elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 6])){

            //echo "success"; die;
            return redirect('/homeintervenants')->with(['message' => $message]);
        }
        
         elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 4])){

            //echo "success"; die;
            return redirect('/hometraducteurs')->with(['message' => $message]);
        }
        
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 3])){

            //echo "success"; die;
            return redirect('/homefacilitateurs')->with(['message' => $message]);
        }
        
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'profil' => 1])){
            $entreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
            
            if(!$entreprise)
                if(Auth::user()->need)
                    return redirect('/homepreinscrits')->with(['message' => $inscription_message]);
                
            return redirect('/home')->with(['message' => $message]);
        }
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'profil' => 2])){
        
            return redirect('/home_membre')->with(['message' => $message]);
        }
         elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'profil' => 4])){
        
            return redirect('/homeInscriptionSansEnt')->with(['message' => $message]);
        }
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
        
            return redirect('/homepsecondaires')->with(['message' => $message]);
        }
        else{
            //echo "failed"; die;

            return redirect('/')->with(['messages' => $messages]);  
        }
        
    }
    return view('User.connexion');
}

public function  destroy_souhait($id)
{
    $souhait = Souhaite::find($id);
    $souhait->delete();
    
    return back();
    
}

public function souhait_accepter($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhait::findOrFail($id);
    $souhait->etats = 1;
    $souhait->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function souhait_refuser($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhait::findOrFail($id);
    $souhait->etats = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

public function souhaite_accepter($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhaite::findOrFail($id);
    $souhait->etats = 1;
    $souhait->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function souhaite_refuser($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhaite::findOrFail($id);
    $souhait->etats = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

public function  destroy_souhait_rvs($id)
{
    $souhait = Souhaites_rv::find($id);
    $souhait->delete();
    
    return back();
    
}

public function souhait_accepter_rvs($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhaits_rv::findOrFail($id);
    $souhait->etats = 1;
    $souhait->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function souhait_refuser_rvs($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhaits_rv::findOrFail($id);
    $souhait->etats = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

public function souhaite_accepter_rvs($id)
{
    $message = 'Valider avec success';
    $souhait  = Souhaites_rv::findOrFail($id);
    $souhait->etats = 1;
    $souhait->save();
    
    return redirect()->back()->with(['message' => $message]);
}

public function souhaite_refuser_rvs($id)
{
    $message = 'Refuser avec success';
    $souhait  = Souhaites_rv::findOrFail($id);
    $souhait->etats = 2;
    $souhait->save();
    return redirect()->back()->with(['message' => $message]);
}

//participant sans entreprise
public function profilsansentr()
{
    $fonction = DB::table('participants')->where('user_id', Auth::id())->first();
    $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
    $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
        return view('User.porofilsansentr', compact('fonction', 'nomentreprise', 'pays'));
}
 public function editprofilSansEntr($id)
    {
        $profilsansentr = User::find($id);
        
        return view('User.editprofilSansEntr', compact('profilsansentr'));
    }

public function updateSansEntr(Request $request, $id)
    {
        if($request->file('photo')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
     $message = 'Profil modifié avec succès';
        $profilsansentr = User::findOrFail($id);
        $profilsansentr->prenom  = (empty($request->get('prenom'))) ? $profilsansentr->prenom : $request->get('prenom');
        $profilsansentr->nom  = (empty($request->get('nom'))) ? $profilsansentr->nom : $request->get('nom');
        $profilsansentr->email  = (empty($request->get('email'))) ? $profilsansentr->email : $request->get('email');
        $profilsansentr->portable  = (empty($request->get('portable'))) ? $profilsansentr->portable : $request->get('portable');
        $profilsansentr->photo  = (isset($file_name)) ? $file_name : $profilsansentr->photo;
        $profilsansentr->update();
        DB::table('participants')->where('user_id', $profilsansentr->id)->update(['prenom' => $profilsansentr->prenom]);
        DB::table('participants')->where('user_id', $profilsansentr->id)->update(['nom' => $profilsansentr->nom]);
        DB::table('participants')->where('user_id', $profilsansentr->id)->update(['email' => $profilsansentr->email]);
        DB::table('participants')->where('user_id', $profilsansentr->id)->update(['tel_part' => $profilsansentr->portable]);
        
        return redirect('/myprofil')->with(['message' => $message]);   
    }
public function homeInscriptionSansEnt()
{
    return view('User.homeInscriptionSansEnt');
}

public function inscriptionSansEntre(Request $request)
{
    request()->validate([
            'email' => 'required|email|unique:users,email|confirmed',
            'email_confirmation' => 'required'
             
    ]);
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1 )->first();

    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('portable');
    
    //Password not hached
    $pass = Str::random(5);

    $user->password = Hash::make($pass);
    $user->pays_id = $request->get('pays_id');
    $user->langue_id = $request->get('langue_id');
    $user->admin = $request->get('admin');
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;
    $user->need = 0;
    $user->profil = 4;

    $sendTo = array();

    if($user->save())
        {
            
        Auth::login($user);
            
        $message = 'Participant ajoutÃ©e avec succÃ©s';
        $participant = new Participant;
        $participant->nom = Auth::user()->nom;
        $participant->prenom = Auth::user()->prenom;
        $participant->email = Auth::user()->email;
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = Auth::user()->portable;
        $participant->langue_id = Auth::user()->langue_id;
        $participant->pays_id = Auth::user()->pays_id;
        $participant->user_id = Auth::user()->id;
        $participant->event_id = $event->id;
        $participant->profil = 4;
        $participant->kit = $request->get('kit');
        $participant->stand = $request->get('stand');
        $participant->visa = $request->get('visa');
        $participant->hebergement = $request->get('hebergement');
        $participant->presence = $request->get('presence');
        $participant->save(); 
        
        $more = array();
    
        if($participant->kit)
            $more['kit'] = $participant->kit;
            
        if($participant->stand)
            $more['stand'] = $participant->stand;
        
        if($participant->visa)
            $more['visa'] = $participant->visa;
            
        $principal = 1;
        
        $use = [
            'prenom' => $user->prenom,
            'nom' => $user->nom,
            'email' => $user->email,
        ];
        
        array_push($sendTo, $user['email']);

       // \Mail::to($user['email'])->send(new kitEmail($use, $more, $pass, $event, $principal));
        
        \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
        
        return redirect('/homeInscriptionSansEnt');
        }
    else
        {
            flash('User not saved')->error();
        }
     
          
    $message = 'Vous etes inscrits avec succes';
    return redirect('/homeInscriptionSansEnt')->with(['message' => $message]);
}


public function editprofilPreinscri($id)
    {
        $monprofil = User::find($id);
        
        return view('User.editProfilPreinscri', compact('monprofil'));
    }

public function editprofilPreinscris(Request $request, $id)
    {
        if($request->file('photo')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/image/', $file_name);
        }
        
        $message = 'Profil modifié avec succès';
        $monprofil = User::findOrFail($id);
        $monprofil->prenom  = (empty($request->get('prenom'))) ? $monprofil->prenom : $request->get('prenom');
        $monprofil->nom  = (empty($request->get('nom'))) ? $monprofil->nom : $request->get('nom');
        $monprofil->email  = (empty($request->get('email'))) ? $monprofil->email : $request->get('email');
        $monprofil->portable  = (empty($request->get('portable'))) ? $monprofil->portable : $request->get('portable');
        $monprofil->photo  = (isset($file_name)) ? $file_name : $monprofil->photo;
        $monprofil->update();
        DB::table('participants')->where('user_id', $monprofil->id)->update(['prenom' => $monprofil->prenom]);
        DB::table('participants')->where('user_id', $monprofil->id)->update(['nom' => $monprofil->nom]);
        DB::table('participants')->where('user_id', $monprofil->id)->update(['email' => $monprofil->email]);
        DB::table('participants')->where('user_id', $monprofil->id)->update(['tel_part' => $monprofil->portable]);
        
        if(!empty($request->get('fonction'))){
            DB::table('participants')
              ->where('user_id', Auth::id())
              ->update(['fonction' => $request->get('fonction')]); 
        }
        
        return redirect('/monprofil3')->with(['message' => $message]);   
    }


public function completermonprofil($id)
{
        $parti = Participant::find($id);
        
        return view('User.completerProfil', compact('parti'));
}

public function completermonprofils(Request $request, $id)
{
    $participant = Participant::findOrFail($id);
    $participant->hebergement = $request->get('hebergement');
    $participant->visa = $request->get('visa');
    $participant->stand = $request->get('stand');
    $participant->presence = $request->get('presence');
    $participant->save();
    
    return redirect('/homepreinscrits');
    
        
}

// Generate PDF
    public function createPDF() {
      // retreive all records from db
      $data = User::where('id', Auth::user()->id)->first();

      // share data to view
      view()->share('employee',$data);
      $pdf = PDF::loadView('pdf_view', $data);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
    }


}

