<?php

namespace App\Http\Controllers;
use App\Models\Intervenant;
use DB;
use Str;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\WelcomeStakeEmail;
use App\Notifications\RegisterNotify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class IntervenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intervenant = DB::table('intervenants')->get();

        return view('Admin/intervenant.intervenantLister', compact('intervenant'));
    }

    
    public function create()
    {
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/intervenant.intervenantCreate', compact( 'langue', 'type'));
    }

    
    public function store(Request $request)
    {
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1)->first();
    
    $type = "intervenants";

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
    $user->admin = 6;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
        $message = 'Facilitateur ajouté avec succés';

        $intervenant = new Intervenant;
        $intervenant->nom = $request->get('nom');
        $intervenant->prenom = $request->get('prenom');
        $intervenant->email = $request->get('email');
        $intervenant->phone = $user->portable;
        $intervenant->langue_id = $request->get('langue_id');
        $intervenant->type_id = $request->get('type_id');
        $intervenant->event_id = $request->get('event_id');
        $intervenant->user_id = $user->id;
        $intervenant->save();
       
        Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return redirect('/intervenants');
        }
    else
        {
            flash('User not saved')->error();
        }
       
        return back()->with(['message' => $message]);
    }
    
    
     public function Ajoutintervenants()
    {
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/intervenant.Ajoutintervenants', compact( 'langue', 'type'));
    }

    
    public function Storeintervenants(Request $request)
    {
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1)->first();
    
    $type = "intervenants";

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
    $user->admin = 6;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
        $message = 'Facilitateur ajouté avec succés';

        $intervenant = new Intervenant;
        $intervenant->nom = $request->get('nom');
        $intervenant->prenom = $request->get('prenom');
        $intervenant->email = $request->get('email');
        $intervenant->phone = $user->portable;
        $intervenant->langue_id = $request->get('langue_id');
        $intervenant->type_id = $request->get('type_id');
        $intervenant->event_id = $request->get('event_id');
        $intervenant->user_id = $user->id;
        $intervenant->save();
       
        Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeStakeEmail($user, $pass, $event, $type));
            return back()->with(['message' => $message]);
        }
    else
        {
            flash('User not saved')->error();
        }
       
        return back()->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $intervenant = Intervenant::find($id);
        $langue= DB::table('langues')->get();
        $type= DB::table('types')->get();
        return view('Admin/intervenant.intervenantEdit', compact('intervenant', 'type', 'langue'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Intervnant modifié avec succés';

        $intervenant = Intervenant::find($id);
        $intervenant->nom = $request->get('nom');
        $intervenant->prenom = $request->get('prenom');
        $intervenant->email = $request->get('email');
        $intervenant->phone = $request->get('phone');
        $intervenant->langue_id = $request->get('langue_id');
        $intervenant->type_id = $request->get('type_id');
        $intervenant->update();
        DB::table('users')->where('id', $intervenant->user_id)->update(['prenom' => $intervenant->prenom]);
        DB::table('users')->where('id', $intervenant->user_id)->update(['nom' => $intervenant->nom]);
        DB::table('users')->where('id', $intervenant->user_id)->update(['email' => $intervenant->email]);
        DB::table('users')->where('id', $intervenant->user_id)->update(['portable' => $intervenant->phone]);
        DB::table('users')->where('id', $intervenant->user_id)->update(['langue_id' => $intervenant->langue_id]);
       
        return redirect('/intervenants')->with(['message' => $message]);   

    }

   
    public function destroy($id)
    {
        $intervenant = Intervenant::find($id);
        $intervenant->delete();
        DB::table('users')->where('id', $intervenant->user_id)->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
