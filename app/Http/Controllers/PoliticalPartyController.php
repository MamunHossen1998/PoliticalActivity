<?php

namespace App\Http\Controllers;

use App\Models\PoliticalParty;
use Illuminate\Http\Request;

class PoliticalPartyController extends Controller
{
    public function index(string $segment)
    {
        return view('backend.politicalParty.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = PoliticalParty::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $resources = $query->get(['uuid', 'name', 'abbreviation', 'founded_year','created_at']);
        $sl = 0;

        $data = $resources->map(function ($u) use (&$sl, $segment) {
            return [
                'sl' => ++$sl,
                'name' => e($u->name),
                'abbreviation' => e($u->abbreviation),
                'founded_year' => e($u->founded_year),
                'created_at' => e($u->created_at),
                'actions' => view('backend.politicalParty._actions', [
                    'segment' => $segment,
                    'politicalParty' => $u,
                ])->render(),
            ];
        });


        return response()->json([
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
      
    }
}
