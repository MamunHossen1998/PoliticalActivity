<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoliticalParty;
use App\Http\Controllers\BaseModelController;
use App\Services\PoliticalPartyModelService;

class PoliticalPartyController extends BaseModelController
{

    public function __construct(private PoliticalPartyModelService $politicalPartyModelService)
    {
     
    }
    public function index(string $segment)
    {
        return view('backend.politicalParty.index', compact('segment'));
    }

    public function resourceList(Request $request, string $segment)
    {
        try {
            $resources = $this->politicalPartyModelService->resourceList($segment);
            return response()->json([
                'recordsTotal' => $resources['recordsTotal'],
                'recordsFiltered' => $resources['recordsFiltered'],
                'data' => $resources['data'],
            ]);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
      
    }
}
