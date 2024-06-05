<?php

namespace App\Http\Controllers;
use App\Models\Creneau;
use DB;
use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;

class CreneauController extends Controller
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
        $crenaux = DB::table('creneaus')->get();

        return view('Admin/crenaux.lister', compact('crenaux'));
    }

    
    public function create()
    {
        $tables= DB::table('tables')->get();
        $salles= DB::table('salles')->get();
        return view('Admin/crenaux.ajouter', compact( 'tables', 'salles'));
    }

    
    public function store(Request $request)
    {
        $message = 'Creneaux ajoutée avec succés';
        
         $data = $request->all();
        

        $data['host_video']  = 1 ;
        $data['participant_video']  = 1  ;
       

        $meet = $this->created($data);

        $crenaux = new Creneau;
        $crenaux->event_id = $request->get('event_id');
        $crenaux->libelle_t = $request->get('libelle_t');
        $crenaux->date_c = $request->get('start_time');
        $crenaux->sale_id = $request->get('sale_id');
        $crenaux->date = $request->get('start_time');
        $crenaux->heure_deb = $request->get('heure_deb');
        $crenaux->heure_fin = $request->get('heure_fin');
        $crenaux->start_url = $meet['data']['start_url'];
        $crenaux->join_url = $meet['data']['join_url'];
        $crenaux->password = $meet['data']['password'];
        $crenaux->duration = $request->get('duration');
        $crenaux->save();
        return back()->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $crenaux = Creneau::find($id);

        return view('Admin/crenaux.edit', compact('crenaux'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Creneaux modifié avec succés';

        $crenaux = new Creneau;
        $crenaux->table_id = $request->get('table_id');
        $crenaux->salle_id = $request->get('salle_id');
        $crenaux->date = $request->get('date');
        $crenaux->heure_debut = $request->get('heure_debut');
        $crenaux->heure_fin = $request->get('heure_fin');
        $crenaux->update();
       
        return redirect('/crenaux')->with(['message' => $message]);   

    }

   
    public function destroy($id)
    {
        $crenaux = Creneau::find($id);
        $crenaux->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
