<?php

namespace App\Http\Controllers;
use App\Models\Chambre;
use DB;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chambres = DB::table('chambres')->get();

        return view('Admin/chambre.chambreLister', compact('chambres'));
    }

    
    public function create()
    {
        $hotel= DB::table('hotels')->get();
        return view('Admin/chambre.chambreCreate', compact('hotel'));
    }

    
    public function store(Request $request)
    {
        $message = 'Chambre ajoutée avec succés';
        $event =  DB::table('events')->where('status', 1)->first();
        
        $chambre = new Chambre;
        $chambre->nom_chambre = $request->get('nom_chambre');
        $chambre->prix = $request->get('prix');
        $chambre->hotel_id = $request->get('hotel_id');
        $chambre->event_id = $event->id;
        $chambre->save();
       
        return redirect('/chambres')->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $chambre = Chambre::find($id);
        $hotel= DB::table('hotels')->get();
        return view('Admin/chambre.chambreEdit', compact('chambre', 'hotel'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Chambre modifié avec succés';

        $chambre = Chambre::find($id);
        $chambre->nom_chambre = $request->get('nom_chambre');
        $chambre->prix = $request->get('prix');
        $chambre->hotel_id = $request->get('hotel_id');
        $chambre->update();
       
        return redirect('/chambres')->with(['message' => $message]);   

    }

   
    public function destroy($id)
    {
        $chambre = Chambre::find($id);
        $chambre->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
