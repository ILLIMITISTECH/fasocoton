<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function B2B()
    {
        return view('Admin/rendez_vous.rendezVousB2B');
    }

    public function B2G()
    {
        return view('Admin/rendez_vous.rendezVousB2G');
    }
}
