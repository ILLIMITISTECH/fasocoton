<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilitateur;
use DB;

class FacilitateurController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilitateur = DB::table('facilitateurs')->get();

        return view('Admin/facilitateur.facilitateurLister', compact('facilitateur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/facilitateur.facilitateurCreate', compact('langue', 'type'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Facilitateur ajouté avec succés';

        $facilitateur = new Facilitateur;
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('nom_event_en');
        $facilitateur->email = $request->get('email');
        $facilitateur->phone = $request->get('phone');
        $facilitateur->langue_id = $request->get('langue_id');
        $facilitateur->type_id = $request->get('type_id');

        $facilitateur->save();
       
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facilitateur = Facilitateur::find($id);

        return view('Admin/facilitateur.facilitateurEdit', compact('facilitateur'));
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
        $facilitateur = Facilitateur::find($id);
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('prenom');
        $facilitateur->email = $request->get('email');
        $facilitateur->langue_id = $request->get('langue_id');
        $facilitateur->type_id = $request->get('type_id');
        $facilitateur->update();
       
        return redirect('/facilitateur')->with(['message' => $message]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facilitateur = Facilitateur::find($id);
        $facilitateur->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
