<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;
use App\Models\Secteur_activite;
use DB;

class SecteurActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $secteur_activites = DB::table('secteur_activites')->get();

        return view('Admin/secteur_activite.secteurDactiviteLister', compact('secteur_activites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/secteur_activite.secteurDactiviteCreate');
    }

    
    public function store(Request $request)
    {
        $message = 'Ajoutée avec succés';

        $secteur_activites = new Secteur_activite;
        $secteur_activites->libelle = $request->get('libelle');
        $secteur_activites->save();
        return back()->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $secteur_activites = Secteur_activite::find($id);

        return view('Admin/secteur_activite.edit', compact('secteur_activites'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Secteur Activité modifé';
        $secteur_activites = Secteur_activite::find($id);
        $secteur_activites->libelle = $request->get('libelle');
        $secteur_activites->update();
       
        return redirect('/secteuractivites')->with(['message' => $message]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secteur_activites = Secteur_activite::find($id);
        $secteur_activites->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
