<?php

namespace App\Services;

use App\Models\ActivityType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ActivityTypeModelService extends BaseModelService
{
    /**
     * Constructor to initialize the ActivityType model.
     *
     * @param ActivityType $model
     */

    public function __construct(ActivityType $model)
    {
        $this->model = $model;
    }

    public function validateData(array $data, $uuid = null): array
    {
        return Validator::make($data, $this->rules($uuid), $this->messages())->validate();
    }


    public function rules($uuid = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activity_types', 'name')->ignore($uuid, 'uuid'),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The activity type is required.',
        ];
    }

    /**
     * Get a list of activity types with pagination and filtering.
     *
     * @param string $segment
     * @return array
     * @throws \Exception
     */
    public function resourceList($segment)
    {
        try {
            $query = $this->model->newQuery();
            $recordsTotal = (clone $query)->count();
            $recordsFiltered = (clone $query)->count();
            $resources = $query->get(['uuid', 'name','created_at']);
            $sl = 0;
            $data = $resources->map(function ($u) use (&$sl, $segment) {
                return [
                    'sl' => ++$sl,
                    'name' => e($u->name),
                    'created_at' => e($u->created_at),
                    'actions' => view('backend.activityType._actions', [
                        'segment' => $segment,
                        'activityType' => $u,
                    ])->render(),
                ];
            });

            return [
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }

    /**
     * Store a new activity type party record.
     *
     * @param array $data
     * @throws \Exception
     */
    public function resourceStore(array $data)
    {
        try {
            $storeData = collect($data)->only(['name'])->toArray();
            $this->model->create($storeData);
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }
    /**
     * Update an existing activity type party record.
     *
     * @param array $data
     * @param ActivityType $activityType
     * @throws \Exception
     */
    public function resourceUpdate(array $data,  $activityType)
    {
        try {
            $updateData = collect($data)->only(['name'])->toArray();
            $activityType->update($updateData);
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }

    public function resourceDelete(ActivityType $activityType)
    {
        try {
            $resource = $this->model->findOrFail($activityType->uuid);
            $resource->delete();
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }
}
