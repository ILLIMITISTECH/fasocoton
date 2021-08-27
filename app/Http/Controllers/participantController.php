<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use DB;

class participantController extends Controller
{
   public function choix()
   {
       return view('Admin/participant.choixparticipant');
   }
    public function index()
    {
        //
        $participant = DB::table('participants')->get();

        return view('Admin/participant.participantLister', compact('participant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entreprise= DB::table('entreprises')->get();
        $langue= DB::table('langues')->get();
        $pays= DB::table('pays')->get();

        return view('Admin/participant.participantCreate', compact( 'langue', 'pays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Participant ajoutée avec succés';
        $participant = new Participant;
        $participant->nom = $request->get('nom');
        $participant->prenom = $request->get('prenom');
        $participant->email = $request->get('email');
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = $request->get('tel_part');
        $participant->langue_id = $request->get('langue_id');
        $participant->pays_id = $request->get('pays_id');
        $participant->presence = $request->get('presence');
        $participant->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
