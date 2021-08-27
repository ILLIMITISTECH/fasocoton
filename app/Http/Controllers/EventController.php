<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use App\Models\Event;
use DB;


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
        
        $even = DB::table('events')->get();

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
        return view('Admin/event.eventConfigurer');
    }
    public function create()
    {


        return view('Admin/event.eventCreate');
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

        return view('Admin/event.eventEdit', compact('even'));
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
}
