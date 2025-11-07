<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModelService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
