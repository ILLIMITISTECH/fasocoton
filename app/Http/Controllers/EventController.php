<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use App\Models\Event;
use App\Models\User;
use App\Models\Entreprise;
use DB;
use Mail;
use App\Mail\SugestionsSouhaitsDeRendezVous;
use App\Mail\PlanningDesRendezVous;
use App\Mail\PlanningFinalDesRendezvous;
use App\Mail\AjouterDesParticipantsSecondaires;



class EventController extends Controller
{

    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('max_execution_time', 180);   
        $even = DB::table('events')->orderBy('id', 'desc')->get();

        return view('Admin/event.eventLister', compact('even'));
    }
    
     public function EntrepriseB2BnonRenseignedescription()
    {
        //ini_set('max_execution_time', 180);   
       // $even = DB::table('events')->get();
       
       $entreprises = DB::table('entreprise_rvs')
       ->where('description', '=', null)
       //->where('profile_entreprise_a', '==', null)
       ->get();

        return view('Admin/entreprise.B2BnonRenseignedescription', compact('entreprises'));
    }
    
     public function EntrepriseB2BnonRenseignepartenaire()
    {
        //ini_set('max_execution_time', 180);   
       // $even = DB::table('events')->get();
       
       $entreprises = DB::table('entreprise_rvs')
       ->where('partenaire_rencontrer_a', '=', null)
       //->where('profile_entreprise_a', '==', null)
       ->get();

        return view('Admin/entreprise.B2BnonRenseignepartenaire', compact('entreprises'));
    }
     public function EntrepriseB2BnonRenseigneprofil()
    {
        //ini_set('max_execution_time', 180);   
       // $even = DB::table('events')->get();
       
       $entreprises = DB::table('entreprise_rvs')
       ->where('profile_entreprise_a', '=', null)
       //->where('profile_entreprise_a', '==', null)
       ->get();

        return view('Admin/entreprise.B2BnonRenseigneprofil', compact('entreprises'));
    }
    
     public function EntrepriseB2BnonRenseigneSendMail()
    {
        $entreprises = DB::table('entreprise_rvs')
       //->where('partenaire_rencontrer_a', '==', null)
       //->where('profile_entreprise_a', '==', null)
       ->get();
        
        foreach($entreprises as $entreprise)
        {
            $users = User::where('id', $entreprise->user_id)->get();
            
            foreach($users as $user)
            {
                
            }
        }

        return back();
    }
    
    public function ajouterParticipantSecondaire()
    {
        //ini_set('max_execution_time', 180);   
        //$even = DB::table('events')->get();

        //return view('Admin/event.eventLister', compact('even'));
        
         $event = DB::table('events')->where('status', '=', 1)->first();
        
        $users = User::where('email', '=', 'fallou.g@illimitis.com')->orWhere('email', '=', 'axel.n@illimitis.com')
        ->orWhere('email', '=', 'roland.k@illimitis.com')
   
       ->get();
            
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new AjouterDesParticipantsSecondaires($user, $event));
            
           
            
        }
        
        dd($event);
    }

    public function check_traducteur()
        {
           $traducteurs = DB::table('traducteurs')->get();
           $tra = 0;
           $plannings = DB::table('plannings')->where('status_rv', 4)->get();
           foreach($traducteurs as $traducteur)
           {
               $tra += $traducteur->id;
           $planning_rvs = DB::table('plannings_rvs')->where('status_rv', 4)
           ->update(['traducteur_id' => $tra]);
           }
          // dd($planning_rvs);
          
          $event = DB::table('events')->where('status', '=', 1)->first();
        
        $users = User::where('email', '=', 'fallou.g@illimitis.com')->orWhere('email', '=', 'axel.n@illimitis.com')
        ->orWhere('email', '=', 'roland.k@illimitis.com')
   
   ->get();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new AjouterDesParticipantsSecondaires($user, $event));
            
           
            
        }
          dd($planning_rvs);
            return view('Admin/event.eventLister', compact('even'));
        }

    public function statistique()
    {


        return view('Admin.statistique');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configurer()
    {
        ini_set('max_execution_time', 180);
        $even = Event::where('status', '=', 1)->first();
        return view('Admin/event.eventConfigurer', compact('even'));
    }
    public function create()
    {

        $organisateurs = DB::table('organisateurs')->get();
        
        return view('Admin/event.eventCreate', compact('organisateurs'));
    }

   
    public function store(Request $request)
    {
        
        $message = 'Evénement ajoutée avec succés';

        $even = new Event;
        $even->nom_event_fr = $request->get('nom_event_fr');
        $even->nom_event_en = $request->get('nom_event_en');
        $even->site = $request->get('site');
        $even->date_debut = $request->get('date_debut');
        $even->date_fin = $request->get('date_fin');
        $even->max = $request->get('max');
        $even->organisateur_id = $request->get('organisateur_id');
        
        $even->save();
       
        return back()->with(['message' => $message]);
        $this->create($request->all());

        // return redirect('events');
        //->route('meetings.index');
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
        $meeting = $this->get($id);

        return view('meetings.index', compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $even = Event::find($id);

        $organisateurs = DB::table('organisateurs')->get();
        return view('Admin/event.eventEdit', compact('even','organisateurs'));
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
        $message = 'Evénement modifée';
        $even = Event::find($id);
        $even->nom_event_fr = $request->get('nom_event_fr');
        $even->nom_event_en = $request->get('nom_event_en');
        $even->site = $request->get('site');
        $even->date_debut = $request->get('date_debut');
        $even->date_fin = $request->get('date_fin');
        $even->organisateur_id = $request->get('organisateur_id');
        $even->max = $request->get('max');
        $even->update();
       
        return redirect('/events')->with(['message' => $message]);   

        $this->update($meeting->zoom_meeting_id, $request->all());

        // return redirect('events');
        //->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZoomMeeting $meeting, $id)
    {
        $even = Event::find($id);
        $even->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    
    
        $this->delete($meeting->id);

        // return $this->sendSuccess('Meeting deleted successfully.');
    }
    
    public function phase_1(Request $request,$id)
    {
        //    

        $even = Event::findOrFail($id);
        $even->phase = 1; //Approved
        $even->save();
        return redirect()->back(); 
    }
    
    public function showEntreprise($id)
    {
        $entreprise = Entreprise::find($id);
        
        return view('User.showEntreprise', compact('entreprise'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phase_2(Request $request,$id)
    {
        //    
        
        $event = DB::table('events')->where('status', '=', 1)->first();

        $even = Event::findOrFail($id);
        $even->phase = 2; //Approved
        $even->save();
        $sql = DB::select('CALL suggestions_automatiques()');
        
        
        $users = User::where('event_id', $event->id)->get();

        foreach ($users as $user) {
            \Mail::to($user['email'])->send(new SugestionsSouhaitsDeRendezVous($user, $event));
        }
        
        // $users = User::where('event_id', $event->id)->get();
        
        // foreach($users as $user)
        // {
            
        //     \Mail::to($user['email'])->send(new SugestionsSouhaitsDeRendezVous($user, $event));
            
           
        // } 
        
        // dd($users); 
        return redirect()->back(); 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phase_3(Request $request,$id)
    {
        $even = Event::findOrFail($id);
        $even->phase = 3; //Approved
        $even->save();
        $sqls = DB::statement('CALL souhaitfs_planningfs()');
        return redirect()->back(); 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phase_4(Request $request,$id)
    {
        $event = DB::table('events')->where('status', '=', 1)->first();

        $even = Event::findOrFail($id);
        $even->phase = 4; //Approved
        $even->save();
        DB::table('plannings')->delete();
        $sql = DB::statement('CALL plannings()');
        
        $users = User::where('event_id', $event->id)->get();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new PlanningDesRendezVous($user, $event));
            
           
            
        }
        
        
         $plans = DB::table('plannings')->get();
        
        foreach($plans as $plan)
        {
          $ent =  DB::table('entreprise_rvs')->where('id', '!=', $plan->entreprise_id)->get(); 
          
          $cre = DB::table('creneaus')
          ->where('libelle_t', '<>', $plan->libelle_t)
          ->where('heure_deb', '<>', $plan->heure_deb)
          ->where('heure_fin', '<>', $plan->heure_fin)
          //->where('date_c', '!=', $plan->date_rv)
          ->get(); 
        
        
        foreach($cre as $cr)
         {
            
             DB::table('creneaus_rvs')->insert(['libelle_t' => $cr->libelle_t,
             'sale_id' => $cr->sale_id,'event_id' => $cr->event_id, 'heure_deb'=> $cr->heure_deb,
             'heure_fin' => $cr->heure_deb, 'date_c' => $cr->date_c,
             'start_url' => $cr->start_url, 'join_url' => $cr->join_url, 'password' => $cr->password,
             'duration' => $cr->duration , 'created_at' => $cr->created_at, 'updated_at' => $cr->updated_at]);  
         }
        
          
         
        }
        
        $souh =  DB::table('souhaits')->where('status', '=', 0)->where('etats', '=', 0)->get(); 
          
            foreach($souh as $sou)
         {
             
             DB::table('souhaits_rvs')->insert(['entreprise_id' => $sou->entreprise_id,
             'entreprise_rv_id' => $sou->entreprise_rv_id,'priorite' => $sou->priorite, 'priorite_a'=> $sou->priorite_a,
             'status' => $sou->status, 'etats' => $sou->etats,
             'user_id' => $sou->user_id, 'event_id' => $sou->event_id]);  
         }
        
        
        return redirect()->back(); 
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phase_5_rvs(Request $request,$id)
    {
        $event = DB::table('events')->where('status', '=', 1)->first();

        $even = Event::findOrFail($id);
        $even->phase_rvs = 5; //Approved
        $even->save();
        DB::table('plannings_rvs')->delete();
        $sql = DB::statement('CALL plannings_rvs()');
        
        $users = User::all();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new PlanningFinalDesRendezvous($user, $event));
            
           
            
        }
        
        return redirect()->back(); 
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function phase_des(Request $request,$id)
    {
        $even = Event::findOrFail($id);
        $even->phase = 0; //Approved
        $even->save();
        return redirect()->back(); 
    }
     public function activer(Request $request,$id)
    {
        //  
        $messa = "activé avec succés";
        $event = Event::findOrFail($id);
        $event->status = 1; //Approved
        $event->save();
        $event = DB::table('events')->where('id', '!=', $id)->update(array('status' => 0));
       
        return redirect()->back()->with(['messa' => $messa]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desactiver(Request $request,$id)
    {
        //    

        $event = Event::findOrFail($id);
        $event->status = 0; //Approved
        $event->save();
        return redirect()->back(); 
    }
    
    
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function plan_traducteur(Request $request,$id)
    {
        $event = DB::table('events')->where('status', '=', 1)->first();

        
       $plann_deamnder = DB::table('plannings')->select('plannings.*','users.id','users.langue_id')
       ->join('users', 'users.id', '=', 'plannings.user_id')
       ->get();
       
       $plann_deamndeur = DB::table('plannings')->select('plannings.*','users.id', 'users.langue_id')
       ->join('users', 'users.id', '=', 'plannings.user_id')
       ->get();

        $users = User::all();
        
        foreach($users as $user)
        {
            
            \Mail::to($user['email'])->send(new PlanningDesRendezVous($user, $event));
            
           
            
        }
        
        
        return redirect()->back(); 
    }
}
