<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoliticalParty;
use App\Http\Controllers\BaseModelController;
use App\Services\PoliticalPartyModelService;

class PoliticalPartyController extends BaseModelController
{

    public function __construct(private PoliticalPartyModelService $politicalPartyModelService) {}

    /**
     * Display a listing of the political parties.
     *
     * @param string $segment
     * @return \Illuminate\View\View
     */
    public function index(string $segment)
    {
        return view('backend.politicalParty.index', compact('segment'));
    }

    /**
     * Fetch political party data for DataTables.
     *
     * @param Request $request
     * @param string $segment
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Show the form for creating a new political party.
     *
     * @param string $segment
     * @return \Illuminate\View\View
     */
    public function create(string $segment)
    {
        $politicalParty = new PoliticalParty();
        $action = route('politicalParty.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.politicalParty._form', compact('segment', 'politicalParty', 'action', 'method'));
    }

    /**
     * Store a newly created political party in storage.
     *
     * @param Request $request
     * @param string $segment
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, string $segment)
    {
        $validated = $this->politicalPartyModelService->validateData($request->all());
        try {
            $result = $this->politicalPartyModelService->resourceStore($validated);
            if($result !== true){
                return _commonSuccessOrErrorMsg('error', 'Failed to insert record.');
            }
            return _commonSuccessOrErrorMsg('success', INSERT_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }
    /**
     * Show the form for editing the specified political party.
     *
     * @param Request $request
     * @param string $segment
     * @param PoliticalParty $politicalParty
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, string $segment, PoliticalParty $politicalParty)
    {
        $action = route('politicalParty.update', ['segment' => $segment, 'politicalParty' => $politicalParty->uuid]);
        $method = 'PUT';
        return view('backend.politicalParty._form', compact('politicalParty', 'action', 'method'));
    }

    /**
     * Update the specified political party in storage.
     *
     * @param Request $request
     * @param string $segment
     * @param PoliticalParty $politicalParty
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $segment, PoliticalParty $politicalParty)
    {
        $validated = $this->politicalPartyModelService->validateData($request->all(), $politicalParty->uuid);
        try {
            $result = $this->politicalPartyModelService->resourceUpdate($validated,$politicalParty);
            if($result !== true){
                return _commonSuccessOrErrorMsg('error', 'Failed to update record.');
            }
            return _commonSuccessOrErrorMsg('success', UPDATE_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }

    public function destroy(Request $request, string $segment, PoliticalParty $politicalParty)
    {
        try {
           $result = $this->politicalPartyModelService->resourceDelete($politicalParty);
              if($result !== true){
                return _commonSuccessOrErrorMsg('error', 'Failed to delete record.');
            }
            return _commonSuccessOrErrorMsg('success', DELETE_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }

}
