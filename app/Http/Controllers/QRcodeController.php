<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Auth;
use DB;

use Illuminate\Support\Facades\Crypt;

class QRcodeController extends Controller
{
    //
    //participant principal
    public function generate () {

    	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$entreprise = DB::table('entreprises')->where('user_id', Auth::user()->id)->first();
    	//$participant = DB::table('participants')->where('entreprise_id', $entreprise->id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view("qrCode.index", compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    //participant secondaire
     public function codeqr () {

    	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$participant = DB::table('participants')->where('user_id', Auth::user()->id)->first();
    	//$entreprise = DB::table('entreprises')->where('id', $participant->entreprise_id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        
        $p_entreprise = DB::table('entreprises')->where('id', $fonction->entreprise_id)->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view("User.qrcodePSecondaire", compact('qrcode', 'fonction', 'p_entreprise', 'pays'));
    }
    
    public function membre()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$pays = DB::table('pays')->where('id', $membr->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.homemembre', compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    
    public function intervenant()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeIntervenant', compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    
     public function deleguer()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeDeleguer', compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    
    public function facilitateur()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeFacilitateur', compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    
    public function organisateur()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$pays = DB::table('pays')->where('id', Auth::user()->pays_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeOrganisateur', compact('qrcode', 'fonction', 'nomentreprise', 'pays'));
    }
    
     public function partsansentr()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$langues = DB::table('langues')->where('id', Auth::user()->langue_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom, Langue: $langues->libelle_eng");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodePsansEntr', compact('qrcode', 'fonction', 'nomentreprise', 'langues'));
    }
    
    public function traducteur()
    {
        	# 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$langues = DB::table('langues')->where('id', Auth::user()->langue_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom, Langue: $langues->libelle_eng");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeTraducteur', compact('qrcode', 'fonction', 'nomentreprise', 'langues'));
    }
    
    public function participant()
    {
        # 2. On génère un QR code de taille 200 x 200 px
    	$user = DB::table('users')->where('id', Auth::user()->id)->first();
    	//$membr = DB::table('membres')->where('user_id', $user->id)->first();
    	$langues = DB::table('langues')->where('id', Auth::user()->langue_id)->first();
    	$event = DB::table('events')->where('status', 1)->first();

    	$qrcode = QrCode::size(200)->generate("Evenement: $event->nom_event_fr, Prénom: $user->prenom, Nom: $user->nom, Langue: $langues->libelle_eng");
    
    	$fonction = DB::table('participants')->where('user_id', Auth::id())->first();
        $nomentreprise = DB::table('entreprises')->where('user_id', Auth::id())->first();
        # 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view('User.qrcodeParticipant', compact('qrcode', 'fonction', 'nomentreprise', 'langues'));
    }
    
    public function sessuggestion()
    {
       
        return view('User.sesSuggestions');
    }
    
    
    
    
    /*
    ** M.A.X B.I.R.D was HERE : READ QR 
    */
     public function read($data){
        $id = intval(Crypt::decryptString($data)); 
        $user = DB::table('users')->where('id', $id)->first();
    	$qrcode = DB::table('qrcode')->get();
    	//dd($user->id);
    	$scan = false;

    	$message = "";
    	
    	$event = DB::table('events')->where('status', '=', 1)
            //->join('users', 'events.id', 'users.event_id')
            //->where('id', $user->event_id)
            ->first();
            
        $enterprise = DB::table('entreprises')->select('entreprises.*')
            ->join('users', 'users.id', 'entreprises.user_id')
            ->where('entreprises.user_id', $user->id)
            ->first();
        
        $participant = DB::table('participants')->select('participants.*')
            ->join('users', 'participants.user_id', 'users.id')
            ->where('users.id', $user->id)
            ->first();
            
        foreach($qrcode as $qr){
            if($qr->user_id == $user->id && $qr->event_id == $user->event_id){
                $scan = true;
                $break;
            }
        }
        
        if(empty($user)){
    	    $message = "Nous n'avons pas pu vous retrouvés les informations concernant ce qrcode";
    	    return view('qrCode.parse', compact('user', 'event',  'enterprise', 'participant', 'message'));
        }
        
        if($event)
            $event_id = $event->id;
           
        else
            $event_id = null;
        
        if($scan)
             DB::table('qrcode')
            ->where('user_id', $user->id)
            ->update(['updated_at' => now()]);
        else 
            DB::table('qrcode')->insert([
                ['user_id' => $user->id,'event_id' =>  $event_id]
            ]);
    	 //dd($user->id);  
    	return view('qrCode.parse', compact('user', 'event','enterprise', 'participant', 'message'));
        
    }
}
