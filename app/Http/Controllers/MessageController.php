<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//mail namespace
use App\Mail\WelcomeEmail;
use App\Mail\KitEmail;
use App\Mail\MessagerieSicot2022;
use App\Models\Newsletter;

//random str generate 
use Str;
use PDF;
use DB;

//zoom meeting
use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newletter()
    {
        //

        return view('Admin.newletter');
    }
    
    public function newletters(Request $request)
    {
        //
        $message = 'Message a bien été envoyé';
        
        if($request->file('piece')){
           $piece = $request->file('piece');
           $pieceName = $piece->getClientOriginalName();
           $piece->move(public_path().'/piecejointe/', $pieceName);
        }
        $news = new Newsletter;
        $news->objet = $request->objet;
        $news->contenu = $request->contenu;
        $news->piece = (isset($pieceName)) ? $pieceName : $news->piece;
        $news->save();
        
        $event = DB::table('events')->where('status', '=', 1)->first();
        $newsletter = DB::table('newsletters')->OrderBy('id', 'desc')->first();
        
        $users = DB::table('users')->get();
       
        $user = 'fallou.g@illimitis.com';
        foreach($users as $user)
        
        \Mail::to($user->email)->send(new MessagerieSicot2022($user,  $event, $newsletter));
            
            return back()->with(['message' => $message]);
        

       // return back()->with(['message' => $message]);

    }

    public function index()
    {
        //

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
        //
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
    }
}
