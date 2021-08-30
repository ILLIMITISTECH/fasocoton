<?php

namespace App\Http\Controllers;
use App\Models\Creneaux;
use DB;
use Illuminate\Http\Request;

class CreneauxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crenaux = DB::table('creneaux')->get();

        return view('Admin/crenaux.lister', compact('crenaux'));
    }

    
    public function create()
    {
        $table= DB::table('tables')->get();
        $salle= DB::table('salles')->get();
        return view('Admin/crenaux.ajouter', compact( 'table', 'salle'));
    }

    
    public function store(Request $request)
    {
        $message = 'Creneaux ajoutée avec succés';

        $crenaux = new Crenaux;
        $crenaux->table_id = $request->get('table_id');
        $crenaux->salle_id = $request->get('salle_id');
        $crenaux->date = $request->get('date');
        $crenaux->heure_debut = $request->get('heure_debut');
        $crenaux->heure_fin = $request->get('heure_fin');
        $crenaux->save();
        return back()->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $crenaux = Crenaux::find($id);

        return view('Admin/crenaux.edit', compact('crenaux'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Creneaux modifié avec succés';

        $crenaux = new Crenaux;
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
        $crenaux = Crenaux::find($id);
        $crenaux->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
