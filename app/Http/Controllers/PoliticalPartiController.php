<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliticalPartiController extends Controller
{
    public function index(string $segment)
    {
        return view('backend.politicalParty.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
       dd('iam her');
      
    }
}
