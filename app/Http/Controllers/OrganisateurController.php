<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisateur;
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

class OrganisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisateurs = DB::table('organisateurs')->get();

        return view('Admin/organisateur.organisateurLister', compact('organisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langues = DB::table('langues')->get();
        return view('Admin/organisateur.organisateurCreate', compact('langues'));
        
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
    $event =  DB::table('events')->where('status', 1)->first();
    
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
    $user->admin = 3;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
        $message = 'organisateur ajouté avec succés';

        $organisateur = new Organisateur;
        $organisateur->nom = $request->get('nom');
        $organisateur->prenom = $request->get('prenom');
        $organisateur->email = $request->get('email');
        $organisateur->portable = $user->portable;
        $organisateur->langue_id = $request->get('langue_id');
        $organisateur->event_id = $request->get('event_id');
        $organisateur->user_id = $user->id;

        $organisateur->save();
        
         Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return redirect('/organisateurs');
        }
    else
        {
            flash('User not saved')->error();
        }
       
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
        $organisateur = Organisateur::find($id);
        $langues = DB::table('langues')->get();
        return view('Admin/organisateur.organisateurEdit', compact('organisateur','langues'));
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
        $messagess = 'Organisateur modifé';
        $organisateur = Organisateur::find($id);
        $organisateur->nom = $request->get('nom');
        $organisateur->prenom = $request->get('prenom');
        $organisateur->email = $request->get('email');
        $organisateur->langue_id = $request->get('langue_id');
        $organisateur->portable = $request->get('portable');
        $organisateur->update();
        DB::table('users')->where('id', $organisateur->user_id)->update(['prenom' => $organisateur->prenom]);
        DB::table('users')->where('id', $organisateur->user_id)->update(['nom' => $organisateur->nom]);
        DB::table('users')->where('id', $organisateur->user_id)->update(['email' => $organisateur->email]);
        DB::table('users')->where('id', $organisateur->user_id)->update(['portable' => $organisateur->portable]);
        DB::table('users')->where('id', $organisateur->user_id)->update(['langue_id' => $organisateur->langue_id]);
       
       
        return redirect('/organisateurs')->with(['messagess' => $messagess]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organisateur = Organisateur::find($id);
        $organisateur->delete();
        DB::table('users')->where('id', $organisateur->user_id)->delete();
        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
