<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }
}
