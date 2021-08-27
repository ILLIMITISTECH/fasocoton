<?php

namespace App\Http\Controllers;
use App\Models\Intervenant;
use DB;
use Illuminate\Http\Request;

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
        $type= DB::table('pays')->get();
        return view('Admin/intervenant.intervenantCreate', compact( 'langue', 'type'));
    }

    
    public function store(Request $request)
    {
        $message = 'Intervnant ajoutée avec succés';

        $intervenant = new Intervenant;
        $intervenant->nom = $request->get('nom');
        $intervenant->prenom = $request->get('prenom');
        $intervenant->email = $request->get('email');
        $intervenant->phone = $request->get('phone');
        $intervenant->langue_id = $request->get('langue_id');
        $intervenant->type_id = $request->get('type_id');

        $intervenant->save();
       
        return back()->with(['message' => $message]);
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $intervenant = Intervenant::find($id);

        return view('Admin/intervenant.intervenantEdit', compact('intervenant'));
    }

    
    public function update(Request $request, $id)
    {
        $message = 'Intervnant modifié avec succés';

        $intervenant = new Intervenant;
        $intervenant->nom = $request->get('nom');
        $intervenant->prenom = $request->get('prenom');
        $intervenant->email = $request->get('email');
        $intervenant->phone = $request->get('phone');
        $intervenant->langue_id = $request->get('langue_id');
        $intervenant->type_id = $request->get('type_id');
        $intervenant->update();
       
        return redirect('/intervenants')->with(['message' => $message]);   

    }

   
    public function destroy($id)
    {
        $intervenant = Intervenant::find($id);
        $intervenant->delete();

        return back()->with('info', "Evénement supprimée dans la base de donnée.");
    }
}
