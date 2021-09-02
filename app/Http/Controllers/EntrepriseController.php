<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\Participant;
use DB;
use Auth;



class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entreprises = DB::table('entreprises')->get();

        return view('Admin/entreprise.entrepriseLister', compact('entreprises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pays= DB::table('pays')->get();
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
        
        return view('Admin/entreprise.entrepriseCreate', compact( 'pays', 'secteur', 'profil'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Entreprise ajoutée avec succés';

        $entreprises = new Entreprise;
        $entreprises->pays_id = $request->get('pays_id');
        $entreprises->secteur_activite_id = $request->get('secteur_a');
        $entreprises->profil_id = $request->get('profil_a');
        $entreprises->save();
        return back()->with(['message' => $message]);
    }
    public function inscriptionentreprise(Request $request, $id)
    {
        $message = 'Entreprise ajoutée avec succés';

        $entreprises = new Entreprise;
        $entreprises->nom_entreprise = $request->get('nom_entreprise');
        $entreprises->pay_id = $request->get('pay_id');
        $entreprises->secteur_a = $request->get('secteur_a');
        $entreprises->profil_entreprise_a = $request->get('profil_entreprise_a');
        $entreprises->autre_participant = $request->get('autre_participant');
        $entreprises->user_id = Auth::user()->id;
        $entreprises->save();
        $participant = Participant::findOrFail($id);
        $participant->fonction = $request->get('fonction');
        $participant->profil = $request->get('profil');
        $participant->save();
        return redirect('/inscriptionstep3')->with(['message' => $message]);
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
        $entreprises = Entreprise::find($id);

        return view('Admin/entreprise.entrepriseEdit', compact('entreprises'));
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
        $message = 'Intervnant modifié avec succés';

        $entreprises = new Entreprise;
        $entreprises->pays_id = $request->get('pays_id');
        $entreprises->secteur_activite_id = $request->get('secteur_activite_id');
        $entreprises->profil_id = $request->get('profil_id');
        $intervenant->update();
       
        return redirect('/entreprises')->with(['message' => $message]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entreprises = Entreprise::find($id);
        $entreprises->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
