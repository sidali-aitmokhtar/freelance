<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EscrowTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\EscrowTransactionFactory> */
    use HasFactory;

    public function contract(): BelongsTo 
    {
        return $this->belongsTo(Contract::class);
    }

    protected $fillable =['money','contract_id'];

    public function milestone(): HasOne
    {
        return $this->hasOne(Milestone::class);
    }
}
