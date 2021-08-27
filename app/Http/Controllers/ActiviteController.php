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
        //

        return view('Admin/activite.activiteCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        

        $data = $request->all();
        

        $data['host_video']  = 1 ;
        $data['participant_video']  = 1  ;
       

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
        $activite->save();

       // $this->create($request->all());
       //dd($meet);
        //return back();
        //->route('meetings.index');
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

        return view('Admin/activite.activiteEdit', compact('activite'));

    }

    
    public function update(Request $request, $id)
    {

        $activite = Activite::find($id);
        $activite->libelle = $request->get('libelle');
        $activite->date = $request->get('date');
        $activite->heure_debut = $request->get('heure_debut');
        $activite->heure_fin = $request->get('heure_fin');
        $activite->update();

        $this->update($meeting->zoom_meeting_id, $request->all());

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

        $this->delete($meeting->id);

        return $this->sendSuccess('Meeting deleted successfully.');
    }
}
