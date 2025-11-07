<?php

namespace App\Services;

use App\Models\PoliticalParty;


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
                    'founded_year' => e($u->founded_year),
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
}
