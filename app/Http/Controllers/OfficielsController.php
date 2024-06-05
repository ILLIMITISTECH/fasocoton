<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Officiels;
use App\Mail\WelcomeEmail;
use DB;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;
use Auth;
use App\Notifications\RegisterNotify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OfficielsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officiels = DB::table('officiels')->get();

        return view('Admin/officiel.officielLister', compact('officiels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/officiel.officielCreate');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $message = 'Officiel ajouté avec succés';

        $officiel = new officiels;
        $officiel->nom = $request->get('nom');
        $officiel->prenom = $request->get('prenom');
        $officiel->email = $request->get('email');
        $officiel->fonction = $request->get('fonction');
        //$officiel->event_id = $request->get('event_id');

        $officiel->save();
       
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
        $officiel = officiels::find($id);
        return view('Admin/officiel.officielEdit', compact('officiel'));
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
        $messagess = 'Officiel modifé';
        $officiel = Officiels::find($id);
        $officiel->nom = $request->get('nom');
        $officiel->prenom = $request->get('prenom');
        $officiel->email = $request->get('email');
        $officiel->fonction = $request->get('fonction');
        $officiel->update();
        
        return redirect('/officiels')->with(['messagess' => $messagess]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $officiel = Officiels::find($id);
        $officiel->delete();
        return back()->with('info', "Officiel supprimée dans la base de donnée.");
    }
    
     public function listerB2G()
    {
   
        //$demande = DB::table('officiel_participants')->get();
        

    $demande = DB::table('officiel_participants')->select('participants.nom', 'participants.prenom', 'officiels.nom', 'officiels.prenom', 'officiels.nom')
    ->join('participants', 'participants.id', 'officiel_participants.participant_id')
    ->join('officiels', 'officiels.id', 'officiel_participants.officiel_id')
    ->get();

        return view('Admin.demandeB2Glister', compact('demande'));
    }
    
    
}
