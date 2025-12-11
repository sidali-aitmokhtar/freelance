<?php

namespace App\Repositories;

use App\Models\Milestone;

class MilestoneRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Milestone $milestone)
    {
        parent::__construct($milestone);
    }
}
