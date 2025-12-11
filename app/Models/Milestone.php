<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    /** @use HasFactory<\Database\Factories\MilestoneFactory> */
    use HasFactory;

    protected $fillable = ['escrow_transaction_id','step','description','price','type'];

    public function escrow(): BelongsTo
    {
        return $this->belongsTo(EscrowTransaction::class);
    }
}
