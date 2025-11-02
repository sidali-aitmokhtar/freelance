<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Create a new class instance.
     */
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model=$model;
    }
}
