<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use App\Models\Activite;
use DB;

class ActiviteController extends Controller
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
        //
   
        $activites = DB::table('activites')->get();

        return view('Admin/activite.activiteLister', compact('activites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //M.A.X B.I.R.D was here
        $languages = DB::table('langues')->get();
        $types  = DB::table('types')->get();

        return view('Admin/activite.activiteCreate', compact('languages','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        

        $data['host_video']  = 1;
        $data['participant_video']  = 0;
        
        $traductors = $request->traductors;

        $stakeholders = $request->stakeholders;

        $participants = $request->participants;

        $meet = $this->created($data);
        
       
        
        $activite = new Activite;
        $activite->libelle = $request->get('libelle');
        $activite->date = $request->get('start_time');
        $activite->heure_debut = $request->get('heure_debut');
        $activite->heure_fin = $request->get('heure_fin');
        
        $activite->start_url = $meet['data']['start_url'];
        $activite->join_url = $meet['data']['join_url'];
        $activite->password = $meet['data']['password'];
        $activite->duration = $request->get('duration');
        $activite->event_id = $request->get('event_id');
        
        $activite->save();
        
        //M.A.X B.I.R.D was here
        
        if($traductors)
            foreach($traductors as $traductor){
                DB::table('interventions')->insert([
                        ['activite_id' => $activite->id, 'intervenant_id' => null, 'participant_id' => null, 'traducteur_id' => $traductor]
                    ]);
            }
        
        if($stakeholders)
            foreach($stakeholders as $stakeholder){
                DB::table('interventions')->insert([
                        ['activite_id' => $activite->id, 'intervenant_id' => $stakeholder, 'participant_id' => null, 'traducteur_id' => null]
                    ]);
            }
            
         if($participants)
            foreach($participants as $participant){
                DB::table('interventions')->insert([
                        ['activite_id' => $activite->id, 'intervenant_id' => null, 'participant_id' => $participant, 'traducteur_id' => null]
                    ]);
            }    
            
       $this->create($request->all());
       
        
        return redirect('/activites');
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
        $activite = Activite::find($id);
        $meeting = $this->get($id);

        return view('activites.show', compact('meeting','activite'));
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

        $activite = Activite::find($id);
        $languages = DB::table('langues')->get();
        $types  = DB::table('types')->get();

        return view('Admin/activite.activiteEdit', compact('activite','languages', 'types'));

    }

    
    public function update(Request $request, $id)
    {

        $activite = Activite::find($id);
        
        if($request->get('libelle') != null)
            $activite->libelle = $request->get('libelle');
        if($request->get('date') != null)
            $activite->date = $request->get('date');    
        if($request->get('heure_debut') != null)
            $activite->heure_debut = $request->get('heure_debut');
        if($request->get('heure_fin') != null)
            $activite->heure_fin = $request->get('heure_fin');
            
        $activite->update();
        
        //M.A.X B.I.R.D was here
        
        $traductors = $request->traductors;

        $stakeholders = $request->stakeholders;
        
        if($traductors){
            DB::table('interventions')->where('activite_id', $id)->where('intervenant_id', null)->delete();
            
            foreach($traductors as $traductor){
                DB::table('interventions')->insert([
                        ['activite_id' => $id, 'intervenant_id' => null, 'traducteur_id' => $traductor]
                    ]);
            }
        }
        
        if($stakeholders){
            DB::table('interventions')->where('activite_id', $id)->where('traducteur_id', null)->delete();
            
            foreach($stakeholders as $stakeholder){
                DB::table('interventions')->insert([
                        ['activite_id' => $id, 'intervenant_id' => $stakeholder, 'traducteur_id' => null]
                    ]);
            }
        }
        
        //$this->update($meeting->zoom_meeting_id, $request->all());

        return redirect('/activites');
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
        //
        $activite = Activite::find($id);
        $activite->delete();

        //$this->delete($meeting->$id);

        return back()->with('message', "Evénement supprimée dans la base de donnée.");
    }
}
