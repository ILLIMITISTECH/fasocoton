<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class InscriptionController extends Controller
{
    //
public function confirmations()
{
    return view('User.confirmations');
}
public function connexion()
{
    return view('User.connexion');
}
public function homeconfirmation()
{
    return view('User.homeconfirmation');
}
public function homeplanning()
{
    //$activites = DB::tables('activites')->get();
    return view('User.homeplanning');//compact('activites'));
}
public function homesuggestion()
{
    return view('User.homesuggestion');
}
public function index()
{
    return view('Admin/Dashboard.index');
}
public function inscription()
{
    return view('User.inscription');
}
public function inscriptionstep0()
{
    return view('User.inscriptionstep0');
}
public function inscriptionstep1()
{
    return view('User.inscriptionstep1');
}
public function inscriptionstep2()
{
    $pays= DB::table('pays')->get();
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
    return view('User.inscriptionstep2', compact( 'pays', 'secteur', 'profil'));
}
public function inscriptionstep3()
{
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
    return view('User.inscriptionstep3', compact('secteur', 'profil'));
}
public function inscriptionstep4()
{
    return view('User.inscriptionstep4');
}
public function messuggestion()
{
    return view('User.messuggestions');
}

public function saveinscription(Request $request)
{
    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('portable');
    $user->password = Hash::make($request->get('password'));
    $user->pays_id = $request->get('pays_id');
    $user->langue_id = $request->get('langue_id');
    $user->admin = $request->get('admin');
    $user->code_event = $request->get('code_event');
    $user->event_id = $request->get('event_id');
    $user->save();
    $message = 'Vous etes inscrits avec succes';
    return redirect()->back()->with(['message' => $message]);
}
public function saveconnexion(Request $request){

    if($request->isMethod('post')){

        $data = $request->input();
        $message = "Vous êtes maintenant conncetés. Vous pouvez remplir les informations de votre entreprise";
        $messages = 'Mot de Passe ou email Incorrect';
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin' => 1])){

            //echo "succes"; die;
            return redirect('/homes')->with(['message' => $message]);
        }
        elseif(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
        
            return redirect('/inscriptionstep0')->with(['message' => $message]);
        }
        else{
            //echo "failed"; die;

            return redirect('/connexions')->with(['messages' => $messages]);  
        }
    }
    return view('User.connexion');
}

}

