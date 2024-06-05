<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilitateur;
use App\Models\Exposant;
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
        
         request()->validate([
            'email' => 'required|email|unique:users,email',
    ]);
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1)->first();
    
    $type = "facilitateurs";

    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('phone');
    
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
        $message = 'Facilitateur ajouté avec succés';

        $facilitateur = new Facilitateur;
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('prenom');
        $facilitateur->email = $request->get('email');
        $facilitateur->phone = $user->portable;
        $facilitateur->langue_id = $request->get('langue_id');
        $facilitateur->event_id = $request->get('event_id');
        $facilitateur->type_id = $request->get('type_id');
        $facilitateur->user_id = $user->id;

        $facilitateur->save();
        
         Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return redirect('/facilitateurs');
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
        $facilitateur = Facilitateur::find($id);
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/facilitateur.facilitateurEdit', compact('facilitateur', 'type', 'langue'));
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
        $facilitateur = Facilitateur::find($id);
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('prenom');
        $facilitateur->phone = $request->get('phone');
        $facilitateur->email = $request->get('email');
        $facilitateur->langue_id = $request->get('langue_id');
        $facilitateur->type_id = $request->get('type_id');
        $facilitateur->update();
        DB::table('users')->where('id', $facilitateur->user_id)->update(['prenom' => $facilitateur->prenom]);
        DB::table('users')->where('id', $facilitateur->user_id)->update(['nom' => $facilitateur->nom]);
        DB::table('users')->where('id', $facilitateur->user_id)->update(['email' => $facilitateur->email]);
        DB::table('users')->where('id', $facilitateur->user_id)->update(['portable' => $facilitateur->portable]);
        DB::table('users')->where('id', $facilitateur->user_id)->update(['langue_id' => $facilitateur->langue_id]);
        return redirect('/facilitateurs')->with(['messagess' => $messagess]);   
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
        DB::table('users')->where('id', $facilitateur->user_id)->delete();
        return back()->with('info', "Facilitateur supprimée dans la base de donnée.");
    }
    
    
    public function Ajoutfacilitateurs()
    {
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/facilitateur.Ajoutfacilitateurs', compact('langue', 'type'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function Storefacilitateurs(Request $request)
    {
        
        /* request()->validate([
            'email' => 'required|email|unique:users,email',
    ]); */
    //$message = 'Le facilitateur s’est inscrit avec succès !';
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1)->first();
    
    $type = "facilitateurs";

    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('phone');
    
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
        $message = 'Le facilitateur s’est inscrit avec succès !';

        $facilitateur = new Facilitateur;
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('prenom');
        $facilitateur->email = $request->get('email');
        $facilitateur->phone = $user->portable;
        $facilitateur->langue_id = $request->get('langue_id');
        $facilitateur->event_id = $request->get('event_id');
        $facilitateur->type_id = $request->get('type_id');
        $facilitateur->user_id = $user->id;
        $facilitateur->entreprise = $request->get('entreprise');

        $facilitateur->save();
        
         //Auth::login($user);
           /// \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return back()->with(['message' => $message, 'messages' => $messages]);
        }
    else
        {
            flash('User not saved')->error();
        }
       
        return back()->with(['message' => $message, 'messages' => $messages]);
    }
    
     public function AjoutExposants()
    {
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/exposant.AjoutExposants', compact('langue', 'type'));
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function StoreExposants(Request $request)
    {
        
        
    //$message = 'Le facilitateur s’est inscrit avec succès !';
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1)->first();
    
    $type = "Exposants";

    $user = new User;
    $user->prenom = $request->get('prenom');
    $user->nom = $request->get('nom');
    $user->email = $request->get('email');
    $user->portable = $request->get('phone');
    
    //Password not hached
    $pass = Str::random(5);

    $user->password = Hash::make($pass);
    $user->pays_id = $request->get('pays_id');
    $user->langue_id = $request->get('langue_id');
    $user->admin = 8;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
        $message = "L'exposants s’est inscrit avec succès !";

        $facilitateur = new Exposant;
        $facilitateur->nom = $request->get('nom');
        $facilitateur->prenom = $request->get('prenom');
        $facilitateur->email = $request->get('email');
        $facilitateur->phone = $user->portable;
        $facilitateur->event_id = $request->get('event_id');
        $facilitateur->user_id = $user->id;
        $facilitateur->entreprise = $request->get('entreprise');

        $facilitateur->save();
        
       
         //Auth::login($user);
           // \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return back()->with(['message' => $message, 'messages' => $messages]);
        }
    else
        {
            flash('User not saved')->error();
        }
       
        return back()->with(['message' => $message, 'messages' => $messages]);
    }
}
