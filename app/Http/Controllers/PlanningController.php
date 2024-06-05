<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\Planning_f;
use App\Models\Entreprise;
use App\Models\Participant;
use App\Models\Entreprise_rv;
use DB;
use PDF;
use Auth;
use App\Models\User;  
use Session;
use App\Mail\RappelSuggestion;
use Mail;


class PlanningController extends Controller
{
    
    // Generate PDF
    public function createPDF() {
    
      $plannings = array();
      $entreprise = DB::table('entreprise_rvs')->where('user_id', Auth::id())->first();
      
      // retreive all records from db
      $planningss = DB::table('plannings')->where('entreprise_rv_id', $entreprise->id)->get();
      $input = array();
      // share data to view
      
      if($planningss)
                foreach($planningss as $planning)
                    if(!in_array($planning->entreprise_id, $input)){
                        array_push($input, $planning->entreprise_id);
                        array_push($plannings, $planning);  
                    }
      view()->share('plannings',$plannings);
      $pdf = PDF::loadView('mon_planning', $plannings)->setOptions(['defaultFont' => 'sans-serif']);
      // download PDF file with download method
      return $pdf->download('mon_planning.pdf');
    }
    
    public function mail_rappel()
    {
        $event =  DB::table('events')->where('status', 1 )->first();
        $prenom = "fALLOU";
        //$user = "fallou.g@illimitis.com";
        $users = DB::table('entreprises')->select('entreprises.*', 'users.prenom', 'users.nom', 'users.email')
                ->join('users', 'users.id', 'entreprises.user_id')
                ->where('entreprises.rendez_vous', 'AVEC un planning B 2 B')
                ->where('entreprises.event_id', $event->id)
                ->get();
        //dd(count($users));
        foreach ($users as $user) {
            \Mail::to($user->email)->send(new RappelSuggestion($user, $event));
        }
        //\Mail::to($user)->send(new RappelSuggestion($prenom, $user, $event));
         
         dd('Okay');
        //return view('Admin.planningslister', compact('planing'));
    }
    
    public function listerplannings()
    {
        $planing = array();
        $planningss = DB::table('plannings')->get();
        
        $input = array();
      // share data to view
      
      if($planningss)
                foreach($planningss as $planning)
                    if(!in_array($planning->entreprise_id, $input)){
                        array_push($input, $planning->entreprise_id);
                        array_push($planing, $planning);  
                    }

        return view('Admin.planningslister', compact('planing'));
    }
    
    
      public function editplanning($id)
    {
        $planing = Plannings::find($id);
        $entreprise= DB::table('entreprises')->get();
        $salle= DB::table('salles')->get();
        $entreprise_rv= DB::table('entreprises_rvs')->get();
        return view('Admin.editplanning', compact('planing', 'entreprise', 'entreprise_rv', 'salle'));
    }
    public function updateplanning(Request $request, $id)
    {
        $message = 'Plannings modifié avec succés';

        $planing = Plannings::find($id);
        $planing->entreprise_id = $request->get('entreprise_id');
        $planing->entreprise_rv_id = $request->get('entreprise_rv_id');
        $planing->sale_id = $request->get('sale_id');
        $planing->date_rv = $request->get('date_rv');
        $planing->update();
       
        return redirect('/adminplannings')->with(['message' => $message]);   

    }
    public function destroy($id)
    {
        $planing = Plannings::find($id);
        $planing->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }

    
    
    
    
    public function planning()
    {
         
        //$plannings = Planning::orderBy('id')->get();
        //$plannings = Planning::where('user_id', Auth::user()->id)->orderBY('created_at','DESC')->paginate(10);
        $plannings = DB::table('plannings')->distinct()->select('entreprise_rvs.nom_entreprise as nom_ent','entreprise_rvs.id as my_id', 'entreprises.nom_entreprise',
        'entreprises.pays','entreprises.id','entreprise_rvs.pays as pay_ent','entreprise_rvs.portable as tel','entreprise_rvs.nom as mon_nom',
        'entreprise_rvs.prenom as mon_prenom','entreprise_rvs.email as mon_email','entreprise_rvs.description', 'plannings.libelle_t', 'plannings.date_rv','plannings.lien', 'plannings.heure_deb', 'plannings.heure_fin')
       ->leftJoin('entreprise_rvs','entreprise_rvs.id','plannings.entreprise_rv_id')
       ->leftJoin('entreprises','entreprises.id','plannings.entreprise_id')
       //->leftJoin('users','users.id','plannings.user_id')
       ->orderBY('date_rv','ASC')->orderBY('heure_deb','ASC')->get();   




        return view('plannings.index',compact('plannings'))
        ->with('i', (request()->input('page', 1) - 1) * 5); 

    }
   
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function mon_planning_final() 
    {
         //  
        
       /*  $planning = Entreprise_rv::where('user_id', Auth::user()->id)->get();
        $plannings = Planning_f::where('user_id', Auth::user()->id)->orderBY('priorite','DESC')->get();
        foreach($planning as $plann){
        $planningss = Planning_f::where('entreprise_rv_id','=',$plann->id)->orderBY('priorite','DESC')->get();
         } */
         //dd($planningss);
         //dd($montant);
       $planning = Entreprise_rv::where('user_id', Auth::user()->id)->get();
       foreach($planning as $plann){
        $plannings = Planning::where('entreprise_id','=',$plann->id)->orderBY('priorite','DESC')->get();       
        $planningss = Planning::where('entreprise_rv_id','=',$plann->id)->orderBY('priorite','DESC')->get();
      }
       /* $plannings = DB::table('plannings')->distinct()->select('entreprise_rvs.nom_entreprise as nom_ent', 'entreprises.nom_entreprise',
        'entreprises.pays', 'entreprises.portable','entreprises.id as my_id','entreprise_rvs.portable as tel','entreprises.nom','entreprises.prenom',
        'entreprise_rvs.nom as mon_nom','entreprise_rvs.prenom as mon_prenom','entreprise_rvs.email as mon_email','entreprises.user_id','entreprise_rvs.user_id','entreprise_rvs.pays as pay_ent','entreprise_rvs.description', 
        'plannings.libelle_t','plannings.priorite','plannings.id','plannings.entreprise_id', 'plannings.date_rv', 'plannings.heure_deb', 'plannings.heure_fin')
       ->leftJoin('entreprise_rvs','entreprise_rvs.id','plannings.entreprise_rv_id')
       ->leftJoin('entreprises','entreprises.id','plannings.entreprise_id')
       ->leftJoin('users','users.id','plannings.user_id')
       ->where('plannings.user_id', Auth::user()->id)
       ->orderBY('date_rv','DESC')->distinct('id')->get();   
      */
 
$activites = DB::table('activites')
        ->select('activites.id','activites.nom','activites.lien','activites.date','activites.heure_debut','activites.heure_fin')
        ->get();
        
        return view('plannings.mon_planning_final2',compact('activites'))
        ->with('i', (request()->input('page', 1) - 1) * 5); 
  

  

    }

     /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function mon_planning() 
    {
         //  
        
        $planning = Entreprise_rv::where('user_id', Auth::user()->id)->get();
        foreach($planning as $plann){
         $plannings = Planning_f::where('entreprise_id', '=',$plann->id)->orderBY('priorite','DESC')->get();
        $planningss = Planning_f::where('entreprise_rv_id','=',$plann->id)->orderBY('priorite','DESC')->get();
      }
         //dd($planningss);
         //dd($montant);
       /*  $plannings = DB::table('plannings')->distinct()->select('entreprise_rvs.nom_entreprise as nom_ent', 'entreprises.nom_entreprise',
        'entreprises.pays', 'entreprises.portable','entreprises.id as my_id','entreprise_rvs.portable as tel','entreprises.nom','entreprises.prenom',
        'entreprise_rvs.nom as mon_nom','entreprise_rvs.prenom as mon_prenom','entreprise_rvs.email as mon_email','entreprises.user_id','entreprise_rvs.user_id','entreprise_rvs.pays as pay_ent','entreprise_rvs.description', 
        'plannings.libelle_t','plannings.priorite','plannings.id','plannings.entreprise_id', 'plannings.date_rv', 'plannings.heure_deb', 'plannings.heure_fin')
       ->leftJoin('entreprise_rvs','entreprise_rvs.id','plannings.entreprise_rv_id')
       ->leftJoin('entreprises','entreprises.id','plannings.entreprise_id') */
       //->leftJoin('users','users.id','plannings.user_id')
       //->where('plannings.user_id', Auth::user()->id)
       //->orderBY('date_rv','DESC')->distinct('id')->get();   

        //$planningsss = Planning::where('user_id', Auth::user()->id)->orderBY('priorite','DESC')
       //->get();   
       //->orWhere('ent_rv_id','=',415)



        return view('plannings.mon_planning2')
        ->with('i', (request()->input('page', 1) - 1) * 5); 
  

  

    }  

    /**
     * Remove the specified resource from storage.  
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_planning($id)
    {
        //
        $planning = Planning_f::find($id);
        $planning->delete();

        return back();
    }

    public function banPlanning(Request $request){  
      //return $request->all();
      $etats = $request->etats;
      $planningID = $request->planningID;

      $update_etats = DB::table('planning_fs')
      ->where('id', $planningID)
      ->update([
        'etats' => $etats
      ]);
      if($update_etats){
        echo "status updated successfully";
      }
    }   

    public function banPlannings(Request $request){  
      //return $request->all();
      $etats = $request->etats;
      $planningsID = $request->planningsID;

      $update_etats = DB::table('planning_fs')
      ->where('id', $planningsID)
      ->update([
        'etats' => $etats
      ]);
      if($update_etats){
        echo "status updated successfully";
      }
    }   
    
    public function nombre()
    {
        $users = User::all();
        
        $participants = Participant::all();

        $entreprises = Entreprise::distinct()->pluck('nom_entreprise');
        $entreprisess = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();

        $pays = DB::table('entreprises')->distinct('pays')->
        count('pays');

        $all_pays = DB::table('entreprises')->select('pays', DB::raw('count(*) as `total`'))
        ->groupBy('pays')->orderBy('total','DESC')->get();  
        
        $all_pays_total = DB::table('entreprises')->count('pays'); 

        $all_secteur_total = DB::table('entreprises')->count('pays'); 

        $all_secteurs = DB::table('entreprises')->select('secteur_a', DB::raw('count(*) as `total`'))
        ->groupBy('secteur_a')->orderBy('total','DESC')->get();

        return view('statistique.page_statistiques',compact('participants','entreprises',
        'pays', 'all_pays','all_secteurs','all_pays_total','all_secteur_total','users','entreprisess'));
    }
    
    public function page_entreprises()
    {
      // $entreprises = Entreprise::orderBy('id')->get();
    // $entreprises = Entreprise::select('nom_entreprise','pays','secteur_a','rendez_vous', DB::raw('MAX(id) as id'))
   //  ->where('nom_entreprise', '!=', NULL)
   // ->groupBy('nom_entreprise', 'pays', 'secteur_a', 'rendez_vous')
   // ->get();
    $entreprises = Entreprise::select('nom_entreprise', 'pays','secteur_a','rendez_vous', 'id')
    //->distinct('nom_entreprise')
    ->get()->unique('nom_entreprise');;

       //dd($entreprises);
       return view('statistique.page_entreprise', compact('entreprises'))
       ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function page_rendez_vous()
    {
       $entrepriss = Entreprise::orderBy('id')->get();
       $entreprises = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();
       return view('statistique.page_rendez_vous', compact('entreprises','entrepriss'))
       ->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    public function page_inscrits()
    {
       $inscrits = User::where('email', '!=', 'admin@optievent.com')->get();
       return view('statistique.page_inscrits', compact('inscrits'))
       ->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    public function page_participants()
    {
        $participants = DB::table('participants')->select('participants.id', 'participants.nom','participants.email',
        'participants.prenom','participants.tel_part','participants.fonction', 'entreprises.nom_entreprise','entreprises.pays','entreprises.rendez_vous')
       ->leftJoin('entreprises','entreprises.id','participants.entreprise_id')
       ->orderBy('id')->get(); 
       //$participants = Participant::paginate(10);
       return view('statistique.page_participant', compact('participants'))
       ->with('i', (request()->input('page', 1) - 1) * 5); 
    }
    
    public function page_rendez_vous_p()
    {
        $participants = DB::table('participants')->select('participants.id', 'participants.nom',
        'participants.prenom','participants.tel_part','participants.email', 'entreprises.nom_entreprise', 'entreprises.pays','entreprises.rendez_vous')
       ->leftJoin('entreprises','entreprises.id','participants.entreprise_id')
        ->where('entreprises.rendez_vous','=','AVEC un planning B 2 B')
       ->orderBy('id')
       ->get(); 
       //$participants = Participant::paginate(10);
       return view('statistique.page_rendez_vous_p', compact('participants'))
       ->with('i', (request()->input('page', 1) - 1) * 5);  
    }
    
    public function page_comptes()
    {
       $users = User::orderBy('id')->get();
       return view('statistique.page_compte', compact('users'))
       ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function statistique_evenements()
    {
        $users = User::all();
        
        $participants = Participant::all();

        $entreprises = Entreprise::all();
        $entreprisess = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();

        

        return view('statistique.statistique_evenement',compact('participants','entreprises','users','entreprisess'));
    }
    
    
    public function nombre_a()
    {
        $users = User::all();
        
        $participants = Participant::all();

        $entreprises = Entreprise::all();
        $entreprisess = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();

        $pays = DB::table('entreprises')->distinct('pays')->
        count('pays');

        $all_pays = DB::table('entreprises')->select('pays', DB::raw('count(*) as `total`'))
        ->groupBy('pays')->orderBy('total','DESC')->get();  
        
        $all_pays_total = DB::table('entreprises')->count('pays'); 

        $all_secteur_total = DB::table('entreprises')->count('pays'); 

        $all_secteurs = DB::table('entreprises')->select('secteur_a', DB::raw('count(*) as `total`'))
        ->groupBy('secteur_a')->orderBy('total','DESC')->get();

        return view('statistique.statistiques.nombre',compact('participants','entreprises',
        'pays', 'all_pays','all_secteurs','all_pays_total','all_secteur_total','users','entreprisess'));
    }
    
    public function page_entreprises_a()
    {
       $entreprises = Entreprise::orderBy('id')->get();
       return view('statistique.statistiques.page_entreprise', compact('entreprises'))
       ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function page_rendez_vous_a()
    {
       $entreprises = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();
       return view('statistique.statistiques.page_rendez_vous', compact('entreprises'))
       ->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    public function entreprise_autres()
    {
       $entreprises = Entreprise::orderBy('id')->Where('secteur_a','=','Autres / Others')->get();
       return view('statistique.entreprise_autres', compact('entreprises'))
       ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function page_participants_a()
    {
         $participants = DB::table('participants')->select('participants.id', 'participants.nom','participants.email',
        'participants.prenom','participants.tel_part','participants.fonction', 'entreprises.nom_entreprise','entreprises.pays','entreprises.rendez_vous')
       ->leftJoin('entreprises','entreprises.id','participants.entreprise_id')
       ->orderBy('id')->get();
       //$participants = Participant::paginate(10);
       return view('statistique.statistiques.page_participant', compact('participants'))
       ->with('i', (request()->input('page', 1) - 1) * 5); 
    }
    
   public function page_rendez_vous_p_a()
    {
        $participants = DB::table('participants')->select('participants.id','participants.nom',
        'participants.prenom','participants.tel_part','participants.email', 'entreprises.nom_entreprise', 'entreprises.pays','entreprises.rendez_vous')
       ->leftJoin('entreprises','entreprises.id','participants.entreprise_id')
        ->where('entreprises.rendez_vous','=','AVEC un planning B 2 B')
       ->orderBy('id')
       ->get(); 
       //$participants = Participant::paginate(10);
       return view('statistique.statistiques.page_rendez_vous_p', compact('participants'))
       ->with('i', (request()->input('page', 1) - 1) * 5);  
    }
    
    public function page_comptes_a()
    {
       $users = User::orderBy('id')->whereNotIn("id",[489,
660,
281,
585,
414,
533,
222,
383,
227,
379,
646,
367,
643,
415,
445,
580,
530,
252,
392,
238,
531,
366,
373,
438,
663,
390,
271,
480,
501,
669,
411,
265,
299,
404,
429,
246,
579,
581,
637,
452,
611,
619,
419,
264,
421,
240,
650,
248,
248,
248,
293,
217,
561,
453,
268,
597,
442,
245,
358,
403,
573,
492,
482,
477,
654,
675,
634,
461,
461,
351,
294,
553,
495,
267,
615,
517,
239,
377,
284,
409,
640,
640,
332,
542,
588,
276,
400,
459,
586,
425,
257,
622,
376,
318,
399,
241,
555,
412,
602,
618,
568,
676,
676,
604,
562,
331,
375,
532,
260,
633,
432,
446,
323,
653,
557,
662,
641,
565,
417,
680,
308,
360,
427,
443,
237,
487,
289,
581,
613,
626,
283,
538,
423,
408,
551,
514,
510,
546,
306,
469,
589,
523,
330,
363,
263,
329,
287,
339,
516,
325,
647,
628,
509,
658,
479,
472,
253,
559,
347,
574,
539,
295,
353,
603,
502,
621,
416,
312,
490,
267,
357,
456,
335,
244,
665,
657,
440,
346,
465,
361,
431,
365,
648,
303,
541,
347,
356,
342,
470,
338,
656,
497,
468,
315,
599,
666,
368,
368,
515,
540,
284,
507,
395,
475,
348,
545,
247,
362,
451,
327,
250,
588,
466,
341,
405,
629,
305,
320,
590,
671,
554,
600,
334,
506,
467,
512,
309,
616,
566,
483,
273,
388,
670,
384,
504,
413,
636,
300,
464,
645,
286,
288,
681,
380,
219,
500,
682,
513,
549,
326,
617,
617,
493,
488,
601,
576,
370,
389,
581,
582,
338,
593,
220,
340,
328,
355,
620,
296,
552,
218,
595,
407,
503,
609,
374,
485,
277,
661,
581,
581,
317,
625,
625,
269,
679,
605,
605,
364,
386])->get();
       return view('statistique.statistiques.page_compte', compact('users'))
       ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function inscriptions()
    {
        $users = User::all();
        
        $participants = Participant::all();

        $entreprises = Entreprise::all();
        $entreprisess = Entreprise::orderBy('id')->Where('rendez_vous','=','AVEC un planning B 2 B')->get();
        
        $pays = DB::table('entreprises')->distinct('pays')->
        count('pays');

        $all_pays = DB::table('entreprises')->Where('rendez_vous','=','AVEC un planning B 2 B')
        ->select('pays', DB::raw('count(*) as `total`'))
        ->groupBy('pays')->orderBy('total','DESC')->get();  
        
        $all_pays_total = DB::table('entreprises')->count('pays'); 

        
        $demandeur = DB::table('demande_b2gs')
        ->select('demande_b2gs.*', 'entreprises.pays')
        ->join('participants', 'participants.id', 'demande_b2gs.participant_id')
        ->join('entreprises', 'participants.entreprise_id', 'entreprises.id')
        ->distinct('pays')->
       get();
        
        return view('statistique.statistique_inscription',compact('participants','entreprises',
        'pays', 'all_pays','all_pays_total','users','entreprisess','demandeur'));
    }
 
}
