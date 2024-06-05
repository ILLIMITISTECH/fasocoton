<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membre;
use App\Models\Chef_delegation;
use App\Models\Participant;
use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;
use Auth;
use App\Notifications\RegisterNotify;
use App\Models\Entreprise;
//mail namespace
use App\Mail\WelcomeEmail;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ChefDelegationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
    {
        $delegation = DB::table('chef_delegations')->get();

        return view('Admin/delegation.lister', compact('delegation'));
    }

    
    public function create()
    {
         $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
        $langue= DB::table('langues')->get();
        $event= DB::table('events')->get();
        return view('Admin/delegation.ajouter', compact( 'pays', 'langue', 'event'));
    }

    
    public function store(Request $request)
    {
         request()->validate([
            'email' => 'required|email|unique:users,email',
    ]);
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1 )->first();
    
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
    $user->admin = 2;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
             $message = 'Chef de délégation ajouté avec succès';
            $delegation = new Chef_delegation;
            $delegation->prenom = $request->get('prenom');
            $delegation->nom = $request->get('nom');
            $delegation->email = $request->get('email');
            $delegation->event_id = $event->id;
            $delegation->user_id = $user->id;
            $delegation->save();
            
            Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return redirect('/chefdelegations');
        }
    else
        {
            flash('User not saved')->error();
        }
   
    
    $message = 'Vous etes inscrits avec succes';
    return redirect('/chefdelegations')->with(['message' => $message]);
    }
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
        $delegation = Chef_delegation::find($id);

        return view('Admin/delegation.edit', compact('delegation'));
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
        
        $delegation = Chef_delegation::find($id);
        $delegation->nom = $request->get('nom');
        $delegation->prenom = $request->get('prenom');
        $delegation->update();
        DB::table('users')->where('id', $delegation->user_id)->update(['prenom' => $delegation->prenom]);
        DB::table('users')->where('id', $delegation->user_id)->update(['nom' => $delegation->nom]);
        return redirect('/chefdelegations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $delegation = Chef_Delegation::find($id);
        $delegation->delete();
        DB::table('users')->where('id', $delegation->user_id)->delete();
        return back()->with('info', "Delegation supprimée dans la base de donnée.");
    }
     public function editdelegation($id)
    {
        $delegations = Chef_delegation::find($id);
        
        return view('User.editdelegation', compact('delegations'));
    }

public function updatedelegation(Request $request, $id)
    {
        if($request->file('photo')){
           $photo = $request->file('photo');
           $file_name = $photo->getClientOriginalName();
           $photo->move(public_path().'/imags/', $file_name);
        }
        
        $message = 'Délégation modifié avec succés';
        $delegations = Chef_delegation::findOrFail($id);
        $delegations->prenom  = (empty($request->get('prenom'))) ? $delegations->prenom : $request->get('prenom');
        $delegations->nom  = (empty($request->get('nom'))) ? $delegations->nom : $request->get('nom');
        $delegations->photo  = (isset($file_name)) ? $file_name : $delegations->photo;
        DB::table('users')->where('id', $delegations->user_id)->update(['prenom' => $delegations->prenom]);
        DB::table('users')->where('id', $delegations->user_id)->update(['nom' => $delegations->nom]);
        $delegations->update();
        
        // if(!empty($request->get('fonction'))){
        //     DB::table('participants')
        //       ->where('user_id', Auth::id())
        //       ->update(['fonction' => $request->get('fonction')]); 
        // }
        
        return redirect('/madelegations')->with(['message' => $message]);   
    }
    //modifier mot de passe
    public function editsetting($id){
     $delegations = User::find($id);

    return view('User.setting', compact('delegations'));
}

public function settingsupdates(Request $request, $id)
{
    $message = 'Mot de passe  modifié avec succés';
    $delegations = User::findOrFail($id);   
    $delegations->password = Hash::make($request->get('password'));
    $delegations->update();
    return redirect('/madelegations')->with(['message' => $message]);  
}

  public function madelegation()
     {
        $delegations = DB::table('chef_delegations')->where('user_id', Auth::id())->first();
        $entreprise = DB::table('entreprises')->where('delege', Auth::id())->get();
        $participants = DB::table('participants')->where('delegation_id', $delegations->id)->get();
        $membres = DB::table('membres')->where('delegation_id', $delegations->id)->get();
        //$user = DB::table('users')->where('user_id', Auth::id())->first();
        $pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
            return view('User.madelegation', compact('delegations', 'entreprise', 'pays', 'participants','membres'));
     }
    
    //ajouter MEMBRE
   
    public function createmembre()
    {
        $enterprises = DB::table('entreprises')->get();
        $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
        return view('User.ajoutmembre', compact('enterprises', 'pays'));
    }
    public function storemembre(Request $request)
    {
        
        $delegations = DB::table('chef_delegations')->where('user_id', Auth::id())->first();
        $event = DB::table('events')->where('status','=', 1)->first();
        
        $message = 'Participant ajoutée avec succés';
        
        $user = new User;
        $user->prenom = $request->get('prenom');
        $user->nom = $request->get('nom');
        $user->email = $request->get('email');
        $user->portable = $request->get('portable');
        $user->profil = 2;
        
        //Password not hached
        $pass = Str::random(5);
    
        $user->password = Hash::make($pass);
        $user->event_id = $event->id;
    
        if($user->save())
        {
            $membre = new Membre;
            $membre->nom = $request->get('nom');
            $membre->prenom = $request->get('prenom');
            $membre->email = $request->get('email');
            //$membre->entreprise_id = $request->get('enterprise');
            $membre->event_id = $event->id;
            $membre->delegation_id = $delegations->id;
            $membre->pays_id = $request->get('pays_id');
            $membre->tel_part = $user->portable;
            $membre->user_id = $user->id;
            $membre->save();
            
            //\Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
                return redirect('/madelegations');
        }
    else
        {
            flash('User not saved')->error();
        }
        
        return redirect('/entrepriseajoutD')->with(['message' => $message]);

    }
     public function editmembre($id)
    {
        $pay= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
        $membre = Membre::find($id);
        
        return view('User.editmembre', compact('membre', 'pay'));
    }
    public function updatemembre(Request $request, $id)
    {
        $message = 'Membre modifié avec succés';
        $membre = Membre::findOrFail($id);
        $membre->prenom  = (empty($request->get('prenom'))) ? $membre->prenom : $request->get('prenom');
        $membre->nom  = (empty($request->get('nom'))) ? $membre->nom : $request->get('nom');
        $membre->email  = (empty($request->get('email'))) ? $membre->email : $request->get('email');
        $membre->tel_part  = (empty($request->get('tel_part'))) ? $membre->tel_part : $request->get('tel_part');
        $membre->pays_id  = (empty($request->get('pays_id'))) ? $membre->pays_id : $request->get('pays_id');
        $membre->update();
        DB::table('users')->where('id', $membre->user_id)->update(['prenom' => $membre->prenom]);
        DB::table('users')->where('id', $membre->user_id)->update(['nom' => $membre->nom]);
        DB::table('users')->where('id', $membre->user_id)->update(['email' => $membre->email]);
        DB::table('users')->where('id', $membre->user_id)->update(['portable' => $membre->portable]);
        DB::table('users')->where('id', $membre->user_id)->update(['pays_id' => $membre->pays_id]);
        return redirect('/madelegations')->with(['message' => $message]);   
    }
public function destroymembre($id) //supprimer 
    {
        $membre = Membre::find($id);
        $membre->delete();
        DB::table('users')->where('id', $membre->user_id)->delete();
        return back()->with('info', "Participant a bien Ã©tÃ© supprimÃ© dans la base de donnÃ©e.");
    }
 public function modifierp($id)
    {
        $monparticipant = Participant::find($id);
        
        return view('User.editparticipantD', compact('monparticipant'));
    }

public function updatep(Request $request, $id)
    {
        $message = 'Participant modifié avec succés';
        $monparticipant = Participant::findOrFail($id);
        $monparticipant->prenom  = (empty($request->get('prenom'))) ? $monparticipant->prenom : $request->get('prenom');
        $monparticipant->nom  = (empty($request->get('nom'))) ? $monparticipant->nom : $request->get('nom');
        $monparticipant->email  = (empty($request->get('email'))) ? $monparticipant->email : $request->get('email');
        $monparticipant->update();
        DB::table('users')->where('id', $monparticipant->user_id)->update(['prenom' => $monparticipant->prenom]);
        DB::table('users')->where('id', $monparticipant->user_id)->update(['nom' => $monparticipant->nom]);
        DB::table('users')->where('id', $monparticipant->user_id)->update(['email' => $monparticipant->email]);
        return redirect('/madelegations')->with(['message' => $message]);   
    }

public function destroyp($id) //supprimer 
    {
        $monparticipant = Participant::find($id);
        $monparticipant->delete();
DB::table('users')->where('id', $monparticipant->user_id)->delete();
        return back()->with('info', "Participant a bien Ã©tÃ© supprimÃ© dans la base de donnÃ©e.");
    }
    
    //ajouter et participant entreprise
    public function inscriptions()
{
    return view('User.ajouterentreprise1');
}
    public function saveajout(Request $request)
{
    $event =  DB::table('events')->where('status', 1 )->first();

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
    $user->admin = $request->get('admin');
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
            Auth::login($user);
            
             $message = 'Participant ajoutÃ©e avec succÃ©s';
        $participant = new Participant;
        $participant->nom = Auth::user()->nom;
        $participant->prenom = Auth::user()->prenom;
        $participant->email = Auth::user()->email;
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = Auth::user()->portable;
        $participant->langue_id = Auth::user()->langue_id;
        $participant->pays_id = Auth::user()->pays_id;
        $participant->user_id = Auth::user()->id;
        $participant->event_id = $event->id;
        $participant->save();   
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return redirect('/entrepriseajoutD');
        }
    else
        {
            flash('User not saved')->error();
        }
     
          
    $message = 'Vous etes inscrits avec succes';
    return redirect('/entrepriseajoutD')->with(['message' => $message]);
}
     public function createentreprise()
    {
        $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
        
        return view('User.ajouterentreprise', compact( 'pays', 'secteur', 'profil'));
    }
     public function storeentreprise(Request $request)
    {
        $message = 'Entreprise ajoutée avec succés';
        $event =  DB::table('events')->where('status', 1 )->first();
        $delegations = DB::table('chef_delegations')->where('user_id', Auth::id())->first();
        

        $entreprises = new Entreprise;
        $entreprises->nom_entreprise = $request->get('nom_entreprise');
        $entreprises->pay_id = $request->get('pay_id');
        $entreprises->secteur_a = $request->get('secteur_a');
        $entreprises->secteur_b = $request->get('secteur_b');
        $entreprises->secteur_c = $request->get('secteur_c');
        $entreprises->profile_entreprise_a = $request->get('profile_entreprise_a');
        $entreprises->profile_entreprise_b = $request->get('profile_entreprise_b');
        $entreprises->profile_entreprise_c = $request->get('profile_entreprise_c');
        $entreprises->autre_participant = $request->get('autre_participant');
        $entreprises->pays = $request->get('pays');
        $entreprises->rendez_vous = $request->get('rendez_vous');
        $entreprises->partenaire_rencontrer_a = $request->get('partenaire_rencontrer_a');
        $entreprises->partenaire_rencontrer_b = $request->get('partenaire_rencontrer_b');
        $entreprises->partenaire_rencontrer_c = $request->get('partenaire_rencontrer_c');
        $entreprises->profile_partenaire_rechercher_a = $request->get('profile_partenaire_rechercher_a');
        $entreprises->profile_partenaire_rechercher_b = $request->get('profile_partenaire_rechercher_b');
        $entreprises->profile_partenaire_rechercher_c = $request->get('profile_partenaire_rechercher_c');
        $entreprises->partenaire_rechercher = $request->get('partenaire_rechercher');
        $entreprises->user_id =  $request->get('user_id');
        $entreprises->delege =  Auth::user()->id;
        $entreprises->event_id = $event->id;
        $entreprises->save();
       
        // $participant = Participant::findOrFail($id);
        // $participant->fonction = $request->get('fonction');
        // $participant->entreprise_id = $entreprises->id;
        // $participant->save();
        
       
            $user = new User;
            $user->email = $request->get('email');
            $pass = Str::random(5);
    
        
            $prenom = $request->get('prenom');
            $nom = $request->get('nom');
            $email = $request->get('email');
            $entreprise_id = $request->get('entreprise_id');
            $presence = $request->get('presence');
            $pays_id = $request->get('pays_id');
            $event_id = $request->get('event_id');
            $delegation_id = $request->get('delegation_id');
            $user->password = Hash::make($pass);
            $profil = $request->get('profil');   
            
            
            for($i=0; $i < count($prenom); $i++){
            $participants = [
                
                'prenom' => $prenom[$i],
                'nom' => $nom[$i],
                'email' => $email[$i],
                'entreprise_id' => $entreprises->id,
                'event_id' => $event->id,
                'password' => $user->password,
                'profil' => $profil[$i],
                'presence' => $presence[$i],
                'pays_id' => $pays_id[$i],
                'delegation_id' => $delegations->id,
                'user_id' => $user->id
                ];
                
            DB::table('participants')->insert($participants);  
            DB::table('users')->insert($participants);  
            
            $users = DB::table('users')->get();
            foreach($users as $us)
            {
            DB::table('participants')->where('email', $us->email)->update(['user_id' => $us->id]);  
            }
            if(isset($user->email))
                \Mail::to($user->email)->send(new WelcomeEmail($user, $pass, $event));
            

            $uparticapants = DB::table('users')->where('profil', '=', 1)->where('entreprise_id', $entreprises->id)->first();
            DB::table('entreprises')->where('id', $entreprises->id)->update(['user_id' => $uparticapants->id]);
            
            }
             //\Mail::to($user->email)->send(new WelcomeEmail($user, $pass, $event));


    
        
        return redirect('/madelegations')->with(['message' => $message]);
    }
    public function modifierentreprise($id)
    {
        $entreprise = Entreprise::find($id);

        return view('User.modifierentreprise', compact('entreprise'));
    }
    
public function updatesentreprise(Request $request, $id) 
    {
        // if($request->file('photos')){
        //   $photo = $request->file('photos');
        //   $file_name = $photo->getClientOriginalName();
        //   $photo->move(public_path().'/photos/', $file_name);
        // }
        
        $message = 'Entreprise modifiée avec succés';
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->nom_entreprise = (empty($request->get('nom_entreprise'))) ? $entreprise->nom_entreprise : $request->get('nom_entreprise');
        $entreprise->site = (empty($request->get('site'))) ? $entreprise->site : $request->get('site');
        $entreprise->tel_entreprise = (empty($request->get('tel_entreprise'))) ? $entreprise->tel_entreprise : $request->get('tel_entreprise');
        $entreprise->slogan = (empty($request->get('slogan'))) ? $entreprise->slogan : $request->get('slogan');
        //$entreprise->photos  = (isset($file_name)) ? $file_name : $entreprise->photos;                
        $entreprise->update();
       
        return redirect('/madelegations')->with(['message' => $message]);   
    }
    public function destroye($id) //supprimer 
    {
        $entreprise = Entreprise::find($id);
        $entreprise->delete();

        return back()->with('info', "Entreprise a bien été supprimée dans la base de donnée.");
    }
    
    
     public function Ajoutdelegations()
    {
         $pays= DB::table('pays')->orderby('libelle_fr', 'asc')->get();      
        $langue= DB::table('langues')->get();
        $event= DB::table('events')->get();
        return view('Admin/delegation.Ajoutdelegations', compact( 'pays', 'langue', 'event'));
    }

    
    public function Storedelegations(Request $request)
    {
         request()->validate([
            'email' => 'required|email|unique:users,email',
    ]);
    
    $messages = 'Email existe déja dans la base de donnée';
    $event =  DB::table('events')->where('status', 1 )->first();
    
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
    $user->admin = 2;
    $user->code_event = $request->get('code_event');
    $user->event_id = $event->id;

    if($user->save())
        {
             $message = 'Chef de délégation ajouté avec succès';
            $delegation = new Chef_delegation;
            $delegation->prenom = $request->get('prenom');
            $delegation->nom = $request->get('nom');
            $delegation->email = $request->get('email');
            $delegation->event_id = $event->id;
            $delegation->user_id = $user->id;
            $delegation->save();
            
            Auth::login($user);
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return back()->with(['message' => $message]);
        }
    else
        {
            flash('User not saved')->error();
        }
   
    
    $message = 'Vous etes inscrits avec succes';
    return back()->with(['message' => $message]);
    }
}