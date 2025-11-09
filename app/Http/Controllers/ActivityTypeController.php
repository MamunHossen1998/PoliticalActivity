<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use App\Services\ActivityTypeModelService;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
    public function __construct(private ActivityTypeModelService $activityTypeModelService) {}


    /**
     * Display a listing of the activity types.
     *
     * @param string $segment
     * @return \Illuminate\View\View
     */
    public function index(string $segment)
    {
        return view('backend.activityType.index', compact('segment'));
    }


    /**
     * Fetch activity type data for DataTables.
     *
     * @param Request $request
     * @param string $segment
     * @return \Illuminate\Http\JsonResponse
     */
    public function resourceList(Request $request, string $segment)
    {
        try {
            $resources = $this->activityTypeModelService->resourceList($segment);
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
     * Show the form for creating a new activity type.
     *
     * @param string $segment
     * @return \Illuminate\View\View
     */
    public function create(string $segment)
    {
        $activityType = new ActivityType();
        $action = route('activityType.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.activityType._form', compact('segment', 'activityType', 'action', 'method'));
    }

    /**
     * Store a newly created activity party in storage.
     *
     * @param Request $request
     * @param string $segment
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, string $segment)
    {
        $validated = $this->activityTypeModelService->validateData($request->all());
        try {
            $result = $this->activityTypeModelService->resourceStore($validated);
            if ($result !== true) {
                return _commonSuccessOrErrorMsg('error', 'Failed to insert record.');
            }
            return _commonSuccessOrErrorMsg('success', INSERT_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified activity type.
     *
     * @param Request $request
     * @param string $segment
     * @param ActivityType activityType
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, string $segment, ActivityType $activityType)
    {
        $action = route('activityType.update', ['segment' => $segment, 'activityType' => $activityType->uuid]);
        $method = 'PUT';
        return view('backend.activityType._form', compact('activityType', 'action', 'method'));
    }

    /**
     * Update the specified activity type in storage.
     *
     * @param Request $request
     * @param string $segment
     * @param ActivityType activityType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $segment, ActivityType $activityType)
    {
        $validated = $this->activityTypeModelService->validateData($request->all(), $activityType->uuid);
        try {
            $result = $this->activityTypeModelService->resourceUpdate($validated, $activityType);
            if ($result !== true) {
                return _commonSuccessOrErrorMsg('error', 'Failed to update record.');
            }
            return _commonSuccessOrErrorMsg('success', UPDATE_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }

    public function destroy(Request $request, string $segment, ActivityType $activityType)
    {
        try {
            $result = $this->activityTypeModelService->resourceDelete($activityType);
            if ($result !== true) {
                return _commonSuccessOrErrorMsg('error', 'Failed to delete record.');
            }
            return _commonSuccessOrErrorMsg('success', DELETE_MSG);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }
}
