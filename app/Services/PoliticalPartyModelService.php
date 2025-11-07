<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\PoliticalParty;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PoliticalPartyModelService extends BaseModelService
{
    /**
     * Constructor to initialize the PoliticalParty model.
     *
     * @param PoliticalParty $model
     */

    public function __construct(PoliticalParty $model)
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
                Rule::unique('political_parties', 'name')->ignore($uuid, 'uuid'),
            ],
            'abbreviation' => [
                'nullable',
                'string',
                'max:10',
                Rule::unique('political_parties', 'abbreviation')->ignore($uuid, 'uuid'),
            ],
            'founded_year' => 'nullable|date|before_or_equal:today',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The political party name is required.',
        ];
    }

    /**
     * Get a list of political parties with pagination and filtering.
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
            $resources = $query->get(['uuid', 'name', 'abbreviation', 'founded_year', 'created_at']);
            $sl = 0;
            $data = $resources->map(function ($u) use (&$sl, $segment) {
                return [
                    'sl' => ++$sl,
                    'name' => e($u->name),
                    'abbreviation' => e($u->abbreviation),
                    'founded_year' => e(Carbon::parse($u->founded_year)->format('d-m-Y')),
                    'created_at' => e($u->created_at),
                    'actions' => view('backend.politicalParty._actions', [
                        'segment' => $segment,
                        'politicalParty' => $u,
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
     * Store a new political party record.
     *
     * @param array $data
     * @throws \Exception
     */
    public function resourceStore(array $data)
    {
        try {
            $storeData = collect($data)->only(['name', 'abbreviation', 'founded_year'])->toArray();
            $this->model->create($storeData);
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }
    /**
     * Update an existing political party record.
     *
     * @param array $data
     * @param PoliticalParty $politicalParty
     * @throws \Exception
     */
    public function resourceUpdate(array $data, PoliticalParty $politicalParty)
    {
        try {
            $updateData = collect($data)->only(['name', 'abbreviation', 'founded_year'])->toArray();
            $politicalParty->update($updateData);
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }

    public function resourceDelete(PoliticalParty $politicalParty)
    {
        try {
            $resource = $this->model->findOrFail($politicalParty->uuid);
            $resource->delete();
            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage() . ' | Line: ' . $th->getLine() . ' | Code: ' . $th->getCode());
        }
    }
}
