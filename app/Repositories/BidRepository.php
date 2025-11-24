<?php

namespace App\Repositories;

use App\Models\Bid;

class BidRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Bid $model)
    {
        parent::__construct($model);
    }
}
