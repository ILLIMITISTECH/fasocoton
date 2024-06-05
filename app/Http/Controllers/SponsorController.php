<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsor;
use DB;
use Auth;

class SponsorController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sponsors = DB::table('sponsors')->get();

        return view('Admin/sponsor.sponsorLister', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin/sponsor.sponsorCreate');
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
        $message = 'sponsor ajouté avec succés';
        
         if($request->file('logo1')){
           $logo1 = $request->file('logo1');
           $file_name = $logo1->getClientOriginalName();
           $logo1->move(public_path().'/sponsor/', $file_name);
        }

        $sponsors = new Sponsor;
        $sponsors->nom_sponsor = $request->get('nom_sponsor');
        $sponsors->logo1  = (isset($file_name)) ? $file_name : $sponsors->logo1;
        $sponsors->ordre = $request->get('ordre');
        $sponsors->save();
       
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
        //
        $sponsor = sponsor::find($id);

        return view('Admin/sponsor.sponsorEdit', compact('sponsor'));
    
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
        $message = 'sponsor modifié';
        $sponsors = sponsor::find($id);
        $sponsors->logo1 = $request->get('event_id');
        $sponsors->ordre = $request->get('ordre');
        $sponsors->update();
       
        return redirect('/sponsors')->with(['message' => $message]);
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
        $sponsors = sponsor::find($id);
        $sponsors->delete();

        return back()->with('info', "Sponsor supprimée dans la base de donnée.");
    }
}
