<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\Participant;
use App\Models\User;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;
use DB;
use App\Notifications\RegisterNotify;

//mail namespace
use App\Mail\WelcomeEmail;
use App\Mail\KitEmail;

//random str generate 
use Str;


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
        $participan = DB::table('participants')->where('admin', 1)->first();
        
        
        return view('Admin/entreprise.entrepriseLister', compact('entreprises', 'participan'));
    }


    public function choice()
    {
        
        return view('User.choice');
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
     public function creates()
    {
        $pays= DB::table('pays')->get();
        $secteur= DB::table('secteur_activites')->get();
        $profil= DB::table('profils')->get();
        
        return view('User/ajouterentreprise', compact( 'pays', 'secteur', 'profil'));
    }

     //ajout entreprise par l'admin
    public function store(Request $request)
    {
        $message = 'Entreprise ajoutée avec succés';

        // $entreprises = new Entreprise;
        // $entreprises->pays_id = $request->get('pays_id');
        // $entreprises->secteur_activite_id = $request->get('secteur_a');
        // $entreprises->profil_id = $request->get('profil_a');
        // $entreprise->event_id = $request->get('event_id');
        // $entreprises->save();
    
        
        $message = 'Entreprise ajoutée avec succés';
        $event =  DB::table('events')->where('status', 1 )->first();
        $admin = DB::table('users')->where('admin', 1)->first();
        
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
        $entreprises->user_id = $request->get('user_id');
        $entreprises->event_id = $event->id;
        $entreprises->b2g = $request->get('b2g');
        $entreprises->save();
        
    
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
            
            
             /*for($i=0; $i < count($email); $i++){
                
                if($i == 0)
                    $profil = 1;
                    
                $pass = Str::random(5);
                 
                DB::table('users')->insert([
                [

                    'prenom' => $prenom[$i],
                    'nom' => $nom[$i],
                    'email' => $email[$i],
                    'password' => Hash::make($pass),
                ]
                ]);
                
                $user = DB::table('users')->orderBy('users.id','desc')->first();

                DB::table('participants')->insert([
                [
                    
                    'prenom' => $prenom[$i],
                    'nom' => $nom[$i],
                    'email' => $email[$i],
                    'pays_id' => $pays_id[$i],
                    'entreprise_id' => $entreprises->id,
                    'user_id' => $user->id,
                    'presence' => $presence[$i],
                    'event_id' => $event->id,
                    'password' => $user->password,
                    'profil' => $profil
                
                ]
                ]);
                
                
               
                
           //     $uparticapants = DB::table('users')->where('profil', '=', 1)->where('entreprise_id', $entreprises->id)->first();
            //    DB::table('entreprises')->where('id', $entreprises->id)->update(['user_id' => $uparticapants->id]);
            
            } */
            
             //\Mail::to($user->email)->send(new WelcomeEmail($user, $pass, $event));


    
       
        return redirect('/entreprises')->with(['message' => $message]);
        
        
    }
    public function inscriptionentreprise(Request $request, $id)
    {
        $event =  DB::table('events')->where('status', 1 )->first();
        $message = 'Entreprise ajoutée avec succés';

        $entreprises = new Entreprise;
        $entreprises->nom_entreprise = $request->get('nom_entreprise');
        $entreprises->pay_id = $request->get('pay_id');
        $entreprises->secteur_a = $request->get('secteur_a');
        $entreprises->secteur_b = $request->get('secteur_b');
        $entreprises->profile_entreprise_a = $request->get('profile_entreprise_a');
        $entreprises->profile_entreprise_b = $request->get('profile_entreprise_b');
        $entreprises->autre_participant = $request->get('autre_participant');
        $entreprises->pays = $request->get('pays');
        $entreprises->rendez_vous = $request->get('rendez_vous');
        $entreprises->user_id = Auth::user()->id;
        $entreprises->save();
        $participant = Participant::findOrFail($id);
        $participant->fonction = $request->get('fonction');
        $participant->profil = $request->get('profil');
        $participant->event_id = $event->id;
        $participant->b2g = $request->get('b2g');
        $participant->save();
        return redirect('/entreprises')->with(['message' => $message]);
    }
    
    //step 2
    
    public function fonction(Request $request, $id)
    {
        $prenom = Auth::user()->prenom;
        $alerte = "Bienvenue"." ". $prenom.","." "."au SBPME 2023. Vos identifiants de connexion vous ont été envoyés à l’adresse fournie.";
        $message ="Entreprise ajoutée";
        
        $event =  DB::table('events')->where('status', 1 )->first();

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
        $entreprises->user_id = Auth::user()->id;
        $entreprises->event_id = $event->id;
        $entreprises->b2g = $request->get('b2g');
        $entreprises->save();
        
        $participant = Participant::findOrFail($id);
        $participant->fonction = $request->get('fonction');
        $participant->entreprise_id = $entreprises->id;
        $participant->hebergement = $request->get('hebergement');
        $participant->type_hebergement = $request->get('type_hebergement');
        $participant->visa = $request->get('visa');
        $participant->kit = $request->get('kit');
        $participant->stand = $request->get('stand');
        $participant->stand_type = $request->get('stand_type');
        $participant->village_id = $request->get('village_id');
        $participant->village = $request->get('village');
        $participant->type_village = $request->get('type_village');
        $participant->type_village1 = $request->get('type_village1');
        $participant->type_village2 = $request->get('type_village2');
        $participant->caravane = $request->get('caravane');
        $participant->type_caravane = $request->get('type_caravane');
        $participant->badge_id = $request->get('badge_id');
        $participant->b2g = $entreprises->b2g;
        $participant->demande_officiel = $request->get('demande_officiel');
        $participant->save();
        
        $use = DB::table('participants')->select('users.*')
                        ->join('users', 'users.id', 'participants.user_id')
                        ->where('participants.id', $id)
                        ->first();
        $more = array();
        if($participant->kit)
            $more['kit'] = $participant->kit;
            
        if($participant->stand)
            $more['stand'] = $participant->stand;
        
        if($participant->visa)
            $more['visa'] = $participant->visa;
            
        $principal = 1;
        
        $pass = 0;
        
        $sendTo = array();

        if($use){
            $user = [
                'prenom' => $use->prenom,
                'nom' => $use->nom,
                'email' => $use->email,
            ];
            
            if(!empty($more)){
                array_push($sendTo, $user['email']);
                \Mail::to($sendTo)->send(new kitEmail($user, $more, $pass, $event, $principal, $participant));
            }
        }
        
        $officials = $request->officials;

        
        if($officials)
            foreach($officials as $official){
                DB::table('officiel_participants')->insert([
                        ['participant_id' => $id, 'officiel_id' => $official]
                    ]);
        }

       
        $prenoms = $request->get('prenom');
        $noms = $request->get('nom');
        $emails = $request->get('email');
        
        /*
        $entreprise_id = $request->get('entreprise_id');
        $event_id = $request->get('event_id');
        */

        /*
        if(!empty($more))
        send email request from user to SBPME
        */

        /*
        *
        */
        $sendTo = null;
        $sendTo = array();
        

        if(!empty($emails)){
            for($i=0; $i < count($emails) ; $i++){
                $principal = 0;
                $pass = Str::random(5);
                $password = Hash::make($pass);
        
                $data = [
                    'email' => $emails[$i],
                    'prenom' => $prenoms[$i],
                    'nom' => $noms[$i],
                    'kit' => $participant->kit,
                    'stand' => $participant->stand,
                    'entreprise_id' => $entreprises->id,
                    'event_id' => $event->id,
                    'password' => $password,
                ];
                
                if($data['email'] != null){
                    array_push($sendTo, $data['email']);
                    $user_ps = User::create($data);
                    \Mail::to($sendTo)->send(new WelcomeEmail($user_ps, $pass , $event));

                    $data['kit'] = $participant->kit;
                    $data['stand'] = $participant->stand;
                    $data['user_id'] = $user_ps->id;
                    
                    DB::table('participants')->insert($data); 
                }
               
            
            }
        }
        
        $ent = DB::table('entreprises')->where('user_id', Auth::user()->id)->where('rendez_vous', '=', 'AVEC un planning B 2 B')->first();
        if($ent)
        return redirect('/inscriptionstep3')->with(['message' => $message]);
        else
         return redirect('/home')->with(['alerte' => $alerte]);
    }
    
     public function fonctionvisit(Request $request, $id)
    {
        $prenom = Auth::user()->prenom;
        $alerte = "Bienvenue"." ". $prenom.","." "."au SBPME 2023. Vos identifiants de connexion vous ont été envoyés à l’adresse fournie.";
        $message ="Entreprise ajoutée";
        
        $event =  DB::table('events')->where('status', 1 )->first();

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
        $entreprises->user_id = Auth::user()->id;
        $entreprises->event_id = $event->id;
        $entreprises->b2g = $request->get('b2g');
        $entreprises->save();
        
        $participant = Participant::findOrFail($id);
        $participant->fonction = $request->get('fonction');
        $participant->entreprise_id = $entreprises->id;
        $participant->hebergement = $request->get('hebergement');
        $participant->type_hebergement = $request->get('type_hebergement');
        $participant->visa = $request->get('visa');
        $participant->kit = $request->get('kit');
        $participant->stand = $request->get('stand');
        $participant->village_id = $request->get('village_id');
        $participant->village = $request->get('village');
        $participant->type_village = $request->get('type_village');
        $participant->type_village1 = $request->get('type_village1');
        $participant->type_village2 = $request->get('type_village2');
        $participant->caravane = $request->get('caravane');
        $participant->type_caravane = $request->get('type_caravane');
        $participant->badge_id = $request->get('badge_id');
        $participant->b2g = $entreprises->b2g;
        $participant->demande_officiel = $request->get('demande_officiel');
        $participant->save();
        
        $use = DB::table('participants')->select('users.*')
                        ->join('users', 'users.id', 'participants.user_id')
                        ->where('participants.id', $id)
                        ->first();
        $more = array();
        if($participant->kit)
            $more['kit'] = $participant->kit;
            
        if($participant->stand)
            $more['stand'] = $participant->stand;
        
        if($participant->visa)
            $more['visa'] = $participant->visa;
            
        $principal = 1;
        
        $pass = 0;
        
        $sendTo = array();

        if($use){
            $user = [
                'prenom' => $use->prenom,
                'nom' => $use->nom,
                'email' => $use->email,
            ];
            
            if(!empty($more)){
                array_push($sendTo, $user['email']);
                \Mail::to($sendTo)->send(new kitEmail($user, $more, $pass, $event, $principal, $participant));
            }
        }
        
        $officials = $request->officials;

        
        if($officials)
            foreach($officials as $official){
                DB::table('officiel_participants')->insert([
                        ['participant_id' => $id, 'officiel_id' => $official]
                    ]);
        }

       
        $prenoms = $request->get('prenom');
        $noms = $request->get('nom');
        $emails = $request->get('email');
        
        /*
        $entreprise_id = $request->get('entreprise_id');
        $event_id = $request->get('event_id');
        */

        /*
        if(!empty($more))
        send email request from user to SBPME
        */

        /*
        *
        */
        $sendTo = null;
        $sendTo = array();
        

        if(!empty($emails)){
            for($i=0; $i < count($emails) ; $i++){
                $principal = 0;
                $pass = Str::random(5);
                $password = Hash::make($pass);
        
                $data = [
                    'email' => $emails[$i],
                    'prenom' => $prenoms[$i],
                    'nom' => $noms[$i],
                    'kit' => $participant->kit,
                    'stand' => $participant->stand,
                    'entreprise_id' => $entreprises->id,
                    'event_id' => $event->id,
                    'password' => $password,
                ];
                
                if($data['email'] != null){
                    array_push($sendTo, $data['email']);
                    $user_ps = User::create($data);
                    \Mail::to($sendTo)->send(new WelcomeEmail($user_ps, $pass , $event));

                    $data['kit'] = $participant->kit;
                    $data['stand'] = $participant->stand;
                    $data['user_id'] = $user_ps->id;
                    
                    DB::table('participants')->insert($data); 
                }
               
            
            }
        }
        
        
         return redirect('/homeInscriptionSansEnt')->with(['alerte' => $alerte]);
    }
 
    //step 3
  
    public function secteurrechercher(Request $request, $id)
    {
        $prenom = Auth::user()->prenom;
        $alerte = "Bienvenue"." ". $prenom.","." "."au SBPME 2023. Vos identifiants de connexion vous ont été envoyés à l’adresse fournie.";
        $alerteenglish = "/ Welcome  to SBPME 2023. Your login details have been sent to the address provided";

        $entreprises = Entreprise::findOrFail($id);
        $entreprises->partenaire_rencontrer_a = $request->get('partenaire_rencontrer_a');
        $entreprises->partenaire_rencontrer_b = $request->get('partenaire_rencontrer_b');
        $entreprises->partenaire_rencontrer_c = $request->get('partenaire_rencontrer_c');
        $entreprises->profile_partenaire_rechercher_a = $request->get('profile_partenaire_rechercher_a');
        $entreprises->profile_partenaire_rechercher_b = $request->get('profile_partenaire_rechercher_b');
        $entreprises->profile_partenaire_rechercher_c = $request->get('profile_partenaire_rechercher_c');
        $entreprises->partenaire_rechercher = $request->get('partenaire_rechercher');
        $entreprises->save();
        
       
        return redirect('/home')->with(['alerte' => $alerte]);

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
        $messagee = 'Entreprise modifié avec succés';

        $entreprises = Entreprise::find($id);
        $entreprises->nom_entreprise = (empty($request->get('nom_entreprise'))) ? $entreprises->nom_entreprise : $request->get('nom_entreprise');
        $entreprises->site = (empty($request->get('site'))) ? $entreprises->site : $request->get('site');
        $entreprises->tel_entreprise = (empty($request->get('tel_entreprise'))) ? $entreprises->tel_entreprise : $request->get('tel_entreprise');
        $entreprises->slogan = (empty($request->get('slogan'))) ? $entreprises->slogan : $request->get('slogan');
        $entreprises->photos  = (isset($file_name)) ? $file_name : $entreprises->photos;                
        $entreprises->update();
       
        return redirect('/entreprises')->with(['message' => $messagee]);   
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
