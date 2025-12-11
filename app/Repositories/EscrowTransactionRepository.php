<?php

namespace App\Repositories;

use App\Models\EscrowTransaction;

class EscrowTransactionRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(EscrowTransaction $model)
    {
        parent::__construct($model);
    }
}
