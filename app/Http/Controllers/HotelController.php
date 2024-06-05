<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Hotel;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $hotels = DB::table('hotels')->get();

        return view('Admin/hotel.hotelLister', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view('Admin/hotel.hotelCreate');
    }
    
     public function listehotel()
    {
        //
         //$hotels = DB::table('hotels')->get(); 
         return view('User.listeHotel');
    }
    public function listehotele()
    {
        //
         //$hotels = DB::table('hotels')->get(); 
         return view('User.listeHotel3');
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
        $message = 'hotel ajouté avec succés';
        

        $hotels = new Hotel;
        $hotels->nom_hotel = $request->get('nom_hotel');
        $hotels->email_hotel = $request->get('email_hotel');
        $hotels->type_hotel = $request->get('type_hotel');
        $hotels->tel_hotel = $request->get('tel_hotel');
        $hotels->site_hotel = $request->get('site_hotel');
        $hotels->details_hotel = $request->get('details_hotel');
        $hotels->save();
       
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
        $hotel = hotel::find($id);

        return view('Admin/hotel.hotelEdit', compact('hotel'));
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
        //
         $message = 'hotel modifié';
        $hotels = hotel::find($id);
        $hotels->nom_hotel = $request->get('nom_hotel');
        $hotels->email_hotel = $request->get('email_hotel');
        $hotels->type_hotel = $request->get('type_hotel');
        $hotels->tel_hotel = $request->get('tel_hotel');
        $hotels->site_hotel = $request->get('site_hotel');
        $hotels->details_hotel = $request->get('details_hotel');
        $hotels->update();
       
        return redirect('/hotels')->with(['message' => $message]);
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
        $hotels = Hotel::find($id);
        $hotels->delete();

        return back()->with('info', "Hotel supprimée dans la base de donnée.");
    }
}
