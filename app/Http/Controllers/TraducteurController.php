<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traducteur;
use App\Mail\WelcomeStakeEmail;
use DB;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;
use Auth;
use App\Notifications\RegisterNotify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TraducteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traducteurs = DB::table('traducteurs')->get();

        return view('Admin/traducteur.traducteurLister', compact('traducteurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langues = DB::table('langues')->get();
        return view('Admin/traducteur.traducteurCreate', compact('langues'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         request()->validate([
            'email' => 'required|email|unique:users,email',
    ]);
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1 )->first();
    
    $type = "traducteurs";
    
    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('portable');
    
    //Password not hached
    $pass = Str::random(5);

    $user->password = Hash::make($pass);
    $user->pays_id = $request->get('pays_id');
    $user->langue_id = $request->get('langue_id');
    $user->admin = 4;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
        $message = 'Traducteur ajouté avec succés';

        $traducteur = new Traducteur;
        $traducteur->nom = $request->get('nom');
        $traducteur->prenom = $request->get('prenom');
        $traducteur->email = $request->get('email');
        $traducteur->tel = $user->portable;
        $traducteur->langue_id = $request->get('langue_id');
        $traducteur->event_id = $event->id;
        $traducteur->user_id = $user->id;
        $traducteur->save();
        
         Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return redirect('/traducteurs');
        }
    else
        {
            flash('User not saved')->error();
        }
       
        return redirect('/traducteurs')->with(['message' => $message]);
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
        $traducteur = Traducteur::find($id);
        $langues = DB::table('langues')->get();
        return view('Admin/traducteur.traducteurEdit', compact('traducteur','langues'));
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
        $messagess = 'Evénement modifée';
        $traducteur = Traducteur::find($id);
        $traducteur->nom = $request->get('nom');
        $traducteur->prenom = $request->get('prenom');
        $traducteur->tel = $request->get('tel');
        $traducteur->email = $request->get('email');
        $traducteur->langue_id = $request->get('langue_id');
        $traducteur->update();
        DB::table('users')->where('id', $traducteur->user_id)->update(['prenom' => $traducteur->prenom]);
        DB::table('users')->where('id', $traducteur->user_id)->update(['nom' => $traducteur->nom]);
        DB::table('users')->where('id', $traducteur->user_id)->update(['email' => $traducteur->email]);
        DB::table('users')->where('id', $traducteur->user_id)->update(['portable' => $traducteur->tel]);
        DB::table('users')->where('id', $traducteur->user_id)->update(['langue_id' => $traducteur->langue_id]);
        return redirect('/traducteurs')->with(['messagess' => $messagess]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $traducteur = Traducteur::find($id);
        $traducteur->delete();
        DB::table('users')->where('id', $traducteur->user_id)->delete();
        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
