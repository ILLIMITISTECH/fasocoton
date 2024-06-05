<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Demande_b2g;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use DB;
use Auth;

//mail namespace
use App\Mail\WelcomeEmail;
use App\Mail\SuiviDemandeB2g;

//random str generate 
use Str;

class ParticipantController extends Controller
{
   public function choix()
   {
       return view('Admin/participant.choixparticipant');
   }
   
    public function participant_stand()
    {
        //
        $participant = DB::table('participants')->where('email', '!=', 'exemple@gmail.com')->where('stand', 1)->get();

        return view('Admin/participant.participant_stand', compact('participant'));
    }
    
    public function participant_badge()
    {
        //
        $participant = DB::table('participants')->where('email', '!=', 'exemple@gmail.com')->where('badge_id', '!=', NULL)->where('badge_id', '!=', 1)->get();
        
        return view('Admin/participant.participant_badge', compact('participant'));
    }
    // public function participant_village()
    // {
    //     //
    //     $participant = DB::table('participants')->where('email', '!=', 'exemple@gmail.com')->where('village', '!=', 'null')->get();

    //     return view('Admin/participant.participant_village', compact('participant'));
    // }
    
    public function index()
    {
        //
        $participant = DB::table('participants')->where('email', '!=', 'exemple@gmail.com')->get();

        return view('Admin/participant.participantLister', compact('participant'));
    }

    //demande B2G
    
    public function createB2G()
    {
        return view('User.demandeB2G');
    }
     public function ajoutB2G(Request $request)
    {
        $event =  DB::table('events')->where('status', 1 )->first();
        $participanss = DB::table('participants')->where('user_id', Auth::user()->id)->first();
        $message = "Votre demande a été bien prise en compte";
        $demandeb2bg = new Demande_b2g;
        $demandeb2bg->dificulte1 = $request->get('difficulte1');
        $demandeb2bg->dificulte2 = $request->get('difficulte2');
        $demandeb2bg->dificulte3 = $request->get('difficulte3');
        $demandeb2bg->aide = $request->get('aide');
        $demandeb2bg->details = $request->get('details');
        $demandeb2bg->participant_id = $participanss->id;
        $demandeb2bg->save();
        
        
        return back()->with(['message' => $message]);

    } 
    //admin demande b2g
    
    public function accepter(Request $request, $id)
    {
        $message = "Demande acceptée";
        $accepter = Demande_b2g::findorfail($id) ;
        $accepter->statut  = 1;
        $accepter->save();
        
        $participant = DB::table('participants')->where('id', $accepter->participant_id)->first();
        $user = User::where('id', $participant->user_id)->first();
        \Mail::to($user['email'])->send(new SuiviDemandeB2g($user, $accepter));
        return back()->with(['message' => $message]);
    }

    public function refuser(Request $request, $id)
    {
        $message = "Demande refusée";
        $accepter = Demande_b2g::findorfail($id) ;
        $accepter->statut  = 2;
        $accepter->save();
        
        $participant = DB::table('participants')->where('id', $accepter->participant_id)->first();
        $user = User::where('id', $participant->user_id)->first();
        
        \Mail::to($user['email'])->send(new SuiviDemandeB2g($user, $accepter));
        return back()->with(['message' => $message]);
    }
    
        public function suivi_demandeb2g()
    {
        $participans = DB::table('participants')->where('user_id', Auth::user()->id)->first();
        $demandeb2gs = DB::table('demande_b2gs')->where('participant_id', $participans->id)->get();
        return view('User.suividemande', compact('demandeb2gs', 'participans'));
    }
    public function listerB2G()
    {
       // $participantss = DB::table('participants')->where('user_id', Auth::user()->id)->first();
        $demandeur = DB::table('demande_b2gs')
        ->select('demande_b2gs.*', 'participants.prenom', 
        'participants.nom', 'participants.fonction', 
        'entreprises.nom_entreprise', 'entreprises.secteur_a',
        'entreprises.profile_entreprise_a')
        ->join('participants', 'participants.id', 'demande_b2gs.participant_id')
        ->join('entreprises', 'participants.entreprise_id', 'entreprises.id')
        ->get();
        return view('Admin.demandeB2Glister', compact('demandeur'));
    }
     public function showdemandeur($id)
    {
        $demandeurs = Demande_b2g::find($id);
        return view('Admin.demandeB2GDetail', compact('demandeurs'));
    }
   
    //....
    
    public function create()
    {
        $entreprise= DB::table('entreprises')->get();
        $langue= DB::table('langues')->get();
        $pays= DB::table('pays')->get();
        
        return view('Admin/participant.participantCreate', compact( 'langue', 'pays', 'entreprise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //M.A.X B.I.R.D was here, sorry for damage
        
        request()->validate([
            'email' => 'required|email|unique:users,email',
    ]);
        
        $event =  DB::table('events')->where('status', 1 )->first();

        
        $message = "Votre utilisateur 'pré-inscrit' a été ajoutée avec succès";
        
        $pass = Str::random(5);
        
        //User save
        $user = new User;
         
        $user->nom = $request->get('nom');
        $user->prenom = $request->get('prenom');
        $user->email = $request->get('email');
        $user->portable = $request->get('tel_part');
        $user->langue_id = $request->get('langue_id');
        $user->pays_id = $request->get('pays_id');
        $user->presence = $request->get('presence');
        $user->need = 1;
        $user->event_id = $event->id;
        $user->profil = 1;
        
        $user->password = Hash::make($pass);

        $user->save();
        
        
        //Participant save
        
        $participant = new Participant;
        $participant->nom = $request->get('nom');
        $participant->prenom =  $request->get('prenom');
        $participant->email = $request->get('email');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = $request->get('tel_part');
        $participant->langue_id = $request->get('langue_id');
        $participant->pays_id = $request->get('pays_id');
        //$participant->user_id = Auth::user()->id;
        $participant->event_id = $event->id;
        $participant->profil = 1;
        $participant->user_id = $user->id;
        $participant->save();   
        
   
    
        //$messages = 'Email existe déja dans la base de donnée';

    if($user->save())
        {
            \Mail::to($user['email'])->send(new WelcomeEmail($user, $pass, $event));
            return back()->with(['message' => $message]);
        }
    else
        {
            flash('User not saved')->error();
        }
     
    }
    public function userparticipant(Request $request)
    {
        $event = DB::table('events')->where('status', '=', 1)->first();
        $message = 'Participant ajoutée avec succés';
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

        $participant->presence = $request->get('presence');
        $participant->save();
        return redirect('/inscriptionstep1')->with(['message' => $message]);

    }
    public function presenceparticipant(Request $request, $id)
    {
        $message = 'Participant ajoutée avec succés';
        $participant = Participant::findOrFail($id);
        $participant->presence = 1;
        $participant->save();
        return redirect('/inscriptionstep2')->with(['message' => $message]);

    }
    public function presenceparticipantnon(Request $request, $id)
    {
        $message = 'Participant ajoutée avec succés';
        $participant = Participant::findOrFail($id);
        $participant->presence = 2;
        $participant->save();
        return redirect('/inscriptionstep2')->with(['message' => $message]);

    }
    public function fonction(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->fonction = $request->get('fonction');
        $participant->save();
        return redirect('/inscriptionstep3');

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
        $participant = Participant::find($id);

        return view('Admin/participant.participantEdit', compact('participant'));
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
        $message = 'Participant modifée';
        $participant = Participant::find($id);
        $participant->nom = $request->get('nom');
        $participant->prenom = $request->get('prenom');
        $participant->email = $request->get('email');
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = $request->get('tel_part');
        $participant->langue_id = $request->get('langue_id');
        $participant->pays_id = $request->get('pays_id');
        $participant->presence = $request->get('presence');
        $participant->update();
        DB::table('users')->where('id', $participant->user_id)->update(['prenom' => $participant->prenom]);
        DB::table('users')->where('id', $participant->user_id)->update(['nom' => $participant->nom]);
        DB::table('users')->where('id', $participant->user_id)->update(['email' => $participant->email]);
        DB::table('users')->where('id', $participant->user_id)->update(['portable' => $participant->portable]);
        DB::table('users')->where('id', $participant->user_id)->update(['langue_id' => $participant->langue_id]);
        DB::table('users')->where('id', $participant->user_id)->update(['pays_id' => $participant->pays_id]);
        DB::table('users')->where('id', $participant->user_id)->update(['presence' => $participant->presence]);
       
        return redirect('/participants')->with(['message' => $message]);   
    }


public function editStand($id)
    {
        $participant = Participant::find($id);

        return view('Admin/participant.participantStandEdit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStand(Request $request, $id)
    {
        $message = 'Participant modifée';
        $participant = Participant::find($id);
        $participant->nom = $request->get('nom');
        $participant->prenom = $request->get('prenom');
        $participant->email = $request->get('email');
        $participant->entreprise_id = $request->get('entreprise_id');
        $participant->fonction = $request->get('fonction');
        $participant->tel_part = $request->get('tel_part');
        $participant->langue_id = $request->get('langue_id');
        $participant->pays_id = $request->get('pays_id');
        $participant->presence = $request->get('presence');
        $participant->update();
        DB::table('users')->where('id', $participant->user_id)->update(['prenom' => $participant->prenom]);
        DB::table('users')->where('id', $participant->user_id)->update(['nom' => $participant->nom]);
        DB::table('users')->where('id', $participant->user_id)->update(['email' => $participant->email]);
        DB::table('users')->where('id', $participant->user_id)->update(['portable' => $participant->portable]);
        DB::table('users')->where('id', $participant->user_id)->update(['langue_id' => $participant->langue_id]);
        DB::table('users')->where('id', $participant->user_id)->update(['pays_id' => $participant->pays_id]);
        DB::table('users')->where('id', $participant->user_id)->update(['presence' => $participant->presence]);
       
        return redirect('/participant_stand')->with(['message' => $message]);   
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participant = Participant::find($id);
        $participant->delete();
        DB::table('users')->where('id', $participant->user_id)->delete();
        return back()->with('info', "participant supprimé dans la base de donnée.");
    }
    
    public function destroy_participantStand($id)
    {
        $participant = Participant::find($id);
        $participant->delete();
        DB::table('users')->where('id', $participant->user_id)->delete();
        return back()->with('info', "participant supprimé dans la base de donnée.");
    }
    
     public function message(){

        $entreprises = Entreprise::where('user_id', Auth::user()->id)->orderBY('created_at','DESC')->paginate(1);
        $participants =  Entreprise::where('user_id', Auth::user()->id)->orderBY('created_at','DESC')->paginate(1);

        $events = DB::table('events')->select('events.*')->where('status','=',1)->get();
        return view('Admin/participant.messages', compact('entreprises','participants','events'));
    }
    //participant secondiare
    public function participantsecond()
     {
        
            return view('User.participantsecond');
     }
     
     public function inscriptions_participants()
   {
       return view('User/inscriptions_participants');
   }
      public function inscriptions_participants_store(Request $request)
    {
        $event =  DB::table('events')->where('status', 1 )->first();
       
            $messages = 'Email existe déja dans la base de donnée';
            $event =  DB::table('events')->where('status', 1 )->first();
            $user = new User;
            $user->prenom = $request->get('prenom');
            $user->nom = $request->get('nom');
            $user->email = $request->get('email');
            $user->portable = $request->get('portable');
            if($user->save())
                {
        $message = "Inscription réussie !";
        $inscription = new Participant;
        $inscription->nom = $request->get('nom');
        $inscription->prenom = $request->get('prenom');
        $inscription->email = $request->get('email');
        $inscription->structure = $request->get('structure');
        $inscription->tel_part = $user->portable;
        $inscription->fonction = $request->get('fonction');
        $inscription->presence = 1;
        $inscription->save();
                }
        return back()->with(['message' => $message]);
    }
}
