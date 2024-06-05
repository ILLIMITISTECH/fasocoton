<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Souhait;
use App\Souhaite;
use App\Planning_f;
use DB;
use PDF;   
use App\Participant;
use Auth;
use App\User;
use App\Entreprise;
use App\Entreprise_rv;
use App\Secteur_activite;
use App\Pay;


class SouhaitController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

      public function souhait(Request $request)
    {
        //
         /* $souhaits =  new Souhait;
         $souhaits->entreprise_id = $request->entreprise_id; 
         $souhaits->entreprise_copie_id = $request->entreprise_copie_id;
         $souhaits->priorite = $request->priorite; 

        dd($souhaits); */

        $souhaits = Souhait::paginate(11);
        return view('souhaits.index', compact('souhaits'));
        //dd($souhaits);
    }

    public function banSouhait(Request $request){  
        //return $request->all();
        $status = $request->status;   
        $souhaitID = $request->souhaitID;
  
        $update_status = DB::table('souhaits')
        ->where('id', $souhaitID)
        ->update([
          'status' => $status
        ]);
        if($update_status){
          echo "status updated successfully";
        }
      }   

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
      public function generatePDF($id)

      {
          $timestamp = time(); 

          //$souhaits = Souhait::all();
          //view()->share('souhaits',$souhaits);

          $participant = Participant::find($id);
          view()->share('participant',$participant);


          //$data = ['title' => 'Welcome to HDTuto.com'];
  
          $pdf = PDF::loadView('souhaits.participant_details', $participant);
  
    
  
          return $pdf->download('itsolutionstuff.pdf');
  
      }
          /**  

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function pdfview(Request $request)

    {

        $participants = Participant::paginate();

        view()->share('participants',$participants);


        if($request->has('download')){

            $pdf = PDF::loadView('souhaits.participant_details');

            return $pdf->download('pdfview.pdf');

        }


        return view('souhaits.participant_details');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $souhait = Souhait::find($id);
        $souhaits = Souhait::where('user_id', Auth::user()->id)->orderBY('created_at','DESC')->get();

        return view('souhaits.details', compact('souhait', 'souhaits'));
    }

    public function souhait_confirmer()
    {
        //  

        //$souhaitss = Souhait::where('user_id', Auth::user()->id)->where('status','=',1)->orderBY('created_at','DESC')->get();
        $souhaitss = DB::table('souhaits')->select('entreprise_rvs.nom_entreprise','entreprise_rvs.pays','entreprise_rvs.description',
         'entreprise_rvs.secteur_a', 'entreprise_rvs.partenaire_rechercher','entreprise_rvs.alliance_rechercher','souhaits.user_id','souhaits.priorite','souhaits.status','souhaits.langue_ent_2','souhaits.id')
        ->leftJoin('entreprise_rvs','entreprise_rvs.id','souhaits.entreprise_rv_id')
        //->leftJoin('entreprises','entreprises.id','souhaits.entreprise_id')
        ->leftJoin('users','users.id','souhaits.user_id')
        ->where('souhaits.user_id', Auth::user()->id)
        ->where('status','=',1)
        ->orderBY('priorite','ASC')->get();

        $souhaites = DB::table('souhaites')->select('entreprise_rvs.nom_entreprise','entreprise_rvs.pays','entreprise_rvs.description',
        'souhaites.user_id','souhaites.priorite','souhaites.status','souhaites.langue_ent_2','souhaites.id')
        ->leftJoin('entreprise_rvs','entreprise_rvs.id','souhaites.entreprise_rv_id')
        //->leftJoin('entreprises','entreprises.id','souhaites.entreprise_id')
        ->leftJoin('users','users.id','souhaites.user_id')
        ->where('souhaites.user_id', Auth::user()->id)
        ->where('status','=',1)
        ->orderBY('priorite','ASC')->get();
        return view('souhaits.lis_souhait', compact('souhaitss','souhaites'));
    }

    public function banSouhait_confirmer(Request $request){
        //return $request->all();
        $status = $request->status;
        $souhaitID = $request->souhaitID;
  
        $update_status = DB::table('souhaits')
        ->where('id', $souhaitID)
        ->where('status','=',1)
        ->update([
          'status' => $status
        ]);
        if($update_status){
          echo "status updated successfully";
        }
      }   

      public function banSouhait_confirme(Request $request){
        //return $request->all();
        $status = $request->status;
        $souhaiteID = $request->souhaiteID;
  
        $update_status = DB::table('souhaites')
        ->where('id', $souhaiteID)
        ->where('status','=',1)
        ->update([
          'status' => $status
        ]);
        if($update_status){
          echo "status updated successfully";
        }
      }   


    public function suggesstion()
    {
        $souhaites = Souhait::where('status', 1) ->where(function($q) {
        $q->where('user_id', Auth::user()->id);
        })->get();
       $plann = Entreprise_rv::where('user_id', Auth::user()->id)->first();
       //foreach($planning as $plann){
       //$souhaitss = Souhait::where('entreprise_id','=',$plann->id)->orWhere('status','=',1)->orderBY('created_at','DESC')->get();
          
        //$souhaits = Souhait::where('user_id', Auth::user()->id)->orderBY('priorite','ASC')->get();
         $souhaits = DB::table('souhaits')->select('entreprise_rvs.nom_entreprise','entreprise_rvs.pays','entreprise_rvs.description',
         'entreprise_rvs.secteur_a', 'entreprise_rvs.partenaire_rechercher','entreprise_rvs.alliance_rechercher','souhaits.user_id','souhaits.priorite','souhaits.status','souhaits.langue_ent_2','souhaits.id')
        ->leftJoin('entreprise_rvs','entreprise_rvs.id','souhaits.entreprise_rv_id')
        //->leftJoin('entreprises','entreprises.id','souhaits.entreprise_id')
        ->leftJoin('users','users.id','souhaits.user_id')
        //->where('souhaits.user_id', Auth::user()->id)
        //->where('entreprise_id','=',$plann->id)
        ->orderBY('priorite','ASC')->paginate(11);  
      //}
        //return view('souhaits.suggesstion', compact('souhaites'));
        return view('souhaits.suggesstion', compact('souhaits', 'souhaites'));
         
    }


    public function catalogue()
    {
        //
        $secteur_activites = DB::table('secteur_activites')
        ->select('secteur_activites.*','events.nom_event','events.status')
        ->join('events','events.id', '=', 'secteur_activites.event_id')
        ->where('events.status', '=', 1)
        ->get();
        $pays = Pay::all();
        $souhaites = Souhaite::where('user_id', Auth::user()->id)->get();
        $plann = Entreprise_rv::where('user_id', Auth::user()->id)->get();
        $entreprises = DB::table('entreprise_rvs')
        ->select('entreprise_rvs.*','events.nom_event','events.status')
        ->join('events','events.id', '=', 'entreprise_rvs.event_id')
        ->where('entreprise_rvs.rendez_vous', '=', 'AVEC un planning B 2 B', 'AND' ,'events.status', '=', 1)
        ->get();
        $souhaits = DB::table('entreprise_rvs')
        ->select('entreprise_rvs.*','events.nom_event','events.status')
        ->join('events','events.id', '=', 'entreprise_rvs.event_id')
        ->where('events.status', '=', 1)
        ->orderBY('created_at','DESC')
        ->get();
       
        return view('souhaits.catalogue', compact('entreprises','souhaits','secteur_activites','pays','souhaites'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function my_catalogue()
    {
        //
        $secteur_activites = Secteur_activite::all();
        $pays = Pay::all();
        $entreprises = Entreprise_rv::where('rendez_vous', '=', 'AVEC un planning B 2 B')->paginate(30);
        //$souhaits = Entreprise::where('user_id', Auth::user()->id)->orderBY('created_at','DESC')->paginate(1);

       
        return view('souhaits.my_catalogue', compact('entreprises','secteur_activites','pays'));
    }
    
    public function my_filter(Request $request){
        $secteur_activites = Secteur_activite::all();
        $pays = Pay::all();
        $search_a = $request->get('search_a');
        $entreprises = Entreprise_rv::where('pays', 'like', '%'.$search_a.'%')->
        orWhere('secteur_a', 'like', '%'.$search_a.'%')->
        orWhere('nom_entreprise', 'like', '%'.$search_a.'%')->orderBy('id')->get();
       
      
         return view('souhaits.my_catalogue', compact('entreprises','secteur_activites','pays'))
         ->with('i', (request()->input('page', 1) - 1) * 5);
         
      }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function my_details($id)
        {
            $entreprise = Entreprise::find($id);
            return view('souhaits.my_details',compact('entreprise'));
    
        }
    public function participant()
    {
        //

        $participants = Participant::paginate(11);
       
        return view('souhaits.participant', compact('participants'));
    }

    public function details($id)
    {
        //
        $participant = Participant::find($id);
        return view('souhaits.participant_details',compact('participant'));

    }

    public function details_ent($id)
    {
        //
        $entreprise = Entreprise::find($id);
        return view('souhaits.details_catalogue',compact('entreprise'));

    }

    public function filter(Request $request){
        $secteur_activites = Secteur_activite::all();
        $pays = Pay::all();
        $souhaites = Souhaite::where('user_id', Auth::user()->id)->get();
        $planning = Entreprise_rv::where('user_id', Auth::user()->id)->get();
        foreach($planning as $plann){
        $search = $request->get('search');
        $entreprises = Entreprise_rv::where('id', '=',$plann->id)->orWhere('nom_entreprise', 'like', '%'.$search.'%')->
        orWhere('secteur_a', 'like', '%'.$search.'%')->
        orWhere('pays', 'like', '%'.$search.'%')->orderBY('created_at','DESC')
        
        ->get();
        $souhaits = Entreprise_rv::where('id', '=',$plann->id)->orWhere('nom_entreprise', 'like', '%'.$search.'%')->
        orWhere('secteur_a', 'like', '%'.$search.'%')->
        orWhere('pays', 'like', '%'.$search.'%')
        ->orderBY('created_at','DESC')->paginate(1);

      }
        /* $entreprises = DB::table('souhaits')->select('entreprises.nom_entreprise','entreprises.pays','entreprises.description',
         'entreprises.secteur_a', 'entreprises.secteur_b','entreprises.secteur_c',
         'entreprises.profile_entreprise_a', 'entreprises.partenaire_rechercher','souhaits.user_id','souhaits.priorite','souhaits.status','souhaits.langue_ent_2','souhaits.id')
        ->leftJoin('entreprises','entreprises.id','souhaits.entreprise_id')->where('pays', 'like', '%'.$search.'%')->
        orWhere('secteur_a', 'like', '%'.$search.'%')
        //->leftJoin('entreprises','entreprises.id','souhaits.entreprise_id')
        ->leftJoin('users','users.id','souhaits.user_id')
        //->where('souhaits.user_id', Auth::user()->id)
        ->paginate(30); */
      
         return view('souhaits.catalogue', compact('entreprises','souhaits','secteur_activites','pays','souhaites'))
         ->with('i', (request()->input('page', 1) - 1) * 5);
         
      }

      public function save_souhait(Request $request)
    {
        //
        $message = 'souhait ajouté avec succès';
        $souhaits =  new Souhaite;
        $souhaits->user_id = Auth::user()->id;
        //$souhaits->entreprise_id = Auth::user()->id;
        $souhaits->entreprise_id = $request->entreprise_id; 
        //$souhaits->entreprise_rv_id = $request->entreprise_copie_id; 
        $souhaits->entreprise_rv_id = $request->entreprise_rv_id;
        $souhaits->status = $request->status; 
        $souhaits->priorite = $request->priorite;
        $souhaits->langue_ent_1 = $request->langue_ent_1; 
        $souhaits->langue_ent_2 = $request->langue_ent_2;  
        $souhaits->save();
        return redirect()->back()->with(['message' => $message]);
  

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $souhait = Souhait::find($id);
        $souhait->delete();
        return redirect()->back();

    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actif_sugg($id)
    {
        //    
        $message_sugg = "Souhait confirmé avec succès";

        $sug = Souhait::findOrFail($id);
        $sug->status = 1; //Approved
        $sug->save();
        return redirect()->back()->with(['message_sugg' => $message_sugg]); 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desactif_sugg($id)
    {
        //    
        $message_suggs = "Souhait non confirmé";

        $sug = Souhait::findOrFail($id);
        $sug->status = 0; //Approved
        $sug->save();
        return redirect()->back()->with(['message_suggs' => $message_suggs]);  
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actif_plan($id)
    {
        //    
       $message_plan = "Souhait confirmé avec succès";
       
        $plan = Planning_f::findOrFail($id);
        $plan->etats = 1; //Approved
        $plan->save();
        return redirect()->back()->with(['message_plan' => $message_plan]);  
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desactif_plan($id)
    {
        //    
       $message_plans = "Souhait désactivé avec succès";

        $plan = Planning_f::findOrFail($id);
        $plan->etats = 0; //Approved
        $plan->save();
        return redirect()->back()->with(['message_plans' => $message_plans]);  
    }
    
    
}
